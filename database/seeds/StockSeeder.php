<?php

use Illuminate\Database\Seeder;
use App\Stock;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Stock::truncate();

	    $stock = [
	        ['product' => 'Indomie Goreng', 'stock_quantity' => '100', 'adjustment' => '0', 'location_id' => '1'],
	        ['product' => 'Teh Kotak', 'stock_quantity' => '150', 'adjustment' => '0', 'location_id' => '2'],
	    ];

	    Stock::insert($stock);
    }
}
