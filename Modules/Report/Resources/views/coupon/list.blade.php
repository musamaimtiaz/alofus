<div id="loader" class="loader-calss"></div>
<div id="report" class="report-table">
        <div class="table-responsive">
            <table class="table" id="report-table">
                <thead>
                    <tr>
                        @foreach ($header as $key => $value)
                            @if(request()->type == $key)
                                @foreach ($value as $data)
                                <th>{{ $data }}</th>
                                @endforeach
                            @endif
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                 @foreach ($report as $key => $value)
                    <tr>
                        @foreach ($value as $k => $data)
                        <td>{{ $data }}</td>
                        @endforeach
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="pull-right"></div>
        </div>
</div>
<script src="{{ asset('Modules/Report/Resources/assets/js/report-table.min.js') }}"></script>
