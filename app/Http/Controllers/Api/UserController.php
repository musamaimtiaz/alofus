<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 *
 * @created 29-05-2021
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\EmailController;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Resources\{
    UserResource,
    userDetailResource,
};
use App\Models\{
    File,
    User
};
use App\Notifications\UserPasswordSetNotification;
use App\Notifications\WelcomeUserNotification;
use Illuminate\Http\Request;
use DB;
use Cache;

class UserController extends Controller
{
    /**
     * UserController constructor.
     *
     * @return void
     */
    public function __construct(EmailController $email)
    {
        $this->email = $email;
    }

    /**
     * User List
     *
     * @return json $data
     */
    public function index(Request $request)
    {
        $configs        = $this->initialize([], $request->all());
        $user           = User::select('*');
        $name           = isset($request->name) ? $request->name : null;
        if (! empty($name)) {
            $user->where('name', strtolower($name));
        }
        $email = isset($request->email) ? $request->email : null;
        if (! empty($email)) {
            $user->where('email', strtolower($email));
        }
        $status = isset($request->status) ? $request->status : null;
        if (! empty($status)) {
            $user->where('status', $status);
        }

        $roleId = isset($request->role_id) ? $request->role_id : null;
        if (! empty($roleId)) {
            $user->whereHas('roleUser', function ($query) use ($roleId) {
                $query->where('role_id', $roleId);
            });
        }

        $keyword = isset($request->keyword) ? $request->keyword : null;
        if (! empty($keyword)) {
            if (is_int($keyword)) {
                $user->where('id', $keyword);
            } elseif (strlen($keyword) >= 2) {
                $user->where(function ($query) use ($keyword) {
                    $query->where('name', 'LIKE', '%' . $keyword . '%')
                        ->orwhere('email', 'LIKE', '%' . $keyword . '%')
                        ->orwhere('status', $keyword);
                });
            }
        }

        return $this->response([
            'data' => UserResource::collection($user->paginate($configs['rows_per_page'])),
            'pagination' => $this->toArray($user->paginate($configs['rows_per_page'])->appends($request->all())),
        ]);
    }

