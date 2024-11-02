<section class="md:flex gap-5 mt-5 mx-0 lg:mx-4 xl:mx-32 2xl:mx-64 3xl:mx-92">
    <div class="mx-5 lg:mx-0">
        <div class="grid py-10 grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 2xl:grid-cols-5 gap-x-3 md:gap-x-5 xl:gap-x-8 gap-y-5 lg:gap-y-5 xl:lg:gap-y-7 2xl:gap-y-8">
            @foreach ($allProducts as $item)
                @include('site.layouts.section.card-one')
            @endforeach
        </div>
    </div>
</section>
<div class="px-4 z-index-1">
    {{ $allProducts->links('pagination::tailwind') }}
</div>
