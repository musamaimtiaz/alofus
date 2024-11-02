<section dir="ltr"
    class="{{ $component->full == 1 ? '' : 'mx-4 lg:mx-4 xl:mx-32 2xl:mx-64 3xl:mx-92' }} my-10 md:my-12"
    style="margin-top:{{ $component->mt }};margin-bottom:{{ $component->mb }};">
    {!! $component->content !!}
</section>
