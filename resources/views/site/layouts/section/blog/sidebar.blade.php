<section class="md:w-63 w-full">
    <div class="mb-30p">
        <div class="flex">
            <div class="relative w-full">
                <form action="{{ route('blog.search') }}" method="get">
                    <div class="h-50p focus:border-gray-12 lg:w-63 w-full rounded border text-decoration-none hover:border-gray-200 border-gray-2">
                        <input class="border-none text-sm h-12 lg:w-56 text-gray-10 roboto-regular font-regular  ltr:ml-2p rtl:mr-2p" type="text" name="search" value="{{request()->search}}" placeholder="{{ __('Search your keyword') }}..">
                    </div>
                    <div class="absolute top-4 ltr:right-5 rtl:left-5 neg-transition-scale">
                        <button type="submit">
                            <svg class="cursor-pointer" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M8 2C4.68629 2 2 4.68629 2 8C2 11.3137 4.68629 14 8 14C11.3137 14 14 11.3137 14 8C14 4.68629 11.3137 2 8 2ZM0 8C0 3.58172 3.58172 0 8 0C12.4183 0 16 3.58172 16 8C16 12.4183 12.4183 16 8 16C3.58172 16 0 12.4183 0 8Z" fill="#2C2C2C" />
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M13.2929 13.2929C13.6834 12.9024 14.3166 12.9024 14.7071 13.2929L17.7071 16.2929C18.0976 16.6834 18.0976 17.3166 17.7071 17.7071C17.3166 18.0976 16.6834 18.0976 16.2929 17.7071L13.2929 14.7071C12.9024 14.3166 12.9024 13.6834 13.2929 13.2929Z" fill="#2C2C2C" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="md:block hidden mb-30p">
        <div class="relative flex mb-1 border-none">
            <span class="text-bas roboto-medium font-medium text-gray-12 capitalize mb-2">{{ __('Categories') }}</span>
        </div>
        <div class="border mb-5 lg:w-63 w-full border-line"></div>
        <ul>
            @foreach ($blogCategories as $blogCategory)
                <li class="text-15 transition ease-in-out delay-120 leading-4 mb-3 roboto-medium font-medium">
                    <a href="{{ route('blog.category', ['id' => $blogCategory->id]) }}" class="flex items-center text-gray-10 hover:text-gray-12 roboto-medium font-medium text-15 cursor-pointer">{{ $blogCategory->name }} </a>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="mb-30p">
        <div class="relative flex mb-1 border-none lg:w-63 w-full">
            <span class="text-base roboto-medium font-medium text-gray-12 capitalize mb-2">{{ __('popular post') }}</span>
        </div>
        <div class="border mb-5 lg:w-63 w-full border-line"></div>
        @foreach ($popularBlogs as $data)
            <div>
                <div class="flex md:justify-between mb-5">
                  <div class="h-20 lg:w-20 w-28">
                    <a href="{{ route('blog.details', ['slug' => $data->slug]) }}">
                        <img class="h-full w-full rounded object-cover neg-transition-scale" src="{{ $data->fileUrl() }}" alt="{{ $data->title }}">
                      </a>
                  </div>
                    <div class="flex justify-left items-center lg:w-44">
                        <div class="ltr:ml-3 ltr:lg:ml-0 rtl:mr-3 rtl:lg:mr-0">
                            <p class="text-xs roboto-medium font-medium text-gray-10">{{ formatDate($data->created_at) }}</p>
                            <a href="{{ route('blog.details', $data->slug) }}"
                                class="mt-3 title-text-decoration md:mt-0 break-all text-gray-12 font-medium dm-sans text-sm mb-2"
                                title="{{ $data->title }}">{{ trimWords($data->title, 45) }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach()
    </div>
    <div class="mb-30p -mt-1p">
        <details x-data x-ref="dropdown" @click.away="$refs.dropdown.removeAttribute('open');"
            class="relative inline-block w-full ltr:text-left rtl:text-right">
            <summary>
                <div class="relative text-base roboto-medium font-medium text-gray-12 capitalize mb-2 accordion__header flex justify-between border-none lg:w-63 cursor-pointer">{{ __('Archives') }}</div>
                <div class="border mb-3.5 lg:w-63 border-line"></div>
            </summary>
            <details-menu role="menu" class="origin-top-right accordion__desc lg:w-63">
                <div class="mt-2 flex flex-col cursor-pointer text-gray-10 roboto-medium font-medium text-15">
                    @foreach ($archives as $archive)
                        <a href="{{ route('blog.all', ['year' => $archive->year]) }}" class="hover:text-gray-12">{{ __('Year') }}
                            {{ $archive->year }}({{ $archive->post_count }})</a>
                    @endforeach
                </div>
            </details-menu>
        </details>
    </div>
</section>
