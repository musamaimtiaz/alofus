<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Kabir Ahmed <[kabir.techvill@gmail.com]>
 *
 * @created 27-12-2021
 */

namespace Modules\CMS\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\CMS\Http\Requests\SlideRequest;
use Modules\CMS\Http\Models\{
    Slide, Slider
};
use Session;

class SlideController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\contracts\View\View|\Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        $data['animations'] = Slide::animationStyle();
        $slider = Slider::where('status', 'Active');
        if (request()->slug != '') {
            $slider = $slider->where(['slug' => request()->slug]);
        }
        $data['slider'] = $slider->first();

        if (is_null($data['slider'])) {
            return back();
        }

        if (isset(request()->slug)) {
            return view('cms::slide.create', $data);
        }

        return response()->json([
            'data' => view('cms::partials.add_slide', $data)->render(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Routing\Redirector
     */
    public function store(SlideRequest $request)
    {
        $data = ['status' => 'fail', 'message' => __('Invalid Request')];
        $id = (new Slide())->store($request->only(
            'title_text',
            'slider_id',
            'title_animation',
            'title_delay',
            'title_font_color',
            'title_font_size',
            'title_direction',
            'sub_title_text',
            'sub_title_animation',
            'sub_title_delay',
            'sub_title_font_color',
            'sub_title_font_size',
            'sub_title_direction',
            'description_title_text',
            'description_title_animation',
            'description_title_delay',
            'description_title_font_color',
            'description_title_font_size',
            'description_title_direction',
            'button_title',
            'button_link',
            'button_font_color',
            'button_bg_color',
            'button_position',
            'button_animation',
            'button_delay',
            'is_open_in_new_window'
        ));
        if ($id) {
            $data['status'] = 'success';
            $data['message'] = __('The :x has been successfully saved.', ['x' => __('Slider')]);
        }

        Session::flash($data['status'], $data['message']);

        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Routing\Redirector
     */
    public function update(SlideRequest $request, $id)
    {
        $data = ['status' => 'fail', 'message' => __('Invalid Request')];
        if ((new Slide())->updateData($request->only(
            'title_text',
            'slider_id',
            'title_animation',
            'title_delay',
            'title_font_color',
            'title_font_size',
            'title_direction',
            'sub_title_text',
            'sub_title_animation',
            'sub_title_delay',
            'sub_title_font_color',
            'sub_title_font_size',
            'sub_title_direction',
            'description_title_text',
            'description_title_animation',
            'description_title_delay',
            'description_title_font_color',
            'description_title_font_size',
            'description_title_direction',
            'button_title',
            'button_link',
            'button_font_color',
            'button_bg_color',
            'button_position',
            'button_animation',
            'button_delay',
            'is_open_in_new_window'
        ), $id)) {
            $data['status'] = 'success';
            $data['message'] = __('The :x has been successfully saved.', ['x' => __('Slider')]);
        }

        Session::flash($data['status'], $data['message']);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Routing\Redirector
     */
    public function delete($id)
    {
        $response = (new Slide())->remove($id);
        Session::flash($response['status'], $response['message']);

        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Support\Renderable|\Illuminate\Routing\Redirector
     */
    public function edit($id)
    {
        $data = ['status' => 'fail', 'message' => __('Invalid Request')];
        $data['slide'] = Slide::find($id);
        if (empty($data['slide'])) {
            Session::flash($data['status'], $data['message']);

            return redirect()->route('slider.index');
        }
        $data['animations'] = Slide::animationStyle();
        $data['sliders'] = Slider::get();

        return response()->json([
            'data' => view('cms::partials.edit_slide', $data)->render(),
        ]);
    }
}
