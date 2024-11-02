<div class="card code-table h-100">
    <div class="card-header d-flex justify-content-between">
        <h5 class="text-uppercase">{{ __('Most sold brands') }}</h5>
    </div>
    <div class="card-block pb-0 h-300">
        <div>
            <table class="table table-hover" id="most-sold-brands">
                @if (count($topSoldBrands))
                    <thead class="bg-inherit">
                        <tr>
                            <th>{{ __('Brand') }}</th>
                            <th class="text-right">{{ __('Total') }}</th>
                        </tr>
                    </thead>
                @endif

                <tbody class="original-data">
                    @forelse ($topSoldBrands as $brand)
                        <tr>
                            <td class="unread">
                                @if ( $brand['url'] == '')
                                    <span>{{ $brand['name'] }}</span>
                                @else
                                    <a href="{{ $brand['url'] }}" class="mb-0" target="_blank">{{ $brand['name'] }}</a>
                                @endif
                            </td>
                            <td class="text-right">
                                {{ $brand['total'] }}
                            </td>
                        </tr>
                    @empty
                        <tr class="border-0">
                            <td colspan="2" class="border-0">{{ __('No data found.') }}</td>
                        </tr>
                    @endforelse

                </tbody>

                <tbody class="placeholder-data d-none">
                    <tr>
                        <td>
                            <div class="placeholder wave h-16p">
                                <div class="square"></div>
                            </div>
                        </td>
                        <td>
                            <div class="placeholder wave h-16p">
                                <div class="square"></div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="placeholder wave h-16p">
                                <div class="square"></div>
                            </div>
                        </td>
                        <td>
                            <div class="placeholder wave h-16p">
                                <div class="square"></div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="placeholder wave h-16p">
                                <div class="square"></div>
                            </div>
                        </td>
                        <td>
                            <div class="placeholder wave h-16p">
                                <div class="square"></div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="placeholder wave h-16p">
                                <div class="square"></div>
                            </div>
                        </td>
                        <td>
                            <div class="placeholder wave h-16p">
                                <div class="square"></div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="placeholder wave h-16p">
                                <div class="square"></div>
                            </div>
                        </td>
                        <td>
                            <div class="placeholder wave h-16p">
                                <div class="square"></div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
