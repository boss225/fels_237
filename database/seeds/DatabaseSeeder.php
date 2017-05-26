<?php

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
        DB::table('users')->insert([
            'name'      => 'admin', 
            'email'     => 'admin@mail.com', 
            'password'  =>  bcrypt('123456'), 
            'avatar'    => 'http://i.imgur.com/ffPLlPe.jpg', 
            'cover'     => 'http://i.imgur.com/izvVRsr.jpg', 
            'location'  => 'Da Nang', 
            'note'      => 'Hard working, friendly, helping people', 
            'role'      => '0',
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
        ]);
    }
}
