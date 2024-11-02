<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sabbir Al-Razi <[sabbir.techvill@gmail.com]>
 *
 * @created 20-05-2021
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Admin\StoreUserRequest;
use App\DataTables\{
    UserListDataTable,
    UserWalletDataTable,
    UsersActivityDataTable
};
use Spatie\Activitylog\Models\Activity;
use App\Models\{
    User,
    File,
    Role,
    RoleUser
};
use App\Exports\{
    UserListExport
};
use App\Http\Resources\AjaxSelectSearchResource;
use App\Notifications\UserPasswordSetNotification;
use App\Notifications\UserVerificationNotification;
use App\Notifications\WelcomeUserNotification;
use Excel;
use DB;
use Session;
use Auth;
use Str;

class UserController extends Controller
{
    /**
     * User List
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(UserListDataTable $dataTable)
    {
        return $dataTable->render('admin.users.index', ['roles' => Role::getAll()]);
    }

    /**
     * Create
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function create()
    {
        return view('admin.users.create', ['roles' => Role::getAll()->whereNotIn('slug', ['vendor-admin', 'guest'])]);
    }

    /**
     * Store
     *
     * @param  Request  $request  [description]
     * @return \Illuminate\Routing\Redirector
     */
    public function store(StoreUserRequest $request)
    {
        $data = ['status' => 'fail', 'message' => __('Invalid Request')];
        if ($request->isMethod('post')) {

            $request['raw_password'] = $request->password;
            $request['password'] = \Hash::make($request->password);
            $request['email'] = validateEmail($request->email) ? strtolower($request->email) : null;

            $request['activation_code'] = null;
            if ($request->status != 'Active') {
                $request['activation_code'] = Str::random(10);
            }

            try {
                DB::beginTransaction();
                $id = (new User())->store($request->only('name', 'email', 'phone', 'activation_code', 'password', 'status'));
                if (! empty($id)) {
                    $roleAll = Role::getAll();
                    $roles = [];
                    foreach ($request->role_ids as $role_id) {
                        $roles[] = ['user_id' => $id, 'role_id' => $role_id];
                        $role = $roleAll->where('id', $role_id)->first();
                    }
                    if (! empty($roles)) {
                        $role_insert=(new RoleUser())->store($roles);
                        // dd($role_insert);
                    }
                    $request['role'] = $role;

                    if (isset($request->send_mail) && $request->status != 'Inactive' && ! empty($request['email'])) {
                        $notification = $request->status == 'Active' ? new WelcomeUserNotification($request) : new UserVerificationNotification($request);
                        User::firstWhere('email', $request['email'])->notify($notification);
                    }

                    $data['status'] = 'success';
                    $data['message'] = __('The :x has been successfully saved.', ['x' => __('User Info')]);
                    DB::commit();
                }
            } catch (Exception $e) {
                DB::rollBack();
                $data['message'] = $e->getMessage();
            }
        }

        $this->setSessionValue($data);

        return redirect()->route('users.index');
    }

    /**
     * Verification
     *
     * @param  int  $id
     * @return \Illuminate\Routing\Redirector
     */
    public function verification($code)
    {
        $user = User::where('activation_code', $code)->first();
        if (empty($user)) {
            $this->setSessionValue(['status' => 'fail', 'message' => __('Invalid Request')]);

            return redirect('/admin/login');
        } elseif ($user->status == 'Active') {
            $this->setSessionValue(['status' => 'fail', 'message' => __('This account is already activated')]);

            return redirect('/admin/login');
        }

        User::where('activation_code', $code)->update(['status' => 'Active', 'activation_code' => null, 'email_verified_at' => now()]);
        $this->setSessionValue(['status' => 'success', 'message' => __('Your account is activated, please login')]);

        return redirect('/admin/login');
    }

