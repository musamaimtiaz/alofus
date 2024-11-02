<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 27-07-2022
 */

namespace Modules\Tax\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Tax\Entities\{
    TaxClass, TaxRate
};

class TaxRateController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return array response
     */
    public function update(Request $request)
    {
        (new TaxRate())->updateData($request->data);

        $data['tax_rates'] = TaxRate::where('tax_class_id', 1)->orderByRaw('priority ASC, tax_rate DESC')->get();
        $data['tax_classes'] = TaxClass::with(['taxRates' => function ($q) {
            $q->orderByRaw('priority ASC, tax_rate DESC');
        }])->where('slug', '!=', 'standard')->get()->sortBy('taxRates.priority');

        return view('tax::layout.contents', $data)->render();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return array response
     */
    public function destroy($id)
    {
        return (new TaxRate())->remove($id);
    }
}
