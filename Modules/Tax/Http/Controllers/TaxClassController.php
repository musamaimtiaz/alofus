<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 27-07-2022
 */

namespace Modules\Tax\Http\Controllers;

use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Modules\GeoLocale\Repositories\CountryRepository;
use App\Models\Preference;
use App\Http\Controllers\Controller;
use Modules\Tax\Entities\{
    TaxClass, TaxRate
};
use Modules\Tax\Http\Requests\{
    TaxClassStoreRequest, TaxClassUpdateRequest
};

class TaxClassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $data['countries'] = Collection::make((new CountryRepository())->index($request))->SortBy('name');

        $data['tax_rates'] = TaxRate::where('tax_class_id', 1)->orderByRaw('priority ASC, tax_rate DESC')->get();
        $data['tax_classes'] = TaxClass::with(['taxRates' => function ($q) {
            $q->orderByRaw('priority ASC, tax_rate DESC');
        }])->where('slug', '!=', 'standard')->get()->sortBy('taxRates.priority');

        $data['setting'] = preference();

        return view('tax::index', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return [type]
     */
    public function store(TaxClassStoreRequest $request)
    {
        return (new TaxClass())->store($request->validated());
    }

    /**
     * Update the specified resource in storage.
     *
     * @return [type]
     */
    public function update(TaxClassUpdateRequest $request)
    {
        return (new TaxClass())->updateData($request->validated(), request()->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  mixed  $id
     * @return [type]
     */
    public function destroy($id)
    {
        return (new TaxClass())->remove($id);
    }

    /**
     * Store or update preference setting
     *
     * @return json $response
     */
    public function setting(Request $request)
    {
        $response = $this->messageArray(__('Invalid Request'), 'fail');
        $category = 'tax_setting';
        $request['rounding'] = isset($request->rounding) ? 1 : 0;
        $i = 0;
        foreach ($request->only(['calculate_tax', 'shipping_tax_class', 'rounding', 'display_price_in_shop', 'display_tax_totals']) as $key => $value) {
            $data[$i]['category'] = $category;
            $data[$i]['field']    = $key;
            $data[$i]['value'] = $value;
            $i++;
        }
        foreach ($data as $key => $value) {
            if ((new Preference())->storeOrUpdate($value)) {
                $response = $this->messageArray(__('The :x has been successfully saved.', ['x' => __('Tax setting')]), 'success');
            }
        }

        return $response;
    }
}