    /**
     * Edit
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function edit($id = null)
    {
        $data['user'] = User::getAll()->where('id', $id)->first();

        if (is_null($data['user'])) {
            return redirect()->back()->withFail(__('User does not exist.'));
        }

        $data['roleIds'] = $data['user']->roles()->pluck('id')->toArray();
        $role = ['guest', 'vendor-admin'];
        if ($data['user']->vendors()->first()) {
            $role = ['guest'];
        }
        $data['roles'] = Role::getAll()->whereNotIn('slug', $role);

        return view('admin.users.edit', $data);
    }

    /**
     * Update password
     *
     * @param  int  $id
     * @return \Illuminate\Routing\Redirector
     */
    public function updatePassword(Request $request, $id = null)
    {
        $data = ['status' => 'fail', 'message' => __('Invalid Request')];
        if ($request->isMethod('post')) {
            $response = $this->checkExistence($id, 'users', ['getData' => true]);
            if ($response['status'] === true) {
                $validator = User::updatePasswordValidation($request->all());
                if ($validator->fails()) {
                    return back()->withErrors($validator)->withInput();
                }

                $request['user_name'] =  $response['data']->name;
                $request['email'] =  $response['data']->email;
                $request['raw_password'] = $request->password;
                $request['updated_at'] = date('Y-m-d H:i:s');
                $request['password'] = \Hash::make(trim($request->password));

                if ((new User())->updateUser($request->only('password', 'updated_at'), $id)) {
                    if (isset($request->send_mail) && ! empty($request->send_mail)) {
                        User::firstWhere('email', $request->email)->notify(new UserPasswordSetNotification($request));
                    }
                    $data['status'] = 'success';
                    $data['message'] = __('Password update successfully.');
                } else {
                    $data['message'] = __('Nothing is updated.');
                }
            } else {
                $data['message'] = $response['message'];
            }
        }

        Session::flash($data['status'], $data['message']);

        return redirect()->route('users.edit', ['id' => $id]);
    }

    /**
     * Update profile password
     *
     * @param  int  $id
     * @return \Illuminate\Routing\Redirector
     */
    public function updateProfilePassword(Request $request, $id = null)
    {
        $this->updatePassword($request, $id);

        return redirect()->route('dashboard');
    }

    /**
     * Update
     *
     * @param  int  $id
     * @return \Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id = null)
    {
        $response = ['status' => 'fail', 'message' => __('Invalid Request')];
        if ($request->isMethod('post')) {
            $result = $this->checkExistence($id, 'users');
            if ($result['status'] === true) {
                $request['phone'] = $request['dial_code'] . $request['phone'];
                $validator = User::updateValidation($request->all(), $id);

                if ($validator->fails()) {
                    return back()->withErrors($validator)->withInput();
                }

                try {
                    DB::beginTransaction();

                    $request['email'] = validateEmail($request->email) ? strtolower($request->email) : null;
                    $data['userData'] = $request->only('name', 'email', 'phone', 'status');
                    $data['userMetaData'] = $request->only('designation', 'description', 'facebook', 'twitter', 'instagram');
                    $userStore = (new user())->updateUser($data, $id);

                    if ($userStore) {
                        if (isset($request->role_ids)) {
                            $request['user_id'] = $id;
                            (new RoleUser())->remove($id);

                            $roles = [];
                            foreach ($request->role_ids as $role_id) {
                                $roles[] = ['user_id' => $id, 'role_id' => $role_id];
                            }
                            if (! empty($roles)) {
                                (new RoleUser())->store($roles);
                            }
                        }

                        DB::commit();
                        $response['status'] = 'success';
                        $response['message'] = __('The :x has been successfully saved.', ['x' => __('User Info')]);
                    }
                } catch (Exception $e) {
                    DB::rollBack();
                    $response['message'] = $e->getMessage();
                }
            } else {
                $response['message'] = $result['message'];
            }
        }

        $this->setSessionValue($response);
        if (isset($request->user_profile)) {
            return redirect()->back();
        }

        return redirect()->route('users.index');
    }

    /**
     * Update Profile
     *
     * @param  int  $id
     * @return \Illuminate\Routing\Redirector
     */
    public function updateProfile(Request $request, $id = null)
    {
        $response = ['status' => 'fail', 'message' => __('Invalid Request')];
        $result = $this->checkExistence($id, 'users');
        if ($result['status'] === true) {
            $request['phone'] = $request['dial_code'] . $request['phone'];
            $validator = User::updateProfileValidation($request->all(), $id);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $request['email'] = validateEmail($request->email) ? strtolower($request->email) : null;
            $data['userData'] = $request->only('name', 'email', 'phone', 'status');
            $data['userMetaData'] = $request->only('designation', 'description', 'facebook', 'twitter', 'instagram');
            (new user())->updateUser($data, $id);
            $response['status'] = 'success';
            $response['message'] = __('The :x has been successfully saved.', ['x' => strtolower(__('User Info'))]);
        } else {
            $response['message'] = $result['message'];
        }

        $this->setSessionValue($response);

        return redirect()->route('dashboard');
    }

