@extends('admin.master_layout')
@section('title')
<title>Edit Industry</title>
@endsection
@section('admin-content')
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Edit Industry</h1>

          </div>

          <div class="section-body">
            {{-- <a href="{{ route('admin.product-child-category.index') }}" class="btn btn-primary"><i class="fas fa-list"></i> {{__('admin.Product Child Category')}}</a> --}}
            <div class="row mt-4">
                <div class="col-12">
                  <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.product-child-category.update',$childCategory->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="form-group col-12">
                                    <label>{{__('admin.Current Image')}}</label>
                                    <div>
                                        <img src="{{ asset($childCategory->image) }}" alt="" width="100px">
                                    </div>
                                </div>

                                <div class="form-group col-12">
                                    <label>{{__('admin.Image')}} <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control-file"  name="image">
                                </div>
                                {{-- <div class="form-group col-12">
                                    <label>{{__('admin.Category')}} <span class="text-danger">*</span></label>
                                    <select name="category" id="category" class="form-control">
                                        <option value="">{{__('admin.Select Category')}}</option>
                                        @foreach ($categories as $category)
                                            <option {{ $childCategory->category_id == $category->id ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-12">
                                    <label>{{__('admin.Sub Category')}} <span class="text-danger">*</span></label>
                                    <select name="sub_category" id="sub_category" class="form-control">
                                        <option value="">{{__('admin.Select Sub Category')}}</option>
                                        @foreach ($subCategories as $subCategory)
                                        <option {{ $subCategory->id == $childCategory->sub_category_id  ? 'selected' : '' }} value="{{ $subCategory->id }}">{{ $subCategory->name }}</option>
                                        @endforeach

                                    </select>
                                </div> --}}

                                <div class="form-group col-12">
                                    <label>{{__('admin.Child Category Name')}} <span class="text-danger">*</span></label>
                                    <input type="text" id="name" class="form-control"  name="name" value="{{ $childCategory->name }}">
                                </div>
                                <div class="form-group col-12">
                                    <label>{{__('admin.Slug')}} <span class="text-danger">*</span></label>
                                    <input type="text" id="slug" class="form-control"  name="slug" value="{{ $childCategory->slug }}">
                                </div>

                                <div class="form-group col-12">
                                    <label>Description 1 <span class="text-danger">*</span></label>
                                    <textarea name="description_1" id="" cols="30" rows="10" class="summernote">{{ $childCategory->description_1 }}</textarea>
                                </div>
                                <div class="form-group col-12">
                                    <label>Description 2 <span class="text-danger">*</span></label>
                                    <textarea name="description_2" id="" cols="30" rows="10" class="summernote">{{ $childCategory->description_2 }}</textarea>
                                </div>

                                <div class="form-group col-12">
                                    <label>Serial <span class="text-danger">*</span></label>
                                    <input type="text" id="serial" class="form-control"  name="serial" value="{{ $childCategory->serial }}">
                                </div>

                                <div class="form-group col-12">
                                    <label>{{__('admin.Status')}} <span class="text-danger">*</span></label>
                                    <select name="status" class="form-control">
                                        <option {{ $childCategory->status == 1 ? 'selected': '' }} value="1">{{__('admin.Active')}}</option>
                                        <option {{ $childCategory->status == 0 ? 'selected': '' }} value="0">{{__('admin.InActive')}}</option>
                                    </select>
                                </div>

                                <div class="form-group col-12">
                                    <label>{{ __('admin.Meta Title') }}</label>
                                    <input type="text" class="form-control" name="meta_title" value="{{ $childCategory->meta_title }}">
                                </div>

                                <div class="form-group col-12">
                                    <label>{{ __('admin.Meta Description') }}</label>
                                    <textarea name="meta_description" cols="30" rows="4" class="form-control text-area-4">{{ $childCategory->meta_description }}</textarea>
                                </div>

                                <div class="form-group col-12">
                                    <label>{{ __('admin.Meta Image') }}</label>
                                    <input type="file" class="form-control-file" name="meta_image">
                                    @if ($childCategory->meta_image)
                                        <div class="mt-2">
                                            <img src="{{ asset($childCategory->meta_image) }}" alt="meta image" class="img-thumbnail" style="max-height: 150px;">
                                        </div>
                                        <div class="custom-control custom-checkbox mt-2">
                                            <input type="checkbox" class="custom-control-input" id="remove_meta_image_child_category" name="remove_meta_image" value="1">
                                            <label class="custom-control-label" for="remove_meta_image_child_category">{{ __('admin.Remove Meta Image') }}</label>
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group col-12 col-md-6">
                                    <label>{{ __('admin.Meta Author') }}</label>
                                    <input type="text" class="form-control" name="author" value="{{ $childCategory->author }}">
                                </div>

                                <div class="form-group col-12 col-md-6">
                                    <label>{{ __('admin.Meta Publisher') }}</label>
                                    <input type="text" class="form-control" name="publisher" value="{{ $childCategory->publisher }}">
                                </div>

                                <div class="form-group col-12 col-md-6">
                                    <label>{{ __('admin.Meta Copyright') }}</label>
                                    <input type="text" class="form-control" name="copyright" value="{{ $childCategory->copyright }}">
                                </div>

                                <div class="form-group col-12 col-md-6">
                                    <label>{{ __('admin.Site Name') }}</label>
                                    <input type="text" class="form-control" name="site_name" value="{{ $childCategory->site_name }}">
                                </div>

                                <div class="form-group col-12">
                                    <label>{{ __('admin.Meta Keywords') }}</label>
                                    <textarea name="keywords" cols="30" rows="3" class="form-control text-area-3" placeholder="{{ __('admin.Meta Keywords Placeholder') }}">{{ $childCategory->keywords }}</textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <button class="btn btn-primary">{{__('admin.Update')}}</button>
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
