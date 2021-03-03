<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->delete();
        $adminRecords = [
        	['id' => 1, 'name'=>'admin', 'type'=>'admin', 'mobile'=>'9866031721','email'=>'admin@gmail.com', 'password'=>'$2y$10$JI18r0xmuGIv9/z8vLq0IeuENw01M06K9DMmRJC4V9zZmrwq.JE2m', 'image'=>'', 'status'=>1],

            ['id' => 2, 'name'=>'subadmin', 'type'=>'subadmin', 'mobile'=>'9866031721','email'=>'subadmin@gmail.com', 'password'=>'$2y$10$JI18r0xmuGIv9/z8vLq0IeuENw01M06K9DMmRJC4V9zZmrwq.JE2m', 'image'=>'', 'status'=>1],

        ];

        DB::table('admins')->insert($adminRecords);
        // foreach ($adminRecords as $key => $record) {
        // 	\App\Models\Admin::create($record);
        // }
    }
}
