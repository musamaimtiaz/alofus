<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sabbir Al-Razi <[sabbir.techvill@gmail.com]>
 *
 * @created 20-05-2021
 */

namespace App\Models;

use DB;
use Validator;

class Role extends Model
{
    public function roleUser()
    {
        return $this->hasMany('App\Models\RoleUser', 'role_id');
    }

    public function user()
    {
        return $this->belongsToMany(User::class)->using(RoleUser::class);
    }

    /**
     * Store Validation
     *
     * @param  array  $data
     * @return mixed
     */
    protected static function storeValidation($data = [])
    {
        $validator = Validator::make($data, [
            'name' => 'required|max:50',
            'slug' => 'required|unique:roles,slug',
            'description' => 'nullable|max:200',
            'type' => 'required|in:global,vendor',
        ]);

        return $validator;
    }

    /**
     * Update validation
     *
     * @param  array  $data
     * @param  int  $id
     * @return mixed
     */
    protected static function updateValidation($data = [], $id = null)
    {
        $validator = Validator::make($data, [
            'name' => 'required|max:50',
            'slug' => [
                'required',
                'unique:roles,slug,' . $id,
            ],
            'description' => 'nullable|max:200',
            'type' => 'in:global,vendor',
        ]);

        return $validator;
    }

    /**
     * store
     *
     * @param  array  $data
     * @return bool
     */
    public function store($data = [])
    {
        if (parent::insert($data)) {
            self::forgetCache();

            return true;
        }

        return false;
    }

    /**
     * delete
     *
     * @param  int  $id
     * @return object
     */
    public function remove($id = null)
    {
        $data = ['status' => 'fail', 'message' => __('Something went wrong, please try again.')];
        $record = parent::find($id);
        if (! empty($record)) {
            try {
                DB::beginTransaction();
                RoleUser::where('role_id', $record->id)->delete();
                PermissionRole::where('role_id', $record->id)->delete();
                $record->delete();
                self::forgetCache(['roles', 'role_users', 'permission_roles']);
                DB::commit();

                $data['status'] = 'success';
                $data['message'] = __('The :x has been successfully deleted.', ['x' => __('Role')]);
            } catch (Exception $e) {
                DB::rollBack();
                $data['message'] = $e->getMessage();
            }
        }

        return $data;
    }

    /**
     * Update
     *
     * @param  array  $request
     * @param  int  $id
     * @return array
     */
    public function updateRole($request = [], $id = null)
    {
        $data = ['status' => 'fail', 'message' => __('Something went wrong, please try again.')];
        $result = parent::where('id', $id);
        if ($result->exists()) {
            try {
                $result->update(array_intersect_key($request, array_flip((array) ['name', 'slug', 'type', 'description'])));
                self::forgetCache();

                $data['status'] = 'success';
                $data['message'] = __('The :x has been successfully saved.', ['x' => __('Role')]);
            } catch (Exception $e) {
                $data['message'] = $e->getMessage();
            }
        }

        return $data;
    }
}
