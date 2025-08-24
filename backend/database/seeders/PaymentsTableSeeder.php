<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentsTableSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        DB::table('payments')->truncate();

        DB::table('payments')->insert([
            ['payment_id'=>1,'booking_id'=>1,'payment_method'=>'cash','amount_paid'=>646.00,'created_at'=>'2025-08-14 23:30:04','updated_at'=>'2025-08-14 23:30:04'],
            ['payment_id'=>2,'booking_id'=>3,'payment_method'=>'bank','amount_paid'=>454.00,'created_at'=>'2025-08-15 05:36:07','updated_at'=>'2025-08-15 05:36:07'],
            ['payment_id'=>3,'booking_id'=>4,'payment_method'=>'bank','amount_paid'=>341.00,'created_at'=>'2025-08-15 05:36:44','updated_at'=>'2025-08-15 05:36:44'],
            ['payment_id'=>4,'booking_id'=>5,'payment_method'=>'bank','amount_paid'=>566.00,'created_at'=>'2025-08-15 09:31:20','updated_at'=>'2025-08-15 09:31:20'],
        ]);

    }
}
