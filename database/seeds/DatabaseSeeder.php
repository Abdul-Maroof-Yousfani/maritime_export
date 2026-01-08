<?php

use App\Models\Line;
use App\Models\Machinery;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Line::insert([
        //     [
        //         'name' => 'Line  1-2-3',
        //         'username' => 'Amir'
        //     ],
        //     [
        //         'name' => 'Line  4',
        //         'username' => 'Amir'
        //     ],
        //     [
        //         'name' => 'Line  5-6',
        //         'username' => 'Amir'
        //     ],
        //     [
        //         'name' => 'Line  7',
        //         'username' => 'Amir'
        //     ],
        //     [
        //         'name' => 'Line  8-9',
        //         'username' => 'Amir'
        //     ],
        //     [
        //         'name' => 'Line  10',
        //         'username' => 'Amir'
        //     ],
        //     [
        //         'name' => 'Line  11',
        //         'username' => 'Amir'
        //     ],
        //     [
        //         'name' => 'Line  12-13',
        //         'username' => 'Amir'
        //     ],
        // ]);
        $this->call(PrintingBadSeeder::class);
    }
}
