<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Kabir Ahmed <[kabir.techvill@gmail.com]>
 *
 * @created 01-05-2022
 */

namespace Modules\CMS\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\CMS\Http\Requests\SliderRequest;
use Modules\CMS\Http\Models\Slider;
use Session;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $data['sliders'] = Slider::with('slides')->get();

        return view('cms::slider.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('blog::create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Routing\Redirector
     */
    public function store(SliderRequest $request)
    {
        $data = ['status' => 'fail', 'message' => __('Invalid Request')];
        if ((new Slider())->store($request->only('name', 'status'))) {
            $data['status'] = 'success';
            $data['message'] = __('The :x has been successfully saved.', ['x' => __('Slide')]);
        }
        Session::flash($data['status'], $data['message']);

        return redirect()->route('slider.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Routing\Redirector
     */
    public function update(SliderRequest $request)
    {
        $data = ['status' => 'fail', 'message' => __('Invalid Request')];
        if ((new Slider())->updateData($request->only('name', 'status', 'id'))) {
            $data['status'] = 'success';
            $data['message'] = __('The :x has been successfully updated.', ['x' => __('Slide')]);
        }

        Session::flash($data['status'], $data['message']);

        return redirect()->route('slider.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Routing\Redirector
     */
    public function delete($id)
    {
        $response = (new Slider())->remove($id);
        Session::flash($response['status'], $response['message']);

        return redirect()->route('slider.index');
    }
}
