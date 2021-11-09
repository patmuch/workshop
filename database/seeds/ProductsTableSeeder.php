<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('products')->insert(
            [
                [
                    'name' => 'Cima',
                    'code' => 'C001',
                    'description' => 'The charm of this car. Choose CIMA. It is the pride and pleasure of choosing one vertex.',
                    'price' => rand(1000000, 100000000),
                    'stock_availability_id' => '1',
                    'category_id' => 5,
                    'photo' => 'images/cars/cima_1912_top_01.jpg.ximg.l_full_m.smart.jpg',
                ],
                [
                    'name' => 'Fuga',
                    'code' => 'F001',
                    'description' => 'The Infiniti brand is highly regarded for its advanced design and powerful performance in each of its markets, including the U.S., Canada, Europe, Russia, the Middle East, China and Korea. With its highly refined style and responsiveness, Infiniti promises a driving experience with unparalleled appeal.',
                    'price' => rand(1000000, 100000000),
                    'stock_availability_id' => '4',
                    'category_id' => 2,
                    'photo' => 'images/cars/fuga_1912_top_02 . jpg . ximg . l_full_m . smart . jpg',
                ],
                [
                    'name' => 'Skyline',
                    'code' => 'SK001',
                    'description' => 'Datsun will provide an appealing and sustainable motoring experience to optimistic up-and-coming customers in high-growth markets. Datsun combines Nissan Motor\'s 80 years of Japanese car-making expertise with the nearly century-old Datsun Brand DNA. Datsun vehicles will be Local Products ensured by a Global Brand, and starts sales in India, Indonesia, Russia and South Africa from 2014.',
                    'price' => rand(1000000, 100000000),
                    'stock_availability_id' => '2',
                    'category_id' => 4,
                    'photo' => 'images/cars/sylphy_1803_top_002.jpg.ximg.l_full_m.smart.jpg',
                ],
                [
                    'name' => 'Sylphy',
                    'code' => 'SY001',
                    'description' => 'Comfort to enjoy driving while relaxing.
                The interior space on a class that has become even wider, and ample rear seats.
                Here is a state-of-the-art environment where all occupants are comfortably wrapped.',
                    'price' => rand(1000000, 100000000),
                    'stock_availability_id' => '1',
                    'category_id' => 1,
                    'photo' => 'images/cars/sylphy_1803_top_002.jpg.ximg.l_full_m.smart.jpg',
                ],
                [
                    'name' => 'Teana',
                    'code' => 'T001',
                    'description' => 'Comfort of "modern living". Consideration of "hospitality". Tiana has found a value that has never been in a sedan before. Refining its modern living and hospitality, Tiana offers a cruise-like, elegant travel experience. Lets go to Tiana Cruz.',
                    'price' => rand(1000000, 100000000),
                    'stock_availability_id' => '3',
                    'category_id' => 2,
                    'photo' => 'images/cars/teana_1803_top_002.jpg.ximg.l_full_m.smart.jpg',
                ],
                [
                    'name' => 'Leaf',
                    'code' => 'L001',
                    'description' => 'NISSAN CROSSING. The Nissan Gallery in Ginza will now be born again as NISSAN CROSSING, a base to dispatch the Nissan brand globally.',
                    'price' => rand(1000000, 100000000),
                    'stock_availability_id' => '2',
                    'category_id' => 1,
                    'photo' => 'images/cars/panel01_img01.jpg',
                ],
                [
                    'name' => 'Submarine',
                    'code' => 'SU001',
                    'description' => 'Details Datsun will provide an appealing and sustainable motoring experience to optimistic up-and-coming customers in high-growth markets. Datsun combines Nissan Motor\'s 80 years of Japanese car-making expertise with the nearly century-old Datsun Brand DNA. Datsun vehicles will be Local Products ensured by a Global Brand, and starts sales in India, Indonesia, Russia and South Africa from 2014.',
                    'price' => rand(1000000, 100000000),
                    'stock_availability_id' => '3',
                    'category_id' => 3,
                    'photo' => 'images/cars/sylphy_1803_top_002.jpg.ximg.l_full_m.smart.jpg',
                ],
            ]
        );
    }
}
