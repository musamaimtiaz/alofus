    @forelse ($reviews as $review)
        <div class="container">
            <div class="pt-8 flex">
                <div class="flex-shrink-0 flex flex-col">
                    <img class="w-14 h-14 ltr:mr-4 rtl:ml-4 inline-flex items-center justify-center rounded-full bg-indigo-100 flex-shrink-0 neg-transition-scale" src="{{ isset($review->user) ? optional($review->user)->fileUrl() : asset('public/dist/img/default-image.png') }}" alt="{{ __('Coustomer image') }}">
                </div>
                <div class="md:flex-grow">
                    <div class="flex justify-between">
                        <p class="text-gray-12 text-lg dm-bold">
                            {{ optional($review->user)->name }}</p>
                    </div>
                    <p class="roboto-medium text-gray-10 text-xs">
                        {{ formatDateTime($review->created_at) }}
                    </p>
                    <div class="flex justify-between">
                        <div>
                            <ul class="flex">
                                @for ($star = 0; $star < 5; $star++)
                                    <li>
                                        <svg class="text-green-500 mt-25p" width="20" height="19" viewBox="0 0 20 19" fill="{{ $star < $review->rating ? 'var(--primary-color)' : '#ccc' }}"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M10.0381 0L12.2918 6.93615H19.5849L13.6846 11.2229L15.9383 18.1591L10.0381 13.8723L4.13785 18.1591L6.39154 11.2229L0.4913 6.93615H7.7844L10.0381 0Z" />
                                        </svg>
                                    </li>
                                @endfor
                            </ul>
                        </div>
                    </div>
                    <p class="leading-relaxed mt-2.5 text-gray-10 roboto-medium text-sm">
                        {{ $review->comments }}
                    </p>
                    <div class="mt-5 grid md:grid-cols-10 grid-cols-5 gap-2">
                        @if ($review->filesUrlNew())
                            @foreach ($review->filesUrlNew(['imageUrl' => true]) as $key => $file)
                                <img class="border border-gray-2 rounded-sm h-12 w-16 mb-2 object-cover" src="{{ $file }}"
                                    alt="{{ __('Product Image') }}">
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
            <div class="border mt-5 border-line"></div>
        </div>
    @empty
        <div class="container">
            <div class="md:flex-grow rtl-direction-space-review">
                <div class="mt-8">
                    <p class="dm-sans flex justify-center font-medium text-lg text-gray-12">
                        {{ __('This seller did not receive any product reviews.') }}
                    </p>
                </div>
            </div>
        </div>
    @endforelse
    <input type="hidden" id="vendor_id" value="{{ $vendor->id }}">
    <div id="review-paginate" class="mt-2">
        {{ $reviews->onEachSide(1)->links('pagination::tailwind') }}
    </div>
