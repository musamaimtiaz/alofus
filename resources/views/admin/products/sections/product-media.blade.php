<div class="mini-form-holder card-border mt-2 card transition-none option-value-rowid ui-sortable-handle common_c">
    <div class="card-header cursor-pointer d-flex justify-content-between align-items-center head-click"
        data-bs-toggle="collapse" href="#Item_Photos">
        <h6 class="mb-0 add-title">{{ __('Product Photos & Videos') }}</h6>
        <div class="d-flex justify-content-end align-items-center">
            <span class="cursor-move mt-0">
                <svg width="16" height="11" viewBox="0 0 16 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="16" height="1" fill="#898989"></rect>
                    <rect y="5" width="16" height="1" fill="#898989"></rect>
                    <rect y="10" width="16" height="1" fill="#898989"></rect>
                </svg>
            </span>
            <span class="toggle-btn icon-collapse mt-0 ltr:ms-3 rtl:me-3">
                <svg width="8" height="6" viewBox="0 0 8 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M4.18767 0.0921111L7.81732 4.65639C8.24162 5.18994 7.87956 6 7.21678 6L0.783223 6C0.120445 6 -0.241618 5.18994 0.182683 4.65639L3.81233 0.092111C3.91 -0.0307037 4.09 -0.0307036 4.18767 0.0921111Z"
                        fill="#2C2C2C"></path>
                </svg>
            </span>
        </div>
    </div>
    <div id="Item_Photos" class="collapse show txt-enable blockable">
        <div class="card-body mt-24p px-32p px-3-res pb-20-res pb-20p">
            <div class="form-group row">
                <input type="hidden" name="saving-product-media" value="1">
                <label class="col-md-2 col-form-label px-2 label-title">{{ __('Image') }}</label>
                <div class="col-md-10 preview-parent">
                    <div class="input-group h-40">
                        <div class="custom-file has-media-manager product-image" data-val="multiple"
                            data-name="meta_image[]">
                            <input class="custom-file-input" id="inputGroupFile02">
                            <label class="custom-file-label color-2c"
                                for="inputGroupFile02">{{ __('Upload Images') }}</label>
                        </div>
                    </div>
                    <div class="d-flx flex-wrap preview-image">
                        @if (isset($product))
                            @php
                                $images = $product->getImagesWithoutDefault() ?? [];
                            @endphp
                            @foreach ($images as $img)
                                <div class="img-box-two mt-4">
                                    @if(isset($img['name']) &&
                                    !empty($img['name'] && in_array(pathinfo($img['name'], PATHINFO_EXTENSION), getFileExtensions(6))))
                                    <video
                                        class="fit-boxed neg-transition-scale"
                                        >
                                        <source src="{{ $img['url'] }}" type="video/mp4">
                                    </video>
                                    @else
                                    <img class="fit-boxed neg-transition-scale" src="{{ $img['url'] }}" alt="{{ $img['name'] }}">
                                    @endif
                                    <input type="hidden" name="meta_image[]" value="{{ $img['id'] }}">
                                    <svg class="svg-postion cursor-pointer remove-product-image" width="14"
                                        height="14" viewBox="0 0 14 14" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="7" cy="7" r="7" fill="#FCCA19" />
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M4.21967 4.21967C4.51256 3.92678 4.98744 3.92678 5.28033 4.21967L9.78033 8.71967C10.0732 9.01256 10.0732 9.48744 9.78033 9.78033C9.48744 10.0732 9.01256 10.0732 8.71967 9.78033L4.21967 5.28033C3.92678 4.98744 3.92678 4.51256 4.21967 4.21967Z"
                                            fill="#2C2C2C" />
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M9.78033 4.21967C9.48744 3.92678 9.01256 3.92678 8.71967 4.21967L4.21967 8.71967C3.92678 9.01256 3.92678 9.48744 4.21967 9.78033C4.51256 10.0732 4.98744 10.0732 5.28033 9.78033L9.78033 5.28033C10.0732 4.98744 10.0732 4.51256 9.78033 4.21967Z"
                                            fill="#2C2C2C" />
                                    </svg>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>


            <div class="form-group row mt-20p">
                <label class="col-md-2 px-2 col-form-label label-title">{{ __('Video') }}</label>

                <div class="col-md-10 preview-parent">
                    <div class="d-flx gap-10px">
                        <div class="radio radio-warning d-flx align-items-center">
                            <input class="cursor-pointer" type="radio" name="video_input" value="file"
                                id="radio-21" checked="">
                            <label for="radio-21" class="crq d-flx align-items-center cursor-pointer"> <span
                                class="f-13 color-2c">{{ __('File Upload') }}</span> </label>
                        </div>
                        <div class="radio radio-warning d-flx align-items-center ml-30p">
                            <input class="cursor-pointer" type="radio" name="video_input" value="link"
                                id="radio-23">
                            <label for="radio-23" class="crq d-flx align-items-center cursor-pointer"> <span
                                class="f-13 color-2c">{{ __('Link') }}</span> </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="file" class="sr-only">{{ __('File') }}</label>
                        <div class="input-group video-uploader has-media-manager" data-val="multiple"
                            data-name="mmm___">
                            <input type="text" name="filename" disabled="disabled"
                                class="form-control video-link-upload cursor-pointer" placeholder="{{ __('Enter your video url') }}">
                            <span class="input-group-btn">
                                <div class="browse-btn custom-file-uploader video-file-upload px-3">
                                    <input type="hidden" class="custom-file-input" name="file" />
                                    <span class="video-label">{{ __('Browse') }}</span>
                                </div>
                            </span>
                        </div>
                    </div>

                    <div class="video-urls">
                        @if (isset($product))
                            @php
                                $videoUrls = $product->getVideoUrls();
                            @endphp
                            @foreach ($videoUrls as $url)
                                <div class="video-url d-flx mt-n2">
                                    <span>{{ __('Video URL') }}:</span>
                                    <a class="m-change ml-2" target="_blank"
                                        href="{{ $url }}">{{ $url }}</a>
                                    <input type="hidden" name="meta_video_url[]" value="{{ $url }}">
                                    <span class="remove-url cursor-pointer d-flex align-items-center ml-2"><svg
                                            width="14" height="14" viewBox="0 0 14 14"
                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="7" cy="7" r="7" fill="#FCCA19">
                                            </circle>
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M4.21967 4.21967C4.51256 3.92678 4.98744 3.92678 5.28033 4.21967L9.78033 8.71967C10.0732 9.01256 10.0732 9.48744 9.78033 9.78033C9.48744 10.0732 9.01256 10.0732 8.71967 9.78033L4.21967 5.28033C3.92678 4.98744 3.92678 4.51256 4.21967 4.21967Z"
                                                fill="#2C2C2C"></path>
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M9.78033 4.21967C9.48744 3.92678 9.01256 3.92678 8.71967 4.21967L4.21967 8.71967C3.92678 9.01256 3.92678 9.48744 4.21967 9.78033C4.51256 10.0732 4.98744 10.0732 5.28033 9.78033L9.78033 5.28033C10.0732 4.98744 10.0732 4.51256 9.78033 4.21967Z"
                                                fill="#2C2C2C"></path>
                                        </svg></span>
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <div class="d-flx flex-wrap preview-video">
                        @if (isset($product))
                            @php
                                $videos = $product->getVideoFiles();
                            @endphp
                            @foreach ($videos as $video)
                                <div class="img-box-two video-prev mt-20p">
                                    <video controls src="{{ $video['url'] }}">
                                        {{ __("Sorry, your browser doesn't support embedded videos.") }}
                                    </video>
                                    <input type="hidden" name="meta_video_files[]" value="{{ $video['id'] }}">
                                    <svg class="svg-postion cursor-pointer remove-product-image" width="14"
                                        height="14" viewBox="0 0 14 14" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="7" cy="7" r="7" fill="#FCCA19" />
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M4.21967 4.21967C4.51256 3.92678 4.98744 3.92678 5.28033 4.21967L9.78033 8.71967C10.0732 9.01256 10.0732 9.48744 9.78033 9.78033C9.48744 10.0732 9.01256 10.0732 8.71967 9.78033L4.21967 5.28033C3.92678 4.98744 3.92678 4.51256 4.21967 4.21967Z"
                                            fill="#2C2C2C" />
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M9.78033 4.21967C9.48744 3.92678 9.01256 3.92678 8.71967 4.21967L4.21967 8.71967C3.92678 9.01256 3.92678 9.48744 4.21967 9.78033C4.51256 10.0732 4.98744 10.0732 5.28033 9.78033L9.78033 5.28033C10.0732 4.98744 10.0732 4.51256 9.78033 4.21967Z"
                                            fill="#2C2C2C" />
                                    </svg>
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <div class="d-flx mt-20p">
                        <a href="javascript:void(0);" class="btn-confirms media-store" id="btnSubmit">
                            {{ __('Save') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
