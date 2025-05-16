<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'zhiwar osman',
            'email' => 'zhiwar@test.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'remember_token' => \Illuminate\Support\Str::random(10),
            'role' => Role::ADMIN
        ]);

        User::factory()->create([
            'name' => 'author',
            'email' => 'author@test.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'remember_token' => \Illuminate\Support\Str::random(10),
            'role' => Role::Author
        ]);

        User::factory(10)->create();
        Category::factory(10)->create();
        Tag::factory(10)->create();
        Post::factory(10)->create()->each(function ($post) {
            $post->tags()->attach(Tag::inRandomOrder()->take(3)->pluck('id'));
        });
    }
}
