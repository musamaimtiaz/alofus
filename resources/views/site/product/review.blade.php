
@forelse($reviews as $review)
    <section class="text-gray-600 body-font overflow-hidden">
        <div class="container">
            <div class=" mt-8 flex">
                <div class="flex-shrink-0 flex flex-col">
                    <img class="w-10 h-10 md:w-14 md:h-14 inline-flex items-center justify-center rounded-full bg-indigo-100 text-indigo-500 flex-shrink-0 ltr:mr-4 rtl:ml-4"
                        src="{{ isset($review->user) ? $review->user->fileUrl() : asset('public/dist/img/default-image.png') }}"
                        alt="{{ __('Image') }}">
                </div>
                <div class="flex-grow rtl-direction-space-review">
                    <p class="text-gray-12 text-13 md:text-lg dm-bold">{{ optional($review->user)->name ?? __('Unknown') }}</p>
                    <p class="roboto-medium text-gray-10 text-xs">
                        {{ formatDateTime($review->format_created_at) }}
                    </p>
                    <div class="flex justify-between items-center">
                        <div>
                            @if ($review->verifiedUser($review->user_id, $review->product->id) || preference('reviews_verified_owner_label') == 0)
                                <div class="primary-text-color mt-2 text-xs rounded-full flex">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-shield-fill-check" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M8 0c-.69 0-1.843.265-2.928.56-1.11.3-2.229.655-2.887.87a1.54 1.54 0 0 0-1.044 1.262c-.596 4.477.787 7.795 2.465 9.99a11.777 11.777 0 0 0 2.517 2.453c.386.273.744.482 1.048.625.28.132.581.24.829.24s.548-.108.829-.24a7.159 7.159 0 0 0 1.048-.625 11.775 11.775 0 0 0 2.517-2.453c1.678-2.195 3.061-5.513 2.465-9.99a1.541 1.541 0 0 0-1.044-1.263 62.467 62.467 0 0 0-2.887-.87C9.843.266 8.69 0 8 0zm2.146 5.146a.5.5 0 0 1 .708.708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 7.793l2.646-2.647z"/>
                                    </svg>
                                    <span class="ml-1 text-md">
                                        {{ __('Verified Purchase') }}
                                    </span>
                                </div>
                            @endif
                            <ul class="flex mt-2 md:mt-0">
                                @if(preference('rating_enable'))
                                @for($i = 0; $i < 5 ; $i++)
                                    <li>
                                        <svg class="primary-text-color md:mt-13p w-13p h-3 md:h-auto md:w-auto" width="20" height="19" viewBox="0 0 20 19" fill="{{ $i < $review->rating ? " var(--primary-color)" : "#ccc" }}" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M10.0381 0L12.2918 6.93615H19.5849L13.6846 11.2229L15.9383 18.1591L10.0381 13.8723L4.13785 18.1591L6.39154 11.2229L0.4913 6.93615H7.7844L10.0381 0Z"/>
                                        </svg>
                                    </li>
                                @endfor
                                @endif
                            </ul>
                        </div>

                        @if (auth()->user() && $review->user_id == auth()->user()->id)
                        <div class="edit-modal-parent" x-data="{ showModalEdit: false,
                            @foreach ($review->filesUrlold() as $key => $file)
                            showModal{{ $key }}: false,
                            @endforeach

                            }"
                            :class="{'overflow-y-hidden': showModalEdit}" x-cloak
                            @keydown.window.escape="showModalEdit = false">
                            <main class="w-full flex flex-col sm:flex-row justify-center items-center">
                                <button id="review-open-modal-btn" class="transition duration-200 rounded flex items-center text-xs md:text-sm md:py-1 px-2 roboto-medium"
                                    @click="showModalEdit = true">
                                    <svg class="md:block hidden ltr:mr-1.5 rtl:ml-1.5" width="15" height="15" viewBox="0 0 9 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M6.36258 0.0294199C6.27472 0.0448675 6.1283 0.0815535 6.03835 0.114378C5.67439 0.243747 5.79362 0.141411 3.14125 2.58589C1.71676 3.89694 0.645768 4.89906 0.599749 4.96085C0.557914 5.01878 0.501436 5.11532 0.476334 5.17711C0.449141 5.23696 0.332002 5.7023 0.216955 6.21012C-0.0277824 7.27403 -0.0403331 7.38602 0.0558884 7.63703C0.120733 7.80502 0.233689 7.96721 0.361287 8.07147C0.536996 8.21436 0.840303 8.32056 1.06831 8.32056C1.14779 8.32056 2.93835 8.00196 3.24584 7.93245C3.30232 7.91894 3.41737 7.87839 3.50313 7.8417C3.65792 7.77412 3.70394 7.73357 6.13248 5.49377C8.73883 3.08791 8.7221 3.10529 8.85388 2.8118C8.94801 2.59747 8.98566 2.43335 8.99821 2.1804C9.01495 1.78458 8.91454 1.43895 8.68445 1.12422C8.53593 0.917618 7.90421 0.336428 7.72851 0.243747C7.3227 0.0294199 6.82904 -0.0478144 6.36258 0.0294199ZM6.86251 1.00451C7.07797 1.04119 7.1951 1.11457 7.52351 1.42351C7.85192 1.73244 7.91677 1.82513 7.9586 2.03945C7.98579 2.18813 7.94605 2.3928 7.86029 2.52603C7.82682 2.58009 6.87506 3.47795 5.42547 4.82569L3.04503 7.03653L2.05981 7.18907C1.52013 7.27403 1.07249 7.33775 1.06831 7.33388C1.06412 7.33002 1.14779 6.91875 1.25447 6.42252L1.44692 5.51694L3.81899 3.32734C5.89611 1.40806 6.2057 1.13001 6.31656 1.07981C6.5111 0.98906 6.65752 0.969752 6.86251 1.00451Z" fill="#2C2C2C"/>
                                        <path d="M0.327299 8.96316C0.00725832 9.07129 -0.0931467 9.47677 0.141132 9.72392C0.1746 9.76061 0.243629 9.80888 0.289647 9.83205L0.37541 9.87453L4.42299 9.88032C8.92866 9.88418 8.60862 9.89384 8.77806 9.75288C8.82617 9.71426 8.88055 9.64668 8.90147 9.6042C8.94749 9.51152 8.95376 9.33002 8.91193 9.23927C8.868 9.1408 8.75296 9.03267 8.63791 8.9844L8.53332 8.93806L4.46482 8.93999C1.38783 8.93999 0.379594 8.94578 0.327299 8.96316Z" fill="#2C2C2C"/>
                                    </svg>

                                    <svg class="mr-1.5 md:hidden" width="9" height="10" viewBox="0 0 9 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M6.36258 0.0294204C6.27473 0.0448673 6.1283 0.0815537 6.03835 0.114378C5.67439 0.243746 5.79362 0.141411 3.14125 2.58589C1.71676 3.89694 0.645768 4.89906 0.599749 4.96085C0.557914 5.01878 0.501436 5.11532 0.476334 5.17711C0.449141 5.23696 0.332002 5.7023 0.216955 6.21012C-0.0277824 7.27403 -0.0403331 7.38602 0.0558884 7.63703C0.120733 7.80502 0.233689 7.96721 0.361287 8.07147C0.536996 8.21436 0.840303 8.32056 1.06831 8.32056C1.14779 8.32056 2.93835 8.00196 3.24584 7.93245C3.30232 7.91894 3.41737 7.87839 3.50313 7.8417C3.65792 7.77412 3.70394 7.73357 6.13248 5.49377C8.73883 3.08791 8.7221 3.10529 8.85388 2.8118C8.94801 2.59747 8.98566 2.43335 8.99821 2.1804C9.01495 1.78458 8.91454 1.43895 8.68445 1.12422C8.53593 0.917618 7.90422 0.336428 7.72851 0.243746C7.3227 0.0294204 6.82904 -0.0478143 6.36258 0.0294204ZM6.86251 1.00451C7.07797 1.04119 7.1951 1.11457 7.52351 1.42351C7.85192 1.73244 7.91677 1.82513 7.9586 2.03945C7.98579 2.18813 7.94605 2.3928 7.86029 2.52603C7.82682 2.58009 6.87506 3.47795 5.42547 4.82569L3.04503 7.03653L2.05981 7.18907C1.52013 7.27403 1.07249 7.33775 1.06831 7.33388C1.06412 7.33002 1.14779 6.91875 1.25447 6.42252L1.44692 5.51694L3.81899 3.32734C5.89611 1.40806 6.2057 1.13001 6.31656 1.07981C6.5111 0.98906 6.65752 0.969752 6.86251 1.00451Z" fill="#2C2C2C"/>
                                        <path d="M0.327299 8.96316C0.00725832 9.07129 -0.0931467 9.47677 0.141132 9.72392C0.1746 9.76061 0.243628 9.80888 0.289647 9.83205L0.37541 9.87453L4.42299 9.88032C8.92866 9.88418 8.60862 9.89384 8.77806 9.75288C8.82617 9.71426 8.88055 9.64668 8.90147 9.6042C8.94749 9.51152 8.95377 9.33002 8.91193 9.23927C8.868 9.1408 8.75296 9.03267 8.63791 8.9844L8.53332 8.93806L4.46482 8.93999C1.38783 8.93999 0.379594 8.94578 0.327299 8.96316Z" fill="#2C2C2C"/>
                                    </svg>

                                    <span class="text-xss md:text-sm">{{ __('Edit') }}</span>
                                </button>
                            </main>

                            <!-- Modal1 -->
                            <div class="edit-modal fixed z-50 scrollbar-w-2 inset-0 w-full h-full bg-black bg-opacity-50 duration-300 overflow-y-auto"
                                x-show="showModalEdit" x-transition:enter="transition duration-300"
                                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                x-transition:leave="transition duration-300" x-transition:leave-start="opacity-100"
                                x-transition:leave-end="opacity-0">
                                <div class="relative sm:w-3/4 md:w-1/2 lg:w-2/3 mx-2 sm:mx-auto top-20 opacity-100">
                                    <div class="relative bg-white shadow-lg rounded-md text-gray-900 z-50 p-6 dark:bg-gray-800 dark:text-white"
                                        @click.away="showModalEdit = true" x-show="showModalEdit"
                                        x-transition:enter="transition transform duration-300"
                                        x-transition:enter-start="scale-0" x-transition:enter-end="scale-100"
                                        x-transition:leave="transition transform duration-300"
                                        x-transition:leave-start="scale-100" x-transition:leave-end="scale-0">
                                        <header class="flex items-center justify-between p-2">
                                            <div class="flex rtl:gap-2">
                                                <div class="flex flex-col justify-center bg-yellow-5 items-center mt-1 h-10 w-10 rounded-full dark:text-gray-2">
                                                    <span class="primary-text-color text-xl">
                                                        <i class="fa fa-edit browse-tooltip neg-transition-scale" aria-hidden="true"></i>
                                                    </span>
                                                </div>
                                                <span class="inline-block mt-3 ml-2">{{ __('Edit your review') }}</span>
                                            </div>

                                            <button class="review-close-modal-btn focus:outline-none p-2" @click="showModalEdit = false">
                                                <svg class="fill-current" xmlns="http://www.w3.org/2000/svg" width="18"
                                                    height="18" viewBox="0 0 18 18">
                                                    <path
                                                        d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z">
                                                    </path>
                                                </svg>
                                            </button>
                                        </header>
                                        <main id="modal-container" class="mt-2">
                                            <section class="text-gray-600 body-font mt-4 ">
                                                <form method="post" action="" id="reviewUpdateFrom" enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $review->id }}">
                                                    <input type="hidden" id="deleted-files" name="deleted_files">
                                                    <input type="hidden" name="rating" value="{{ $review->rating }}">

                                                    <div class="flex items-center mt-4">
                                                        <p class="text-sm md:text-lg dm-sans">{{ __('Add Your Rating') }} : </p>
                                                        <div class='rating-stars text-center'>
                                                            <ul class="ml-2" id='stars'>
                                                                <li class='star {{ $review->rating >= 1 ? 'selected' : '' }}' title="{{ __('Poor') }}" data-value='1'>
                                                                    <i class='fa fa-star fa-fw'></i>
                                                                </li>
                                                                <li class='star {{ $review->rating >= 2 ? 'selected' : '' }}' title="{{ __('Fair') }}" data-value='2'>
                                                                    <i class='fa fa-star fa-fw'></i>
                                                                </li>
                                                                <li class='star {{ $review->rating >= 3 ? 'selected' : '' }}' title="{{ __('Good') }}" data-value='3'>
                                                                    <i class='fa fa-star fa-fw'></i>
                                                                </li>
                                                                <li class='star {{ $review->rating >= 4 ? 'selected' : '' }}' title="{{ __('Excellent') }}" data-value='4'>
                                                                    <i class='fa fa-star fa-fw'></i>
                                                                </li>
                                                                <li class='star {{ $review->rating >= 5 ? 'selected' : '' }}' title="{{ __('WOW') }}" data-value='5'>
                                                                    <i class='fa fa-star fa-fw'></i>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="flex rtl:gap-2">
                                                        <label class="block text-left mt-3 w-1/2">
                                                            <span class="text-sm text-gray-600 dm-sans">{{ __('Your review') }}</span>
                                                            <textarea class="form-control form-textarea mt-1 block w-full border p-3"
                                                                id="comments" name="comments" rows="3" placeholder="{{ __('Your review') }}">{{ $review->comments }}</textarea>
                                                        </label>
                                                        <label class="block text-left mt-3 ml-2 w-1/2">
                                                            <span class="text-sm text-gray-600 dm-sans">{{ __('Attachments') }}</span>
                                                            <div class="relative h-24 rounded-lg border-dashed mt-1 pb-3 border-2 border-gray-200 bg-white flex justify-center items-center hover:cursor-pointer">
                                                                <div class="absolute">
                                                                    <div class="flex flex-col items-center">
                                                                        <div class="text-xl mt-2">
                                                                            <i class="fa fa-cloud-upload text-gray-200"></i>
                                                                        </div>
                                                                        <span class="block text-gray-400 font-normal text-sm">{{ __('Attach you files here') }}</span>
                                                                        <span class="block text-gray-400 font-normal text-sm">{{ __('or') }}</span>
                                                                        <span class="block text-blue-400 font-normal text-sm">{{ __('Browse files') }}</span>
                                                                    </div>
                                                                </div>
                                                                <input type="file" id="image" name="image[]" multiple class="h-full w-full opacity-0">
                                                            </div>
                                                        </label>
                                                    </div>
                                                    <div id="message" class="mt-4">

                                                    </div>

                                                    <div id="imgs" class="grid grid-cols-3 sm:grid-cols-4 lg:grid-cols-6 xl:grid-cols-8 2xl:grid-cols-10 gap-4 mt-8">
                                                        @if($review->objectFile()->get()->isNotEmpty())
                                                            @foreach ($review->filesUrlold() as $key => $file)
                                                                <div class="pip" >
                                                                    <div class="relative inline-block">
                                                                        <img class="imageThumb object-contain h-24 w-24 border-2" src="{{ $file }}"/>
                                                                        <span data-path="{{ $file }}" data-key="{{ $key }}" class="remove-review-image absolute rounded-full bg-red-200 px-2 cursor-pointer -top-3 -right-3 text-bold text-red-700">x</span>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                    <div class="flex rtl:gap-3">
                                                        <button type="submit"
                                                            class="review-submit-modal-btn text-white hover:text-gray-12 bg-gray-12 primary-bg-hover flex justify-center items-center mt-3 border-0 focus:outline-none rounded text-sm py-2.5 px-6">
                                                            {{ __('Submit') }}
                                                        </button>
                                                        <button type="button" class="review-close-modal-btn ml-3 dm-sans text-center transition duration-200 rounded py-2.5 px-6 cursor-pointer font-medium text-sm text-gray-12 mt-3 bg-white border border-gray-2 hover:border-gray-12"
                                                            @click="showModalEdit = false">
                                                            {{ __('Cancel') }}
                                                        </button>
                                                    </div>
                                                </form>
                                            </section>
                                        </main>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>

                    <p class="leading-relaxed mt-2.5 text-gray-10 roboto-medium text-sm">
                        {{ $review->comments }}
                    </p>
                    @if ($review->objectFile()->get()->isNotEmpty())
                        <div class="flex mt-4 gap-2 flex-wrap">
                            @foreach ($review->filesUrlold() as $key => $file)
                            <div class="w-11 h-11 flex items-center border">
                                <img data-src="{{ $file }}" id="review-image-{{ $key }}" class="image-thumbnail cursor-pointer object-contain w-full h-full" src="{{ $file }}" alt="{{ __('Image') }}">
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

@empty
<div class="text-center roboto-medium text-sm py-4">
    <h4>{{ __('This product has no reviews.') }}</h4>
    <h4>{{ __('Let others know what do you think and be the first to write a review.') }}</h4>
</div>
@endforelse

<div id="review-paginate" class="mt-2">
    {{ $reviews->onEachSide(1)->links('pagination::tailwind') }}
</div>

<div class="preview-body">
    <div class="preview-image">
        <img src="" alt="{{ __('Image') }}">
        <span>X</span>
    </div>
</div>
<script>
    var allowExtension = ['jpg', 'jpeg', 'png', 'bmp', 'gif'];
</script>