    /**
     * Delete
     *
     * @param  int  $id
     * @return \Illuminate\Routing\Redirector
     */
    public function destroy(Request $request, $id = null)
    {
        $response = ['status' => 'fail', 'message' => __('Invalid Request')];
        if ($request->isMethod('post')) {
            $result = $this->checkExistence($id, 'users');
            if ($result['status'] === true) {
                $response = (new User())->remove($id);
            } else {
                $response['message'] = $result['message'];
            }
        }

        $this->setSessionValue($response);

        return redirect()->route('users.index');
    }

    /**
     * Profile
     *
     * @return view
     */
    public function profile()
    {
        $id = Auth::guard('user')->user()->id;
        $data['user'] = User::getAll()->where('id', $id)->first();
        $data['roleIds'] = $data['user']->roles()->pluck('id')->toArray();
        $data['roles'] = Role::getAll();

        return view('admin.users.profile', $data);
    }

    /**
     * Import User
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function import(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('admin.epz.import.user');
        }

        $data = ['status' => 'fail', 'message' => __('Invalid Request')];

        $validator = User::importValidation($request->all());
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if (! $request->hasFile('file')) {
            return back()->withErrors(['fail' => __('Please upload a CSV file.')]);
        }
        $path = $request->file('file')->getRealPath();
        $csv = [];

        if (is_uploaded_file($path)) {
            $csv = readCSVFile($path, true);
        }

        if (empty($csv)) {
            return back()->withErrors(__('Your CSV has no data to import'));
        }

        $requiredHeader  = ['Name', 'Email', 'Role', 'Password', 'Status'];
        $header = array_keys($csv[0]);

        // Check if required headers are available or not
        if (! empty(array_diff($requiredHeader, $header))) {
            return back()->withErrors(__('Please Check CSV Header Name.'));
        }

        $errorMessages = [];
        $emails = User::pluck('email')->toArray();
        $emails = array_change_key_case($emails, CASE_LOWER);

        $roles = ['admin' => 1, 'customer' => 3];

        foreach ($csv as $key => $value) {
            $errorFails = [];

            $value = array_map('trim', $value);

            // check if first name is empty
            if (empty($value['Name'])) {
                $errorFails[] = __(':x is required', ['x' => __('Name')]);
            }

            // check if there is any value in the email field then the email is not used and a valid email
            if (empty($value['Email'])) {
                $errorFails[] = __(':x is required', ['x' => __('Email')]);
            } elseif (empty(validateEmail($value['Email']))) {
                $errorFails[] = __('Enter a valid email');
            } elseif (in_array(strtolower($value['Email']), $emails)) {
                $errorFails[] = __(':x is already taken.', ['x' => __('Email')]);
            }

            // check if the password is not empty and contains at least eight characters
            if (empty($value['Password'])) {
                $errorFails[] = __(':x is required', ['x' => __('Password')]);
            } elseif (strlen($value['Password']) < 8) {
                $errorFails[] = __('Password should be at least 8 characters');
            }

            // check if the status is valid
            if (empty($value['Status'])) {
                $errorFails[] = __(':x is required', ['x' => __('Status')]);
            } elseif (! (strtolower($value['Status']) == 'active' || strtolower($value['Status']) == 'inactive' || strtolower($value['Status']) == 'pending' || strtolower($value['Status']) == 'deleted')) {
                $errorFails[] = __('Status can be either :x, :y, :z or :a.', ['x' => __('Active'), 'y' => __('Inactive'), 'z' => __('Pending'), 'a' => __('Deleted')]);
            }

            if (empty($errorFails)) {
                try {
                    DB::beginTransaction();

                    $data = [
                        'name' => $value['Name'],
                        'email' => $value['Email'],
                        'password' => \Hash::make($value['Password']),
                        'status' => $value['Status'],
                    ];

                    if ($id = (new User())->store($data)) {
                        array_push($emails, $value['Email']);

                        (new RoleUser())->store(['user_id' => $id, 'role_id' => $roles[$value['Role']] ?? 3]);

                        DB::commit();
                    }
                } catch (\Exception $e) {
                    DB::rollBack();
                    $errorFails[] = $e->getMessage();
                }
            }

            // set the error messages
            if (! empty($errorFails)) {
                $errorMessages[$key] = ['fails' => $errorFails, 'data' => $value];
            }
        }

        // redirect with success message if no error found.
        if (empty($errorMessages)) {
            \Session::flash('success', __('Total Imported row: ') . count($csv));

            return redirect()->route('epz.imports');
        }

        $data['totalRow'] = count($csv);

        return view('admin.layouts.includes.csv_import_errors', $data)->with('errorMessages', $errorMessages);
    }

    /**
     * User list pdf
     *
     * @return html static page
     */
    public function pdf()
    {
        $data['users'] = User::orderBy('id', 'desc')->get();

        return printPDF($data, 'user_list' . time() . '.pdf', 'admin.users.list_pdf', view('admin.users.list_pdf', $data), 'pdf');
    }

