@extends('vendor.layouts.app')
@section('page_title', __('Import'))
@section('content')
<!-- Main content -->
<div class="col-sm-12" id="item-import-container">
    <div class="card Recent-Users">
        <div class="card-header">
            <h5><a href="{{ route('vendor.items') }}">{{ __('Products') }}</a> >> {{ __('Import') }}</h5>
        </div>
        <div class="card-body p-0">
            <div class="col-sm-12">
                <div class="card-block pt-2">
                    <button class="btn btn-outline-primary custom-btn-small" id="fileRequest"><i class="fa fa-download"></i>{{ __('Download Sample') }}</button>
                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#show-brands" class="btn btn-outline-primary custom-btn-small"><span class="fa fa-eye"> &nbsp;</span>{{ __('Brands') }}</a>
                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#show-categories" class="btn btn-outline-primary custom-btn-small"><span class="fa fa-eye"> &nbsp;</span>{{ __('Categories') }}</a>
                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#show-attributes" class="btn btn-outline-primary custom-btn-small"><span class="fa fa-eye"> &nbsp;</span>{{ __('Attributes') }}</a>
                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#show-options" class="btn btn-outline-primary custom-btn-small"><span class="fa fa-eye"> &nbsp;</span>{{ __('Options') }}</a>
                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#show-shops" class="btn btn-outline-primary custom-btn-small"><span class="fa fa-eye"> &nbsp;</span>{{ __('Shops') }}</a>
                    <hr>
                    <div class="accordion" id="accordionExample">
                        <div class="border">
                            <div class="card-header p-0" id="headingTwo">
                                <h2 class="mb-0 mt-1">
                                    <button class="btn btn-link btn-block text-left collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        {{ __('Documentation') }}
                                    </button>
                                </h2>
                            </div>
                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">

                                <div class="card-body">
                                    <div class="require-section position-relative">
                                        <a href="#optional" id="goto-optional" class="position-absolute border px-4 py-2 my-2 d-inline-block">{{ __('Go to optional field') }}</a>

                                        <div id="required" class="border-success px-4 border-right border-left py-2 font-bold bg-blue text-white text-center ">{{ __('Required') }}</div>
                                        <table class="table table-bordered mb-4">
                                            <tr>
                                                <th width="218">{{ __('Name') }}</th>
                                                <td>
                                                    <ul>
                                                        <li>{{ __('Example') }}: Realme C9</li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>{{ __('Category id') }}</th>
                                                <td>
                                                    <ul>
                                                        <li>{{ __('You just click the categories button then you will get an category id') }}</li>
                                                        <li>{{ __('Example') }}: 6</li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>{{ __('Shop id') }}</th>
                                                <td>
                                                    <ul>
                                                        <li>{{ __('You just click the shops button then you will get an shop id') }}</li>
                                                        <li>{{ __('Example') }}: 1</li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>{{ __('Brand id') }}</th>
                                                <td>
                                                    <ul>
                                                        <li>{{ __('You just click the brands button then you will get an brand id') }}</li>
                                                        <li>{{ __('Example') }}: 4</li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>{{ __('Product quantity') }}</th>
                                                <td>
                                                    <ul>
                                                        <li>{{ __('How many items you have') }}</li>
                                                        <li>{{ __('Example') }}: 100</li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>{{ __('Price') }}</th>
                                                <td>
                                                    <ul>
                                                        <li>{{ __('Your productproduct price will be here.') }}</li>
                                                        <li>{{ __('Example') }}: 99</li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>{{ __('Summary') }}</th>
                                                <td>
                                                    <ul>
                                                        <li>{{ __('Short description of your product will be here.') }}</li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>{{ __('Description') }}</th>
                                                <td>
                                                    <ul>
                                                        <li>{{ __('Long description of your product will be here.') }}</li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>{{ __('Status') }}</th>
                                                <td>
                                                    <ul>
                                                        <li>{{ __('Example') }}: Active or Inactive</li>
                                                    </ul>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>

                                    <div class="optional-section position-relative">
                                        <a href="#required" id="goto-required" class="position-absolute border px-4 py-2 my-2 d-inline-block">{{ __('Go to required field') }}</a>
                                        <div id="optional" class="border-success px-4 border-right border-left py-2 font-bold bg-blue text-white text-center ">{{ __('Optional') }}</div>
                                        <table class="table table-bordered">
                                            <tr>
                                                <th>SKU</th>
                                                <td>
                                                    <ul>
                                                        <li>{{ __('Example') }}: UGG-BB-PUR-06</li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>{{ __('Available from') }}</th>
                                                <td>
                                                    <ul>
                                                        <li>{{ __('From when the product will be available for users') }}</li>
                                                        <li>{{ __('Example') }}: 30-01-2022</li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>{{ __('Available to') }}</th>
                                                <td>
                                                    <ul>
                                                        <li>{{ __('From when the product will be unavailable for users') }}</li>
                                                        <li>{{ __('Example') }}: 30-05-2022</li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>{{ __('Is virtual') }}</th>
                                                <td>
                                                    <ul>
                                                        <li>{{ __('Nowadays all these things can be experienced virtually.') }}</li>
                                                        <li>{{ __('Example') }}: yes or no</li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>{{ __('Is shippable') }}</th>
                                                <td>
                                                    <ul>
                                                        <li>{{ __('Shippable is capable of being taken from one place to another by public carrier.') }}</li>
                                                        <li>{{ __('Example') }}: yes or no</li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>{{ __('Is shareable') }}</th>
                                                <td>
                                                    <ul>
                                                        <li>{{ __('This product is sharable or not') }}</li>
                                                        <li>{{ __('Example') }}: yes or no</li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>{{ __('Discount amount') }}</th>
                                                <td>
                                                    <ul>
                                                        <li>{{ __('If you want to give some discount of your product then you can fill the box.') }}</li>
                                                        <li>{{ __('Note: Suppose your product price is 99 now you can give discount 10 or something') }}</li>
                                                        <li>{{ __('Example') }}: 10</li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>{{ __('Discount type') }}</th>
                                                <td>
                                                    <ul>
                                                        <li>{{ __('Example') }}: fixed or percent</li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>{{ __('Discount price') }}</th>
                                                <td>
                                                    <ul>
                                                        <li>{{ __('Discount price') }} = {{ __('product price') }} - {{ __('discount amount') }}</li>
                                                        <li>{{ __('Example') }}: 89</li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>{{ __('Discount from') }}</th>
                                                <td>
                                                    <ul>
                                                        <li>{{ __('Discount start date') }}</li>
                                                        <li>{{ __('Example') }}: 30-05-2022</li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>{{ __('Discount to') }}</th>
                                                <td>
                                                    <ul>
                                                        <li>{{ __('Discount end date') }}</li>
                                                        <li>{{ __('Example') }}: 30-08-2022</li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>{{ __('Maximum discount amount') }}</th>
                                                <td>
                                                    <ul>
                                                        <li>{{ __('It will be applicable when discount type is percent') }}</li>
                                                        <li>{{ __('Example') }}: 20</li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>{{ __('Minimum order for discount') }}</th>
                                                <td>
                                                    <ul>
                                                        <li>{{ __('Discount will be applied when minimum order is exceeded.') }}</li>
                                                        <li>{{ __('Example') }}: 50</li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>{{ __('Is inventory enabled') }}</th>
                                                <td>
                                                    <ul>
                                                        <li>{{ __('Example') }}: yes or no</li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>{{ __('Files url') }}</th>
                                                <td>
                                                    <ul>
                                                        <li>{{ __('You can add multiple image url with comma separated.') }}</li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>{{ __('Video url') }}</th>
                                                <td>
                                                    <ul>
                                                        <li>{{ __('It will be youtube video share link.') }}</li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>{{ __('Tags') }}</th>
                                                <td>
                                                    <ul>
                                                        <li>{{ __("Please ignore this filed. If you don't have enough knowledge to write json.") }}</li>
                                                        <li>{{ __('Example') }}: {"0":"Samsung","1":"Mobile","2":"A30", "3":"Phone"}</li>
                                                        <li>{{ __('Here :x is serial number.', ['x' => '0, 1, 2, 3']) }}</li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>{{ __('Attribute') }}</th>
                                                <td>
                                                    <ul>
                                                        <li>{{ __("Please ignore this filed. If you don't have enough knowledge to write json.") }}</li>
                                                        <li>{{ __('Example') }}: {"1":"GSM / HSPA / LTE",<br>
                                                            "2":"2019, February 25", <br>
                                                            "3":"Available. Released 2019, March",<br>
                                                            "4":"158.5 x 74.7 x 7.7 mm (6.24 x 2.94 x 0.30 in)", <br>
                                                            "5":"165 g (5.82 oz)", <br>
                                                            "6":"Single SIM (Nano-SIM) or Dual SIM (Nano-SIM, dual stand-by)", <br>
                                                            "7": "Super AMOLED", <br>
                                                            "8":"6.4 inches, 100.5 cm2 (~84.9% screen-to-body ratio)", <br>
                                                            "9":"1080 x 2340 pixels, 19.5:9 ratio (~403 ppi density)",<br>
                                                            "10":"Corning Gorilla Glass 3", <br>
                                                            "11": "Android 9.0 (Pie), upgradable to Android 10, One UI 2.0", <br>
                                                            "12": "Exynos 7904 (14 nm)",<br>
                                                            "14":"Blue"}
                                                        </li>
                                                        <li>{{ __('Here :x is attribute id', ['x' => '1, 2, 3 ... 12, 14']) }}</li>
                                                        <li>{{ __('You just click the attributes button then you will get an attribute id') }}</li>
                                                        <li>{{ __('Attribute id is related to category id.') }}</li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>{{ __('Option') }}</th>
                                                <td>
                                                    <ul>
                                                        <li>{{ __("Please ignore this field. If you don't have enough knowledge to write json.") }}</li>
                                                        <li>
                                                            {{ __('Example') }}: {"1":{"option_name":"Price", "type": "dropdown", "is_required": 0,<br>
                                                              "label":{"0":"4GB 64GB", "1": "6GB 64GB"},<br>
                                                              "option_price":{"0": "190", "1":"210"},<br>
                                                              "option_price_type":{"0":"Fixed", "1":"Percent"}},<br>
                                                             "2":{"option_name":"Color", "type":"radio", "is_required": "0", <br>
                                                             "label":{"0":"Blue", "1":"Red"},<br>
                                                              "option_price":{"0":"0", "1":"5"}, <br>
                                                              "option_price_type":{"0":"Fixed", "1":"Fixed"}}
                                                        </li>
                                                        <li>{{ __('Here 1 and 2 is option number') }}</li>
                                                        <li>{{ __('You just click the options button then you will get option type.') }}</li>
                                                        <li>{{ __('label (0, 1) is serial number') }}</li>
                                                        <li>{{ __('option_price (0, 1) is serial number') }}</li>
                                                        <li>{{ __('option_price_type (0, 1) is serial number') }}</li>
                                                        <li>{{ __('Option price type value will be Fixed or Percent') }}</li>
                                                    </ul>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <form action="{{ route('vendor.product.import') }}" method="post" id="myform1" class="form-horizontal"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-2 control-label pt-1">{{ __('Choose CSV File') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="custom-file col-md-8">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input form-control d-none" name="file" accept=".csv">
                                        <label class="custom-file-label overflow_hidden position-relative d-flex align-items-center"
                                            for="validatedCustomFile">{{ __('Upload csv...') }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 control-label note"></label>
                            <div class="col-md-8" id='note_txt_1'>
                                <span class="badge badge-info">{{ __('Note') }}</span> <small
                                    class="text-info">{{ __('Allowed File Extensions: csv') }}</small>
                            </div>
                            <div class="col-md-8" id='note_txt_2'>
                            </div>
                        </div>

                        <!-- /.box-body -->
                        <div class="col-sm-8 px-0 mt-3">
                            <button class="btn btn-primary custom-btn-small" type="submit"
                                id="submit">{{ __('Submit') }}</button>
                            <a href="{{ route('vendor.items') }}" class="btn btn-danger custom-btn-small">{{ __('Cancel') }}</a>
                        </div>
                        <!-- /.box-footer -->
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Show brands --}}
<div id="show-brands" class="modal fade display_none" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('Brands') }}</h4>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body item-import-table">
                <input type="text" class="w-100 p-2 my-2 form-control search-table"  placeholder="{{ __('Search for names') }}..">
                <table id="myTable" class="table table-bordered myTable">
                    <thead>
                        <tr>
                            <th width="100">{{ __('Id') }}</th>
                            <th>{{ __('Name') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($brands as $brand)
                            <tr>
                                <td>{{ $brand->id }}</td>
                                <td class="search">{{ $brand->name }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">{{ __('Close') }}</button>
            </div>
        </div>

    </div>
</div>

{{-- Show categories --}}
<div id="show-categories" class="modal fade display_none" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('Categories') }}</h4>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body item-import-table">
                <input type="text" class="w-100 p-2 my-2 form-control search-table"  placeholder="{{ __('Search for names') }}..">
                <table id="myTable" class="table table-bordered myTable">
                    <thead>
                        <tr>
                            <th width="100">{{ __('Id') }}</th>
                            <th>{{ __('Name') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td class="search">{{ $category->name }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">{{ __('Close') }}</button>
            </div>
        </div>

    </div>
</div>

{{-- Show Attributes --}}
<div id="show-attributes" class="modal fade display_none" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('Attributes') }}</h4>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body item-import-table">
                <input type="text" class="w-100 p-2 my-2 form-control search-table"  placeholder="{{ __('Search for names') }}..">
                <table id="myTable" class="table table-bordered myTable">
                    <thead>
                        <tr>
                            <th width="100">{{ __('Attribute Id') }}</th>
                            <th width="100">{{ __('Category Id') }}</th>
                            <th>{{ __('Name') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($attributes as $attribute)
                            @php $catIds = optional($attribute->categoryAttribute)->pluck('category_id') @endphp
                            <tr>
                                <td>{{ $attribute->id }}</td>
                                <td>{{ !empty($catIds) ? $catIds->implode(',') : '' }}</td>
                                <td class="search">{{ $attribute->name }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">{{ __('Close') }}</button>
            </div>
        </div>
    </div>
</div>

{{-- Show Options --}}
<div id="show-options" class="modal fade display_none" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('Options') }}</h4>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body item-import-table">
                <input type="text" class="w-100 p-2 my-2 form-control search-table"  placeholder="{{ __('Search for names') }}..">
                <table id="myTable" class="table table-bordered myTable">
                    <thead>
                        <tr>
                            <th width="100">{{ __('Option type') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $optionTypes = ['field', 'textarea', 'dropdown', 'checkbox', 'checkbox_custom', 'radio', 'radio_custom', 'multiple_select', 'date', 'date_time', 'time']
                        @endphp
                        @foreach ($optionTypes as $type)
                            <tr>
                                <td class="search">{{ $type }}</td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">{{ __('Close') }}</button>
            </div>
        </div>
    </div>
</div>

{{-- Show Options --}}
<div id="show-shops" class="modal fade display_none" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('Shops') }}</h4>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body item-import-table">
                <input type="text" class="w-100 p-2 my-2 form-control search-table"  placeholder="{{ __('Search for names') }}..">
                <table id="myTable" class="table table-bordered myTable">
                    <thead>
                        <tr>
                            <th width="100">{{ __('Id') }}</th>
                            <th width="100">{{ __('Vendor') }}</th>
                            <th>{{ __('Shop') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($shops as $shop)
                            <tr>
                                <td>{{ $shop->id }}</td>
                                <td>{{ optional($shop->vendor)->name }}</td>
                                <td class="search">{{ $shop->name }}</td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">{{ __('Close') }}</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
    <script src="{{ asset('public/dist/js/custom/product.min.js') }}"></script>
@endsection
