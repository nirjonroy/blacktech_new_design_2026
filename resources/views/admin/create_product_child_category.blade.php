@extends('admin.master_layout')
@section('title')
<title>Add Industry </title>
@endsection
@section('admin-content')
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Add Industry Here</h1>

          </div>

          <div class="section-body">

            <div class="row mt-4">
                <div class="col-12">
                  <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.product-child-category.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="form-group col-12">
                                    <label>{{__('admin.Image')}} <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control-file"  name="image">
                                </div>




                                <div class="form-group col-12">
                                    <label>Industry Name <span class="text-danger">*</span></label>
                                    <input type="text" id="name" class="form-control"  name="name">
                                </div>
                                <div class="form-group col-12">
                                    <label>{{__('admin.Slug')}} <span class="text-danger">*</span></label>
                                    <input type="text" id="slug" class="form-control"  name="slug">
                                </div>
                                <div class="form-group col-12">
                                    <label>Description 1 <span class="text-danger">*</span></label>
                                    <textarea name="description_1" id="" cols="30" rows="10" class="summernote">{{ old('long_description') }}</textarea>
                                </div>
                                <div class="form-group col-12">
                                    <label>Description 2 <span class="text-danger">*</span></label>
                                    <textarea name="description_2" id="" cols="30" rows="10" class="summernote">{{ old('long_description') }}</textarea>
                                </div>
                                <div class="form-group col-12">
                                    <label> Serial <span class="text-danger">*</span></label>
                                    <input type="text" id="" class="form-control" value="300"  name="serial">
                                </div>

                                <div class="form-group col-12">
                                    <label>{{__('admin.Status')}} <span class="text-danger">*</span></label>
                                    <select name="status" class="form-control">
                                        <option value="1">{{__('admin.Active')}}</option>
                                        <option value="0">{{__('admin.Inactive')}}</option>
                                    </select>
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
                                    <label>{{ __('admin.Meta Image') }}</label>
                                    <input type="file" class="form-control-file" name="meta_image">
                                </div>

                                <div class="form-group col-12 col-md-6">
                                    <label>{{ __('admin.Meta Author') }}</label>
                                    <input type="text" class="form-control" name="author" value="{{ old('author') }}">
                                </div>

                                <div class="form-group col-12 col-md-6">
                                    <label>{{ __('admin.Meta Publisher') }}</label>
                                    <input type="text" class="form-control" name="publisher" value="{{ old('publisher') }}">
                                </div>

                                <div class="form-group col-12 col-md-6">
                                    <label>{{ __('admin.Meta Copyright') }}</label>
                                    <input type="text" class="form-control" name="copyright" value="{{ old('copyright') }}">
                                </div>

                                <div class="form-group col-12 col-md-6">
                                    <label>{{ __('admin.Site Name') }}</label>
                                    <input type="text" class="form-control" name="site_name" value="{{ old('site_name') }}">
                                </div>

                                <div class="form-group col-12">
                                    <label>{{ __('admin.Meta Keywords') }}</label>
                                    <textarea name="keywords" cols="30" rows="3" class="form-control text-area-3" placeholder="{{ __('admin.Meta Keywords Placeholder') }}">{{ old('keywords') }}</textarea>
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
            $("#name").on("focusout",function(e){
                $("#slug").val(convertToSlug($(this).val()));
            })

            $("#category").on("change",function(){
                var categoryId = $("#category").val();
                if(categoryId){
                    $.ajax({
                        type:"get",
                        url:"{{url('/admin/subcategory-by-category/')}}"+"/"+categoryId,
                        success:function(response){
                            $("#sub_category").html(response.subCategories);
                        },
                        error:function(err){
                        }
                    })
                }
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
