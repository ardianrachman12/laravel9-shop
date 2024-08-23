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
        User::create([
            'name' => 'Administrator',
            'role' => 'admin',
            'no_hp' => '0858698889876',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12345'),
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        User::create([
            'name' => 'Ardian R',
            'role' => 'member',
            'no_hp' => '0858698889888',
            'email' => 'ardian@gmail.com',
            'password' => bcrypt('12345'),
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        User::create([
            'name' => 'Budi Santoso',
            'role' => 'member',
            'no_hp' => '0858698889889',
            'email' => 'budi@gmail.com',
            'password' => bcrypt('12345'),
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        User::create([
            'name' => 'Siti Nurhaliza',
            'role' => 'member',
            'no_hp' => '0858698889890',
            'email' => 'siti@gmail.com',
            'password' => bcrypt('12345'),
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        User::create([
            'name' => 'Rudi Hartono',
            'role' => 'member',
            'no_hp' => '0858698889891',
            'email' => 'rudi@gmail.com',
            'password' => bcrypt('12345'),
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        User::create([
            'name' => 'Dewi Lestari',
            'role' => 'member',
            'no_hp' => '0858698889892',
            'email' => 'dewi@gmail.com',
            'password' => bcrypt('12345'),
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        User::create([
            'name' => 'Agus Salim',
            'role' => 'member',
            'no_hp' => '0858698889893',
            'email' => 'agus@gmail.com',
            'password' => bcrypt('12345'),
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        User::create([
            'name' => 'Fitriani Aulia',
            'role' => 'member',
            'no_hp' => '0858698889894',
            'email' => 'fitriani@gmail.com',
            'password' => bcrypt('12345'),
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        User::create([
            'name' => 'Hendra Wijaya',
            'role' => 'member',
            'no_hp' => '0858698889895',
            'email' => 'hendra@gmail.com',
            'password' => bcrypt('12345'),
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        User::create([
            'name' => 'Linda Putri',
            'role' => 'member',
            'no_hp' => '0858698889896',
            'email' => 'linda@gmail.com',
            'password' => bcrypt('12345'),
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
