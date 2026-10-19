<?php

namespace Tests\Feature;

use App\Enums\Day;
use App\Models\Host;
use App\Models\ScheduleSlot;
use App\Models\Show;
use App\Models\Station;
use App\Services\ScheduleService;
use App\Support\Clock;
use DomainException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class ScheduleTest extends TestCase
{
    use RefreshDatabase;

    private Station $station;

    protected function setUp(): void
    {
        parent::setUp();
        $this->station = Station::factory()->create();
    }

    private function add(Show $show, array $days, string $from, string $to)
    {
        return app(ScheduleService::class)->schedule($this->station, $show, $days, Clock::toMinutes($from), Clock::toMinutes($to));
    }

    public function test_slots_on_the_same_station_and_day_cannot_overlap(): void
    {
        $morning = Show::factory()->create(['title' => 'Pagi Bandung']);
        $this->add($morning, [Day::Monday], '06:00', '10:00');

        try {
            $this->add(Show::factory()->create(), [Day::Monday], '09:00', '11:00');
            $this->fail('An overlapping slot was saved.');
        } catch (DomainException $e) {
            $this->assertStringContainsString('Pagi Bandung', $e->getMessage()); // the message names what it clashes with
        }
    }

    public function test_back_to_back_slots_and_other_days_or_stations_are_fine(): void
    {
        $show = Show::factory()->create();
        $this->add($show, [Day::Monday], '06:00', '10:00');

        $this->add($show, [Day::Monday], '10:00', '13:00');
        $this->add($show, [Day::Tuesday], '06:00', '10:00');
        app(ScheduleService::class)->schedule(Station::factory()->create(), $show, [Day::Monday], 360, 600);

        $this->assertSame(4, ScheduleSlot::count());
    }

    public function test_several_days_are_saved_together_or_not_at_all(): void
    {
        $this->add(Show::factory()->create(), [Day::Wednesday], '07:00', '08:00');

        try {
            $this->add(Show::factory()->create(), [Day::Monday, Day::Tuesday, Day::Wednesday], '06:00', '10:00');
        } catch (DomainException) {
        }

        $this->assertSame(1, ScheduleSlot::count());
    }

    public function test_a_slot_must_end_after_it_starts_and_can_run_until_midnight(): void
    {
        $show = Show::factory()->create();
        $this->add($show, [Day::Friday], '20:00', '24:00');

        $this->expectException(DomainException::class);
        $this->add($show, [Day::Saturday], '23:00', '01:00');
    }

    public function test_moving_a_slot_does_not_clash_with_itself(): void
    {
        $slot = $this->add(Show::factory()->create(), [Day::Monday], '06:00', '10:00')->first();

        app(ScheduleService::class)->move($slot, $this->station, $slot->show, Day::Monday, Clock::toMinutes('06:00'), Clock::toMinutes('09:30'));

        $this->assertSame('06:00 - 09:30', $slot->fresh()->timeRange());
    }

    public function test_on_air_now_and_up_next(): void
    {
        $morning = Show::factory()->create(['title' => 'Pagi']);
        $sunday = Show::factory()->create(['title' => 'Minggu']);
        $this->add($morning, [Day::Monday], '06:00', '10:00');
        $this->add($sunday, [Day::Sunday], '07:00', '10:00');
        $service = app(ScheduleService::class);

        $mondayNine = Carbon::parse('2026-10-19 09:00'); // a Monday
        $this->assertSame('Pagi', $service->onAir($this->station, $mondayNine)->show->title);
        $this->assertNull($service->onAir($this->station, $mondayNine->copy()->setTime(10, 0))); // the end minute is not on air
        $this->assertSame('Minggu', $service->upNext($this->station, $mondayNine)->show->title);
        $this->assertSame('Pagi', $service->upNext($this->station, Carbon::parse('2026-10-25 11:00'))->show->title); // wraps to next week
    }

    public function test_empty_hours_are_found(): void
    {
        $show = Show::factory()->create();
        $this->add($show, [Day::Monday], '06:00', '10:00');
        $this->add($show, [Day::Monday], '13:00', '24:00');

        $this->assertSame([[0, 360], [600, 780]], app(ScheduleService::class)->gaps($this->station->fresh('slots'), Day::Monday));
        $this->assertSame([[0, 1440]], app(ScheduleService::class)->gaps($this->station->fresh('slots'), Day::Tuesday));
    }

    public function test_airtime_counts_every_host_of_a_show(): void
    {
        $show = Show::factory()->create();
        $show->hosts()->attach(Host::factory()->count(2)->create(['name' => fn () => fake()->unique()->firstName()]));
        $this->add($show, [Day::Monday, Day::Tuesday], '06:00', '10:00');

        $this->assertSame([480, 480], app(ScheduleService::class)->weeklyMinutesByHost()->values()->all());
    }

    public function test_the_form_adds_one_slot_per_ticked_day(): void
    {
        $show = Show::factory()->create();

        $this->post(route('slots.store'), ['station_id' => $this->station->id, 'show_id' => $show->id, 'days' => [1, 3, 5], 'starts_at' => '06:00', 'ends_at' => '10:00'])
            ->assertRedirect(route('stations.show', $this->station));

        $this->assertSame([1, 3, 5], ScheduleSlot::orderBy('day_of_week')->pluck('day_of_week')->map->value->all());
    }

    public function test_the_form_explains_a_clash_and_rejects_free_text_times(): void
    {
        $this->add(Show::factory()->create(['title' => 'Pagi Bogor']), [Day::Monday], '06:00', '10:00');
        $base = ['station_id' => $this->station->id, 'show_id' => Show::factory()->create()->id, 'days' => [1]];

        $this->post(route('slots.store'), $base + ['starts_at' => '08:00', 'ends_at' => '11:00'])
            ->assertSessionHasErrors('starts_at');
        $this->assertStringContainsString('Pagi Bogor', session('errors')->first('starts_at'));

        foreach (['6:00 AM', '08.00', '24:30', '25:00'] as $bad) {
            $this->post(route('slots.store'), $base + ['starts_at' => $bad, 'ends_at' => '23:00'])->assertSessionHasErrors('starts_at');
        }
    }

    public function test_things_in_use_cannot_be_deleted(): void
    {
        $show = Show::factory()->create();
        $host = Host::factory()->create();
        $show->hosts()->attach($host);
        $this->add($show, [Day::Monday], '06:00', '10:00');

        $this->delete(route('stations.destroy', $this->station))->assertSessionHas('error');
        $this->delete(route('shows.destroy', $show))->assertSessionHas('error');
        $this->delete(route('hosts.destroy', $host))->assertSessionHas('error');

        $this->assertModelExists($this->station);
        $this->assertModelExists($show);
        $this->assertModelExists($host);
    }

    public function test_the_dashboard_can_show_any_day_and_time(): void
    {
        $this->add(Show::factory()->create(['title' => 'Kisah Misteri']), [Day::Wednesday], '20:00', '24:00');

        $this->get(route('dashboard', ['day' => 3, 'time' => '21:30']))->assertOk()->assertSee('Kisah Misteri');
    }

    public function test_every_page_loads_with_the_demo_data(): void
    {
        $this->seed();

        foreach (['dashboard', 'stations.index', 'stations.create', 'slots.index', 'slots.create', 'shows.index', 'shows.create', 'hosts.index', 'hosts.create'] as $route) {
            $this->get(route($route))->assertOk();
        }
        $this->get(route('stations.show', Station::first()))->assertOk();
        $this->get(route('slots.edit', ScheduleSlot::first()))->assertOk();
    }
}
