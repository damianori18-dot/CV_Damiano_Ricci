<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['HTML', 'CSS', 'JS', 'LARAVEL', 'PHP', 'MYSQL', 'REACT'] as $name) {
            Tag::query()->firstOrCreate(['name' => $name]);
        }
    }
}
