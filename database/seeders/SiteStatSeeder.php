<?php

namespace Database\Seeders;

use App\Models\SiteStat;
use Illuminate\Database\Seeder;

class SiteStatSeeder extends Seeder
{
    public function run(): void
    {
        SiteStat::truncate();

        SiteStat::insert([
            [
                'icon'       => 'bi-calendar-event',
                'value'      => '2017',
                'label'      => 'Sejak dibentuk',
                'order'      => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'icon'       => 'bi-people-fill',
                'value'      => '4',
                'label'      => 'Unsur komite',
                'order'      => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'icon'       => 'bi-list-check',
                'value'      => '7/8',
                'label'      => 'Tahap proses baku',
                'order'      => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}