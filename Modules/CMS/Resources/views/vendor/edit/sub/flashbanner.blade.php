@php
    $flash = miniCollection($component->flash ?? []);
@endphp
<div class="form-group row form-parent flashOptions {{ $component && $component->sidebar == 'flash_sale' ? 'd-flex' : 'd-none' }}">
    <div class="col-12">
        <hr>
    </div>
    <label class="col-md-3 control-label">
        <dt>{{ __('Flash Sale Settings') }}</dt>
    </label>
    <div class="col-md-8">
        <div class="form-group row">
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-sm-12 control-label">{{ __('Badge Text') }}</label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control inputFieldDesign" value="{{ $flash->badge_text }}"
                            name="flash[badge_text]">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@php
    unset($flash);
@endphp
