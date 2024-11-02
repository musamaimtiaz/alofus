<section class="mx-4 lg:mx-4 xl:mx-32 2xl:mx-64 3xl:mx-92 my-10 md:my-12"
    style="margin-top:{{ $component->mt }};margin-bottom:{{ $component->mb }};">
    @if ($component->title)
        <P class="dm-bold text-sm text-center md:text-left mb-2.5 md:mb-5 md:text-22 text-gray-12 uppercase">{!! $component->title !!}</P>
    @endif
    <div>
        <button class="has-ajax-load-data opacity-0 invisible" onclick="ajaxProductLoad(this)"
            data-component="{{ $component->id }}"></button>
        <div class="flex flex-col md:flex-row md:gap-29p">
            <div class="skeleton-box bg-gray-11 rev-img rounded-md relative h-36 md:h-80 md:w-1/4">
                <div class="p-10 flex justify-center items-center h-80">
                </div>
            </div>
            <div class="w-full md:w-3/4 mt-5 md:mt-0">
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-5 md:gap-7">
                    <div class="skeleton-box bg-gray-11 rev-img rounded-md relative">
                        <div class="p-10 flex justify-center items-center h-36">
                        </div>
                    </div>
                    <div class="skeleton-box bg-gray-11 rev-img rounded-md relative">
                        <div class="p-10 flex justify-center items-center h-36">
                        </div>
                    </div>
                    <div class="skeleton-box bg-gray-11 rev-img rounded-md relative">
                        <div class="p-10 flex justify-center items-center h-36">
                        </div>
                    </div>
                    <div class="skeleton-box bg-gray-11 rev-img rounded-md relative">
                        <div class="p-10 flex justify-center items-center h-36">
                        </div>
                    </div>
                    <div class="skeleton-box bg-gray-11 rev-img rounded-md relative">
                        <div class="p-10 flex justify-center items-center h-36">
                        </div>
                    </div>
                    <div class="skeleton-box bg-gray-11 rev-img rounded-md relative">
                        <div class="p-10 flex justify-center items-center h-36">
                        </div>
                    </div>

                    <div class="skeleton-box bg-gray-11 rev-img rounded-md relative">
                        <div class="p-10 flex justify-center items-center h-36">
                        </div>
                    </div>

                    <div class="skeleton-box bg-gray-11 rev-img rounded-md relative">
                        <div class="p-10 flex justify-center items-center h-36">
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
