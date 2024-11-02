@extends('admin.layouts.app')
@section('page_title', __('View :x', ['x' => __('Invoice')]))
@section('css')
    <!-- date range picker css -->
    <link rel="stylesheet" href="{{ asset('public/dist/plugins/bootstrap-daterangepicker/daterangepicker.min.css') }}">
    <!-- select2 css -->
    <link rel="stylesheet" href="{{ asset('public/datta-able/plugins/select2/css/select2.min.css') }}">
@endsection
@section('content')

    <!-- Main content -->
    <div class="col-sm-12 order-details-container" id="invoice-view-container">
        {{-- Notification --}}
        <div class="col-md-12 no-print notification-msg-bar smoothly-hide">
            <div class="noti-alert pad">
                <div class="alert bg-dark text-light m-0 text-center">
                    <span class="notification-msg"></span>
                </div>
            </div>
        </div>

        <div>
            @php
                $sections = (new \App\Services\Order\Section)->getSections();
            @endphp
            @foreach ($sections as $key => $section)
                @if (
                    ($section['visibility'] ?? '1') == '1' 
                    && ($section['is_main'] ?? false))
                    @if (is_callable($section['content']))
                        {!! $section['content']() !!}
                    @else
                        @includeIf($section['content'])
                    @endif
                @endif
            @endforeach
        </div>
        
        <div class="order-actions-container">
            @foreach ($sections as $key => $section)
                @if (
                    ($section['visibility'] ?? '1') == '1' 
                    && !($section['is_main'] ?? false))
                    @if (is_callable($section['content']))
                        {!! $section['content']() !!}
                    @else
                        @includeIf($section['content'])
                    @endif
                @endif
            @endforeach
        </div>

        <div id="refund-store" class="modal fade display_none" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('Refund') }} &nbsp; </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('site.orderRefund') }}" method="post" class="form-horizontal">
                            @csrf
                            <input type="hidden" name="quantity_sent" id="quantity_sent" value="1">
                            <input type="hidden" name="order_detail_id" id="order_detail_id">
                            <input type="hidden" name="type" value="admin">
                            <div class="form-group row mb-3">
                                <label class="col-3 control-label" for="inputEmail3">{{ __('Quantity') }}</label>
                                <div class="col-6 d-flex align-items-center">
                                    <a href="javascript:void(0)" class="text-center px-3 py-2 border" id="refundQtyDec"><span class="inline-block">-</span></a>
                                    <div class="px-3" id="refundQty">1</div>
                                    <a href="javascript:void(0)" class="text-center px-3 py-2 border" id="refundQtyInc"><span class="inline-block">+</span></a>
                                </div>
                            </div>

                            <div class="form-group row mt-3 mt-md-0">
                                <label class="col-3 control-label ltr:pe-0 rtl:ps-0 relative" for="inputEmail3">{{ __('Reason') }}</label>
                                <div class="col-8">
                                    <select class="form-control select2" name="refund_reason_id">
                                        @foreach ($refundReasons as $reason)
                                            <option value="{{ $reason->id }}">{{ $reason->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row mt-3">
                                <label class="col-3 control-label ltr:pe-0 rtl:ps-0" for="is_default"></label>
                                <div class="col-8">
                                    <textarea name="comment" class="form-control" placeholder="{{ __('Please let me know, why are you want to refund this item.') }}" rows="5"></textarea>
                                </div>
                            </div>

                            <div class="form-group row mt-3 mt-md-0">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn custom-btn-submit ltr:float-right rtl:float-left">{{ __('Submit') }}</button>
                                    <button type="button" class="btn custom-btn-cancel all-cancel-btn ltr:float-right rtl:float-left" data-bs-dismiss="modal">{{ __('Close') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        var orderId = "{{ $order->id }}";
        var paymentStatus = "{{ $order->payment_status }}";
        var finalOrderStatus = "{{ $finalOrderStatus }}";
        var orderUrl = "{{ route('order.update') }}";
        var orderView = "admin";
    </script>
    <script src="{{ asset('public/datta-able/plugins/sweetalert/js/sweetalert.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/common.min.js') }}"></script>
    <!-- select2 JS -->
    <script src="{{ asset('public/datta-able/plugins/select2/js/select2.full.min.js') }}"></script>
    <!-- date range picker Js -->
    <script src="{{ asset('public/dist/js/moment.min.js') }}"></script>
    <script src="{{ asset('public/dist/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/invoice.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/jquery.blockUI.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/order.min.js') }}"></script>
@endsection
