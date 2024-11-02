<?php

namespace Modules\FormBuilder\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\FormBuilder\Events\Form\FormCreated;
use Modules\FormBuilder\Events\Form\FormDeleted;
use Modules\FormBuilder\Events\Form\FormUpdated;
use Modules\FormBuilder\Services\Helper;
use Modules\FormBuilder\Entities\Form;
use Modules\FormBuilder\Http\Requests\SaveFormRequest;
use Illuminate\Support\Facades\DB;
use Modules\FormBuilder\DataTables\FormDataTable;
use Throwable;

class FormController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkForDemoMode')->only('store', 'update', 'destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(FormDataTable $dataTable)
    {
        $forms = Form::getForUser(auth()->user());

        return $dataTable->render('formbuilder::forms.index', compact('forms'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageTitle = 'Create New Form';

        $saveURL = route('formbuilder::forms.store');

        // get the roles to use to populate the make the 'Access' section of the form builder work
        $form_roles = Helper::getConfiguredRoles();

        return view('formbuilder::forms.create', compact('pageTitle', 'saveURL', 'form_roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Modules\FormBuilder\Requests\SaveFormRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaveFormRequest $request)
    {
        $user = $request->user();

        $request['form_builder_json'] = str_replace(['&lt;script&gt;', '&lt;/script&gt;'], '', $request->form_builder_json);

        $input = $request->merge(['user_id' => $user->id])->except('_token');

        DB::beginTransaction();

        // generate a random identifier
        $input['identifier'] = Helper::randomString(20);

        $created = Form::create($input);

        try {
            // dispatch the event
            event(new FormCreated($created));

            DB::commit();

            return response()
                ->json([
                    'success' => true,
                    'details' => __('Form successfully created!'),
                    'dest' => route('formbuilder::forms.edit', ['form' => $created->id]),
                ]);
        } catch (Throwable $e) {
            info($e);

            DB::rollback();

            return response()->json(['success' => false, 'details' => __('Failed to create the form.')]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = auth()->user();
        $form = Form::where(['id' => $id])
            ->with('user')
            ->withCount('submissions')
            ->firstOrFail();

        return view('formbuilder::forms.show', compact('form'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = auth()->user();

        $form = Form::where(['user_id' => $user->id, 'id' => $id])->firstOrFail();

        $saveURL = route('formbuilder::forms.update', $form);

        // get the roles to use to populate the make the 'Access' section of the form builder work
        $form_roles = Helper::getConfiguredRoles();

        return view('formbuilder::forms.edit', compact('form', 'saveURL', 'form_roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Modules\FormBuilder\Requests\SaveFormRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SaveFormRequest $request, $id)
    {
        $user = auth()->user();
        $form = Form::where(['user_id' => $user->id, 'id' => $id])->firstOrFail();

        $request['form_builder_json'] = str_replace(['&lt;script&gt;', '&lt;/script&gt;'], '', $request->form_builder_json);

        $input = $request->except('_token');

        if ($form->update($input)) {
            // dispatch the event
            event(new FormUpdated($form));

            return response()
                ->json([
                    'success' => true,
                    'details' => __('Form successfully updated!'),
                    'dest' => isActive('Affiliate') && $form->type == 'affiliate' ? route('affiliate.settings') : route('formbuilder::forms.index'),
                ]);
        } else {
            response()->json(['success' => false, 'details' => __('Failed to update the form.')]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = auth()->user();
        $form = Form::where(['user_id' => $user->id, 'id' => $id])->firstOrFail();
        $form->delete();

        // dispatch the event
        event(new FormDeleted($form));

        return back()->with('success', __(':x deleted', ['x' => $form->name]));
    }
}
