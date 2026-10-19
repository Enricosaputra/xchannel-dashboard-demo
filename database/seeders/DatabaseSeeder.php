<?php

namespace Database\Seeders;

use App\Enums\Day;
use App\Enums\StreamStatus;
use App\Models\Host;
use App\Models\Show;
use App\Models\Station;
use App\Services\ScheduleService;
use App\Support\Clock;
use Illuminate\Database\Seeder;

// Made-up stations, shows and hosts. Frequencies, show names and people are invented;
// only the shape (one station per city, a week of shows each) follows the real system.
class DatabaseSeeder extends Seeder
{
    private const WEEKDAYS = [Day::Monday, Day::Tuesday, Day::Wednesday, Day::Thursday, Day::Friday];

    public function run(ScheduleService $schedule): void
    {
        $stations = collect([
            ['Jakarta', '95.1 FM', StreamStatus::Live, true],
            ['Bogor', '88.4 FM', StreamStatus::Live, true],
            ['Banten', '101.7 FM', StreamStatus::Idle, true],
            ['Bandung', '92.3 FM', StreamStatus::Live, true],
            ['Surabaya', '104.5 FM', StreamStatus::Live, true],
            ['Solo', '97.6 FM', StreamStatus::Offline, false],
        ])->mapWithKeys(fn ($s) => [$s[0] => Station::create([
            'name' => "XChannel {$s[0]}", 'city' => $s[0], 'frequency' => $s[1], 'stream_status' => $s[2], 'is_active' => $s[3],
            'stream_url' => $s[3] ? 'https://stream.example.com/'.strtolower($s[0]) : null,
        ])]);

        $hosts = collect(['Raka', 'Sasa', 'Dimas', 'Nadia', 'Bayu', 'Tari', 'Fajar', 'Rani', 'Yoga', 'Mega', 'Andre', 'Lala', 'Gilang', 'Putri'])
            ->mapWithKeys(fn ($name) => [$name => Host::create(['name' => $name, 'bio' => "$name sudah siaran sejak masih kuliah."])]);
        Host::create(['name' => 'Cici', 'is_active' => false]);

        $show = function (string $title, string $description, array $hostNames) use ($hosts) {
            $show = Show::create(['title' => $title, 'description' => $description]);
            $show->hosts()->sync(collect($hostNames)->map(fn ($n) => $hosts[$n]->id));

            return $show;
        };

        // Network shows, relayed by several stations.
        $lunch = $show('Jam Makan Siang', 'Lagu santai, resep cepat, dan info kuliner di sekitar kota.', ['Sasa', 'Bayu']);
        $afternoon = $show('Setelah Istirahat', 'Musik dan film terbaru, plus request lagu dari pendengar.', ['Nadia']);
        $driveTime = $show('Jalan Pulang', 'Teman perjalanan pulang: info lalu lintas, kuis, dan obrolan ringan.', ['Dimas', 'Tari']);
        $night = $show('Malam Cerita', 'Cerita pendengar, curhat, dan lagu-lagu pelan menjelang tidur.', ['Rani']);
        $indie = $show('Musik Nusantara', '100% musik Indonesia dan bintang tamu tiap minggu.', ['Fajar']);
        $horror = $show('Kisah Misteri', 'Cerita horor dan pengalaman seram dari pendengar.', ['Yoga', 'Mega']);
        $chart = $show('Tangga Lagu Mingguan', 'Dua puluh lagu teratas minggu ini, dihitung dari request dan streaming.', ['Andre']);
        $weekend = $show('Akhir Pekan Santai', 'Playlist akhir pekan dan agenda acara di kota.', ['Lala', 'Gilang']);
        $sunday = $show('Sapa Minggu Pagi', 'Olahraga pagi, info car free day, dan lagu semangat.', ['Putri']);
        $lateNight = $show('Begadang Jumat', 'Remix dan DJ set untuk yang masih terjaga.', ['Gilang']);
        $show('Ngobrol Komunitas', 'Belum dijadwalkan: obrolan dengan komunitas lokal.', ['Lala']);

        // Each city has its own morning show.
        $morning = $stations->filter->is_active->mapWithKeys(fn (Station $s, $city) => [$city => $show(
            "Pagi $city", "Info pagi, berita viral, dan lowongan kerja di $city.",
            match ($city) { 'Jakarta' => ['Raka', 'Sasa'], 'Bogor' => ['Bayu'], 'Banten' => ['Mega'], 'Bandung' => ['Tari', 'Gilang'], default => ['Andre', 'Putri'] },
        )]);

        $add = fn (Station $station, Show $show, array $days, string $from, string $to) => $schedule->schedule($station, $show, $days, Clock::toMinutes($from), Clock::toMinutes($to));

        foreach ($stations->filter->is_active as $city => $station) {
            $add($station, $morning[$city], self::WEEKDAYS, '06:00', '10:00');
            $add($station, $chart, [Day::Saturday], '10:00', '13:00');
            $add($station, $sunday, [Day::Sunday], '07:00', '10:00');

            if ($city === 'Banten') {
                $add($station, $driveTime, self::WEEKDAYS, '16:00', '19:00'); // a smaller station: the rest is automated music
                continue;
            }

            $add($station, $lunch, self::WEEKDAYS, '10:00', '13:00');
            $add($station, $afternoon, self::WEEKDAYS, '13:00', '16:00');
            $add($station, $driveTime, self::WEEKDAYS, '16:00', '20:00');
            $add($station, $night, [Day::Monday, Day::Tuesday], '20:00', '24:00');
            $add($station, $night, [Day::Friday], '20:00', $city === 'Surabaya' ? '22:00' : '24:00');
            $add($station, $indie, [Day::Thursday], '20:00', '24:00');
            $add($station, $weekend, [Day::Saturday, Day::Sunday], '13:00', '17:00');

            if (in_array($city, ['Jakarta', 'Bandung'], true)) {
                $add($station, $horror, [Day::Wednesday], '20:00', '24:00');
            } else {
                $add($station, $night, [Day::Wednesday], '20:00', '24:00');
            }

            if ($city === 'Surabaya') {
                // A show past midnight is two slots: until 24:00 on Friday, and from 00:00 on Saturday.
                $add($station, $lateNight, [Day::Friday], '22:00', '24:00');
                $add($station, $lateNight, [Day::Saturday], '00:00', '02:00');
            }
        }
    }
}
