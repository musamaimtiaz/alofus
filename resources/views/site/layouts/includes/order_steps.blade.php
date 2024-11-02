<div class="flex justify-center items-center mt-5 ltr:-ml-5 ltr:md:-ml-0 rtl:-mr-5 rtl:md:-mr-0">
    @php $steps = [__('MY CART'), __('CHECKOUT'), __('PAYMENT'), __('ORDER COMPLETE')] @endphp
    @for($i = 0; $i < 4; $i++)
   @if($stepsNumber >= $i+1)
    <div class="uppercase relative">
        <div class="flex justify-center items-center">
            <div class="md:h-9 md:w-9 h-5 w-5 bg-white md:border-2 border border-gray-12 rounded-full flex justify-center items-center">
                <span class="dm-bold font-bold text-gray-12 md:text-base text-8">{{ $i + 1 }}</span>
            </div>
            @if($i != 3)
            <div class="md:p-4 p-1">
                <svg class="hidden md:block w-20 lg:w-full" xmlns="http://www.w3.org/2000/svg" width="183" height="6" viewBox="0 0 183 6" fill="none">
                    <path
                        d="M182.887 3.00002L180 0.113264L177.113 3.00002L180 5.88677L182.887 3.00002ZM-4.37114e-08 3.5L180 3.50002L180 2.50002L4.37114e-08 2.5L-4.37114e-08 3.5Z"
                        fill="#33C172" />
                </svg>
                <svg class="md:hidden" width="50" height="5" viewBox="0 0 63 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M62.8867 3.00001L60 0.113254L57.1132 3L60 5.88676L62.8867 3.00001ZM-4.37114e-08 3.5L60 3.50001L60 2.50001L4.37114e-08 2.5L-4.37114e-08 3.5Z" fill="#33C172"/>
                </svg>
            </div>
            @endif
        </div>
        <p class="absolute  mt-2.5 md:mt-5 whitespace-nowrap dm-bold font-bold text-gray-12 text-8 md:text-base ltr:-left-1.5 ltr:md:-left-5 rtl:-right-1.5 rtl:md:-right-5">{{ $steps[$i] }}</p>
    </div>
    @else
        <div class="uppercase relative">
         <div class="flex justify-center items-center">
             <div class="md:h-9 md:w-9 h-5 w-5 bg-gray-11 rounded-full flex justify-center items-center">
                 <span class="dm-bold font-bold text-gray-10 md:text-base text-8">{{ $i+1 }}</span>
             </div>
             @if($i != 3)
             <div class="md:p-4 p-1">
                 <svg class="hidden md:block w-20 lg:w-full" xmlns="http://www.w3.org/2000/svg" width="183" height="6" viewBox="0 0 183 6" fill="none">
                     <path
                         d="M182.887 3.00002L180 0.113264L177.113 3.00002L180 5.88677L182.887 3.00002ZM-4.37114e-08 3.5L180 3.50002L180 2.50002L4.37114e-08 2.5L-4.37114e-08 3.5Z"
                         fill="#DFDFDF" />
                 </svg>
                 <svg class="md:hidden" width="50" height="5" viewBox="0 0 63 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path d="M62.8867 3.00001L60 0.113254L57.1132 3L60 5.88676L62.8867 3.00001ZM-4.37114e-08 3.5L60 3.50001L60 2.50001L4.37114e-08 2.5L-4.37114e-08 3.5Z" fill="#DFDFDF"/>
                 </svg>
             </div>
             @endif
         </div>
         <p class="absolute mt-2.5 md:mt-5 whitespace-nowrap dm-bold font-bold text-gray-10 text-8 md:text-base ltr:-left-2.5 ltr:md:-left-4 rtl:-right-2.5 rtl:md:-right-4">{{ $steps[$i] }}</p>
     </div>
    @endif
    @endfor
</div>
