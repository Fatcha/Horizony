<?php

use Illuminate\Database\Seeder;
use App\Models\Country;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Eloquent::unguard();

        $countriessInDB = Country::get()->count();

        if($countriessInDB > 0 ){
            $this->command->info('Country  table ALREADY seeded!');
            return;
        }

        $path = 'database/seeds/sql_files/countries.sql';
        DB::unprepared(file_get_contents($path));

        $this->command->info('Country table seeded!');
    }
}
