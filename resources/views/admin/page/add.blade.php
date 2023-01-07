@extends('admin.layouts.master')
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Add Page</h4>
                <span class="text-muted mt-1 tx-13 ml-2 mb-0">/ Setting</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" data-parsley-validate="" id="addEditForm" role="form">
                        @csrf
                        <div class="row row-sm">

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="screen_info">Page Name<span
                                            class="error">*</span></label>
                                    <input type="text" class="form-control"
                                           name="page_name"
                                           id="page_name"
                                           placeholder="Page Name" required/>
                                    <div class="help-block with-errors error"></div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="screen_info">Slug<span
                                            class="error">*</span></label>
                                    <input type="text" class="form-control"
                                           name="slug"
                                           id="slug"
                                           pattern="[^' ']+"
                                           placeholder="Slug" required/>
                                    <div class="help-block with-errors error"></div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="driver_or_passenger">Driver Or Passenger<span
                                            class="error">*</span></label>
                                    <select class="form-control" id="driver_or_passenger" name="driver_or_passenger">
                                        <option value="1">Driver</option>
                                        <option value="2">Passenger</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="app_or_panel">Select Order<span class="error">*</span></label>
                                <select class="form-control" id="page_order" name="page_order">

                                    @if(count($indexes)>0)
                                        @foreach($indexes as $key=>$indexe)
                                            @if(count($indexes)>0)
                                                <option value="{{$key+1}}">{{$key+1}}</option>
                                            @else
                                                <option value="{{1}}">{{1}}</option>
                                            @endif
                                        @endforeach
                                    @else
                                        <option value="{{1}}">{{1}}</option>
                                    @endif

                                </select>
                            </div>
                            @foreach($languages as $key=>$language)

                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="{{ $language->language_code }}_name">{{ $language->name }} Name<span
                                                class="error">*</span></label>
                                        <input type="text" class="form-control"
                                               name="{{ $language->language_code }}_name"
                                               id="{{ $language->language_code }}_name"
                                               value=""
                                               @if($language->is_rtl == 1)
                                               dir="rtl"
                                               @endif
                                               placeholder="{{ $language->name }} Name" required/>
                                        <div class="help-block with-errors error"></div>
                                    </div>
                                </div>

                                <div class="col-12 mb-3">
                                    <label for="{{ $language->language_code }}_description">{{ $language->name }}
                                        Description
                                        <span class="error">*</span></label>
                                    <textarea id="{{ $language->language_code }}_description" class="description"
                                              name="{{ $language->language_code }}_description"

                                    ></textarea>
                                </div>
                            @endforeach
                            <div class="col-12">
                                <div class="form-group mb-0 mt-3 justify-content-end">
                                    <div>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                        <a href="{{ route('admin::page.index') }}" class="btn btn-secondary">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /row -->

    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script src="{{URL::asset('assets/js/custom/page.js')}}?v={{ time() }}"></script>
@endsection
