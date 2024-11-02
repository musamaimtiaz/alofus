<?php

namespace Infoamin\Installer\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\User;
use App\Models\Vendor;
use App\Models\VendorUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Modules\Shop\Http\Models\Shop;

class UserController extends Controller
{
    /**
     * Show form.
     *
     * @return \Illuminate\View\View
     */
    public function createUser()
    {
        $data['fields'] = config('installer.fields');
        $data['field_types'] = config('installer.field_types');

        return view('packages.installer.register', $data);
    }

    /**
     * Manage form submission.
     *
     * @param  Illuminate\Http\Request  $request
     */
    public function storeUser(Request $request)
    {
        // Form validation with form request or validator method
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:155',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|max:191',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $user = User::find(1);

            $request->request->add([
                'password' => Hash::make($request->password),
                'status' => 'Active',
            ]);

            if ($user) {
                $user->name = $request->name;
                $user->email = $request->email;
                $user->password = $request->password;
                $user->save();
            } else {
                $user = User::create($request->only('name', 'email', 'password', 'status'));

                $role = Role::whereSlug('super-admin')->first();

                $userRole = RoleUser::where('user_id', $user->id)->where('role_id', $role->id)->first();

                if (! $userRole) {
                    $userRole = RoleUser::create(['user_id' => $user->id, 'role_id' => $role->id]);
                }

                $request->request->add(['role' => $role]);

                $data['vendorData'] = [
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => '0123456789',
                    'status' => 'Active',
                    'sell_commissions' => 0,
                ];

                $vendorId = (new Vendor())->store($data);
                $shop = [
                    'vendor_id' => $vendorId,
                    'name' => $request->name,
                    'email' => $request->email,
                    'alias' => \Str::slug($request->name),
                    'status' => 'Active',
                ];

                (new Shop())->store($shop);

                (new VendorUser())->store(['vendor_id' => $vendorId, 'user_id' => $user->id, 'status' => 'Active']);
            }
            DB::commit();
        } catch (\Exception $e) {
            abort(500, __('Failed to create new user.'));
            DB::rollBack();
        }

        return redirect('install/finish');
    }
}
