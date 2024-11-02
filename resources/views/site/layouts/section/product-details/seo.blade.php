@php
    $seoTitle = isset($seo['title']) && strlen($seo['title']) > 0 ? $seo['title'] : $name;
    $seoDescription = isset($seo['description']) && strlen($seo['description']) > 0 ? $seo['description'] : $summary;
    $seoImage = '';
    if (isset($seo['image']) && strlen($seo['image']) && !is_array($seo['image'])) {
        $seoImage = $seo['image'];
    } else if (is_array($images) && count($images)) {
       $seoImage = reset($images);
    }
@endphp
<meta name="robots" content="index, follow">
<meta name="description" content="{{ $seoDescription }}" />
<meta name="keywords" content="">
<!-- Schema.org markup for Google+ -->
<meta itemprop="name" content="{{ $seoTitle }}">
<meta itemprop="description" content="{{ $seoDescription }}">
<meta itemprop="image" content="{{ $seoImage }}">

<!-- Twitter Card data -->
<meta name="twitter:card" content="{{ __('Product') }}">
<meta name="twitter:site" content="@publisher_handle">
<meta name="twitter:title" content="{{ $seoTitle }}">
<meta name="twitter:description" content="{{ $seoDescription }}">
<meta name="twitter:creator" content="@author_handle">
<meta name="twitter:image" content="{{ $seoImage }}">
<meta name="twitter:data1" content="">
<meta name="twitter:label1" content="{{ __('Price') }}">

<!-- Open Graph data -->
<meta property="og:title" content="{{ $seoTitle }}" />
<meta property="og:type" content="og:{{ __('Product') }}" />
<meta property="og:url" content="{{ route('site.productDetails', ['slug' => $slug]) }}" />
<meta property="og:image" content="{{ $seoImage }}" />
<meta property="og:description" content="{{ $seoDescription }}" />
<meta property="og:site_name" content="{{ trimWords(preference('company_name'), 17) }}" />
<meta property="og:price:amount" content="" />
<meta property="product:price:currency" content="{{ currency()->name }}" />
<meta property="fb:app_id" content="">
