<?php

namespace Modules\FormBuilder\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\FormBuilder\Entities\Form;

class FormTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        Form::create([
            'user_id' => '1',
            'name' => 'KYC Form',
            'visibility' => 'PRIVATE',
            'type' => 'kyc',
            'allows_edit' => '1',
            'identifier' => '1-LJA43JKHHM4KLAJ82K3C',
            'form_builder_json' => '[{"type":"text","required":true,"label":"Full Name","className":"form-control","name":"name","subtype":"text"},{"type":"text","subtype":"email","required":true,"label":"Email","className":"form-control","name":"email"},{"type":"text","required":true,"label":"NID Number","description":"National Identity Card Number","className":"form-control","name":"nid","subtype":"text"},{"type":"file","required":true,"label":"NID Image","className":"form-control","name":"nid_image"},{"type":"text","required":true,"label":"Tax ID","className":"form-control","name":"tax_id","subtype":"text"},{"type":"text","required":true,"label":"Trade License No.","className":"form-control","name":"trade_license","subtype":"text"}]',
        ]);
    }
}
