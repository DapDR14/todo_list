<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tasks;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tasks::create([
            'title' => 'Task 1',
            'position' => 1,
            'description' => 'Create a laravel project'
        ]);

        Tasks::create([
            'title' => 'Task 2',
            'position' => 2,
            'description' => 'Create a model',
        ]);

        Tasks::create([
            'title' => 'Task 3',
            'position' => 3,
            'description' => 'Create a controller',
        ]);

        Tasks::create([
            'title' => 'Task 4',
            'position' => 4,
            'description' => 'Update your api.php or web.php to list your endpoints',
        ]);
    }
}
