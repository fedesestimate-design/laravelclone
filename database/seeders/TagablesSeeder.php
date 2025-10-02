<?php

namespace Database\Seeders;

use App\Models\Taggables;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Taggables::factory()->count(20)->create();
    }
}
