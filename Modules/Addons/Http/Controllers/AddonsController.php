<?php

namespace Modules\Addons\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Modules\Addons\Entities\Addon;
use Modules\Addons\Entities\AddonManager;
use Illuminate\Filesystem\Filesystem;
use Validator;

class AddonsController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        return view('addons::index');
    }

    /**
     * upload
     *
     * @param  mixed  $request
     * @return void
     */
    public function upload(Request $request)
    {
        if ($request->isMethod('post')) {

            do_action('before_addon_upload');

            $validator = Validator::make($request->all(), [
                'attachment' => 'required|mimes:zip,rar,7zip',
            ]);

            if ($validator->fails()) {
                return back()->with(['AddonStatus' => 'fail', 'AddonMessage' => __('Validation failed.')]);
            }

            if (! $this->isModuleDirectoryWritable()) {
                return back()->with('fail', __('Directory is not writable (recursively): ' . base_path('Modules')));
            }

            try {
                $addonManager = new AddonManager();
                $install = $addonManager->install($request);

                if (! $install['status']) {
                    return back()->with(['AddonStatus' => 'fail', 'AddonMessage' => $install['message']]);
                }

                $addonName = pathinfo($request->attachment->getClientOriginalName(), PATHINFO_FILENAME);
                $this->existsAddonRemove($addonName);

                Artisan::call('cache:clear');

                $addonManager::upload($request->attachment);

                do_action('after_addon_upload');

                return back()->with(['AddonStatus' => 'success', 'AddonMessage' => __('Addon successfully uploaded.')]);
            } catch (\Exception $e) {
                return back()->with(['AddonStatus' => 'fail', 'AddonMessage' => $e->getMessage()]);
            }
        }

        return back()->with(['AddonStatus' => 'fail', 'AddonMessage' => __('Something went wrong, please try again.')]);
    }

    /**
     * switchStatus
     *
     * @param  mixed  $alias
     * @return void
     */
    public function switchStatus($alias)
    {
        $addon = Addon::findByAlias($alias);

        if (is_null($addon)) {
            return back()->with(['fail' => 'success', 'AddonMessage' => __('Addon not found.')]);
        }

        if (! $this->isModuleDirectoryWritable()) {
            return back()->with('fail', __('Directory is not writable (recursively): ' . base_path('Modules')));
        }

        if ($addon->isEnabled()) {

            do_action('before_addon_deactivation', $alias);
            do_action("before_{$alias}_addon_deactivation");

            try {
                $addon->disable();
            } catch (\Exception $e) {
                return back()->with(['AddonStatus' => 'fail', 'AddonMessage' => $e->getMessage()]);
            }

            do_action('after_addon_deactivation', $alias);
            do_action("after_{$alias}_addon_deactivation");

        } else {

            do_action('before_addon_activation', $alias);
            do_action("before_{$alias}_addon_activation");

            try {
                $addon->enable();
                $addonManager = new AddonManager();
                $addonManager->migrateAndSeed($addon->getName());
                $addonManager->cacheClear();

                // include addon files
                foreach ($addon->get('files') as $file) {
                    if (file_exists($fileToInclude = $addon->getPath() . '/' . $file)) {
                        require_once $fileToInclude;
                    }
                }

            } catch (\Exception $e) {
                return back()->with(['AddonStatus' => 'fail', 'AddonMessage' => $e->getMessage()]);
            }

            do_action('after_addon_activation', $alias);
            do_action("after_{$alias}_addon_activation");
        }

        return back()->with(['AddonStatus' => 'success', 'AddonMessage' => __('Addon status updated.')]);
    }

    public function remove($alias)
    {
        $addon = Addon::find($alias);

        if (is_null($addon)) {
            return back()->with('fail', __('Addon not found.'));
        }

        if ($addon->get('core')) {
            return back()->with('fail', __('Can not be deleted. This is core addon.'));
        }

        if (! $this->isModuleDirectoryWritable()) {
            return back()->with('fail', __('Directory is not writable (recursively): ' . base_path('Modules')));
        }

        do_action('before_addon_remove', $alias);
        do_action("before_{$alias}_addon_remove");

        try {
            $addon->delete();
            Artisan::call('cache:clear');
        } catch (\Exception $e) {
            return back()->with(['AddonStatus' => 'fail', 'AddonMessage' => $e->getMessage()]);
        }

        do_action('after_addon_remove', $alias);
        do_action("after_{$alias}_addon_remove");

        return back()->with('success', __('Addon successfully removed.'));
    }

    public function getForm(Request $request)
    {
        $addon = Addon::find($request->alias);
        if (is_null($addon)) {
            return response()->json(['status' => false, 'data' => []], 200);
        }

        return response()->json(['status' => true, 'data' => ['name' => 'Paypal', 'html' => '<span class="addon-modal-danger">*</span>']], 200);
    }

    public function removeAlert($alias)
    {
        return response()->json(
            [
                'html' => view('addons::remove', compact('alias'))->render(),
                'status' => true,
            ],
            200
        );
    }

    /**
     * check exists addon if found then delete it
     *
     * @param  $addon
     */
    public function existsAddonRemove($addonName): void
    {
        $addon = Addon::find($addonName);

        if (! is_null($addon)) {
            $addon->delete();
        }
    }

    private function isModuleDirectoryWritable()
    {
        $filesystem = new Filesystem();
        $directoryPath = base_path('Modules');
        $modulesPath = base_path('Modules/modules.json');

        if ($filesystem->isWritable($directoryPath) && $filesystem->isWritable($modulesPath)) {
            return true;
        } else {
            try {
                // Attempt to change permissions to make the directory writable recursively
                $filesystem->chmod($directoryPath, 0777, 0000, true);
                $filesystem->chmod($modulesPath, 0777, 0000, true);
            } catch (\Exception $e) {
                // An exception occurred, return false
                return false;
            }

            return $filesystem->isWritable($directoryPath) && $filesystem->isWritable($modulesPath);
        }
    }
}
