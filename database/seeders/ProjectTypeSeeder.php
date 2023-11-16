<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\ProjectType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $type = ['type 1', 'type 2', 'type 3', 'type 4', 'type 5'];

        foreach ($type as $item) {
            ProjectType::create(['name' => $item]);
        }
    }
}
