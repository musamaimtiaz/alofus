<a href="{{ route('admin.tickets', ['thread_status' => 'open']) }}" target="_blank">
    <div class="card mb-0">
        <div class="card-block">
            <div class="row d-flex align-items-center">
                <div class="col-auto">
                    <i class="fas fa-ticket-alt f-30 text-c-yellow neg-transition-scale-svg "></i>
                </div>
                <div class="col text-left">
                    <h3 class="font-weight-500">{{ $openTicketCount }}</h3>
                    <span class="d-block text-uppercase font-weight-600 c-gray-5">{{ __('Open Tickets') }}</span>
                </div>
            </div>
        </div>
    </div>
</a>
