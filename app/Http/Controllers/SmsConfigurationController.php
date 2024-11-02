<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 14-01-2024
 */

namespace App\Http\Controllers;

use App\Http\Requests\Admin\Fast2SmsUpdateRequest;
use App\Http\Requests\Admin\MimSmsUpdateRequest;
use App\Http\Requests\Admin\MsegatUpdateRequest;
use App\Http\Requests\Admin\NexmoUpdateRequest;
use App\Http\Requests\Admin\SparrowUpdateRequest;
use App\Http\Requests\Admin\SslWirelessUpdateRequest;
use App\Http\Requests\Admin\TwilioUpdateRequest;
use App\Http\Requests\Admin\ZenderUpdateRequest;
use App\Models\SmsGateway;
use App\Services\SmsService;
use Illuminate\Foundation\Http\FormRequest;

class SmsConfigurationController extends Controller
{
    /**
     * Constructor
     */
    public function __construct(private SmsService $service)
    {
    }

    /**
     * Index
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('admin.sms_configurations.index');
    }

    /**
     * Display the Twilio configuration view.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function twilio()
    {
        return view('admin.sms_configurations.twilio-config', [
            'gateway' => SmsGateway::firstWhere('alias', 'twilio'),
        ]);
    }

    /**
     * Store or update the Twilio configuration.
     *
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeTwilio(TwilioUpdateRequest $request)
    {
        return $this->storeOrUpdateProvider($request, 'twilio', 'Twilio');
    }

    /**
     * Display the Nexmo configuration view.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function nexmo()
    {
        return view('admin.sms_configurations.nexmo-config', [
            'gateway' => SmsGateway::firstWhere('alias', 'nexmo'),
        ]);
    }

    /**
     * Store or update the Nexmo configuration.
     *
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeNexmo(NexmoUpdateRequest $request)
    {
        return $this->storeOrUpdateProvider($request, 'nexmo', 'Nexmo');
    }

    /**
     * Display the Fast2Sms configuration view.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function fast2Sms()
    {
        return view('admin.sms_configurations.fast2sms-config', [
            'gateway' => SmsGateway::firstWhere('alias', 'fast2sms'),
        ]);
    }

    /**
     * Store or update the Fast2Sms configuration.
     *
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeFast2Sms(Fast2SmsUpdateRequest $request)
    {
        return $this->storeOrUpdateProvider($request, 'fast2sms', 'Fast2Sms');
    }

    /**
     * Display the SslWireless configuration view.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function sslWireless()
    {
        return view('admin.sms_configurations.sslwireless-config', [
            'gateway' => SmsGateway::firstWhere('alias', 'sslwireless'),
        ]);
    }

    /**
     * Store or update the SslWireless configuration.
     *
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeSslWireless(SslWirelessUpdateRequest $request)
    {
        return $this->storeOrUpdateProvider($request, 'sslwireless', 'Ssl Wireless');
    }

    /**
     * Display the MimSms configuration view.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function mimSms()
    {
        return view('admin.sms_configurations.mim-sms-config', [
            'gateway' => SmsGateway::firstWhere('alias', 'mimsms'),
        ]);
    }

    /**
     * Store or update the MimSms configuration.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeMimSms(MimSmsUpdateRequest $request)
    {
        return $this->storeOrUpdateProvider($request, 'mimsms', 'MIM Sms');
    }

    /**
     * Display the Msegat configuration view.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function msegat()
    {
        return view('admin.sms_configurations.msegat-config', [
            'gateway' => SmsGateway::firstWhere('alias', 'msegat'),
        ]);
    }

    /**
     * Store or update the Msegat configuration.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeMsegat(MsegatUpdateRequest $request)
    {
        return $this->storeOrUpdateProvider($request, 'msegat', 'Msegat');
    }

    /**
     * Display the Sparrow configuration view.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function sparrow()
    {
        return view('admin.sms_configurations.sparrow-config', [
            'gateway' => SmsGateway::firstWhere('alias', 'sparrow'),
        ]);
    }

    /**
     * Store or update the Sparrow configuration.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeSparrow(SparrowUpdateRequest $request)
    {
        return $this->storeOrUpdateProvider($request, 'sparrow', 'Sparrow');
    }

    /**
     * Display the Zender configuration view.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function zender()
    {
        return view('admin.sms_configurations.zender-config', [
            'gateway' => SmsGateway::firstWhere('alias', 'zender'),
        ]);
    }

    /**
     * Store or update the Zender configuration.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeZender(ZenderUpdateRequest $request)
    {
        return $this->storeOrUpdateProvider($request, 'zender', 'Zender');
    }

    /**
     * Store or update the SMS provider configuration.
     *
     * @param  \App\Services\SmsService  $service
     * @param  string  $providerName
     * @param  string  $displayName
     * @return \Illuminate\Http\RedirectResponse
     */
    private function storeOrUpdateProvider(FormRequest $request, $providerName, $displayName)
    {
        $response = $this->service->store($request->validated(), $providerName, $displayName);

        if ($response) {
            $this->service->setDefaultProvider($providerName, $request->is_default);

            return redirect()->back()->withSuccess(__('The SMS provider successfully saved.'));
        }

        return redirect()->back()->withErrors(__('Failed to save SMS provider.'));
    }
}
