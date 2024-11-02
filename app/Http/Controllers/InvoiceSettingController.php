<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Md. Mostafijur Rahman <[mostafijur.techvill@gmail.com]>
 *
 * @created 02-02-2024
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Preference;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Modules\MediaManager\Http\Models\ObjectFile;

class InvoiceSettingController extends Controller
{
    public function __construct(Request $request)
    {
        //this middleware should be for POST request only
        if ($request->isMethod('post')) {
            $this->middleware('checkForDemoMode')->only('index');
        }
    }

    /**
     * Order general setting
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        if ($request->isMethod('GET')) {
            $data['list_menu'] = 'invoice';
            $data['invoice'] = json_decode(preference('invoice'));
            $data['logo'] =  Preference::where('field', 'invoice')->first()?->fileUrl();

            if ($request->ajax()) {
                return response()->json([
                    'data' => view('admin.invoice_settings.create', $data)->render(),
                ]);
            }

            return view('admin.invoice_settings.create', $data);
        }

        $formData = [];
        parse_str($request->data, $formData);
        unset($formData['_token']);

        array_walk_recursive($formData, function (&$value) {
            $value = xss_clean(($value));
        });

        if ($request->has('delete_file_ids')) {
            $preference = Preference::where('field', 'invoice')->first();
            ObjectFile::whereIn('file_id', $request->delete_file_ids)->where('object_id', $preference->id)->delete();
        }

        if (empty(Arr::get($formData['invoice'], 'document.footer.main_footer.align'))) {
            $formData['invoice']['document']['footer']['main_footer']['align'] = 'center';
        }

        if (empty(Arr::get($formData['invoice'], 'document.footer.copy_right_footer.align'))) {
            $formData['invoice']['document']['footer']['copy_right_footer']['align'] = 'center';
        }

        $request->merge($formData);

        if (Preference::updateOrInsert(['category' => 'invoice', 'field' => 'invoice'], ['value' => json_encode($request->invoice)])) {
            if (! empty(request()->file_id)) {
                foreach (request()->file_id as $key => $value) {
                    $result = Preference::where('field', 'invoice');
                    request()->file_id = [$value];
                    $result->first()->updateFiles(['isUploaded' => false, 'isOriginalNameRequired' => true, 'thumbnail' => true]);
                }
            }
            Cache::forget('preferences');

            return ['status' => 1, 'message' => __('The :x has been successfully saved.', ['x' => __('Invoice Setting')])];
        }

        return ['status' => 0, 'message' => __('Something went wrong, please try again.')];
    }
}
