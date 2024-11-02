@php
function generateMetaTags($title, $description, $image = '')
{
    $url = url()->current();

    echo <<<HTML
        <meta name="robots" content="index, follow">
        <meta name="title" content="$title">
        <meta name="description" content="$description" />
        <meta name="keywords" content="">

        <!-- Schema.org markup for Google+ -->
        <meta itemprop="name" content="$title">
        <meta itemprop="description" content="$description">
        <meta itemprop="image" content="$image">

        <!-- Open Graph / Facebook -->
        <meta property="og:type" content="website">
        <meta property="og:url" content="$url">
        <meta property="og:title" content="$title">
        <meta property="og:description" content="$description">
        <meta property="og:image" content="$image">

        <!-- Twitter -->
        <meta property="twitter:card" content="summary_large_image">
        <meta property="twitter:url" content="$url">
        <meta property="twitter:title" content="$title">
        <meta property="twitter:description" content="$description">
        <meta property="twitter:image" content="$image">
HTML;
}

if ($page) {
    generateMetaTags($page->meta_title ?? $page->title, $page->meta_description, $page->fileUrl());
} else {
    $seoTitle = isset($vendor->name) && strlen($vendor->name) > 0 ? $vendor->name : '';
    $seoDescription = isset($vendor->description) && strlen($vendor->description) > 0 ? $vendor->description : '';
    $seoImage = optional($vendor->logo)->fileUrl() ? optional($vendor->logo)->fileUrl() : '';
    $seoKeywords = preference('company_name').', '.__('eCommerce').', '.__('Multivendor').', '.__('Multivendor eCommerce');
    
    generateMetaTags($seoTitle, $seoDescription, $seoImage);
}
@endphp
