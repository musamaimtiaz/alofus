@if (count($child_category->categories->where('status', 'Active')))
    <li class="-hasSubmenu category-list categorySearchDiv-{{ $catId-1 }}" id="list-{{ $child_category->id }}" data-catId = "{{ $child_category->id }}" data-name = "{{ $child_category->name }}"><a href="javascript:void(0)">{{ wrapIt($child_category->name, 20, ['columns' => 3, 'trim' => true, 'trimLength' => 25]) }}</a>
        <ul>
            <div class="input-group p-2">
                <input class="form-control ltr:border-end-0 rtl:border-start-0 border m-border input-height category-search" type="search" placeholder="{{ __('Search') }}" data-seId = "{{ $catId }}">
                <span class="input-group-append input-height">
                        <button class="btn text-secondary bg-white ltr:border-start-0 ltr:rounded-end rtl:border-end-0 rtl:rounded-start border ms-n5 input-height" type="button">
                            <div class="icon-height">
                                <i class="fa fa-search"></i>
                            </div>
                        </button>
                    </span>
            </div>
            <div class="custom-overflow" id="categorySearchDiv-{{ $catId++ }}">
                @foreach ($child_category->categories->where('status', 'Active') as $childCategory)
                    @include('../admin/layouts.includes.child_category', ['child_category' => $childCategory, 'catId' => $catId])
                @endforeach
            </div>
        </ul>
    </li>
@else
    <li class="category-list clicked categorySearchDiv-{{ $catId-1 }}" id="list-{{ $child_category->id }}" data-catId = "{{ $child_category->id }}" data-name = "{{ $child_category->name }}"><a href="javascript:void(0)">{{ wrapIt($child_category->name, 20, ['columns' => 3, 'trim' => true, 'trimLength' => 25]) }}</a></li>
@endif
