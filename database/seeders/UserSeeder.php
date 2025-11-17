<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $admin_user = User::create([
            'name' => 'Admin User',
            'email' => 'admin@baaboo.com',
            'password' => bcrypt('baaboo123'),
        ]);
        $admin_user->assignRole('admin');


        User::factory()->count(100)->create();
    }
}
