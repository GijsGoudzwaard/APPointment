<?php

use Illuminate\Database\Seeder;

class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $company = \App\Models\Company::where('subdomain', 'Goudzwaard')->get();
        if ($company->isEmpty()) {
            DB::table('companies')->insert([
                'name' => 'Goudzwaard',
                'subdomain' => 'goudzwaard',
                'email' => 'gijs.goudzwaard@gmail.com',
                'address' => 'noorderwalstraat 5a',
                'phonenumber' => '0642311100'
            ]);
        }
    }
}
