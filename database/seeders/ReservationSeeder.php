<?php

namespace Database\Seeders;

use App\Models\Reservation;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get some users to create reservations for
        $users = User::all();
        
        if ($users->count() < 2) {
            // Create sample users if none exist
            $guest = User::create([
                'name' => 'Ahmed Hassan',
                'first_name' => 'Ahmed',
                'last_name' => 'Hassan',
                'email' => 'ahmed@example.com',
                'password' => bcrypt('password'),
                'user_type' => 'traveler',
                'country' => 'Egypt',
                'city' => 'Cairo'
            ]);
            
            $host = User::create([
                'name' => 'Fatima Benali',
                'first_name' => 'Fatima',
                'last_name' => 'Benali',
                'email' => 'fatima@example.com',
                'password' => bcrypt('password'),
                'user_type' => 'host',
                'country' => 'Morocco',
                'city' => 'Marrakech'
            ]);
        } else {
            $guest = $users->first();
            $host = $users->count() > 1 ? $users->skip(1)->first() : $users->first();
        }

        // Create sample reservations
        Reservation::create([
            'user_id' => $guest->id,
            'host_id' => $host->id,
            'guest_name' => $guest->first_name . ' ' . $guest->last_name,
            'host_name' => $host->first_name . ' ' . $host->last_name,
            'description' => 'Traditional Moroccan family experience in Marrakech medina',
            'check_in_date' => now()->addDays(15),
            'check_out_date' => now()->addDays(22),
            'guests_count' => 2,
            'total_price' => 350.00,
            'status' => 'confirmed',
            'special_requests' => 'Vegetarian meals preferred'
        ]);

        Reservation::create([
            'user_id' => $guest->id,
            'host_id' => $host->id,
            'guest_name' => $guest->first_name . ' ' . $guest->last_name,
            'host_name' => $host->first_name . ' ' . $host->last_name,
            'description' => 'Cultural immersion with Berber family in Atlas Mountains',
            'check_in_date' => now()->subDays(30),
            'check_out_date' => now()->subDays(25),
            'guests_count' => 1,
            'total_price' => 200.00,
            'status' => 'completed',
            'special_requests' => 'Interest in learning traditional crafts'
        ]);

        Reservation::create([
            'user_id' => $guest->id,
            'host_id' => $host->id,
            'guest_name' => $guest->first_name . ' ' . $guest->last_name,
            'host_name' => $host->first_name . ' ' . $host->last_name,
            'description' => 'Coastal family stay in Essaouira with surfing lessons',
            'check_in_date' => now()->addDays(45),
            'check_out_date' => now()->addDays(50),
            'guests_count' => 1,
            'total_price' => 280.00,
            'status' => 'pending',
            'special_requests' => 'Beginner surfer, need equipment rental'
        ]);
    }
}
