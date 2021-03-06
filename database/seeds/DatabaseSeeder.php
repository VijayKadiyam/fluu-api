<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
      $this->call(RoleSeeder::class);
      $this->call(SiteSeeder::class);
      $this->call(UserSeeder::class);
      $this->call(PermissionSeeder::class);
      $this->call(PermissionRoleSeeder::class);
      $this->call(StateSeeder::class);

    }
}
