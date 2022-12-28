<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Post::factory(5)
            ->state([
                'link_video' => 'https://www.youtube.com/watch?v=_VuJA-VQRcY',
            ])
            ->for(User::all()->random(), 'creator')
            ->create();

        Post::factory(5)->for(User::all()->random(), 'creator')->create();
    }
}
