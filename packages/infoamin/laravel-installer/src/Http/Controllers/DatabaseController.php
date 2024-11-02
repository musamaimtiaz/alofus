<?php

namespace Infoamin\Installer\Http\Controllers;

use App\Http\Controllers\Controller;
use Infoamin\Installer\Repositories\EnvironmentRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class DatabaseController extends Controller
{
    /**
     * Show form.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $host     = env('DB_HOST');
        $port     = env('DB_PORT');
        $database = env('DB_DATABASE');
        $username = env('DB_USERNAME');
        $password = env('DB_PASSWORD');

        return view('packages.installer.database', compact('host', 'port', 'database', 'username', 'password'));
    }

    /**
     * Manage form submission.
     *
     * @param  Illuminate\Http\Request  $request
     * @param  Infoamin\Installer\Repositories\EnvironmentRepository  $environmentRepository
     * @return redirection
     */
    public function store(Request $request, EnvironmentRepository $environmentRepository)
    {
        // Set config for migrations and seeds
        $connection = config('database.default');
        config([
            'database.connections.' . $connection . '.host'     => $request->host,
            'database.connections.' . $connection . '.port'     => $request->port,
            'database.connections.' . $connection . '.database' => $request->dbname,
            'database.connections.' . $connection . '.password' => $request->password,
            'database.connections.' . $connection . '.username' => $request->username,
        ]);

        // Update .env file
        $environmentRepository->SetDatabaseSetting($request);
        $seedType = 'dummy-data-off';

        return redirect('install/seedmigrate/' . $seedType);
    }

    public function seedMigrate($type)
    {
        // Migrations and seeds
        try {
            ini_set('max_execution_time', 600);
            Artisan::call('app:install');
        } catch (Exception $e) {
            return view('packages.installer.database-error', ['error' => $e->getMessage()]);
        }

        return redirect('install/register');
    }
}
