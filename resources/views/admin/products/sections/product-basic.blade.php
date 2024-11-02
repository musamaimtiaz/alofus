<div id="item-edit-container">
    <div id="home" class="card section">
        <div class="card-h pt-24p pl-3-res">
            <h4> <a class="text-dark" href="{{ str_contains(url()->current(), '/admin') ? route('product.index') : route('vendor.products') }}">{{ __('Product') }} </a> /
                <span
                    class="f-13">{{ isset($product) ? __('Edit :x', ['x' => __('Product')]) : __('Create :x', ['x' => __('Product')]) }}</span>
            </h4>
        </div>
        <div class="table-border-style blockable pb-11p">
            <div class="row form-tabs pb-20-res">
                <div class="col-md-12 mt-7p" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="row">
                            <div class="col-md-12 p-1">
                                <div class="card-border">
                                    <div class="card-body px-3-res px-32p">
                                        <div class="form-group row">
                                            <label for="name"
                                                class="label-title col-md-2 control-label">{{ __('Name') }}
                                            </label>
                                            <div class="col-md-10">
                                                <input type="text" placeholder="{{ __('Name') }}"
                                                    class="form-control inputFieldDesign" id="item_name" name="name"
                                                    value="{{ isset($product) ? $product->name : '' }}">
                                                <div
                                                    class="align-items-center mt-12p permalink-section close-parent {!! isset($product) ? ' d-md-flex flex-wrap ' : 'd-none' !!}">
                                                    <span class="color-2c">{{ __('Permalink') }}:</span>
                                                    <a class="m-change ltr:ms-1 rtl:me-1 preview-link word-break" target="_blank"
                                                        href="{{ isset($product) ? route('site.productDetails', ['slug' => $product->slug]) : '' }}"
                                                        data-url="{{ url('/products') }}">{{ url('/products') }}/<span
                                                            class="permalink-msg"></span>
                                                    </a>
                                                    <input
                                                        class="border-0 edit-input bg-white edit-permalink customs-permalink d-none"
                                                        type="text" disabled
                                                        value="{{ isset($product) ? $product->slug : '' }}" />
                                                    <a
                                                        class="options-add px-2 t-10-res ltr:ms-1 rtl:me-1 f-12 edit-button bg-white">
                                                        {{ __('Edit') }}
                                                    </a>
                                                    <a
                                                        class="btn-add save-button save-permalink">{{ __('Ok') }}</a>
                                                    <a
                                                        class="cancel-button f-14 font-weight-500 color-2c ltr:ms-2 rtl:me-2 cursor-pointer border-b-2c">{{ __('Cancel') }}</a>
                                                </div>
                                            </div>
                                        </div>
                                        @if (count($categories))
                                            <div class="ajax-loader">
                                                <img src="{{ asset('public/dist/img/loader/loader.gif') }}"
                                                    class="img-responsive" />
                                            </div>
                                            @php
                                                $catId = 0;
                                                $specificCat = 0;
                                                $specificSubCat = 1;
                                            @endphp
                                            <div class="form-group row form-h mt-25p">
                                                <label for="category_id"
                                                    class="col-md-2 label-title control-label">{{ __('Category') }}</label>
                                                <div class="col-md-10">
                                                    <input class="form-control inputFieldDesign" id="custom-show"
                                                        placeholder="{{ __('Select Category') }}"
                                                        value="{{ $parentCategory ?? null }}" autocomplete="off">
                                                    <div class="Content">
                                                        <div class="d-flex">
                                                            <div class="drop-main custom-scroll shadow-sm" id="myDIV">
                                                                <ul class="Menu -vertical">
                                                                    <div class="input-group p-2">
                                                                        <input
                                                                            class="form-control border m-border input-height category-search ltr:border-end-0 rtl:border-start-0"
                                                                            type="search"
                                                                            placeholder="{{ __('Search') }}"
                                                                            data-seId={{ $catId }}>
                                                                        <span class="input-group-append input-height">
                                                                            <button
                                                                                class="btn text-secondary bg-white border input-height ltr:border-start-0 ltr:rounded-end rtl:border-end-0 rtl:rounded-start"
                                                                                type="button">
                                                                                <div class="icon-height">
                                                                                    <i class="fa fa-search"></i>
                                                                                </div>
                                                                            </button>
                                                                        </span>
                                                                    </div>
                                                                    <div class="custom-overflow"
                                                                        id="categorySearchDiv-{{ $catId++ }}">
                                                                        @foreach ($categories as $category)
                                                                            @if (count($category->childrenCategories))
                                                                                <li class="-hasSubmenu category-list categorySearchDiv-{{ $specificCat }}"
                                                                                    id="list-{{ $category->id }}"
                                                                                    data-catId="{{ $category->id }}"
                                                                                    data-name="{{ $category->name }}">
                                                                                    <a
                                                                                        href="javascript:void(0)">{{ wrapIt($category->name, 20, ['columns' => 3, 'trim' => true, 'trimLength' => 25]) }}</a>
                                                                                    <ul>
                                                                                        <div class="input-group p-2">
                                                                                            <input
                                                                                                class="form-control ltr:border-end-0 rtl:border-start-0 border m-border input-height category-search"
                                                                                                type="search"
                                                                                                placeholder="{{ __('Search') }}"
                                                                                                data-seId={{ $catId }}>
                                                                                            <span
                                                                                                class="input-group-append input-height">
                                                                                                <button
                                                                                                    class="btn text-secondary bg-white ltr:border-start-0 ltr:rounded-end rtl:border-end-0 rtl:rounded-start input-height border ms-n5"
                                                                                                    type="button">
                                                                                                    <div
                                                                                                        class="icon-height">
                                                                                                        <i
                                                                                                            class="fa fa-search"></i>
                                                                                                    </div>
                                                                                                </button>
                                                                                            </span>
                                                                                        </div>
                                                                                        <div class="custom-overflow"
                                                                                            id="categorySearchDiv-{{ $catId++ }}">
                                                                                            @foreach ($category->childrenCategories as $childCategory)
                                                                                                @include('../admin/layouts.includes.child_category',
                                                                                                    [
                                                                                                        'child_category' => $childCategory,
                                                                                                        'catId' => $catId,
                                                                                                    ])
                                                                                            @endforeach
                                                                                        </div>
                                                                                    </ul>
                                                                                </li>
                                                                            @else
                                                                                <li class="category-list clicked categorySearchDiv-{{ $specificCat }}"
                                                                                    id="list-{{ $category->id }}"
                                                                                    data-catId="{{ $category->id }}"
                                                                                    data-name="{{ $category->name }}">
                                                                                    <a
                                                                                        href="javascript:void(0)">{{ wrapIt($category->name, 20, ['columns' => 3, 'trim' => true, 'trimLength' => 25]) }}</a>
                                                                                </li>
                                                                            @endif
                                                                        @endforeach
                                                                    </div>
                                                                </ul>

                                                                <nav aria-label="breadcrumb"
                                                                    class="mt-2 small current-section">
                                                                    <ol class="breadcrumb custom-breadcrumb text-sm">
                                                                        <span
                                                                            class="inline-block ltr:me-2 rtl:ms-2">{{ __('Current section') }}:
                                                                        </span>
                                                                    </ol>
                                                                </nav>

                                                                <div class="d-flx align-items-center">
                                                                    <a class="btn-confirms h-33p w-88p" disabled
                                                                        id="categorySubmit">{{ __('Confirm') }}</a>
                                                                    <a class="btn-add"
                                                                        id="categoryCancel">{{ __('Cancel') }}</a>
                                                                    <a class="f-14 color-2c ltr:ms-2 rtl:me-2 text-black cursor-pointer font-weight-500"
                                                                        id="categoryClear">{{ __('Clear') }}</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        <input type="hidden" name="category_id" id="category_id"
                                            value="{{ isset($product) ? optional($product->productCategory)->category_id ?? 1 : 1 }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