    /**
     * User list csv
     *
     * @return html static page
     */
    public function csv()
    {
        return Excel::download(new UserListExport(), 'user_list' . time() . '.csv');
    }

    /**
     * User wallet
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function wallet(UserWalletDataTable $dataTable, $id = null)
    {
        $data['user'] = User::getAll()->where('id', $id)->first();
        if (! empty($data['user'])) {
            $data['wallet'] = 'active';

            return $dataTable->with(['userId' => $id])->render('admin.users.wallet', $data);
        } else {
            return back()->withErrors(__('Invalid Request'));
        }
    }

    /**
     * Find users
     *
     * @return json
     */
    public function findUser(Request $request)
    {
        $users = User::whereLike('name', $request->q)->limit(10)->get();

        return AjaxSelectSearchResource::collection($users);
    }

    /**
     * All users activities log
     *
     * @return mixed
     */
    public function allUserActivity(UsersActivityDataTable $dataTable)
    {
        return $dataTable->render('admin.users.activity_list');
    }

    /**
     * Delete user activity log
     *
     * @param  int  $id
     * @return mixed
     */
    public function deleteUserActivity($id)
    {
        $response = ['status' => 'fail', 'message' => __('Invalid Request')];
        $result = $this->checkExistence($id, 'activity_logs');

        if ($result['status'] === true) {
            Activity::find($id)->delete();
            $response['status'] = 'success';
            $response['message'] = 'Activity log deleted successfully!';
        } else {
            $response['message'] = $result['message'];
        }

        $this->setSessionValue($response);                                  // flash response

        return redirect()->route('users.activity');
    }
}
