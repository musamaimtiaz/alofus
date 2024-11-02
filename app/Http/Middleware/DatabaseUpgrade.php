<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Lib\DatabaseUpgrader;

class DatabaseUpgrade
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): mixed
    {
        if ((! app()->runningInConsole() && env('APP_INSTALL') == false) || ! $this->needsDatabaseUpgrade()) {
            return $next($request);
        }

        if ($this->isUpgradeRequest($request)) {
            try {
                DatabaseUpgrader::run(config('martvill.versions'));

                return redirect()->route('site.index');
            } catch (\Exception $e) {
                exit($this->formatError('Database Upgrade Failed', $e->getMessage()));
            }
        }

        exit(include_once base_path('resources/views/dbupgrade.blade.php'));
    }

    /**
     * Check if the database needs to be upgraded.
     */
    private function needsDatabaseUpgrade(): bool
    {
        return preference('db_version') !== config('martvill.file_version');
    }

    /**
     * Check if the request is an upgrade request.
     */
    private function isUpgradeRequest(Request $request): bool
    {
        return $request->isMethod('get') && $request->input('is_upgrade');
    }

    /**
     * Format the error message.
     */
    private function formatError(string $title, string $message): string
    {
        return <<<HTML
            <h1>$title</h1>
            <p>An error occurred while upgrading the database:</p>
            <pre><strong>$message</strong></pre>
            <p>Please refer to the <a href="https://help.techvill.net" target="_blank"><strong>Documentation</strong></a> for assistance.</p>
            HTML;
    }
}
