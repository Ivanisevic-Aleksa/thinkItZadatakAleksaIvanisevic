<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductModel;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $insertArray = [
            [
                'id' => 1,
                'category_id' => 1,
                'number' => 'asdfg56',
                'name' => '147 1.9 150hp',
                'about' => 'Car is build in 2006, great italian car.',
                'price' => 2000,
                'image_name' => 'asdfg56.jpg',
            ],
            [
                'id' => 2,
                'category_id' => 1,
                'number' => 'qwert78',
                'name' => '147 1.6 120hp',
                'about' => 'Car is build in 2008, have a problem with engine.',
                'price' => 500,
                'image_name' => 'qwert78.jpg',
            ],
            [
                'id' => 3,
                'category_id' => 2,
                'number' => 'gjhgih67',
                'name' => 'punto 1.2 60hp',
                'about' => 'Cheap car',
                'price' => 1500,
                'image_name' => 'gjhgih67.jpg',
            ],
            [
                'id' => 4,
                'category_id' => 2,
                'number' => 'weer454yh',
                'name' => 'punto 1.9 160hp',
                'about' => 'Tuned punto',
                'price' => 2000,
                'image_name' => 'weer454yh.jpg',
            ],
            [
                'id' => 5,
                'category_id' => 3,
                'number' => 'gyt858g',
                'name' => 'Civic race car',
                'about' => 'Tuned civic, prepared for racing!',
                'price' => 5000,
                'image_name' => 'gyt858g.jpeg',
            ],
        ];

        foreach($insertArray as $item){
            if(ProductModel::query()->where('number', $item['number'])->exists()){
                continue;
            }else{
                ProductModel::create($item);
            }
        }
    }
}
