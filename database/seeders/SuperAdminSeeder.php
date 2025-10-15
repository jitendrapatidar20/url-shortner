<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder {
   public function run() 
   {
        DB::statement("INSERT INTO roles (name, created_at, updated_at) VALUES ('SuperAdmin', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP), ('Admin', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP), ('Member', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)");

        
        // insert a SuperAdmin user (password: superadmin)
        $now = date('Y-m-d H:i:s');
        $email = 'superadmin@sembark.com';
        $passwordHash = Hash::make('superadmin');

        // Create a  company
        DB::table('companies')->insert(['name' => 'Sembark Company','slug'=>'sembark-company','created_at'=>$now]);
        $companyId = DB::table('companies')->where('slug','sembark-company')->value('id');

        $roleId = DB::table('roles')->where('name','SuperAdmin')->value('id');

        DB::statement("INSERT INTO users (name, email, password,slug,company_id,role_id, status,created_at, updated_at) VALUES ('Super Admin', '{$email}', '{$passwordHash}','super-admin',{$companyId}, {$roleId},1,'{$now}', '{$now}')");

    }
}