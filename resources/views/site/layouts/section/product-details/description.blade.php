<div class="c-tab is-active md:mt-6" id="product-description-panel">
    <div class="c-tab__content">
        <div id="item-details-section">
            <div id="item-details" class="h-96 unreset overflow-hidden relative item-full-details mt-5 md:mt-0">
                <div>
                    <div>
                        <h3 class="sr-only">{{ __('Description') }}</h3>
                        <div class="space-y-6 list-style mb-20 roboto-medium text-sm md:text-15 text-gray-10">
                            @if(isset($videos) && is_array($videos) && count($videos) > 0)
                            <iframe class="w-337p h-155p inline-block ltr:float-right rtl:float-left rounded px-2" src="{{ $videos[0] }}" allowfullscreen></iframe>
                            @endif
                            @if(!empty(strip_tags($description)) || strpos($description, '<img src'))
                                    {!! $description !!}
                            @elseif(!empty($summary))
                                    {{ $summary }}
                            @else
                                {{ __('No Description') }}
                            @endif
                        </div>
                    </div>
                </div>
                @if(strlen(strip_tags($description)) > 1667 || strpos($description, '<img src') || substr_count($description,'<li>') > 18 || substr_count($description,'<p>') > 8)
                <div id="view-more" class="absolute justify-center flex inset-x-0 bottom-0 add">
                    <div class="mb-2 mt-8 px-6 py-1 cursor-pointer rounded-sm">
                        <a class="flex justify-center">
                            <span class=" ltr:pr-5p rtl:pl-5p text-sm dm-sans font-medium text-gray-10">{{ __('See More') }}</span>
                            <svg class="mt-2" width="11" height="7" viewBox="0 0 11 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5.5 5L4.83564 5.74741L5.5 6.33796L6.16436 5.74741L5.5 5ZM0.335636 1.74741L4.83564 5.74741L6.16436 4.25259L1.66436 0.252591L0.335636 1.74741ZM6.16436 5.74741L10.6644 1.74741L9.33564 0.252591L4.83564 4.25259L6.16436 5.74741Z" fill="#898989"/>
                            </svg>
                        </a>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
