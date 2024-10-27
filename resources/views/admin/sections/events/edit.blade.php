@php
    $default_lang_code = language_const()::NOT_REMOVABLE;
    $system_default_lang = get_default_language_code();
    $languages_for_js_use = $languages->toJson();
@endphp
@extends('admin.layouts.master')

@push('css')
    <style>
        .fileholder {
            min-height: 374px !important;
        }

        .fileholder-files-view-wrp.accept-single-file .fileholder-single-file-view,
        .fileholder-files-view-wrp.fileholder-perview-single .fileholder-single-file-view {
            height: 330px !important;
        }
    </style>
@endpush

@section('page-title')
    @include('admin.components.page-title', ['title' => __($page_title)])
@endsection

@section('breadcrumb')
    @include('admin.components.breadcrumb', [
        'breadcrumbs' => [
            [
                'name' => __('Dashboard'),
                'url' => setRoute('admin.dashboard'),
            ],
        ],
        'active' => __('Edit Event'),
    ])
@endsection

@section('content')
    <div class="custom-card">
        <div class="card-header">
            <h6 class="title">{{ __($page_title) }}</h6>
        </div>

        <div class="card-body">
            <form class="modal-form" method="POST" action="{{ setRoute('admin.events.update') }}"
            enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="target" value="{{ $data->id }}">
                <div class="row mb-10-none mt-3">
                    <div class="language-tab">
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <button class="nav-link @if (get_default_language_code() == language_const()::NOT_REMOVABLE) active @endif"
                                    id="edit-modal-english-tab" data-bs-toggle="tab"
                                    data-bs-target="#edit-modal-english" type="button" role="tab"
                                    aria-controls="edit-modal-english" aria-selected="false">English</button>
                                @foreach ($languages as $item)
                                    <button class="nav-link @if (get_default_language_code() == $item->code) active @endif"
                                        id="edit-modal-{{ $item->name }}-tab" data-bs-toggle="tab"
                                        data-bs-target="#edit-modal-{{ $item->name }}" type="button" role="tab"
                                        aria-controls="edit-modal-{{ $item->name }}"
                                        aria-selected="true">{{ $item->name }}</button>
                                @endforeach

                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane @if (get_default_language_code() == language_const()::NOT_REMOVABLE) fade show active @endif"
                                id="edit-modal-english" role="tabpanel" aria-labelledby="edit-modal-english-tab">
                                @php
                                    $default_lang_code = language_const()::NOT_REMOVABLE;
                                @endphp

                                <div class="row">
                                    <div class="col-xl-8">
                                        <div class="form-group">
                                            @include('admin.components.form.input', [
                                                'label' => __('Title'),
                                                'name' => $default_lang_code . '_title',
                                                'value' => old(
                                                    $default_lang_code . '_title',
                                                    $data->title->language->$default_lang_code->title ?? ''),
                                            ])
                                        </div>
                                    </div>
                                    <div class="col-xl-4">
                                        <div class="form-group">
                                            <label for="category">{{ __("Category") }}</label>
                                            <select name="category" id="category" class="form--control nice-select"
                                                required>
                                                @foreach ($allCategory as $cat)
                                                    <option value="{{ $cat->id }}" {{ $data->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="tags">{{ __('Tags') }}*</label>
                                    <select name="{{ $default_lang_code . '_tags[]' }}" multiple id=""
                                        class="select2-auto-tokenize">
                                        @foreach ($data->tags->language->$default_lang_code->tags ?? [] as $item)
                                            <option value="{{ $item }}" selected>{{ $item }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>{{ __('Details') }}*</label>
                                    <textarea name="{{ $default_lang_code . '_details' }}" class="form--control rich-text-editor">
                                    {!! old($default_lang_code . '_details', $data->details->language->$default_lang_code->details) !!}</textarea>
                                </div>

                            </div>

                            @foreach ($languages as $item)
                                @php
                                    $lang_code = $item->code;
                                @endphp
                                <div class="tab-pane @if (get_default_language_code() == $item->code) fade show active @endif"
                                    id="edit-modal-{{ $item->name }}" role="tabpanel"
                                    aria-labelledby="edit-modal-{{ $item->name }}-tab">

                                    <div class="row">
                                        <div class="col-xl-7">
                                            <div class="form-group">
                                                @include('admin.components.form.input', [
                                                    'label' => __('Title')."*",
                                                    'name' => $lang_code . '_title',
                                                    'value' => old( $lang_code . '_title', $data->title->language->$lang_code->title ?? ''),
                                                ])
                                            </div>
                                        </div>
                                        <div class="col-xl-5">
                                            <div class="form-group">
                                                <label for="tags">{{ __('Tags') }}*</label>
                                                <select name="{{ $lang_code . '_tags[]' }}" multiple id=""
                                                    class="select2-auto-tokenize">
                                                    @foreach ($data->tags->language->$lang_code->tags ?? [] as $item)
                                                        <option value="{{ $item }}" selected>{{ $item }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>{{ __('Details') }}*</label>
                                        <textarea name="{{ $lang_code . '_details' }}" class="form--control rich-text-editor">
                                            {!! old($lang_code . '_details', @$data->details->language->$lang_code->details) !!}
                                        </textarea>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>

                    <div class="col-xl-12 col-lg-12 form-group">
                        @include('admin.components.form.input-file', [
                            'label' => __('Image'),
                            'name' => 'image',
                            'class' => 'file-holder',
                            'old_files_path' => files_asset_path('events'),
                            'old_files' => $data->image,
                        ])
                    </div>
                    <div class="col-xl-12 col-lg-12 form-group d-flex align-items-center justify-content-between mt-4">
                        <button type="button" class="btn btn--danger modal-close">{{ __('cancel') }}</button>
                        <button type="submit" class="btn btn--base">{{ __('Update') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script>
        editModal.find("input[name=image]").attr("data-preview-name", oldData.image);
        fileHolderPreviewReInit("#event-edit input[name=image]");
    </script>
@endpush
