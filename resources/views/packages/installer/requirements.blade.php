@extends('packages.installer.layout')

@section('content')
  <div class="card darken-1">
        <div class="card-content black-text">
            <div class="center-align">
                <p class="card-title">{{ __("Server Requirements") }}</p>
                <hr>
            </div>
            @foreach ($requirements['requirements'] as $type => $requirement)
               <ul class="collection with-header">
                  <div class="row collection-item font-bold font-16">
                      <div class="col s4 pl-0">
                        {{ __('PHP') }}
                      </div>
                      @if($type == 'php')
                        <div class="col s4">
                          {{ __("(version :x required)", ['x' => 8.0]) }}
                        </div>
                        <div class="col s4 pr-0">
                           {{ __("Current") }}({{ $phpSupportInfo['current'] }})
                           @if($phpSupportInfo['supported'])
                            <i class="material-icons secondary-content green-text text-accent-4">check_circle</i>
                           @endif
                        </div>
                      @endif
                  </div>
                  <li class="collection-item">
                    @foreach ($requirements['requirements'][$type] as $extention => $enabled)
                      <div class="row">
                          <div class="left">
                            {{ ucfirst($extention) }}
                          </div>
                          <div class="right">
                              @if($enabled)
                                <i class="material-icons green-text text-accent-4">check_circle</i>
                              @else
                                <i class="material-icons red-text text-accent-4">cancel</i>
                              @endif
                          </div>
                      </div>
                    @endforeach
                  </li>
               </ul>
            @endforeach
        </div>

        <div class="card-action">
            <div class="row">
               <div class="left">
                  <a class="btn waves-effect blue waves-light" href="{{ url('/') }}">
                      {{ __('Back') }}
                      <i class="material-icons left">arrow_back</i>
                  </a>
                </div>
                @if ( isset($requirements['errors']) && $phpSupportInfo['supported'] )
                  <div class="right">
                    <a class="btn waves-effect blue waves-light" readonly>
                        {{ __('Next') }}
                        <i class="material-icons right">send</i>
                    </a>
                  </div>
                @else
                  <div class="right">
                    <a class="btn waves-effect blue waves-light" href="{{ url('install/permissions') }}">
                        {{ __('Next') }}
                        <i class="material-icons right">send</i>
                    </a>
                  </div>
                @endif
            </div>
        </div>
  </div>
@endsection
