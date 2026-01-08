<?php

use Illuminate\Database\Seeder;
use App\Models\PrintingBags;

class PrintingBadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PrintingBags::insert([
            [
                'printing_bags' => 'normal printing',
                'bag_weight' => 50,
                'grams' => 130 / 1000,
            ],
            [
                'printing_bags' => 'normal printing',
                'bag_weight' => 40,
                'grams' => 100 / 1000,
            ],
            [
                'printing_bags' => 'normal printing',
                'bag_weight' => 35,
                'grams' => 100 / 1000,
            ],
            [
                'printing_bags' => 'normal printing',
                'bag_weight' => 25,
                'grams' => 90 / 1000,
            ],
            [
                'printing_bags' => 'normal printing',
                'bag_weight' => 10,
                'grams' => 40 / 1000,
            ],
            [
                'printing_bags' => 'laminated bags',
                'bag_weight' => 50,
                'grams' => 150 / 1000,
            ],
            [
                'printing_bags' => 'laminated bags',
                'bag_weight' => 25,
                'grams' => 100 / 1000,
            ],
            [
                'printing_bags' => 'laminated bags',
                'bag_weight' => 22.50,
                'grams' => 100 / 1000,
            ],
            [
                'printing_bags' => 'double woven bags',
                'bag_weight' => 50,
                'grams' => 230 / 1000,
            ],
        ]);
    }
}
