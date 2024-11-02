 @php
     $totalCard = is_array($component->cta) ? count($component->cta) : 0;
 @endphp
 @if ($totalCard)
     <section class="{{ $component->full ? '' : 'mx-4 lg:mx-4 xl:mx-32 2xl:mx-64 3xl:mx-92' }} md:my-12 my-10"
         style="margin-top:{{ $component->mt }};margin-bottom:{{ $component->mb }};">
         <div class="flex flex-col md:flex-row md:gap-30p gap-15p">
             @foreach ($component->cta as $cta)
                 @php
                     $cta = miniCollection($cta);
                 @endphp
                 <div class="md:w-{{ $totalCard == 1 ? 'full' : '1/' . $totalCard }} w-full">
                     <{{ $component->full_link == 1 ? 'a' : 'div' }} class="block relative"
                         href="{{ $component->full_link == 1 ? $cta['btn_link'] : '' }}">
                         <div class="h-44" style="height: {{ $component->height . 'px' }}">
                             @isset($cta->image)
                                 <img class="h-full w-full object-cover neg-transition-scale {{ $component->rounded == 1 ? 'rounded-md' : '' }}"
                                     src="{{ asset('public/uploads') . DIRECTORY_SEPARATOR . $cta['image'] }}">
                             @endisset
                         </div>
                         <div class="absolute p-6 top-0 right-0 bottom-0 left-0 flex align-items-center">
                             <div>
                                 @if ($cta['upper_st'])
                                     <p class="text-11 text-gray-12 dm-regular">
                                         {!! $cta['upper_st'] !!}</p>
                                 @endif
                                 @if ($cta['lower_st'])
                                     <p class="text-gray-12 font-bold text-lg uppercase dm-bold">
                                         {!! $cta['lower_st'] !!}</p>
                                 @endif
                                 @if ($cta['title'])
                                     <p class="text-gray-12 font-bold text-33 -mt-3 uppercase dm-bold">
                                         {!! $cta['title'] !!}</p>
                                 @endif
                                 @if ($component->full_link != 1 && $cta['btn_text'])
                                     <a href="{{ $cta['btn_link'] ?? 'javascript:void(0)' }}"
                                         class="process-goto hover:bg-gray-12 hover:text-white cursor-pointer relative flex justify-center text-gray-12 rounded-sm text-xs items-center py-2 w-max px-5 dm-sans border border-gray-800 mt-2">
                                         <span>{!! $cta['btn_text'] !!}</span>
                                         <svg class="relative ltr:ml-5p rtl:mr-2.5 neg-transition-scale" width="10" height="7" viewBox="0 0 10 7"
                                             fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                             <path fill-rule="evenodd" clip-rule="evenodd"
                                                 d="M6.7344 0L5.75327 1.05155L7.34399 2.75644H0.69376C0.310607 2.75644 0 3.08934 0 3.5C0 3.91066 0.310607 4.24356 0.69376 4.24356H7.34399L5.75327 5.94845L6.7344 7L10 3.5L6.7344 0Z"
                                                 fill="currentColor"></path>
                                         </svg>
                                     </a>
                                 @endif
                             </div>
                         </div>
                         </{{ $component->full_link == 1 ? 'a' : 'div' }}>
                 </div>
             @endforeach
         </div>
     </section>
 @endif
