<?php

use Illuminate\Database\Seeder;
use App\Location;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Location::truncate();

	    $location = [
	        ['location_name' => 'A-1-1'],
	        ['location_name' => 'A-1-2'],
	    ];

	    Location::insert($location);
    }
}
