<meta name="robots" content="index, follow">
<meta name="description" content="{{ $page->title }}" />
<meta name="keywords" content="">
<!-- Schema.org markup for Google+ -->
<meta itemprop="name" content="{{ $page->name }}">
<meta itemprop="description" content="{{ $page->meta_description ?? strip_tags($page->meta_description) }}">
<meta itemprop="image" content="{{ $page->fileUrl() }}">

<!-- Twitter Card data -->
<meta name="twitter:card" content="{{ __('Page') }}">
<meta name="twitter:site" content="@publisher_handle">
<meta name="twitter:title" content="{{ $page->title }}">
<meta name="twitter:description" content="{{ $page->meta_description ?? strip_tags($page->meta_description) }}">
<meta name="twitter:creator" content="@author_handle">
<meta name="twitter:image" content="{{ $page->fileUrl() }}">
<meta name="twitter:data1" content="">

<!-- Open Graph data -->
<meta property="og:title" content="{{ $page->title }}" />
<meta property="og:type" content="og:{{ __('Page') }}" />
<meta property="og:url" content="{{ route('site.page', ['slug' => $page->slug]) }}" />
<meta property="og:image" content="{{ $page->fileUrl() }}" />
<meta property="og:description" content="{{ $page->meta_description ?? strip_tags($page->meta_description) }}" />
<meta property="og:site_name" content="{{ trimWords(preference('company_name'), 17) }}" />
<meta property="fb:app_id" content="">

