@php
    $component = isset($component) ? $component : null;
    $allBlogs = \Modules\CMS\Service\Homepage::getBlogsList();
@endphp

<div class="card dd-content {{ $editorClosed ?? 'card-hide' }}">
    <div class="card-body">
        <form action="{{ route('builder.update', ['id' => '__id']) }}" novalidate data-type="component" method="post"
            class="component_form form-parent silent-form">
            @csrf
            @include('cms::hidden_fields')
            <div class="form-group row">
                <label class="col-sm-3 control-label require">
                    <dt>{{ __('Title') }}</dt>
                </label>
                <div class="col-sm-8">
                    <input type="text" class="form-control section_name inputFieldDesign crequired" name="title" id="title"
                        required value="{{ $component ? $component->title : '' }}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 control-label require">
                    <dt>{{ __('Blog Type') }}</dt>
                </label>
                <div class="col-sm-8">
                    <select type="text" required class="form-control crequired select3" name="blog_type"
                        id="blog_type">
                        @foreach (\Modules\CMS\Service\Homepage::blogsOptions() as $key => $value)
                            <option {{ $component && $component->blog_type == $key ? 'selected' : '' }}
                                value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div
                class="form-group row cats {{ $component && $component->blog_type == 'selectedBlogs' ? '' : 'd-none' }}">
                <label class="col-sm-3 control-label">
                    <dt>{{ __('Blogs') }}</dt>
                </label>
                <div class="col-sm-8">
                    <select type="text" class="form-control select2" name="blogs[]" multiple>
                        @if ($component && is_array($component->blogs))
                            @foreach ($component->blogs as $selected)
                                @if (isset($allBlogs[$selected]))
                                    <Option selected value="{{ $selected }}">{{ $allBlogs[$selected] }}
                                    </Option>
                                    @php
                                        unset($allBlogs[$selected]);
                                    @endphp
                                @endif
                            @endforeach
                        @endif
                        @foreach ($allBlogs as $key => $value)
                            <Option value="{{ $key }}">{{ $value }}</Option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 control-label require">
                    <dt>{{ __('No. of blogs to show') }}</dt>
                </label>
                <div class="col-sm-8">
                    <input type="number" min="1" max="30" class="form-control crequired inputFieldDesign" name="blog_limit"
                        required value="{{ $component ? $component->blog_limit : 3 }}">
                    <div class="d-flex mt-2">
                        <span class="badge badge-danger h-100 mt-1">{{ __('Note') }}!</span>
                        <small
                            class="mt-1 ltr:ms-2 rtl:me-2">{{ __('Total blogs to display should be between 1 to 30. Default is 10') }}</small>
                    </div>
                </div>
            </div>

            @include('cms::edit.sub.appearance', ['fields' => ['margin']])
            @include('cms::pieces.submit-btn')
        </form>
    </div>
</div>
