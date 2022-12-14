<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create();

        User::factory()
            ->state([
                'name' => 'Breno',
                'email' => 'breno@email.com',
            ])
            ->create();
    }
}
