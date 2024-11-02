<?php

namespace Modules\FormBuilder\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuItemsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        /**
         * Auto generated seed file
         *
         * @return void
         */
        DB::table('menu_items')->upsert([
            ['id' => 70, 'label' => 'KYC', 'link' => 'forms/kyc-form', 'params' => '{"permission":"Modules\\\\FormBuilder\\\\Http\\\\Controllers\\\\KycController@index", "route_name":["formbuilder::kyc.index", "formbuilder::kyc.edit", "formbuilder::kyc.sub-view", "formbuilder::kyc.sub-edit"], "menu_level":"1"}', 'is_default' => 1, 'icon' => null, 'parent' => 67, 'sort' => 37, 'class' => null, 'menu' => 1, 'depth' => 1],
            ['id' => 71, 'label' => 'KYC', 'link' => 'kyc', 'params' => '{"permission":"Modules\\\\FormBuilder\\\\Http\\\\Controllers\\\\Vendor\\\\KycController@userKycForm", "route_name":["kyc.user.show"], "menu_level":"3"}', 'is_default' => 1, 'icon' => 'far fa-address-card', 'parent' => 0, 'sort' => 9, 'class' => null, 'menu' => 3, 'depth' => 0],
            ['id' => 68, 'label' => 'All Forms', 'link' => 'forms', 'params' => '{"permission":"Modules\\\\FormBuilder\\\\Http\\\\Controllers\\\\FormController@index", "route_name":["formbuilder::forms.index", "formbuilder::forms.create", "formbuilder::forms.edit"], "menu_level":"1"}', 'is_default' => 1, 'icon' => null, 'parent' => 67, 'sort' => 35, 'class' => null, 'menu' => 1, 'depth' => 1],
            ['id' => 67, 'label' => 'Forms', 'link' => null, 'params' => '{"permission":"Modules\\\\FormBuilder\\\\Http\\\\Controllers\\\\FormController@index","route_name":["formbuilder::kyc.index", "formbuilder::kyc.edit", "formbuilder::kyc.sub-view", "formbuilder::submissions.all","formbuilder::entry.index","formbuilder::entry.edit", "formbuilder::entry.update", "formbuilder::entry.show", "formbuilder::forms.index", "formbuilder::forms.create", "formbuilder::forms.edit"]}', 'is_default' => 0, 'icon' => 'fas fa-window-restore', 'parent' => 0, 'sort' => 34, 'class' => null, 'menu' => 1, 'depth' => 0],
            ['id' => 69, 'label' => 'All Submissions', 'link' => 'forms/submissions', 'params' => '{"permission":"Modules\\\\FormBuilder\\\\Http\\\\Controllers\\\\SubmissionController@index", "route_name":["formbuilder::submissions.all","formbuilder::entry.index","formbuilder::entry.edit", "formbuilder::entry.update", "formbuilder::entry.show"], "menu_level":"1"}', 'is_default' => 1, 'icon' => null, 'parent' => 67, 'sort' => 36, 'class' => null, 'menu' => 1, 'depth' => 1],
        ], 'id');
    }
}
