<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Assessor;
use App\Models\Major;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        Major::create([
            'major_name' => 'RPL',
            'description' => 'REKAYASA PERANGKAT LUNAK'
        ]);
        Major::create([
            'major_name' => 'DKV',
            'description' => 'DESAIN KOMUNIKASI VISUAL'
        ]);
        Major::create([
            'major_name' => 'TKJ',
            'description' => 'TEKNIK KOMPUTER JARINGAN'
        ]);
        User::create([
            'full_name' => 'admin',
            'username' => 'admin1',
            'email'=> 'admin1@gmail.com',
            'password'=> bcrypt('1234'),
            'phone_number'=> '0823323',
            'role'=> 'admin',
        ]);
         $user = User::create([
            'full_name' => 'Akasshy',
            'username' => 'Akasshy123',
            'email'=> 'akasshy@gmail.com',
            'password'=> bcrypt('1234'),
            'phone_number'=> '0823323',
            'role'=> 'assessor',
        ]);
        if ($user->role == 'assessor') {
            Assessor::create([
                'user_id' => '2',
                'assessor_type' => 'external',
                'description' => 'Suka makan'

            ]);
        }
        $user = User::create([
           'full_name' => 'Aditia',
           'username' => 'Aditia123',
           'email'=> 'aditia@gmail.com',
           'password'=> bcrypt('1234'),
           'phone_number'=> '0823323',
           'role'=> 'student',
       ]);
        if ($user->role == 'student') {
            Student::create([
                'nisn' => '0001',
                'grade_level' => '12',
                'major_id' => '1',
                'user_id' => '3',
            ]);
        }

    }
}
