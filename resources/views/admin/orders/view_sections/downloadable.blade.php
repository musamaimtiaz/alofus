<div class="card card-width download-permission-container">
    <div class="product-permissions-header accordion cursor_pointer">
        <span>{{ __('Downloadable Product Permission') }}</span>
        <span class="drop-down-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="8" viewBox="0 0 13 10" fill="none">
                <path d="M6.80496 9.84648L12.7031 2.23935C13.3926 1.35009 12.8043 -9.56008e-07 11.7273 -9.68852e-07L1.27274 -1.09352e-06C0.195723 -1.10636e-06 -0.39263 1.35009 0.296859 2.23935L6.19504 9.84648C6.35375 10.0512 6.64626 10.0512 6.80496 9.84648Z" fill="white"/>
                </svg>
        </span>
    </div>
    <br>
    <div id="download_div">
        @php
            $downloadData = $order->download_data;
        @endphp
        @if(is_array($downloadData) && !empty($downloadData))
            @foreach ($order->download_data as $key => $data)
                @if($data['is_accessible'] == 1)
                    <div class="col-sm-12 download_data" id="downloadData-{{ $data['id'] }}">
                        <div class="row px-3">
                            <div class="col-md-2 mt-2 mt-md-0">
                                <span>{{ __('Download limit') }}</span>
                                <div class="d-flex">
                                    <input type="hidden" name="id" value="{{ $data['id'] }}">
                                    <input value="{{ $data['download_limit'] }}" name="download_limit" class="form-control inputFieldDesign" type="text">
                                </div>
                            </div>
                            <div class="col-md-2 mt-2 mt-md-0">
                                <span>{{ __('Download expiry') }}</span>
                                <div class="d-flex">
                                <input value="{{ $data['download_expiry'] }}" name="download_expiry" class="form-control inputFieldDesign" type="text">
                                </div>
                            </div>
                            <div class="col-md-3 mt-2 mt-md-0">
                                <span>{{ __('Customer download link') }}</span>
                                <div class="d-flex">
                                <a href="javascript:void(0)" class="download_copy_link btn-default p-1" data-link = "{{ route('site.downloadProduct',['link' => \Crypt::encrypt($data['link']),'file' => $data['id'].",".$order['id']]) }}">{{ __("Copy Link") }}</a>
                                </div>
                            </div>
                            <input type="hidden" name="link" value="{{ $data['link'] }}">
                            <input type="hidden" name="download_times" value="{{ $data['download_times'] }}">
                            <input type="hidden" name="is_accessible" value="{{ $data['is_accessible'] }}">
                            <input type="hidden" name="vendor_id" value="{{ $data['vendor_id'] }}">
                            <input type="hidden" name="name" value="{{ $data['name'] }}">
                            <input type="hidden" name="f_name" value="{{ $data['f_name'] }}">
                            <div class="col-md-3 mt-2 mt-md-0">
                                <span>{{ __('Access') }}</span>
                                <div class="d-flex">
                                    <a href="javascript:void(0)" class="revoke_access btn-default p-2" data-id="{{ $data['id'] }}">{{ __("Revoke access") }}</a>
                                </div>
                            </div>
                            <div class="col-md-2 mt-2 mt-md-0">
                                <span>{{ __('Downloaded') }}</span>
                                <div class="d-flex">
                                    {{ __(':x Times', ['x' => $data['download_times']]) }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        @endif
    </div>
    <div class="product-permissions-body">
        <div class="row">
            <div class="status-dropdown col-sm-10 col-12 mb-2 mb-md-0">
                <select class="form-control select2" id="search_products" multiple name="grant_access[]">
                </select>
            </div>
            <button class="grant-access col-sm-2 col-12 py-2 py-md-0" id="grant_access">{{ __('Grant Access') }}</button>
        </div>
    </div>
</div>
