<div class="d-flex flex-wrap mt-2">
    @if (!empty($files))
        @foreach ($files as $file)
            <div class="position-relative border boder-1 media-box p-1 me-2 rounded mt-2">
                <div class="position-absolute rounded-circle text-center img-remove-icon"><i class="fa fa-times"></i>
                </div>
                <img class="upl-img neg-transition-scale" class="p-1"
                    src="{{ is_object($file) ? $file->fileUrlNew(['id' => $file->id]) : '' }}" alt="{{ __('Image') }}">
                <input type="hidden" name="file_id[]" value="{{ is_object($file) ? $file->id : $file }}">
                <div class="img-text ps-2">
                    {{ $file->object_type ?? $file->object_type }}</div>
                <small
                    class="img-size ps-2">{{ $file->file_size ?? $file->file_size }}
                    {{ __('kb') }}</small>
            </div>
        @endforeach
    @endif
</div>
