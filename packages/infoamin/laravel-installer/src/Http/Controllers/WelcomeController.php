<?php

namespace Infoamin\Installer\Http\Controllers;

use App\Http\Controllers\Controller;

class WelcomeController extends Controller
{
    /**
     * Display the installer welcome page.
     *
     * @return \Illuminate\View\View
     */
    public function welcome()
    {
        $envFilePath = base_path('.env');

        if (! \File::exists($envFilePath)) {
            copy(base_path('.env.example'), $envFilePath);
        }

        return view('packages.installer.welcome');
    }
}
