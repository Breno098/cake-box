<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Image;
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
        Post::factory(10)
            ->state(['link_video' => 'https://www.youtube.com/watch?v=_VuJA-VQRcY'])
            ->for(User::all()->random(), 'creator')
            ->has(Comment::factory()->count(3))
            ->create();

        Post::factory(10)
            ->for(User::all()->random(), 'creator')
            ->has(Comment::factory()->count(3))
            ->create();

        Post::get()->each(function(Post $post) {
            foreach (range(1, random_int(1, 5)) as $image) {
                $post->images()->create(Image::factory()->make([
                    'image_type' => Post::class,
                    'image_id' => $post->id
                ])->toArray());
            }
        });
    }
}
