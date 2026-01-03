@extends('admin.master_layout')
@section('title')
<title>{{__('admin.Custom Page')}}</title>
@endsection
@section('admin-content')
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>{{__('admin.Create Custom Page')}}</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{__('admin.Dashboard')}}</a></div>
              <div class="breadcrumb-item active"><a href="{{ route('admin.custom-page.index') }}">{{__('admin.Custom Page')}}</a></div>
              <div class="breadcrumb-item">{{__('admin.Create Custom Page')}}</div>
            </div>
          </div>

          <div class="section-body">
            <a href="{{ route('admin.custom-page.index') }}" class="btn btn-primary"><i class="fas fa-list"></i> {{__('admin.Custom Page')}}</a>
            <div class="row mt-4">
                <div class="col">
                  <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.custom-page.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="form-group col-12">
                                    <label>{{__('admin.Page Name')}} <span class="text-danger">*</span></label>
                                    <input type="text" id="page_name" class="form-control"  name="page_name" value="{{ old('page_name') }}">
                                </div>
                                <div class="form-group col-12">
                                    <label>{{__('admin.Slug')}} <span class="text-danger">*</span></label>
                                    <input type="text" id="slug" class="form-control"  name="slug" value="{{ old('slug') }}">
                                </div>

                                <div class="form-group col-12">
                                    <label>{{__('admin.Description')}} <span class="text-danger">*</span></label>
                                    <textarea name="description" cols="30" rows="10" class="summernote">{{ old('description') }}</textarea>
                                </div>

                                <div class="form-group col-12">
                                    <label>{{ __('admin.Meta Title') }}</label>
                                    <input type="text" class="form-control" name="meta_title" value="{{ old('meta_title') }}">
                                </div>

                                <div class="form-group col-12">
                                    <label>{{ __('admin.Meta Description') }}</label>
                                    <textarea name="meta_description" cols="30" rows="4" class="form-control text-area-4">{{ old('meta_description') }}</textarea>
                                </div>

                                <div class="form-group col-12">
                                    <label>{{ __('admin.Meta Keywords') }}</label>
                                    <textarea name="meta_keywords" cols="30" rows="3" class="form-control text-area-3" placeholder="keyword one, keyword two">{{ old('meta_keywords') }}</textarea>
                                </div>

                                <div class="form-group col-12">
                                    <label>{{ __('admin.Canonical URL') }}</label>
                                    <input type="url" class="form-control" name="canonical_url" value="{{ old('canonical_url') }}">
                                </div>

                                <div class="form-group col-12">
                                    <label>{{ __('admin.Meta Robots') }}</label>
                                    <input type="text" class="form-control" name="meta_robots" value="{{ old('meta_robots', 'index, follow') }}">
                                </div>

                                <div class="form-group col-12">
                                    <label>{{ __('admin.Meta Image') }}</label>
                                    <input type="file" name="meta_image" class="form-control-file">
                                    <small class="form-text text-muted">{{ __('admin.Recommended size') }}: 1200x630px</small>
                                </div>

                                <div class="form-group col-12">
                                    <label>{{__('admin.Status')}} <span class="text-danger">*</span></label>
                                    <select name="status" class="form-control">
                                        <option value="1">{{__('admin.Active')}}</option>
                                        <option value="0">{{__('admin.Inactive')}}</option>
                                    </select>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <button class="btn btn-primary">{{__('admin.Save')}}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                  </div>
                </div>
          </div>
        </section>
      </div>

<script>
        (function($) {
            "use strict";
            $(document).ready(function () {
                $("#page_name").on("focusout",function(e){
                    $("#slug").val(convertToSlug($(this).val()));

                })
            });
        })(jQuery);

        function convertToSlug(Text)
            {
                return Text
                    .toLowerCase()
                    .replace(/[^\w ]+/g,'')
                    .replace(/ +/g,'-');
            }
    </script>
@endsection
