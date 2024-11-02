<?php

namespace Infoamin\Installer\Http\Controllers;

use App\Lib\Env;
use Illuminate\Http\Request;
use Infoamin\Installer\Helpers\PermissionsChecker;
use Infoamin\Installer\Helpers\RequirementsChecker;
use Infoamin\Installer\Interfaces\PurchaseInterface;
use Illuminate\Support\Facades\Cache;
use Validator;

class PermissionsController extends PermissionsChecker
{
    /**
     * @var PermissionsChecker
     */
    protected $permissions;

    /**
     * @var RequirementsChecker
     */
    protected $requirements;

    /**
     * @param  PermissionsChecker  $checker  && @param RequirementsChecker $requirementschecker
     */
    public function __construct(PermissionsChecker $checker, RequirementsChecker $requirementschecker)
    {
        $this->permissions  = $checker;
        $this->requirements = $requirementschecker;
    }

    /**
     * Display the permissions check page.
     *
     * @return \Illuminate\View\View
     */
    public function checkPermissions()
    {
        $phpSupportInfo = $this->requirements->checkPHPversion(config('installer.core.minimumPhpVersion'));
        $requirements   = $this->requirements->check(config('installer.requirements'));
        $permissions    = $this->permissions->checkPermission(config('installer.permissions'));
        if (! isset($requirements['errors']) && $phpSupportInfo['supported']) {
            return view('packages.installer.permissions', compact('permissions'));
        } else {
            return redirect('install/requirements');
        }
    }

    /**
     * Display the purchase code verification page.
     *
     * @return \Illuminate\View\View
     */
    public function verifyPurchaseCode(Request $request, PurchaseInterface $purchaseChecker)
    {
        $this->isInstalled();
        if (! $request->isMethod('POST')) {
            return view('packages.installer.purchasecode', ['bypass' => $request->bypass]);
        }

        $validator = Validator::make($request->all(), [
            'envatopurchasecode' => 'required',
            'envatoUsername' => 'required',
        ]);
        $validator->setAttributeNames([
            'envatopurchasecode' => 'Purchase code',
            'envatoUsername' => 'Envato Username',
        ]);

        if ($validator->fails()) {
            return view('packages.installer.purchasecode', ['errors' => $validator->errors(), 'bypass' => $request->bypass]);
        }

        $domainName     = str_replace(['https://www.', 'http://www.', 'https://', 'http://', 'www.'], '', request()->getHttpHost());
        $domainIp       = request()->ip();

        $purchaseData = $purchaseChecker->getPurchaseStatus($domainName, $domainIp, $request->envatopurchasecode, $request->envatoUsername);

        if ($purchaseData->status) {
            Env::set(base64_decode('SU5TVEFMTF9BUFBfU0VDUkVU'), $purchaseData->data);
            Env::set('APP_URL', url('/'));
            if ($request->bypass == 'purchase_code') {
                Env::set('APP_INSTALL', 'true');
                Cache::put('a_s_k', $purchaseData->data, 2629746);

                return redirect('/');
            }

            return redirect('install/database');
        } else {
            return view('packages.installer.purchasecode', ['responseError' => $purchaseData->data, 'bypass' => $request->bypass]);
        }
    }

    public function isInstalled()
    {
        if (base64_decode('SU5TVEFMTF9BUFBfU0VDUkVU') && env('APP_INSTALL')) {
            return view('packages.installer.purchasecode', ['installed' => 'App is already installed']);
        }
    }

    public function clearCache(Request $request)
    {

        if ($request->cache == env(base64_decode('SU5TVEFMTF9BUFBfU0VDUkVU'))) {
            Env::set(base64_decode('SU5TVEFMTF9BUFBfU0VDUkVU'), 'clear');
            Cache::forget('a_s_k');

            return true;
        }

        return false;
    }
}
