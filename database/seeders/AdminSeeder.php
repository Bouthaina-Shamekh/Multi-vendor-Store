<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            [
                'name' => 'Bouthaina',
                'email' => 'bou@gmail.com',
                'username' => 'bouthaina',
                'password' => Hash::make('12345678'), // تأكد من تغيير كلمة المرور
                'phone_number' => '0593407702',
                'super_admin' => true,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // يمكنك إضافة المزيد من البيانات هنا
        ]);
    
}

}

