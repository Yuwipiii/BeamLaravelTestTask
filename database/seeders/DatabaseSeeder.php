<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Category;
use App\Models\Group;
use App\Models\Product;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        Profile::factory([
            'user_id'=>User::factory()
                ->hasAttached(Group::factory()
                    ->create())->create()
        ])->create();
        Category::factory(4)->create();
        Product::factory(20)->create();

    }
}
