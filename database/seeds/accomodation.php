<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class accomodation extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insert Location
        $location = array(
            [
                "city" => "Cuernavaca",
                "state" => "Morelos",
                "country" => "Mexico",
                "zip_code" => "62448",
                "address" => "Boulevard Díaz Ordaz No. 9 Cantarranas",
                "created_at" =>Carbon::now()->toDateTimeString()

            ]
        );
        App\Location::insert($location);

        //Insert accommodation
        $accommodations = array(
            [
                "name" => "Example name",
                "rating" => 5,
                "category" => "hotel",
                "location_id" => 1,
                "image" => "image-url.com",
                "reputation" => 8990,
                "reputations_badge" => "green",
                "price" => 1000,
                "availability" => 10,
                "created_at" => Carbon::now()->toDateTimeString()
            ]

        );
        App\Accommodation::insert($accommodations);


         //Insert default user
         $users = array(
            [
                'first_name'=>'Jonas',
                'last_name'=>'Levin',
                'email'=>'jonas@email.com',
                'password'=>Hash::make('1234'),
                'role'=>'admin',
                'created_at'=>Carbon::now()->toDateTimeString()
            ],
            [
                'first_name'=>'Maria',
                'last_name'=>'Maria',
                'email'=>'maria@email.com',
                'password'=>Hash::make('1234'),
                'role'=>'saler',
                'created_at'=>Carbon::now()->toDateTimeString()
            ],

        );
        App\User::insert($users);





    }
}
