<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $User = new User();
        $User->name = 'Admin User';
        $User->email = 'admin@example.com';
        $User->password = hash::make('12345678');
        $User->save();
}
}
