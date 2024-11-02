@php
    $blogs = $homeService->getBlogs($component->blog_type, $component->blog_limit, null, $component->blogs);
@endphp
@foreach ($blogs as $blog)
    <div class="w-4/5 md:w-1/3 mb-2 md:mb-0 relative">
        <div class="w-260p rounded-md md:w-full overflow-hidden">
            <div class="rounded-md">
                <div class="grows inline-block overflow-hidden w-full md:h-48 h-36">
                    <a href="{{ route('blog.details', ['slug' => $blog->slug]) }}">
                        <img class="w-full h-full rounded-md block object-cover neg-transition-scale" src="{{ $blog->fileUrl() }}"
                            alt="{{ $blog->title }}">
                    </a>
                </div>
            </div>
        </div>
        <div class="absolute left-2.5 top-2.5 h-10 w-10 bg-opacity rounded md:left-4 md:top-4 md:h-11 md:w-11">
            <p class="text-center text-15 md:text-xl font-bold dm-bold leading-3 mt-2 md:mt-0">
                {{ date('d', strtotime($blog->created_at)) }}</p>
            <p class="text-center text-xs md:text-sm font-normal mt-0.5 md:-mt-1.5 dm-regular">
                {{ date('M', strtotime($blog->created_at)) }}</p>
        </div>
        <p class="text-xss md:text-13 font-medium break-all title-font text-gray-10 mt-3 dm-sans">
            {{ optional($blog->user)->name }}</p>
        <p class="text-base md:text-xl md:leading-relaxed break-all font-medium text-gray-12 dm-sans">
            {{ trimWords($blog->title, 65) }}</p>
        <a href="{{ route('blog.details', $blog->slug) }}"
            class="text-gray-10 font-medium text-sm md:text-base inline-flex items-center mt-1 dm-sans">{{ __('Read Now') }}
            <svg class="w-3 md:w-4 h-4 mt-0.5 ltr:ml-2 rtl:mr-2 neg-transition-scale" viewBox="0 0 15 10" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M9.70696 0L8.29274 1.41421L10.5856 3.70711H0.999849C0.447564 3.70711 -0.000150681 4.15482 -0.000150681 4.70711C-0.000150681 5.25939 0.447564 5.70711 0.999849 5.70711H10.5856L8.29274 8L9.70696 9.41421L14.4141 4.70711L9.70696 0Z"
                    fill="currentColor" />
            </svg>
        </a>
    </div>
@endforeach
