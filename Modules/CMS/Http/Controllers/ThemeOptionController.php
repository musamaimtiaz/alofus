<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Kabir Ahmed <[kabir.techvill@gmail.com]>
 *
 * @created 27-12-2021
 */

namespace Modules\CMS\Http\Controllers;

use Modules\CMS\DataTables\PageDataTable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\CMS\Http\Models\Page;
use Modules\CMS\Http\Models\Slider;
use Modules\CMS\Http\Models\ThemeOption;

class ThemeOptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(PageDataTable $dataTable)
    {
        return $dataTable->render('cms::index');
    }

    /**
     * Get All Theme Option
     *
     * @param  string  $layout
     * @return \Illuminate\Contracts\view\View
     */
    public function list(Request $request, $layout = 'default')
    {
        if (isset($request->layout)) {
            $layout = $request->layout;
        }

        $data['themeOption'] = ThemeOption::getAll();
        $data['sliders'] = Slider::getAll();
        $data['pages'] = Page::select('slug', 'name')->active()->get();
        $data['layout'] = $layout;
        $data['fontFamilies'] = ThemeOption::fontFamilies();
        $imageNames = ['footer_logo', 'google_play', 'app_store', 'payment_methods', 'header_logo', 'header_mobile_logo', 'download_google_play_logo', 'download_app_store_logo'];
        foreach ($imageNames as $name) {
            if ($image = $data['themeOption']->where('name', $layout . '_template_' . $name)->first()) {
                $data['image']['id'][$name] = $image->objectFile->id ?? 0;
                $data['image'][$name] = $image->fileUrl();
            }
        }

        $data['layouts'] = ThemeOption::layouts();

        if ($request->ajax()) {
            return response()->json([
                'data' => view('cms::theme.appearance', $data)->render(),
            ]);
        }

        return view('cms::theme.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return array
     */
    public function store(Request $request)
    {
        $formData = [];
        parse_str($request->data, $formData);
        unset($formData['_token']);

        array_walk_recursive($formData, function (&$value) {
            $value = xss_clean(($value));
        });

        $formData['custom']['css'] = str_replace('double_quotation', '"', $formData['custom']['css']);
        $formData['custom']['js'] = str_replace('double_quotation', '"', $formData['custom']['js']);

        $css = 'Modules/CMS/Resources/assets/css/user-custom.css';
        $js = 'Modules/CMS/Resources/assets/js/user-custom.js';

        try {
            $responseCss = $this->handleFile($css, $formData['custom']['css']);
            $responseJs = $this->handleFile($js, $formData['custom']['js']);

            if (! $responseCss['status']) {
                return $responseCss;
            }

            if (! $responseJs['status']) {
                return $responseJs;
            }

            unset($formData['custom']);

            $layout = $formData['layout'];
            unset($formData['layout']);

            (new ThemeOption())->store($formData, $layout);

            return ['status' => 1, 'message' => __('Successfully Saved')];
        } catch (\Exception $e) {
            return ['status' => 0, 'message' => $e->getMessage()];
        }
    }

    /**
     * Handle File
     */
    private function handleFile(string $filePath, string $fileContent): array
    {
        $fileContent = empty($fileContent) ? ' ' : $fileContent;

        if (! \File::exists($filePath)) {
            if (! $this->makeWritable($filePath)) {
                return $this->FileWriteResponse(false, __('Please provide write permissions to the directory: :x', ['x' => dirname($filePath)]));
            }

            if (! \File::put($filePath, $fileContent)) {
                return $this->FileWriteResponse(false, __('Unable to create the file: :x', ['x' => $filePath]));
            }

            return $this->FileWriteResponse(true, __('File created successfully: :x', ['x' => $filePath]));
        }

        if (! $this->makeWritable($filePath)) {
            return $this->FileWriteResponse(false, __('Please provide write permissions to the file: :x', ['x' => $filePath]));
        }

        if (! \File::put($filePath, $fileContent)) {
            return $this->FileWriteResponse(false, __('Unable to update the file: :x', ['x' => $filePath]));
        }

        return $this->FileWriteResponse(true, __('File updated successfully: :x', ['x' => $filePath]));

    }

    /**
     * Make Writable
     */
    private function makeWritable(string $path): bool
    {
        $directory = dirname($path);

        return \File::isWritable($directory) || chmod($directory, 0777);
    }

    /**
     * File Write Response
     */
    private function FileWriteResponse(bool $status, string $message): array
    {
        return [
            'status' => $status,
            'message' => $message,
        ];
    }

    /**
     * Store theme layout with default layout content.
     *
     * @return array
     */
    public function layoutStore(Request $request)
    {
        $menu = 'layout';
        if (empty($request->name)) {
            return redirect()->back()->with('appearanceMenu', $menu)->withErrors(__('Something went wrong, please try again.'));
        }

        $layout = strtolower(str_replace(' ', '_', $request->name));
        if (in_array($layout, ThemeOption::layouts())) {
            return redirect()->back()->with('appearanceMenu', $menu)->withErrors(__('The layout name already exists.'));
        }

        if ((new ThemeOption())->layoutStore($request->name)) {
            return redirect()->back()->with('appearanceMenu', $menu)->withSuccess(__('The :x has been successfully saved.', ['x' => __('Layout')]));
        }

        return redirect()->back()->with('appearanceMenu', $menu)->withErrors(__('Something went wrong, please try again.'));
    }

    /**
     * Update theme layout.
     *
     * @return array
     */
    public function layoutUpdate(Request $request)
    {
        $menu = 'layout';
        if (empty($request->name)) {
            return redirect()->back()->with('appearanceMenu', $menu)->withErrors(__('Something went wrong, please try again.'));
        }

        if ($request->old_layout == $request->name) {
            return redirect()->back()->with('appearanceMenu', $menu)->withErrors(__('No change found.'));
        }

        if ((new ThemeOption())->layoutUpdate($request->input())) {
            return redirect()->back()->with('appearanceMenu', $menu)->withSuccess(__('The :x has been successfully saved.', ['x' => __('Layout')]));
        }

        return redirect()->back()->with('appearanceMenu', $menu)->withErrors(__('Something went wrong, please try again.'));
    }

    /**
     * Delete theme layout.
     *
     * @param  string  $layout
     * @return array
     */
    public function layoutDelete($layout)
    {
        $menu = 'layout';
        if ($layout == 'default') {
            return redirect()->back()->with('appearanceMenu', $menu)->withErrors(__('Default layout can not be deleted'));
        }

        if ((new ThemeOption())->layoutDelete($layout)) {
            return redirect()->back()->with('appearanceMenu', $menu)->withSuccess(__('The :x has been successfully deleted.', ['x' => __('Layout')]));
        }

        return redirect()->back()->with('appearanceMenu', $menu)->withErrors(__('Something went wrong, please try again.'));
    }

    /**
     * Store layout primary color.
     *
     * @return array
     */
    public function storePrimaryColor(Request $request)
    {
        if ((new ThemeOption())->storePrimaryColor($request->only('name', 'value'))) {
            return ['status' => 1, 'message' => __('Successfully Saved')];
        }

        return ['status' => 0, 'message' => __('Something went wrong, please try again.')];
    }
}
