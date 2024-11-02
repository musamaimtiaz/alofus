<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 *
 * @created 30-01-2022
 */

namespace App\Models;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;
use Validator;

class OrderStatus extends Model
{
    use ModelTrait;

    /**
     * relation with role table
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function role()
    {
        return $this->belongsToMany('App\Models\Role', 'order_status_roles');
    }

    /**
     * Relation with FlashSale model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderStatusRole()
    {
        return $this->hasMany('App\Models\OrderStatusRole', 'order_status_id', 'id');
    }

    /**
     * Foreign key with OrderStatusHistory model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderHistories()
    {
        return $this->hasMany('App\Models\OrderStatusHistory', 'order_status_id');
    }

    /**
     * Relation with Order model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }

    /**
     * Relation with Order Details model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderDetails()
    {
        return $this->hasMany('App\Models\OrderDetail');
    }

    /**
     * role name
     *
     * @return string
     */
    public function roleName($roles)
    {
        $str = '';

        foreach ($roles as $role) {
            $str .= '<p><span class="fas fa-bullseye mr-2"></span>' . $role->name . '</p>';
        }

        return $str;
    }

    /**
     * Store Validation Rules
     *
     * @param  array  $data
     * @return object
     */
    protected function storeValidation($data = [])
    {
        $validator = Validator::make($data, [
            'name' => 'required|min:2|unique:order_statuses,name',
            'order_by' => 'required|numeric|unique:order_statuses,order_by',
            'role_ids' => 'required',
            'payment_scenario' => 'sometimes|in:paid,unpaid',
            'is_default' => 'required | in:1,0',
        ]);

        return $validator;
    }

    /**
     * Order Status validation rules
     *
     * @return mixed
     */
    protected function updateValidation($data, $id)
    {
        $validator = Validator::make($data, [
            'name' => ['required', 'min:2', 'unique:order_statuses,name,' . $id],
            'order_by' => ['required', 'numeric', 'unique:order_statuses,order_by,' . $id],
            'role_ids' => 'required',
            'payment_scenario' => 'sometimes|in:paid,unpaid',
            'is_default' => 'required | in:1,0',
        ]);

        return $validator;
    }

    /**
     * Store status
     *
     * @param  array  $data
     * @return object
     */
    public function store($data = [])
    {
        if ($data['is_default'] == 1) {
            parent::where('is_default', 1)->update(['is_default' => 0]);
        }

        $slug = str_replace(' ', '-', strtolower($data['name']));

        while (1) {
            $isSlugExists = parent::where('slug', $slug);

            if ($isSlugExists->exists()) {
                $slug = $slug . '-' . strtolower(\Str::random(5));
            } else {
                break;
            }
        }

        $data['slug'] = $slug;
        $id = parent::insertGetId($data);

        if (! empty($id)) {
            self::forgetCache();

            return $id;
        } else {
            return false;
        }
    }

    /**
     * Status Update
     *
     * @return bool
     */
    public function statusUpdate($data, $id)
    {
        if ($data['is_default'] == 1) {
            parent::where('is_default', 1)->update(['is_default' => 0]);
        } elseif ($data['is_default'] == 0) {

            if (parent::where('is_default', 1)->where('id', '!=', $id)->count() == 0) {
                return false;
            }
        }

        if (parent::where('id', $id)->update($data)) {
            self::forgetCache();

            return true;
        }

        return false;
    }

    /**
     * Status Role Delete
     *
     * @param  null  $id
     * @return array
     */
    public function remove($id = null)
    {
        $data = ['type' => 'fail', 'message' => __('Something went wrong, please try again.')];

        $record = OrderDetail::where('order_status_id', $id);

        if ($record->exists()) {
            return ['type' => 'fail', 'message' => __('Can not be deleted. This :x has records!', ['x' => __('Status')])];
        }

        $statusInfo = parent::find($id);

        if (! empty($statusInfo)) {
            $isCore = in_array($statusInfo->slug, coreStatusSlug());

            if ($statusInfo->is_default != 1 && ! $isCore) {
                $statusInfo->delete();
                self::forgetCache();
                $data = ['type'    => 'success', 'message' => __('The :x has been successfully deleted.', ['x' => __('Status')])];
            } else {

                if ($isCore) {
                    return ['type' => 'fail', 'message' => __('Can not be deleted. This is core status.')];
                }
                $data = ['type' => 'fail', 'message' => __('Can not be deleted. This is default status.')];
            }

        }

        return $data;
    }

    public static function vendorStatusPermission($statusId = null)
    {
        $orderStatusRole = OrderStatusRole::getAll()->where('order_status_id', $statusId)->where('role_id', 2)->first();

        if (! empty($orderStatusRole)) {
            return true;
        }

        return false;
    }
}
