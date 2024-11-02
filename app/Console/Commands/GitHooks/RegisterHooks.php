<?php

namespace App\Console\Commands\GitHooks;

class RegisterHooks
{
    /**
     * @var string
     */
    private const GIST_BASE_URL = 'https://gist.githubusercontent.com/SneherAdor/';

    /**
     * @var array
     */
    private const HOOK_SCRIPTS = [
        'commit-msg' => '8c2edb8bf226037e86be753920701e95/raw/6d613d249ef77d8b6dfa439d9d6d939314893159/commit-msg.sh',
        'pre-commit' => '36276ab21ff611f5dcedf5d2f21cc0e1/raw/3676b284f02fca49271b37dcaf19ba9af4fcb7aa/pre-commit.sh',
    ];

    /**
     * Register git hooks
     *
     * @return void
     */
    public function install()
    {
        if (! $this->isGitRepository()) {
            throw new \Exception('Git hooks registration failed! Current directory is not a git repository.');
        }

        $hooksDir = $this->getGitHooksDirectory();

        foreach (self::HOOK_SCRIPTS as $hookName => $script) {
            $scriptURL = self::GIST_BASE_URL . $script;
            $this->registerHook($hookName, $scriptURL, $hooksDir);
        }
    }

    /**
     * Uninstall git hooks
     *
     * @return void
     */
    public function uninstall()
    {
        $hooksDir = $this->getGitHooksDirectory();

        foreach (self::HOOK_SCRIPTS as $hookName => $script) {
            $hookPath = $hooksDir . DIRECTORY_SEPARATOR . $hookName;

            if (file_exists($hookPath)) {
                unlink($hookPath);
            }
        }
    }

    /**
     * Get git hooks directory
     */
    private function getGitHooksDirectory(): string
    {
        $projectDir = realpath(__DIR__ . '/../../../..');

        return $projectDir . DIRECTORY_SEPARATOR . '.git' . DIRECTORY_SEPARATOR . 'hooks';
    }

    /**
     * Check if the current directory is a git repository
     */
    private function isGitRepository(): bool
    {
        return is_dir($this->getGitHooksDirectory());
    }

    /**
     * Register a git hook
     */
    private function registerHook(string $hookName, string $scriptURL, string $hooksDir): void
    {
        $hookPath = $hooksDir . DIRECTORY_SEPARATOR . $hookName;

        file_put_contents($hookPath, file_get_contents($scriptURL));
        chmod($hookPath, 0755); // Set execute permissions
    }
}
