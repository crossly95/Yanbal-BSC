<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('TBL_Usuarios')->insert([
            [
                'name' => 'Claudia Norato',
                'email' => 'root@app.com',
                'role' => 'admin',
                'password' => bcrypt('12345')
            ],
            [
                'name' => 'Gabriel Cañon',
                'email' => 'Loba@app.com',
                'role' => 'evaluator',
                'password' => bcrypt('12345')
            ]
        ]);
    }
}
