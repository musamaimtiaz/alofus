@extends('site.layouts.app')
@section('page_title', trimWords($blog->title, 65))
@section('seo')

@php
    $seoTitle = isset($blog->title) && strlen($blog->title) > 0 ? $blog->title : '';
    $seoDescription = isset($blog->summary) && strlen($blog->summary) > 0 ? trimWords($blog->summary, 120) : '';
    $seoImage = $blog->fileUrl() ? $blog->fileUrl() : '';
    $seoKeywords = preference('company_name').', '.__('eCommerce').', '.__('Multivendor').', '.__('Multivendor eCommerce');
@endphp

    <meta name="robots" content="index, follow">
    <meta name="title" content="{{ $seoTitle }}">
    <meta name="description" content="{{ $seoDescription }}" />
    <meta name="keywords" content="{{ $seoKeywords }}">

    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="{{ $seoTitle }}">
    <meta itemprop="description" content="{{ $seoDescription }}">
    <meta itemprop="image" content="{{ $seoImage }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $seoTitle }}">
    <meta property="og:description" content="{{ $seoDescription }}">
    <meta property="og:image" content="{{ $seoImage }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="{{ $seoTitle }}">
    <meta property="twitter:description" content="{{ $seoDescription }}">
    <meta property="twitter:image" content="{{ $seoImage }}">
