<?php

namespace App\Models;

class VendorUser extends Model
{
    /**
     * Foreign key with Vendor model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function vendor()
    {
        return $this->belongsTo('App\Models\Vendor', 'vendor_id');
    }

    /**
     * Foreign key with User model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    /**
     * Store
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

    public static function getVendorAdminId($vendorId)
    {
        return Vendor::join('vendor_users', 'vendor_id', '=', 'vendors.id')
            ->join('role_users', 'role_users.user_id', '=', 'vendor_users.user_id')
            ->join('roles', 'roles.id', '=', 'role_users.role_id')
            ->where('vendor_users.vendor_id', $vendorId)
            ->where('roles.slug', 'vendor-admin')
            ->select('vendors.id', 'vendors.name', 'vendors.email', 'vendors.phone', 'vendors.status', 'vendors.formal_name', 'vendor_users.user_id', 'roles.slug')
            ->first();
    }

    public static function getVendorDetails($userId)
    {
        return Vendor::join('vendor_users', 'vendor_id', '=', 'vendors.id')
            ->where('vendor_users.user_id', $userId)
            ->select('vendors.id', 'vendors.name', 'vendors.email', 'vendors.phone', 'vendors.status', 'vendors.formal_name')
            ->first();
    }
}
