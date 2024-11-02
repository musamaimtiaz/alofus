<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Contracts\Auth\Factory;

class UserAuthenticate extends Middleware
{
    /**
     * Logout Inactive user.
     *
     * @return void
     */
    public function __construct(Factory $auth)
    {
        parent::__construct($auth);
        $user = auth()->user();
        if ($user && $user->status != 'Active') {
            \Auth::logout();
        }
        
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        session()->put('prev3', session()->get('prev2'));
        session()->put('prev2', session()->get('prev1'));
        session()->put('prev1', url()->previous());
        session()->put('nextUrl', url()->full());

        if (!$request->expectsJson()) {
            return route('site.login');
        }
    }
}