@endsection
@section('content')
    <!-- component -->
    <div class="mx-4 lg:mx-4 xl:mx-32 2xl:mx-64 3xl:mx-92">
        <nav class="text-gray-600 text-sm mt-30p" aria-label="Breadcrumb">
            <ol class="list-none p-0 flex flex-wrap md:inline-flex text-xs md:text-sm roboto-medium font-medium text-gray-10 leading-5">
                <li class="flex items-center">
                    <svg class="-mt-1 ltr:mr-2 rtl:ml-2" width="13" height="15" viewBox="0 0 13 15" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M5.35643 1.89407C4.93608 2.1717 4.43485 2.59943 3.69438 3.23412L2.916 3.9013C2.0595 4.63545 1.82512 4.85827 1.69934 5.13174C1.57357 5.4052 1.55692 5.72817 1.55692 6.85625V10.1569C1.55692 10.9127 1.55857 11.4013 1.60698 11.7613C1.65237 12.099 1.72565 12.2048 1.7849 12.264C1.84416 12.3233 1.94997 12.3966 2.28759 12.442C2.64759 12.4904 3.13619 12.492 3.89206 12.492H8.56233C9.31819 12.492 9.80679 12.4904 10.1668 12.442C10.5044 12.3966 10.6102 12.3233 10.6695 12.264C10.7287 12.2048 10.802 12.099 10.8474 11.7613C10.8958 11.4013 10.8975 10.9127 10.8975 10.1569V6.85625C10.8975 5.72817 10.8808 5.4052 10.755 5.13174C10.6293 4.85827 10.3949 4.63545 9.53838 3.9013L8.76 3.23412C8.01953 2.59943 7.5183 2.1717 7.09795 1.89407C6.69581 1.62848 6.44872 1.55676 6.22719 1.55676C6.00566 1.55676 5.75857 1.62848 5.35643 1.89407ZM4.49849 0.595063C5.03749 0.239073 5.5849 0 6.22719 0C6.86948 0 7.41689 0.239073 7.95589 0.595063C8.4674 0.932894 9.04235 1.42573 9.7353 2.01972L10.5515 2.71933C10.5892 2.75162 10.6264 2.78347 10.6632 2.81492C11.3564 3.40806 11.8831 3.85873 12.1694 4.48124C12.4557 5.10375 12.4551 5.79693 12.4543 6.70926C12.4543 6.75764 12.4542 6.80662 12.4542 6.85625L12.4542 10.2081C12.4543 10.8981 12.4543 11.4927 12.3903 11.9688C12.3217 12.479 12.167 12.9681 11.7703 13.3648C11.3736 13.7615 10.8845 13.9162 10.3742 13.9848C9.89812 14.0488 9.30358 14.0488 8.61355 14.0488H3.84083C3.1508 14.0488 2.55626 14.0488 2.08015 13.9848C1.56991 13.9162 1.08082 13.7615 0.68411 13.3648C0.2874 12.9681 0.132701 12.479 0.064101 11.9688C9.07021e-05 11.4927 0.000124017 10.8981 0.000162803 10.2081L0.000164659 6.85625C0.000164659 6.80662 0.000122439 6.75763 8.07765e-05 6.70926C-0.000705247 5.79693 -0.00130245 5.10374 0.285011 4.48124C0.571324 3.85873 1.09802 3.40806 1.79122 2.81492C1.82798 2.78347 1.8652 2.75162 1.90288 2.71933L2.68126 2.05215C2.69391 2.0413 2.70652 2.03049 2.71909 2.01972C3.41204 1.42573 3.98698 0.932893 4.49849 0.595063Z" fill="#898989" />
                        <path fill-rule="evenodd" clip-rule="evenodd"d="M3.50293 9.37853C3.50293 8.51876 4.19991 7.82178 5.05969 7.82178H7.39482C8.25459 7.82178 8.95158 8.51876 8.95158 9.37853V13.2704C8.95158 13.7003 8.60309 14.0488 8.1732 14.0488C7.74331 14.0488 7.39482 13.7003 7.39482 13.2704V9.37853H5.05969V13.2704C5.05969 13.7003 4.71119 14.0488 4.28131 14.0488C3.85142 14.0488 3.50293 13.7003 3.50293 13.2704V9.37853Z" fill="#898989" />
                    </svg>
                    <a href="{{ route('site.index') }}">{{ __('Home') }}</a>
                    <p class="px-2">/</p>
                </li>
                @if (isset($blog->category_id) && !empty($blog->category_id))
                     <li class="flex items-center">
                        <a href="{{ route('blog.category', ['id' => $blog->category_id]) }}">{{ optional($blog->blogCategory)->name }}</a>
                        <p class="px-2">/</p>
                    </li>
                @endif
                @if (isset($blog->title) && !empty($blog->title))
                    <li>
                        <a href="javaScript:void(0);" class="text-gray-12" aria-current="page" title="{{ $blog->title }}">{{ trimWords($blog->title, 65) }}</a>
                    </li>
                @endif
            </ol>
        </nav>
        <main>
            {{-- left --}}
            <div class="md:flex justify-between w-full mt-5">
                <div class="md:w-4/6 lg:w-full ltr:md:mr-8 rtl:md:ml-8">
                    {{-- post cards --}}
                    <div>
                        <div class="left-side lg:w-833 w-full h-411p">
                            <img src="{{ $blog->fileUrl() }}" class="rounded w-full lg:h-411p h-full neg-transition-scale object-cover"/>
                        </div>
                        <div class="mb-10 md:mt-3.5 mt-18p">
                            <div>
                                <p class="text-gray-12 leading-15p md:text-13 text-xs roboto-medium font-medium ltr:ml-1 ltr:mr-5 rtl:mr-1 rtl:ml-5">
                                    <span class="font-normal text-gray-10">{{ __('By') }}</span>
                                    <span class="cursor-pointer">
                                        {{ isset($blog->user) && !empty(optional($blog->user)->name) ? optional($blog->user)->name : __('Guest Author') }}
                                    </span>
                                    @if (isset($blog->created_at) && !empty($blog->created_at))
                                        <span class="text-gray-10">{{ __('On') }}</span>
                                        <span class="text-gray-12">{{ formatDateTime($blog->created_at) }}</span>
                                    @endif
                                </p>
                            </div>
                            <p class="lg:leading-42p text-gray-12 break-all font-bold dm-bold mt-2.5 md:text-32 text-lg mb-2">
                                {{ $blog->title }}
                            </p>
                            <div class="unreset">
                                {!! $blog->description !!}</div>
                        </div>
                    </div>
                    @if (isset($blog->user) && !empty($blog->user))
                        <div class="lg:w-833 w-full lg:h-152 border rounded border-gray-2 box-border">
                            <div class="grid lg:grid-cols-4 grid-cols-2">
                                <img class="h-24 w-24 my-7 object-fit rounded-full neg-transition-scale ltr:ml-7 rtl:mr-7" src="{{ optional($blog->user)->fileUrl() }}"
                                    alt="{{ __('Image') }}">
                                <div class="mt-8 ltr:lg:-ml-12 rtl:lg:-mr-12">
                                    <p class="roboto-medium text-13 font-medium leading-15p text-gray-10">{{ __('Author') }}</p>
                                    <p class="dm-sans font-medium text-lg mt-2p leading-6 text-gray-12">
                                        {{ optional($blog->user)->name }}</p>
                                    <p class="roboto-medium text-13 font-medium mt-5p text-gray-10 leading-15p">
                                        {{ optional($blog->user)->designation }}
                                    </p>
                                    <div class="flex mt-3.5 cursor-pointer text-gray-10">
                                        @if (optional($blog->user)->facebook)
                                            <a href="{{ optional($blog->user)->facebook }}">
                                                <svg class="hover:text-gray-12 transition ease-in-out delay-130 ltr:mr-3 rtl:ml-3 neg-transition-scale"
                                                    width="15" height="15" viewBox="0 0 15 15" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M15 7.51739C15 3.62777 11.6421 0.474609 7.5 0.474609C3.35786 0.474609 0 3.62777 0 7.51739C0 11.0326 2.74263 13.9463 6.32812 14.4746V9.55319H4.42383V7.51739H6.32812V5.96578C6.32812 4.20068 7.44785 3.22569 9.16099 3.22569C9.9813 3.22569 10.8398 3.36325 10.8398 3.36325V5.09643H9.89414C8.9625 5.09643 8.67188 5.63936 8.67188 6.19687V7.51739H10.752L10.4194 9.55319H8.67188V14.4746C12.2574 13.9463 15 11.0326 15 7.51739Z" fill="currentColor" />
                                                </svg>
                                            </a>
                                        @endif
                                        @if (optional($blog->user)->instagram)
                                            <a href="{{ optional($blog->user)->twitter }}">
                                                <svg class="t-0.5 hover:text-gray-12 transition ease-in-out delay-130 ltr:mr-3 rtl:ml-3 neg-transition-scale"
                                                    width="14" height="13" viewBox="0 0 14 13" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M4.40426 12.4746C9.68598 12.4746 12.5757 7.85738 12.5757 3.85454C12.5757 3.72474 12.5729 3.59205 12.5675 3.46225C13.1296 3.0334 13.6147 2.50222 14 1.89365C13.4765 2.13937 12.9206 2.29984 12.3514 2.3696C12.9507 1.99064 13.3995 1.39532 13.6145 0.693985C13.0507 1.04646 12.4341 1.2951 11.7912 1.42925C11.358 0.943696 10.7852 0.622203 10.1615 0.514475C9.53772 0.406746 8.89769 0.518782 8.34035 0.83326C7.783 1.14774 7.33938 1.64714 7.07808 2.25426C6.81677 2.86138 6.75233 3.5424 6.89473 4.19203C5.75312 4.1316 4.6363 3.81875 3.61666 3.27379C2.59702 2.72882 1.69732 1.96389 0.975898 1.02859C0.609233 1.69547 0.497033 2.48461 0.662101 3.23563C0.82717 3.98665 1.25712 4.64318 1.86457 5.07181C1.40853 5.05653 0.962486 4.92701 0.563281 4.69393V4.73143C0.562873 5.43128 0.792224 6.10967 1.21235 6.65131C1.63247 7.19294 2.21744 7.56437 2.86781 7.70248C2.44537 7.82441 2.00199 7.84217 1.57199 7.7544C1.75552 8.35627 2.11258 8.88268 2.59337 9.26017C3.07415 9.63766 3.65465 9.84739 4.25387 9.86009C3.23658 10.7031 1.97993 11.1603 0.686328 11.1581C0.456917 11.1577 0.227733 11.1429 0 11.1137C1.31417 12.0031 2.84289 12.4755 4.40426 12.4746Z"
                                                        fill="currentColor" />
                                                </svg>
                                            </a>
                                        @endif
                                        @if (optional($blog->user)->instagram)
                                            <a href="{{ optional($blog->user)->instagram }}">
                                                <svg class="mt-0.5 hover:text-gray-12 transition ease-in-out delay-130 neg-transition-scale"
                                                    xmlns="http://www.w3.org/2000/svg" width="15" height="15"
                                                    viewBox="0 0 15 15" fill="none">
                                                    <path d="M7.29625 1.31389C9.24572 1.31389 9.47657 1.32245 10.2433 1.35665C10.9558 1.388 11.3405 1.5077 11.597 1.60746C11.9362 1.73856 12.1813 1.89816 12.435 2.15182C12.6915 2.40833 12.8482 2.65059 12.9793 2.98975C13.0791 3.24626 13.1988 3.63387 13.2302 4.34355C13.2644 5.11307 13.2729 5.34393 13.2729 7.29055C13.2729 9.24002 13.2644 9.47087 13.2302 10.2376C13.1988 10.9501 13.0791 11.3348 12.9793 11.5913C12.8482 11.9305 12.6886 12.1756 12.435 12.4293C12.1785 12.6858 11.9362 12.8425 11.597 12.9736C11.3405 13.0734 10.9529 13.1931 10.2433 13.2245C9.47372 13.2587 9.24287 13.2672 7.29625 13.2672C5.34678 13.2672 5.11593 13.2587 4.34925 13.2245C3.63672 13.1931 3.25196 13.0734 2.99545 12.9736C2.65629 12.8425 2.41118 12.6829 2.15752 12.4293C1.90102 12.1728 1.74426 11.9305 1.61316 11.5913C1.5134 11.3348 1.3937 10.9472 1.36235 10.2376C1.32815 9.46802 1.3196 9.23717 1.3196 7.29055C1.3196 5.34108 1.32815 5.11022 1.36235 4.34355C1.3937 3.63102 1.5134 3.24626 1.61316 2.98975C1.74426 2.65059 1.90387 2.40548 2.15752 2.15182C2.41403 1.89531 2.65629 1.73856 2.99545 1.60746C3.25196 1.5077 3.63957 1.388 4.34925 1.35665C5.11593 1.32245 5.34678 1.31389 7.29625 1.31389ZM7.29625 0C5.31543 0 5.06747 0.00855029 4.2894 0.0427515C3.51417 0.0769526 2.9812 0.202357 2.51949 0.381913C2.03782 0.570019 1.63026 0.817978 1.22554 1.22554C0.817978 1.63026 0.57002 2.03782 0.381913 2.51664C0.202357 2.9812 0.0769526 3.51132 0.0427515 4.28655C0.00855029 5.06747 0 5.31543 0 7.29625C0 9.27707 0.00855029 9.52503 0.0427515 10.3031C0.0769526 11.0783 0.202357 11.6113 0.381913 12.073C0.57002 12.5547 0.817978 12.9622 1.22554 13.367C1.63026 13.7717 2.03782 14.0225 2.51664 14.2077C2.9812 14.3873 3.51132 14.5127 4.28655 14.5469C5.06462 14.5811 5.31258 14.5896 7.2934 14.5896C9.27422 14.5896 9.52218 14.5811 10.3003 14.5469C11.0755 14.5127 11.6084 14.3873 12.0702 14.2077C12.549 14.0225 12.9565 13.7717 13.3613 13.367C13.766 12.9622 14.0168 12.5547 14.202 12.0759C14.3816 11.6113 14.507 11.0812 14.5412 10.306C14.5754 9.52788 14.5839 9.27992 14.5839 7.2991C14.5839 5.31828 14.5754 5.07032 14.5412 4.29225C14.507 3.51702 14.3816 2.98405 14.202 2.52234C14.0225 2.03782 13.7745 1.63026 13.367 1.22554C12.9622 0.820828 12.5547 0.570019 12.0759 0.384763C11.6113 0.205207 11.0812 0.0798027 10.306 0.0456016C9.52503 0.0085503 9.27707 0 7.29625 0Z"
                                                        fill="currentColor" />
                                                    <path d="M7.29671 3.54883C5.22754 3.54883 3.54883 5.22754 3.54883 7.29671C3.54883 9.36588 5.22754 11.0446 7.29671 11.0446C9.36588 11.0446 11.0446 9.36588 11.0446 7.29671C11.0446 5.22754 9.36588 3.54883 7.29671 3.54883ZM7.29671 9.72784C5.95431 9.72784 4.86557 8.6391 4.86557 7.29671C4.86557 5.95431 5.95431 4.86557 7.29671 4.86557C8.6391 4.86557 9.72784 5.95431 9.72784 7.29671C9.72784 8.6391 8.6391 9.72784 7.29671 9.72784Z" fill="currentColor" />
                                                    <path d="M12.0673 3.40037C12.0673 3.88489 11.674 4.27535 11.1924 4.27535C10.7078 4.27535 10.3174 3.88204 10.3174 3.40037C10.3174 2.91585 10.7107 2.52539 11.1924 2.52539C11.674 2.52539 12.0673 2.9187 12.0673 3.40037Z"
                                                        fill="currentColor" />
                                                </svg>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                                <div class="border-l mt-6 lg:block hidden border-line w-0 h-25 ltr:-ml-20 rtl:-mr-20"></div>
                                <p class="lg:block hidden break-all my-10 italic text-left roboto-medium text-15 font-medium text-gray-10 ltr:mr-30p ltr:lg:-ml-250p rtl:ml-30p rtl:lg:-mr-250p">
                                    {{ optional($blog->user)->description }}</p>
                                <div>
                                </div>
                            </div>
                            <div class="lg:hidden block">
                                <div class="border mx-7 border-gray-2">
                                </div>
                                <div class="text-center italic m-6 break-all roboto-medium lg:text-15 text-13 font-medium text-gray-10">
                                    <p>{{ optional($blog->user)->description }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                    @php
                        $social = option('default_template_social', '');
                    @endphp
                    <div class="flex justify-end mt-8">
                        <div class="flex">
                            @if ($social['facebook'] || $social['whatsapp'] || $social['instagram'] || $social['instagram'] || $social['linkedin'])
                                <p class="text-base dm-sans font-medium text-gray-12 ltr:mr-3 rtl:ml-3">{{ __('Share on') }}:</p>
                            @endif
                            <div class="flex text-gray-10 ltr:mr-1 rtl:ml-1">
                                @if ($social['facebook'])
                                <a href="https://www.facebook.com/sharer.php?u={{ urlencode(url()->current()) }}"
                                    target="_blank">
                                    <svg class="transition ease-in-out delay-130 hover:text-gray-12 hover:border-gray-12 border border-gray-2 rounded-full cursor-pointer ltr:mr-7p rtl:ml-7p neg-transition-scale"
                                        xmlns="http://www.w3.org/2000/svg" width="25" height="25"
                                        viewBox="0 0 25 25" fill="none">
                                        <path d="M17.6004 8.38641C17.6004 7.47764 16.7986 6.67578 15.8898 6.67578H8.99383C8.08506 6.67578 7.2832 7.47764 7.2832 8.38641V15.2824C7.2832 16.1912 8.08506 16.993 8.99383 16.993H12.4685V13.0906H11.1856V11.38H12.4685V10.6851C12.4685 9.50901 13.3239 8.49332 14.393 8.49332H15.7829V10.204H14.393C14.2326 10.204 14.0723 10.3643 14.0723 10.6851V11.38H15.7829V13.0906H14.0723V16.993H15.8898C16.7986 16.993 17.6004 16.1912 17.6004 15.2824V8.38641Z" fill="currentColor" />
                                    </svg>
                                </a>
                                @endif
                                @if ($social['whatsapp'])
                                <a href="https://api.whatsapp.com/send?text={{ urlencode(url()->current()) }}"
                                    target="_blank">
                                    <svg class="hover:text-gray-12 transition ease-in-out delay-130 hover:border-gray-12 border border-gray-2 rounded-full cursor-pointer ltr:mr-7p rtl:ml-7p neg-transition-scale"
                                        xmlns="http://www.w3.org/2000/svg" width="25" height="25"
                                        viewBox="0 0 25 25" fill="none">
                                        <path d="M17.2938 7.32151C16.0948 6.12668 14.4961 5.46289 12.8087 5.46289C9.30052 5.46289 6.45847 8.29507 6.45847 11.7911C6.45847 12.8974 6.76932 14.0037 7.3022 14.933L6.41406 18.2077L9.789 17.3227C10.7215 17.8094 11.7429 18.075 12.8087 18.075C16.3168 18.075 19.1589 15.2428 19.1589 11.7468C19.1145 10.1094 18.4928 8.51634 17.2938 7.32151ZM15.8728 14.0479C15.7395 14.402 15.1178 14.756 14.807 14.8002C14.5406 14.8445 14.1853 14.8445 13.83 14.756C13.608 14.6675 13.2972 14.579 12.9419 14.402C11.3432 13.7382 10.3219 12.1451 10.2331 12.0123C10.1443 11.9238 9.56697 11.1715 9.56697 10.375C9.56697 9.57841 9.96663 9.22438 10.0998 9.04737C10.2331 8.87036 10.4107 8.87036 10.5439 8.87036C10.6327 8.87036 10.766 8.87036 10.8548 8.87036C10.9436 8.87036 11.0768 8.82611 11.21 9.13588C11.3432 9.44565 11.6541 10.2422 11.6985 10.2865C11.7429 10.375 11.7429 10.4635 11.6985 10.552C11.6541 10.6405 11.6097 10.729 11.5209 10.8175C11.4321 10.906 11.3432 11.0388 11.2988 11.083C11.21 11.1715 11.1212 11.26 11.21 11.3928C11.2988 11.5698 11.6097 12.0566 12.0982 12.4991C12.7199 13.0301 13.2083 13.2071 13.386 13.2957C13.5636 13.3842 13.6524 13.3399 13.7412 13.2514C13.83 13.1629 14.1409 12.8089 14.2297 12.6319C14.3185 12.4548 14.4517 12.4991 14.585 12.5434C14.7182 12.5876 15.5175 12.9859 15.6507 13.0744C15.8284 13.1629 15.9172 13.2071 15.9616 13.2514C16.006 13.3842 16.006 13.6939 15.8728 14.0479Z"
                                            fill="currentColor" />
                                    </svg>
                                </a>
                                @endif
                                @if ($social['instagram'])
                                <a href="https://www.instagram.com/sharer.php?u={{ url()->current() }}"
                                    target="_blank">
                                    <svg class="transition ease-in-out delay-130 hover:text-gray-12 hover:border-gray-12 border border-gray-2 rounded-full cursor-pointer ltr:mr-7p rtl:ml-7p neg-transition-scale"
                                        xmlns="http://www.w3.org/2000/svg" width="25" height="25"
                                        viewBox="0 0 25 25" fill="none">
                                        <path d="M16.8217 7.2832H9.44088C8.60756 7.2832 7.97266 7.91811 7.97266 8.75143V16.1322C7.97266 16.9655 8.60756 17.6004 9.44088 17.6004H16.8217C17.655 17.6004 18.2899 16.9655 18.2899 16.1322V8.75143C18.2899 7.91811 17.655 7.2832 16.8217 7.2832ZM13.1313 15.537C14.8376 15.537 16.2264 14.1878 16.2264 12.5609C16.2264 12.2831 16.1868 11.9656 16.1074 11.7276H16.9804V15.9338C16.9804 16.1322 16.8217 16.3306 16.5836 16.3306H9.67897C9.48056 16.3306 9.28215 16.1719 9.28215 15.9338V11.6879H10.1948C10.1155 11.9656 10.0758 12.2434 10.0758 12.5212C10.0361 14.1878 11.425 15.537 13.1313 15.537ZM13.1313 14.3465C12.0202 14.3465 11.1472 13.4735 11.1472 12.4021C11.1472 11.3307 12.0202 10.4577 13.1313 10.4577C14.2424 10.4577 15.1154 11.3307 15.1154 12.4021C15.1154 13.5132 14.2424 14.3465 13.1313 14.3465ZM16.9407 10.1006C16.9407 10.3387 16.7423 10.5371 16.5042 10.5371H15.3931C15.155 10.5371 14.9566 10.3387 14.9566 10.1006V9.0292C14.9566 8.79111 15.155 8.5927 15.3931 8.5927H16.5042C16.7423 8.5927 16.9407 8.79111 16.9407 9.0292V10.1006Z" fill="currentColor" />
                                    </svg>
                                </a>
                                @endif
                                @if ($social['linkedin'])
                                <a href="http://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(url()->current()) }}"
                                    target="_blank">
                                    <svg class="transition ease-in-out delay-130 hover:text-gray-12 hover:border-gray-12 border border-gray-2 rounded-full cursor-pointer ltr:mr-7p rtl:ml-7p neg-transition-scale"
                                        xmlns="http://www.w3.org/2000/svg" width="25" height="25"
                                        viewBox="0 0 25 25" fill="none">
                                        <path d="M17.0273 12.5901V15.9376H15.0678V12.7943C15.0678 12.0186 14.782 11.4879 14.088 11.4879C13.5574 11.4879 13.2308 11.8553 13.1083 12.1819C13.0675 12.3044 13.0267 12.4677 13.0267 12.6718V15.9376H11.0672C11.0672 15.9376 11.108 10.6307 11.0672 10.1H13.0267V10.9164C13.2716 10.5082 13.7615 9.93668 14.782 9.93668C16.0475 9.93668 17.0273 10.794 17.0273 12.5901ZM9.02604 7.2832C8.37288 7.2832 7.92383 7.73225 7.92383 8.30377C7.92383 8.87529 8.33205 9.32434 8.98522 9.32434C9.6792 9.32434 10.0874 8.87529 10.0874 8.30377C10.1283 7.69143 9.72002 7.2832 9.02604 7.2832ZM8.0463 15.9376H10.0058V10.1H8.0463V15.9376Z"
                                            fill="currentColor" />
                                    </svg>
                                </a>
                                @endif
                                @if ($social['pinterest'])
                                <a href="http://pinterest.com/pin/create/button/?url={{ urlencode(url()->current()) }}"
                                    target="_blank">
                                    <svg class="transition ease-in-out delay-130 hover:text-gray-12 hover:border-gray-12 border border-gray-2 rounded-full cursor-pointer ltr:mr-7p rtl:ml-7p neg-transition-scale"
                                        xmlns="http://www.w3.org/2000/svg" width="25" height="25"
                                        viewBox="0 0 25 25" fill="none">
                                        <path d="M16.1614 7.83793C15.3867 7.06317 14.273 6.67578 13.0624 6.67578C11.2223 6.67578 10.1086 7.45055 9.47912 8.08004C8.70436 8.8548 8.26855 9.87168 8.26855 10.937C8.26855 12.2444 8.8012 13.2128 9.72123 13.6002C9.76966 13.6486 9.8665 13.6486 9.91492 13.6486C10.1086 13.6486 10.2539 13.5034 10.3023 13.3097C10.3507 13.2128 10.3992 12.9223 10.4476 12.777C10.496 12.5349 10.4476 12.4381 10.3023 12.2444C10.0602 11.9538 9.91492 11.5665 9.91492 11.0822C9.91492 9.67799 10.9802 8.17689 12.9171 8.17689C14.4667 8.17689 15.4351 9.04849 15.4351 10.4527C15.4351 11.3244 15.2414 12.1475 14.9025 12.777C14.6603 13.2128 14.2245 13.6971 13.595 13.6971C13.3045 13.6971 13.0624 13.6002 12.9171 13.3581C12.7719 13.1644 12.7234 12.9223 12.7719 12.6802C12.8203 12.3897 12.9171 12.0991 13.014 11.8086C13.1592 11.2759 13.3529 10.7433 13.3529 10.3559C13.3529 9.67799 12.9171 9.19376 12.2876 9.19376C11.4644 9.19376 10.8349 10.0169 10.8349 11.0338C10.8349 11.5665 10.9802 11.9054 11.0287 12.0507C10.9318 12.4865 10.3023 15.0529 10.2055 15.4887C10.157 15.7792 9.72123 18.0067 10.3991 18.1519C11.1255 18.3456 11.8034 16.1666 11.8518 15.9245C11.9002 15.7308 12.0939 14.956 12.1908 14.5202C12.5297 14.8592 13.1108 15.1013 13.6919 15.1013C14.7572 15.1013 15.6772 14.6171 16.3551 13.7455C16.9846 12.9223 17.372 11.7602 17.372 10.4527C17.3236 9.58114 16.9362 8.56427 16.1614 7.83793Z"
                                            fill="currentColor"/>
                                    </svg>
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-between mt-30p">
                        @if ($previousUrl)
                            <div>
                                <a href="{{ route('blog.details', $previousUrl->slug) }}" class="flex relative arrow-hover ltr:pl-4 rtl:pr-4 md:text-base text-sm dm-sans font-medium text-gray-10 hover:text-gray-12">
                                    <svg class="mt-1.5 ltr:mr-2 rtl:ml-2 neg-transition-scale absolute w-3 h-2 lg:w-4 lg:h-2.5" width="15" height="10" viewBox="0 0 15 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M4.70711 0L6.12132 1.41421L3.82843 3.70711H13.4142C13.9665 3.70711 14.4142 4.15482 14.4142 4.70711C14.4142 5.25939 13.9665 5.70711 13.4142 5.70711H3.82843L6.12132 8L4.70711 9.41421L0 4.70711L4.70711 0Z" fill="currentColor"/>
                                    </svg>
                                    <span class="ltr:ml-4 rtl:mr-4 dm-sans font-medium">{{ __('Previous Post') }}</span>
                                </a>
                                <a href="{{ route('blog.details', $previousUrl->slug) }}"
                                    class="text-base transition ease-in-out delay-120 title-text-decoration dm-sans break-all font-medium text-gray-12">{{ trimWords($previousUrl->title, 30) }}</a>
                            </div>
                        @else
                            <a href="javaScript:void(0);"
                                class="pointer-events-none flex text-base dm-sans font-medium text-gray-10">
                                <svg class="mt-1.5 w-3 h-2 lg:w-4 lg:h-2.5 ltr:mr-3 rtl:ml-3 neg-transition-scale" xmlns="http://www.w3.org/2000/svg" width="15"
                                    height="10" viewBox="0 0 15 10" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M4.70696 0L6.12117 1.41421L3.82828 3.70711H13.4141C13.9663 3.70711 14.4141 4.15482 14.4141 4.70711C14.4141 5.25939 13.9663 5.70711 13.4141 5.70711H3.82828L6.12117 8L4.70696 9.41421L-0.000150681 4.70711L4.70696 0Z"
                                        fill="#898989" />
                                </svg> {{ __('Previous Post') }} </a>
                        @endif
                        @if ($nextUrl)
                            <div class="flex flex-col break-all lg:items-end items-end justify-center lg:justify-end">
                                <a href="{{ route('blog.details', $nextUrl->slug) }}"
                                    class="process-goto hover:text-gray-12 relative justify-center text-gray-10 font-medium lg:text-base text-sm dm-sans inline-flex items-center dm-sans">
                                    <span class="ltr:-ml-5 rtl:-mr-5">{{ __('Next Post') }}</span>
                                    <svg class="ltr:ml-2 rtl:mr-2 neg-transition-scale relative w-3 h-2 lg:w-4 lg:h-2.5" width="15" height="10"
                                        viewBox="0 0 15 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M9.70696 0L8.29274 1.41421L10.5856 3.70711H0.999849C0.447564 3.70711 -0.000150681 4.15482 -0.000150681 4.70711C-0.000150681 5.25939 0.447564 5.70711 0.999849 5.70711H10.5856L8.29274 8L9.70696 9.41421L14.4141 4.70711L9.70696 0Z"
                                            fill="currentColor" />
                                    </svg>
                                </a>
                                <a href="{{ route('blog.details', $nextUrl->slug) }}" class="text-base transition ease-in-out delay-120 title-text-decoration lg:text-right text-right dm-sans font-medium text-gray-12">{{ trimWords($nextUrl->title, 30) }}</a>
                            </div>
                        @else
                        <a href="javaScript:void(0);" class="process-goto disabled relative justify-center text-gray-10 font-medium lg:text-base text-sm dm-sans inline-flex dm-sans mt-1 lg:mt-0">
                            <span class="ltr:-ml-5 rtl:-mr-5">{{ __('Next Post') }}</span>
                            <svg class="relative w-3 my-1.5 h-2 lg:w-4 lg:h-2.5 ltr:ml-2 rtl:mr-2 neg-transition-scale" width="15" height="10"
                                viewBox="0 0 15 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M9.70696 0L8.29274 1.41421L10.5856 3.70711H0.999849C0.447564 3.70711 -0.000150681 4.15482 -0.000150681 4.70711C-0.000150681 5.25939 0.447564 5.70711 0.999849 5.70711H10.5856L8.29274 8L9.70696 9.41421L14.4141 4.70711L9.70696 0Z"
                                    fill="#898989" />
                            </svg>
                        </a>
                        @endif
                    </div>
                    @if (isset($relatedPosts) && !empty($relatedPosts) && count($relatedPosts) > 0)
                        <p class="lg:text-22 text-lg dm-bold lg:mt-10 mt-30p uppercase font-bold text-center leading-29p text-gray-12">{{__('Related posts')}}</p>
                        <div class="flex gap-x-5 md:gap-x-3 overflow-auto md:mt-15p mt-2 mb-30p">
                            @foreach ($relatedPosts as $relatedPost)
                                <div class="relative w-full md:w-1/3 sm:mb-0 mb-6">
                                    <a href="{{ route('blog.details', $relatedPost->slug) }}">
                                        <div class="w-245p md:w-full">
                                            <img alt="content" class="rounded h-141p w-275p object-fit neg-transition-scale"
                                                src="{{ $relatedPost->fileUrl() }}">
                                            <div class="absolute top-2.5 bg-opacity rounded-sm px-2 pt-0 pb-2p ltr:left-2.5 rtl:right-2.5">
                                                <p class="text-center text-15 font-bold dm-bold  md:mt-0">
                                                    {{ date('d', strtotime($relatedPost->created_at)) }}</p>
                                                <p class="text-center text-xss font-normal -mt-1.5 dm-regular">
                                                    {{ date('M', strtotime($relatedPost->created_at)) }}</p>
                                            </div>
                                        </div>
                                    </a>
                                    <p class="text-xs leading-15p dm-sans pt-11p text-gray-10 font-medium">{{ optional($relatedPost->user)->name }}
                                    </p>
                                    <a href="{{ route('blog.details', $relatedPost->slug) }}"
                                        class="text-base dm-sans mt-1p title-text-decoration break-all cursor-pointer leading-22p text-gray-12 font-medium" title="{{ $relatedPost->title }}">
                                        {{ trimWords($relatedPost->title, 65) }}</a> <br>
                                    <a href="{{ route('blog.details', $relatedPost->slug) }}"
                                        class="dm-sans process-goto font-medium text-sm text-gray-10 inline-flex items-center hover:text-gray-12 process-goto relative trans-2 ltr:ml-auto">
                                        {{ __('Read Now') }}
                                        <svg class="fill-current relative mt-1 ltr:ml-2 rtl:mr-2 neg-transition-scale"
                                            xmlns="http://www.w3.org/2000/svg" width="12" height="7"
                                            viewBox="0 0 12 7" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M7.8527 0.00012207L6.80238 1.05045L8.50529 2.75336H1.386C0.975825 2.75336 0.64331 3.08588 0.64331 3.49605C0.64331 3.90623 0.975825 4.23875 1.386 4.23875H8.50529L6.80238 5.94166L7.8527 6.99198L11.3486 3.49605L7.8527 0.00012207Z"
                                                fill="currentColor" />
                                        </svg>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
                {{-- right sidebar --}}
                @include('site.layouts.section.blog.sidebar')
            </div>
        </main>
    </div>
@endsection
