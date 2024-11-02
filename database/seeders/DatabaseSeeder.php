<?php

namespace Database\Seeders;

use Database\Seeders\versions\v1_1_0\DatabaseSeeder as V11DatabaseSeeder;
use Database\Seeders\versions\v1_2_0\DatabaseSeeder as V12DatabaseSeeder;
use Database\Seeders\versions\v1_3_0\DatabaseSeeder as V13DatabaseSeeder;
use Database\Seeders\versions\v1_4_0\DatabaseSeeder as V14DatabaseSeeder;
use Database\Seeders\versions\v1_5_0\DatabaseSeeder as V15DatabaseSeeder;
use Database\Seeders\versions\v1_6_0\DatabaseSeeder as V16DatabaseSeeder;
use Database\Seeders\versions\v1_7_0\DatabaseSeeder as V17DatabaseSeeder;
use Database\Seeders\versions\v1_8_0\DatabaseSeeder as V18DatabaseSeeder;
use Database\Seeders\versions\v2_0_0\DatabaseSeeder as V20DatabaseSeeder;
use Database\Seeders\versions\v2_0_1\DatabaseSeeder as V201DatabaseSeeder;
use Database\Seeders\versions\v2_1_0\DatabaseSeeder as V21DatabaseSeeder;
use Database\Seeders\versions\v2_1_1\DatabaseSeeder as V211DatabaseSeeder;
use Database\Seeders\versions\v2_2_0\DatabaseSeeder as V22DatabaseSeeder;
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
        if (file_exists('Modules\Dummy\Database\Seeders\DummyImportDatabaseSeeder.php')) {
            $this->call(\Modules\Dummy\Database\Seeders\DummyImportDatabaseSeeder::class);

            if (file_exists('Modules\Credential\Database\Seeders\CredentialDatabaseSeeder.php')) {
                $this->call(\Modules\Credential\Database\Seeders\CredentialDatabaseSeeder::class);
            }

            return;
        }

        $this->call(CurrenciesTableSeeder::class);
        $this->call(LanguagesTableSeeder::class);
        $this->call(EmailTemplatesTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(PreferencesTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableWithoutDummyDataSeeder::class);
        $this->call(VendorsTableWithoutDummyDataSeeder::class);
        $this->call(RoleUsersTableWithoutDummyDataSeeder::class);
        $this->call(VendorUsersTableWithoutDummyDataSeeder::class);
        $this->call(CategoriesTableWithoutDummyDataSeeder::class);
        $this->call(PermissionRolesTableSeeder::class);
        $this->call(OrderStatusesTableSeeder::class);
        $this->call(OrderStatusRolesTableSeeder::class);
        $this->call(WithdrawalMethodsTableSeeder::class);
        $this->call(VendorsMetaTableWithoutDummyDataSeeder::class);
        $this->call(V11DatabaseSeeder::class);
        $this->call(V12DatabaseSeeder::class);
        $this->call(V13DatabaseSeeder::class);
        $this->call(V14DatabaseSeeder::class);
        $this->call(V15DatabaseSeeder::class);
        $this->call(V16DatabaseSeeder::class);
        $this->call(V17DatabaseSeeder::class);
        $this->call(V18DatabaseSeeder::class);
        $this->call(V20DatabaseSeeder::class);
        $this->call(V201DatabaseSeeder::class);
        $this->call(V21DatabaseSeeder::class);
        $this->call(V211DatabaseSeeder::class);
        $this->call(V22DatabaseSeeder::class);
    }
}
