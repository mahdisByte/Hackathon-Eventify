<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventsTableSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        DB::table('events')->truncate();

        DB::table('events')->insert([
            [
                'event_id' => 101,
                'user_id' => 4001,
                'name' => 'CodeSprint',
                'description' => 'An intense coding competition where participants solve algorithmic problems under time pressure.',
                'category' => 'CodeSprint',
                'location' => 'Dhaka',
                'price' => 200,
                'available_time' => '9am-5pm',
                'created_at' => '2025-08-24',
                'updated_at' => '2025-08-24'
            ],
            [
                'event_id' => 102,
                'user_id' => 4002,
                'name' => 'Hackathon Mania',
                'description' => 'A 24-hour hackathon encouraging innovation and teamwork to build software solutions.',
                'category' => 'Hackathon Mania',
                'location' => 'Chittagong',
                'price' => 500,
                'available_time' => '10am-10am next day',
                'created_at' => '2025-08-24',
                'updated_at' => '2025-08-24'
            ],
            [
                'event_id' => 103,
                'user_id' => 4003,
                'name' => 'AI Challenge',
                'description' => 'Participants present AI and machine learning projects to solve real-world problems.',
                'category' => 'AI Challenge',
                'location' => 'Khulna',
                'price' => 700,
                'available_time' => '11am-7pm',
                'created_at' => '2025-08-24',
                'updated_at' => '2025-08-24'
            ],
            [
                'event_id' => 104,
                'user_id' => 4004,
                'name' => 'WebDev Contest',
                'description' => 'Showcase web development skills by building responsive and interactive websites.',
                'category' => 'WebDev Contest',
                'location' => 'Barisal',
                'price' => 300,
                'available_time' => '9am-6pm',
                'created_at' => '2025-08-24',
                'updated_at' => '2025-08-24'
            ],
            [
                'event_id' => 105,
                'user_id' => 4005,
                'name' => 'Cybersecurity Quest',
                'description' => 'Test ethical hacking and cybersecurity skills by identifying vulnerabilities.',
                'category' => 'Cybersecurity Quest',
                'location' => 'Sylhet',
                'price' => 400,
                'available_time' => '10am-5pm',
                'created_at' => '2025-08-24',
                'updated_at' => '2025-08-24'
            ],
            [
                'event_id' => 106,
                'user_id' => 4006,
                'name' => 'Data Science Battle',
                'description' => 'Solve data-driven challenges using analytics, visualization, and predictive modeling.',
                'category' => 'Data Science Battle',
                'location' => 'Dhaka',
                'price' => 600,
                'available_time' => '10am-6pm',
                'created_at' => '2025-08-24',
                'updated_at' => '2025-08-24'
            ],
            [
                'event_id' => 107,
                'user_id' => 4007,
                'name' => 'AppDev Challenge',
                'description' => 'Build mobile applications within a limited time frame and showcase creativity.',
                'category' => 'AppDev Challenge',
                'location' => 'Chittagong',
                'price' => 350,
                'available_time' => '9am-5pm',
                'created_at' => '2025-08-24',
                'updated_at' => '2025-08-24'
            ],
            [
                'event_id' => 108,
                'user_id' => 4008,
                'name' => 'Algorithm Masters',
                'description' => 'Solve complex algorithm and data structure problems efficiently under time constraints.',
                'category' => 'Algorithm Masters',
                'location' => 'Khulna',
                'price' => 250,
                'available_time' => '10am-4pm',
                'created_at' => '2025-08-24',
                'updated_at' => '2025-08-24'
            ],
            [
                'event_id' => 109,
                'user_id' => 4009,
                'name' => 'Blockchain Hack',
                'description' => 'Develop blockchain-based solutions and smart contracts in a competitive environment.',
                'category' => 'Blockchain Hack',
                'location' => 'Barisal',
                'price' => 700,
                'available_time' => '11am-7pm',
                'created_at' => '2025-08-24',
                'updated_at' => '2025-08-24'
            ],
            [
                'event_id' => 110,
                'user_id' => 4010,
                'name' => 'Cloud Computing Race',
                'description' => 'Deploy cloud-based applications and manage resources efficiently under time limits.',
                'category' => 'Cloud Computing Race',
                'location' => 'Sylhet',
                'price' => 500,
                'available_time' => '9am-6pm',
                'created_at' => '2025-08-24',
                'updated_at' => '2025-08-24'
            ],
            [
                'event_id' => 111,
                'user_id' => 4011,
                'name' => 'Robotics Challenge',
                'description' => 'Design and program robots to complete specific tasks in a fun, competitive contest.',
                'category' => 'Robotics Challenge',
                'location' => 'Dhaka',
                'price' => 800,
                'available_time' => '10am-5pm',
                'created_at' => '2025-08-24',
                'updated_at' => '2025-08-24'
            ],
            [
                'event_id' => 112,
                'user_id' => 4012,
                'name' => 'UI/UX Design Contest',
                'description' => 'Compete by designing intuitive and aesthetic user interfaces for web and mobile apps.',
                'category' => 'UI/UX Design Contest',
                'location' => 'Chittagong',
                'price' => 300,
                'available_time' => '9am-4pm',
                'created_at' => '2025-08-24',
                'updated_at' => '2025-08-24'
            ],
        ]);
    }
}