    /**
     * Store User
     *
     * @return json $data
     */
    public function store(StoreUserRequest $request)
    {
        if (isset($request->status) && array_key_exists(strtolower($request->status), ['pending' => 'pending', 'active' => 'active', 'inactive' => 'inactive'])) {
            $request['status'] = strtolower($request->status);
        }

        try {
            DB::beginTransaction();
            $request['password'] = \Hash::make($request->password);
            $request['email']    = validateEmail($request->email) ? strtolower($request->email) : null;
            $id                  = (new User())->store($request->only('name', 'email', 'password', 'status'));
            if (! empty($id)) {
                if (isset($request->send_mail) && validateEmail($request->email)) {
                    User::firstWhere('email', $request->email)->notify(new WelcomeUserNotification($request));
                }
                DB::commit();

                return $this->okResponse([], __('The :x has been successfully saved.', ['x' => __('User Info')]));
            }
        } catch (\Exception $e) {
            DB::rollBack();

            return $this->errorResponse([], 500, $e->getMessage());
        }
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePassword(Request $request, $id)
    {
        $response = $this->checkExistence($id, 'users', ['getData' => true]);
        if ($response['status'] === true) {
            $validator = User::updatePasswordValidation($request->all());
            if ($validator->fails()) {
                return $this->unprocessableResponse($validator->messages());
            }

            $request['user_name'] =  $response['data']->name;
            $request['email'] =  $response['data']->email;
            $request['raw_password'] = $request->password;
            $request['updated_at'] = date('Y-m-d H:i:s');
            $request['password']   = \Hash::make(trim($request->password));

            if ((new User())->updateUser($request->only('password', 'updated_at'), $id)) {
                if (isset($request->send_mail) && ! empty($request->send_mail)) {
                    User::firstWhere('email', $request->email)->notify(new UserPasswordSetNotification($request));
                }

                return $this->okResponse([], __('Password update successfully.'));
            }
        }

        return $this->response([], 204, $response['message']);
    }

    /**
     * Detail User
     *
     * @param  int  $id
     * @return json $data
     */
    public function detail($id)
    {
        $response   = $this->checkExistence($id, 'users');
        $userData   = User::with('avatarFile')->where('id', $id)->first();
        if ($response['status'] === true && ! empty($userData)) {
            return $this->response(['data' => new userDetailResource($userData)]);
        }

        return $this->response([], 204, $response['message']);
    }

    /**
     * Update User Information
     *
     * @param  int  $id
     * @return array
     */
    public function update(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            $response = $this->checkExistence($id, 'users');
            if ($response['status'] === true) {
                if (isset($request->status) && array_key_exists(strtolower($request->status), ['pending' => 'pending', 'active' => 'active', 'inactive' => 'inactive'])) {
                    $request['status'] = strtolower($request->status);
                }
                $validator = User::updateValidation($request->all(), $id);
                if ($validator->fails()) {
                    return $this->unprocessableResponse($validator->messages());
                }

                try {
                    DB::beginTransaction();
                    $request['email'] = validateEmail($request->email) ? strtolower($request->email) : null;
                    if ((new User())->updateUser($request->only('name', 'email', 'status'), $id)) {
                        if (isset($request->attachment) && ! empty($request->attachment)) {
                            //delete file region
                            $fileIds     = array_column(json_decode(json_encode(File::Where(['object_type' => 'USER', 'object_id' => $id])->get(['id'])), true), 'id');
                            $oldFileName = isset($fileIds) && ! empty($fileIds) ? File::find($fileIds[0])->file_name : null;
                            if (isset($fileIds) && ! empty($fileIds)) {
                                (new File())->deleteFiles('USER', $id, ['ids' => [$fileIds], 'isExceptId' => false], $path = 'public/uploads/user');
                            }
                            //end region

                            //region store files
                            if (isset($id) && ! empty($id) && $request->hasFile('attachment')) {
                                $path       = createDirectory('public/uploads/user');
                                $fileIdList = (new File())->store([$request->attachment], $path, 'USER', $id, ['isUploaded' => false, 'isOriginalNameRequired' => true, 'resize' => false]);
                                if (isset($fileIdList[0]) && ! empty($fileIdList[0])) {
                                    $uploadedFileName = File::find($fileIdList[0])->file_name;
                                    $uploadedFilePath = asset($path . '/' . $uploadedFileName);
                                    $thumbnailPath    = createDirectory('public/uploads/user/thumbnail');
                                    (new File())->resizeImageThumbnail($uploadedFilePath, $uploadedFileName, $thumbnailPath, $oldFileName);

                                    Cache::forget(config('cache.prefix') . '-user-0-avatar-' . $id);
                                    Cache::forget(config('cache.prefix') . '-user-1-avatar-' . $id);
                                }
                            }
                            //end region
                        }
                        DB::commit();

                        return $this->okResponse([], __('The :x has been successfully saved.', ['x' => __('User Info')]));
                    } else {
                        return $this->okResponse([], __('No changes found.'));
                    }
                } catch (\Exception $e) {
                    DB::rollBack();

                    return $this->errorResponse([], 500, $e->getMessage());
                }
            }

            return $this->response([], 204, $response['message']);
        }
    }

    /**
     * Remove the specified User from db.
     *
     * @return json $data
     */
    public function destroy(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            $response = $this->checkExistence($id, 'users');
            if ($response['status'] === true) {
                $result  = (new User())->remove($id);

                return $this->okResponse([], $result['message']);
            }

            return $this->response([], 204, $response['message']);
        }
    }

    /**
     * user preference data save
     *
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function storeMeta(Request $request, $id)
    {
        $response = $this->checkExistence($id, 'users');
        if ($response['status'] === true) {
            $data['userMetaData'] = $request->all();

            if ($userStore = (new user())->updateUser($data, $id)) {
                return $this->okResponse([], __('The :x has been successfully saved.', ['x' => __('User Meta')]));
            }

            return $this->okResponse([], __('Something went wrong, please try again.'));
        }

        return $this->notFoundResponse([], $response['message']);
    }

    /**
     * user meta data
     *
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function getMeta($id)
    {
        $user =  User::where('id', $id)->first();
        if (! empty($user)) {

            return $this->response([
                'data' => $user->getMeta(),
            ]);
        }

        return $this->notFoundResponse([], __('The :x does not exist.', ['x' => __('Users')]));
    }
}
