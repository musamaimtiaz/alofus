@extends('admin.layouts.app')
@section('page_title', __('Review'))
@section('css')
    <link rel="stylesheet" href="{{ asset('public/dist/plugins/lightbox/css/lightbox.min.css') }}">
@endsection
@section('content')
    <!-- Main content -->
    <div class="col-sm-12" id="brand-edit-container">
        <div class="card">
            <div class="card-header">
                <h5> <a href="{{ route('review.index') }}">{{ __('Review') }} </a> >> {{ __('View') }}</h5>
            </div>
            <div class="card-body mt-2 order-review-section">
                <div
                    class="d-flex flex-column flex-md-row justify-content-center justify-content-md-start align-items-center">
                    <div>
                        <img class="img-fluid review-img neg-transition-scale" src="{{ optional($review->product)->getFeaturedImage('medium') }}">
                    </div>
                    <div class="mt-3 mt-md-0 ltr:ms-md-4 rtl:me-md-4 items">
                        <div class="ltr:text-md-start rtl:text-md-end item-container">
                            <span>{{ __('Product') }}</span>
                            <h4 class="font-bold mt-2 item-name">
                                @isset($review->product->slug)
                                    <a target="_blank" href="{{ route('site.productDetails', ['slug' => $review->product->slug]) }}">{{ optional($review->product)->name }}</a>
                                @else
                                    {{ optional($review->product)->name }}
                                @endisset
                            </h4>
                        </div>
                        <div class="ltr:text-md-start rtl:text-md-end mt-3">
                            <span>{{ __('Seller') }}</span>
                            <h5 class="font-bold mt-2 seller-name">{{ optional(optional($review->product)->vendor)->name }}
                                @if (isset($review->product->vendor->id) && in_array($review->product->vendor->id, $topSellerIds))
                                    <span class="ltr:ms-2 rtl:me-2 rounded seller-category">{{ __('Top Seller') }}</span>
                                @endif
                            </h5>
                        </div>
                    </div>
                </div>
                <div class="row mt-3 pt-4 reviews">
                    <div class="col-md-6 col-xl-3">
                        <p>{{ __('Reviewed By') }}</p>
                        <div class="d-flex align-items-center">
                            <div>
                                <img class="rounded-circle img-fluid review-user-img neg-transition-scale"
                                    src="{{ optional($review->user)->fileUrl() }}">
                            </div>
                            <div class="ltr:ms-3 rtl:me-3">
                                <h5 class="user-name font-bold">{{ optional($review->user)->name }}</h5>
                                @if ($review->verifiedUser($review->user_id, $review->product_id) &&
                                    preference('reviews_verified_owner_label') == 1)
                                    <div class="d-flex align-items-center">
                                        <span>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="18"
                                                viewBox="0 0 14 18" fill="none">
                                                <path
                                                    d="M6.57558 0.0496559C6.30542 0.107792 5.97711 0.251425 5.51202 0.518169C4.66048 1.00036 4.28772 1.12348 3.58666 1.15084C2.77617 1.18161 1.7981 1.03456 0.789253 0.726778C0.300219 0.579727 0.252342 0.569468 0.170266 0.617344C-0.0144037 0.719938 -0.00756411 0.545528 0.00611515 4.59801C0.0197944 8.67443 0.0197944 8.62997 0.218144 9.5499C0.85081 12.4841 2.86508 15.1174 5.84374 16.8991C6.40117 17.2342 6.9244 17.5078 7.00648 17.5078C7.15353 17.5078 8.31969 16.8375 8.98997 16.369C9.89622 15.7329 10.7546 14.9669 11.4112 14.2077C12.8578 12.5388 13.7196 10.6306 13.9555 8.58209C13.9897 8.28115 14 7.32702 14 4.46806V0.743877L13.9008 0.658382C13.7811 0.555788 13.7777 0.555788 13.1587 0.747297C12.2251 1.03114 11.2197 1.18161 10.4263 1.15084C9.72523 1.12348 9.35247 1.00036 8.50094 0.518169C7.65282 0.0359764 7.17405 -0.0802975 6.57558 0.0496559ZM7.58785 1.36286C7.76568 1.45178 8.15212 1.65013 8.4428 1.79718C9.19516 2.1802 9.75601 2.32383 10.5186 2.32383C10.9564 2.32383 11.2265 2.29305 11.9618 2.14942C12.6013 2.02973 12.6218 2.02973 12.7415 2.13232L12.8373 2.2144V5.18622C12.8373 8.28115 12.8338 8.36665 12.6834 9.15662C12.4064 10.5998 11.6916 12.0977 10.6691 13.3698C10.2929 13.8349 9.41403 14.7138 8.94551 15.0866C8.15896 15.7124 7.20141 16.3246 7.00648 16.3246C6.81155 16.3246 5.854 15.7124 5.06744 15.0866C4.59893 14.7138 3.72003 13.8349 3.34386 13.3698C2.87192 12.7782 2.44102 12.1045 2.11614 11.4376C1.70576 10.6032 1.48348 9.95344 1.32958 9.15662C1.17911 8.36665 1.17569 8.28115 1.17569 5.18622V2.2144L1.27145 2.13232C1.39114 2.02973 1.41166 2.02973 2.05116 2.14942C2.78643 2.29305 3.05659 2.32383 3.49433 2.32383C4.41084 2.32383 4.95801 2.14942 6.23702 1.4552C6.88336 1.10296 7.05777 1.08928 7.58785 1.36286Z"
                                                    fill="#2C2C2C" />
                                                <path
                                                    d="M6.78408 1.82089C6.69175 1.86535 6.41816 2.0124 6.17878 2.14577C5.41274 2.57667 4.85189 2.77502 4.14398 2.87077C3.68231 2.93575 2.86497 2.89813 2.26993 2.7887C2.0066 2.74082 1.78089 2.69978 1.76721 2.69978C1.7296 2.69978 1.73643 7.37467 1.77405 7.9834C1.88691 9.79248 2.53667 11.4066 3.78832 12.9934C4.13373 13.4277 4.98526 14.2793 5.45035 14.6486C5.7855 14.9154 6.60283 15.4796 6.89694 15.6472C7.03031 15.7224 6.99269 15.7395 7.70743 15.2642C8.3914 14.8094 8.86675 14.4229 9.45154 13.8347C10.3475 12.9353 10.9289 12.1248 11.435 11.0681C11.9241 10.0455 12.1703 9.10168 12.2387 7.9834C12.2763 7.37467 12.2831 2.69978 12.2489 2.69978C12.2318 2.69978 12.0061 2.74082 11.7428 2.7887C11.0486 2.91523 10.2449 2.93917 9.69093 2.84342C8.98644 2.7203 8.59316 2.56983 7.63904 2.04318C7.37571 1.89613 7.1158 1.76959 7.05767 1.75933C6.98927 1.74566 6.90036 1.76617 6.78408 1.82089Z"
                                                    fill="#FCCA19" />
                                                <path
                                                    d="M8.71873 5.82354C8.58475 5.86502 8.48029 5.96182 7.61734 6.83758L6.71125 7.76175L6.20937 7.25472C5.65754 6.6993 5.5985 6.65782 5.37141 6.65552C5.18746 6.65552 5.07846 6.6947 4.9581 6.80071C4.76734 6.97125 4.69922 7.22016 4.7787 7.46445C4.81503 7.57968 4.88089 7.65112 5.75065 8.53841C6.26615 9.06157 6.69535 9.49023 6.70897 9.49023C6.7226 9.49023 7.32666 8.88642 8.05336 8.14662C9.51128 6.66474 9.49084 6.69239 9.49084 6.41353C9.49084 6.01713 9.08889 5.71061 8.71873 5.82354Z"
                                                    fill="#2C2C2C" />
                                            </svg>

                                        </span>
                                        <span class="v-fied-con">
                                            <span class="d-block v-fied">{{ __('Verified') }}</span>
                                            {{ __('By :x', ['x' => preference('company_name')]) }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-4 mt-3 mt-md-0">
                        <p>{{ __('Comment') }}</p>
                        <span class="review-comments">{{ $review->comments }}</span>
                    </div>
                </div>
                <div class="row mt-3 pt-4 ratings">
                    <div class="col-md-6 col-xl-3">
                        <p>{{ __('Rating') }}</p>
                        <div class="d-flex align-items-center">
                            @for ($i = 0; $i < 5; $i++)
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="20"
                                        viewBox="0 0 22 20" fill="none">
                                        <path
                                            d="M10.8476 0L13.283 7.49548H21.1642L14.7882 12.1279L17.2236 19.6234L10.8476 14.991L4.47153 19.6234L6.90696 12.1279L0.530918 7.49548H8.41214L10.8476 0Z"
                                            fill="{{ $i < $review->rating ? '#FCCA19' : '#C4C4C4' }}" />
                                    </svg>
                                </span>
                            @endfor
                            <span class="ltr:ms-2 rtl:me-2 rating-count">
                                <span>{{ __(':x star', ['x' => $review->rating]) }}</span>
                            </span>
                        </div>
                    </div>
                    @if ($images = $review->filesUrlNew(['imageUrl' => true]))
                        <div class="col-md-8 col-12 mt-3 mt-md-0">
                            <p>{{ __('Photos') }}</p>
                            <div class="d-flex flex-wrap">
                                @foreach ($images as $key => $image)
                                    <div class="m-1">
                                        <a class="cursor_pointer" href='{{ $image }}' data-lightbox="image-1">
                                            <img class="img-fluid review-photo" src='{{ $image }}' alt="{{ __('Image') }}" >
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script src="{{ asset('public/dist/plugins/lightbox/js/lightbox.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/review.min.js') }}"></script>
@endsection
