

<a class="btn btn-sm btn-primary mb-0 ltr:me-1 rtl:ms-1 display_none" href="javascript:void(0)" id="batch_payment_btn">
    <span class="far fa-money-bill-alt ltr:me-1 rtl:ms-1"></span>
    {{ __('Batch Payment') }} <span class="batch_payment_count"></span>
</a>

@include('bulkpayment::layouts.payment_modal')
