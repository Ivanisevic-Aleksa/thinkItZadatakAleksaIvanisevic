<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CategoryModel;

class CategorySeeder extends Seeder
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
                'name' => 'alfa'
            ],
            [
                'id' => 2,
                'name' => 'fiat'
            ],
            [
                'id' => 3,
                'name' => 'honda'
            ],
        ];

        foreach($insertArray as $item){
            if(CategoryModel::query()->where('name', $item['name'])->exists()){
                continue;
            }else{
                CategoryModel::create($item);
            }
        }
    }
}
