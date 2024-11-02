<?php

namespace App\Models;

use App\Rules\{
    CheckValidEmail,
    StrengthPassword
};
use Validator;

class PasswordReset extends Model
{
    protected $table = 'password_resets';

    public $timestamps = false;

    protected $fillable = [
        'email', 'token', 'created_at',
    ];

    /**
     * Store Validation
     *
     * @param  array  $data
     * @return mixed
     */
    protected static function storeValidation($data = [])
    {
        $validator = Validator::make($data, [
            'email' => ['required', 'email', 'exists:users', new CheckValidEmail()],
        ]);

        return $validator;
    }

    /**
     * Password Validation
     *
     * @param  array  $data
     * @return mixed
     */
    protected static function passwordValidation($data = [])
    {
        $validator = Validator::make($data, [
            'password' => ['required', 'confirmed', new StrengthPassword()],
        ]);

        return $validator;
    }

    /**
     * store
     *
     * @param  array  $data
     * @return bool
     */
    public function storeOrUpdate($data = [])
    {
        if (parent::updateOrInsert(['email' => $data['email']], $data)) {
            return true;
        }

        return false;
    }

    /**
     * Check token existance
     *
     * @param  array  $data
     * @return bool
     */
    public function tokenExist($data)
    {
        if (parent::where('token', $data)->orWhere('otp', $data)->first()) {
            return true;
        }

        return false;
    }

    /**
     * Update
     *
     * @param  array  $request
     * @param  int  $id
     * @return array
     */
    public function updatePassword($request = [], $id = null)
    {
        $data = ['status' => 'fail', 'message' => __('Something went wrong, please try again.')];
        $result = User::where('id', $id);
        if ($result->exists()) {
            $result->update(array_intersect_key($request, array_flip((array) ['password', 'updated_at'])));

            parent::where('token', $request['token'])->orWhere('otp', $request['token'])->update(['token' => null, 'otp' => null]);

            $data['status'] = 'success';
            $data['message'] = __('Password reset successfully');
        }

        return $data;
    }
}
