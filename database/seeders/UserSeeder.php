<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $i = 1;
        $usernames = ['aleksa','mika','zika','pera'];
        $insertArray = [
            [
                'id' => 1,
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'status' => 1,
                'email_verified_at' => null,
                'password' => Hash::make('admin1234'),
                'remember_token' => null,
            ]
        ];
        
        foreach($usernames as $username){
            $i++;
            $insert = [
                'id' => $i,
                'name' => $username,
                'email' => $username.'@gmail.com',
                'status' => 0,
                'email_verified_at' => null,
                'password' => Hash::make($username.'1234'),
                'remember_token' => null,
            ];
            $insertArray[] = $insert;
        }
        
        foreach($insertArray as $item){
            if(User::query()->where('email', $item['email'])->exists()){
                continue;
            }else{
                User::create($item);
            }
        }
    }
}
