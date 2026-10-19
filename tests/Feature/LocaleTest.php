<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LocaleTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_app_speaks_indonesian_by_default(): void
    {
        $this->get(route('stations.index'))->assertSee('Stasiun')->assertSee('Penyiar');
    }

    public function test_visitors_can_switch_to_english_and_back(): void
    {
        $this->from(route('stations.index'))->get(route('locale', 'en'))->assertRedirect(route('stations.index'));
        $this->get(route('stations.index'))->assertSee('Stations')->assertSee('Hosts');

        $this->get(route('locale', 'id'));
        $this->get(route('stations.index'))->assertSee('Stasiun');
    }

    public function test_unknown_languages_are_rejected(): void
    {
        $this->get('/locale/fr')->assertNotFound();
    }

    public function test_validation_messages_follow_the_language(): void
    {
        $this->post(route('hosts.store'), ['name' => ''])->assertSessionHasErrors(['name' => 'Nama wajib diisi.']);
    }
}
