<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sabbir Al-Razi <[sabbir.techvill@gmail.com]>
 *
 * @created 20-05-2021
 */

namespace App\Models;

use App\Rules\{
    CheckValidEmail
};
use Validator;

class EmailConfiguration extends Model
{
    /**
     * timestamps
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Validation
     *
     * @param  array  $data
     * @return mixed
     */
    protected static function validation($data = [])
    {
        $emailValidation = '';
        if ($data['protocol'] == 'smtp') {
            $emailValidation = ['email', new CheckValidEmail()];
        }

        $validator = Validator::make($data, [
            'protocol' => 'required|in:smtp,sendmail',
            'encryption' => 'required_if:protocol,smtp',
            'smtp_host' => 'required_if:protocol,smtp',
            'smtp_port' => 'required_if:protocol,smtp',
            'smtp_email' => ['required_if:protocol,smtp', $emailValidation],
            'from_address' => ['required_if:protocol,smtp', $emailValidation],
            'from_name' => ['required_if:protocol,smtp'],
            'smtp_username' => ['required_if:protocol,smtp'],
            'smtp_password' => 'required_if:protocol,smtp',
        ]);

        return $validator;
    }

    /**
     * Store
     *
     * @param  array  $request
     * @return bool
     */
    public function store($request = [])
    {
        if (parent::updateOrInsert(['id' => 1], $request)) {
            self::forgetCache();

            return true;
        }

        return false;
    }
}
