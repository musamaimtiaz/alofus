<?php

namespace Modules\FormBuilder\Http\Middleware;

use Closure;
use Modules\FormBuilder\Entities\Form;

class PublicFormAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $identifier = $request->route('identifier');

        $form = Form::where('identifier', $identifier)->firstOrFail();

        if ($form->isPrivate()) {
            // the user must be authenticated
            if (! auth()->check()) {
                return redirect()
                    ->route('site.index')
                    ->with('error', __('Form :x requires you to login before you can access it.', ['x' => $form->name]));
            }
        }

        return $next($request);
    }
}
