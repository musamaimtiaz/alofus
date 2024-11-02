<div class="noti-alert pad no-print warningMessage mt-2 px-2">
    <div class="alert warning-message abc mb-0">
        <strong id="warning-msg" class="msg"></strong>
    </div>
</div>
<div class="row px-4">
    <div class="col-sm-12 p-0 mt-14 accordion-parent">
        @php
            $id = 1;
        @endphp
        @forelse ($shippingZones as $zone)
        @php
            $mainId = Str::random(10);
            $locationId = Str::random(10);
            $methodId = Str::random(10);
            $freeId = Str::random(10);
            $localId = Str::random(10);
            $flatId = Str::random(10);
        @endphp
        <div class="accordion accordion-flush" id="accordionFlush-{{ $mainId }}">
            <div class="card bg-light-gray mb-0">
                <div class="card-header p-0 " id="flush-headingOne">
                    <div class="d-flex justify-content-between">
                        <input type="hidden" name="id" value="{{ $id++ }}">
                        <input type="text" class="form-control w-50 border-left-0 border-top-0 border-bottom-0" placeholder="{{ __('Enter zone name') }}" name="name" value="{{ isset($zone->name) ? $zone->name : '' }}">
                        <div class="d-md-flex justify-content-between">
                            <button class="btn btn-link text-right text-dark collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse-{{ $locationId }}" aria-expanded="false" aria-controls="flush-collapse-{{ $locationId }}">
                                {{ __('Set Locations') }} <i class="fas fa-angle-down"></i>
                            </button>
                            <button class="btn btn-link text-right text-dark collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse-{{ $methodId }}" aria-expanded="false" aria-controls="flush-collapse-{{ $methodId }}">
                                {{ __('Set Shipping Methods') }} <i class="fas fa-angle-down"></i>
                            </button>
                            <div class="ltr:me-3 rtl:ms-3">
                                <span class="text-dark delete-zone cursor_pointer delete-button action-btn d-flex justify-content-center" title="{{ __('Delete Tax Rate') }}">
                                    <i class="fa fa-trash"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="flush-collapse-{{ $locationId }}" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlush-{{ $mainId }}">


                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-main border-left-right">
                            <thead class="bg-light-gray text-dark border-top-gray">
                                <tr>
                                    <th>{{ __('Country') }}</th>
                                    <th>{{ __('State') }}</th>
                                    <th>{{ __('City') }}</th>
                                    <th>{{ __('ZIP') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($zone->shippingZoneGeolocales as $geolocale)
                                    <tr>
                                        <td>
                                            <input type="text" class="form-control" maxlength="30" name="country" value="{{ isset($geolocale->country) ? $geolocale->country : '' }}">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" maxlength="30" name="state" value="{{ isset($geolocale->state) ? $geolocale->state : '' }}">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" maxlength="30" name="city" value="{{ isset($geolocale->city) ? $geolocale->city : '' }}">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" maxlength="10" name="zip" value="{{ isset($geolocale->zip) ? $geolocale->zip : '' }}">
                                        </td>
                                        <td>
                                            <span class="text-dark cursor_pointer location-delete-button action-btn d-flex justify-content-center" title="{{ __('Delete Tax Rate') }}">
                                                <i class="fa fa-trash"></i>
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="5">{{ __('No location found.') }}</td>
                                    </tr>
                                @endforelse
                                <tr>
                                    <td colspan="10" class="pt-3">
                                        <button type="button" class="btn custom-btn-submit btn-sm add-new-location">{{ __('Add New Location') }}</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div id="flush-collapse-{{ $methodId }}" class="collapse accordion-collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlush-{{ $mainId }}">
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link free-shipping-button nav-list-buttons text-uppercase active font-bold" data-bs-toggle="tab" href="#free_shipping-{{ $freeId }}" role="tab" data-tab="free_shipping-{{ $freeId }}"  aria-controls="free_shipping-{{ $freeId }}" aria-selected="true">{{ __('Free Shipping') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link pickup-button nav-list-buttons text-uppercase font-bold" data-bs-toggle="tab" href="#local_pickup-{{ $localId }}" role="tab" data-tab="local_pickup-{{ $localId }}" aria-controls="local_pickup-{{ $localId }}" aria-selected="false">{{ __('Local Pickup') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link flat-rate-button nav-list-buttons text-uppercase font-bold" data-bs-toggle="tab" href="#flat_rate-{{ $flatId }}" role="tab" data-tab="flat_rate-{{ $flatId }}" aria-controls="flat_rate-{{ $flatId }}" aria-selected="false">{{ __('Flat Rate') }}</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            @include('shipping::layout.shipping-method')
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
            <div class="border p-2 no_shipping_zone">
                <h4 class="text-center" colspan="10">{{ __('No shipping zone found.') }}</h4>
            </div>
        @endforelse

        <div class="mt-14">
            <button type="button" class="btn custom-btn-submit add-shipping-zone">{{ __('Add New') }}</button>
            <button type="submit" class="btn custom-btn-submit save-shipping-zone">{{ __('Save') }}</button>
        </div>
    </div>
</div>
