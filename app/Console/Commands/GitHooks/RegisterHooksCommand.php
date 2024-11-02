<?php

namespace App\Console\Commands\GitHooks;

use Illuminate\Console\Command;

class RegisterHooksCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:register-git-hooks {--remove}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Register and remove Git hooks';

    /**
     * @var RegisterHooks
     */
    protected $registerHooks;

    /**
     * Create a new command instance.
     */
    public function __construct(RegisterHooks $registerHooks)
    {
        parent::__construct();
        $this->registerHooks = $registerHooks;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if ($this->option('remove')) {
            $this->removeHooks();

            return 0;
        }

        try {
            $this->registerHooks->install();
            $this->info('Git hooks registered successfully!');
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }

        return 0;
    }

    /**
     * Remove Git hooks
     */
    private function removeHooks(): void
    {
        try {
            $this->registerHooks->uninstall();
            $this->info('Git hooks removed successfully!');
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }

    /**
     * Get the console command options.
     */
    protected function getOptions(): array
    {
        return [
            ['remove', 'r', null, 'Remove registered Git hooks.'],
        ];
    }
}
