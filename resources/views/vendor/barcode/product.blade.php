@extends('vendor.layouts.app')
@section('page_title', __('Product Barcode'))

@section('css')
    <link rel="stylesheet" href="{{ asset('public/dist/plugins/jQueryUI/jquery-ui.min.css') }}" type="text/css"/>
@endsection

@section('content')
    <div class="col-sm-12" id="barcode-generate-container">
        <form action="{{ route('vendor.barcode.product') }}" method="post">
            @csrf
            <div class="col-sm-12">

                <div class="card">
                    <div class="card-header">
                        <h5>{{ __('Products') }}</h5>
                    </div>
                    <div class="card-body">
        
                        <div class="row">
                            <label class="col-form-label col-md-4" for="add_products">{{ __('Add Products') }}</label>
                            <div class="col-md-8">
                                <input id="search" class="form-control inputFieldDesign" type="search" name="search" placeholder="{{ __('Search for product by name') }}" autocomplete="off">
                                <ul class="ui-autocomplete ui-front ui-menu ui-widget ui-widget-content" id="no_div" tabindex="0">
                                    <li>{{ __('No record found') }} </li>
                                </ul>
                            </div>
                            <div class="row">
                                <div class="col-md-5"></div>
                                <div id="error_message" class="text-danger col-md-7 p-0"></div>
                            </div>
                        </div>

                        <br>
                 
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table" id="product-table">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Products') }}</th>
                                            <th class="text-center">{{ __('SKU') }}</th>
                                            <th class="itemQty text-center">{{ __('Quantity') }}</th>
                                            <th class="w-5">{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    @php $rowNo = 0; $stack = [] @endphp
                                    @if(!empty(old('product_id')))
                                        @foreach(old('product_id') as $key => $productId)
                                            @php $stack[] = $productId @endphp
                                            <tbody id="rowId-{{ $rowNo }}">
                                            <input type="hidden" name="product_id[]" value="{{ $productId }}">
                                            <input type="hidden" name="product_slug[]" value="{{ old('product_slug')[$key] }}">
                                            <input type="hidden" name="product_name[]" value="{{ old('product_name')[$key] }}">
                                            <tr class="itemRow rowNo-${rowNo}" id="productId-{{ $productId }}"  data-row-no="{{ $rowNo }}">
                                                <td class="pl-1">
                                                    <a href="{{ route('site.productDetails', old('product_slug')[$key]) }}" target="_blank">{{ old('product_name')[$key] }}</a>
                                                </td>

                                                <td class="sku">
                                                    <input id="sku_{{ $rowNo }}" name="product_sku[]" class="form-control text-center" type="text" readonly value="{{ old('product_sku')[$key] }}">
                                                </td>

                                                <td class="productQty">
                                                    <input name="product_qty[{{ $productId }}]" id="product_qty_{{ $rowNo }}" class="inputQty form-control text-center" type="number" value="{{ old('product_qty')[$productId] }}" data-rowId = {{ $rowNo }}>
                                                </td>
                                                <td class="text-center" style="padding-top: 15px !important;">
                                                    <a href="javascript:void(0)" class="closeRow" data-row-id="{{ $rowNo }}" data-id = "{{ $productId }}"><i class="feather icon-trash"></i></a>
                                                </td>
                                            </tr>

                                            </tbody>
                                        @endforeach
                                    @endif
                                </table>
                            </div>
                        </div>
                        <div class="col-sm-10 px-0 mt-3 mt-md-0">
                            <a href="{{ url()->previous() }}" class="btn custom-btn-cancel all-cancel-btn">{{ __('Cancel') }}</a>
                            <button class="btn custom-btn-submit" type="submit" id="btnSubmit">
                                <i class="comment_spinner spinner fa fa-spinner fa-spin custom-btn-small display_none"></i>
                                <span id="spinnerText">{{ __('Submit') }}</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        @if(isset($data) && is_array($data) && count($data) > 0)
            <div class="card">
                <div class="card-body">
                   <div class="box">
                <div class="box-default">
                    <div class="box-header clearfix">
                        <a href="javascript:void(0);" id="printBtn" class="options-add-two float-right">{{ __('Print') }}</a>
                    </div>
                    <div class="box-body">
                        <div class="form-group col-md-12 barcode w-100">
                            @if(!empty($data))
                                <table class="table">
                                    <tbody>
                                    @php $isTr = 0; $j = 0@endphp
                                    @foreach ($data as $key => $value)
                                        @for($i = 0; $i < $value['qty']; $i++)


                                            @if($isTr == 0)<tr class="text-center">@endif
                                                <td>
                                                    @if(isset($value['image']))
                                                        <img src='{{ $value['image'] }}' alt="barcode" class="bcimg" width="50"/>
                                                    @endif
                                                    @if(isset($value['vendor']))
                                                        <span class="barcode_site f-10">{{ wrapIt($value['vendor'], 10, ['trim' => true, 'trimLength' => 40]) }}</span>
                                                    @endif
                                                    @if(isset($value['name']))
                                                        <span class="barcode_name f-10">{{ wrapIt($value['name'], 10, ['trim' => true, 'trimLength' => 40]) }}</span>
                                                    @endif
                                                    <span class="barcode_image">
                                                  <img src='data:image/png;base64, {{ $value['barcode'] }}' alt="barcode" class="bcimg"/>
                                               </span>
                                                </td>
                                                @php $j++ @endphp
                                                @if($j%3 == 0 && $isTr == 1)
                                                    @php $isTr = 0; @endphp
                                            </tr>
                                            @else
                                                @php $isTr = 1;@endphp
                                            @endif
                                        @endfor
                                    @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>

                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
                </div>
            </div>
        @endif
    </div>
@endsection
@section('js')
    <script src="{{ asset('public/dist/plugins/jQueryUI/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/moment.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/jquery.PrintArea.min.js') }}"></script>
    <script>
        var HomePageUrl = '{{ route('site.index') }}';
        var rowNo = '{{ $rowNo }}';
        var stack = '{!! count($stack) > 0 ? json_encode($stack) : '[]' !!}';
    </script>
    <script src="{{ asset('public/dist/js/custom/barcode.min.js') }}"></script>
@endsection
