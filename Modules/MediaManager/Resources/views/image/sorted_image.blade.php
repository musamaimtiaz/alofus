<div id="image-card-container"  class="modal-img-container mx-3 media-manager-child-card gap-4">
  @if(!empty($files))
  @foreach ($files as $file)
   <div class="image-card" id="{{ $file->id }}">
      <div class="border border-1 rounded modal-img-des image-card-box-shadow">
        <div class="d-flex image-cards-design justify-content-center m-2 align-items-center">
          @if(isset($file->params) && !empty($file->params['type'] && in_array($file->params['type'], getFileExtensions(5))))
            <div class="card-file-thumb img-fluid image-id p-4 upload-img-size">
              <i class="fa fa-file fa-6" aria-hidden="true"></i>
            </div>
            @else
            <div>
              <img class="modal-card-image-design neg-transition-scale" src="{{ $file->fileUrlNew(['id' => $file->id, 'type' => 'items']) }}" alt="{{ __('Image') }}">
            </div>
            @endif
        </div>
        <div class="card-body">
            <p class="image-name m-0 font-weight-bold">{{ nameConversion($file->original_file_name) }}</p>
            <small class="image-size-name">{{ !empty($file->file_size) ?  number_format($file->file_size, preference('decimal_digits'), '.', ',') . __('KB') : '' }} </small>
        </div>
      </div>
   </div>
   @endforeach
   @endif
</div>
