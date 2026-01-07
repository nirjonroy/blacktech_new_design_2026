@extends('admin.master_layout')
@section('title')
<title>Career</title>
@endsection
@section('admin-content')
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Create Career</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{__('admin.Dashboard')}}</a></div>
              <div class="breadcrumb-item active"><a href="{{ route('admin.career.index') }}">Careers</a></div>
              <div class="breadcrumb-item">Create Career</div>
            </div>
          </div>

          <div class="section-body">
            <a href="{{ route('admin.career.index') }}" class="btn btn-primary"><i class="fas fa-list"></i> Careers</a>
            <div class="row mt-4">
                <div class="col-12">
                  <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.career.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="form-group col-12">
                                    <label>Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="title">
                                </div>
                                <div class="form-group col-12">
                                    <label>Slug</label>
                                    <input type="text" class="form-control" name="slug" placeholder="leave blank to auto-generate">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Employment Type</label>
                                    <input type="text" class="form-control" name="employment_type" placeholder="Full Time">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Location</label>
                                    <input type="text" class="form-control" name="location" placeholder="London">
                                </div>
                                <div class="form-group col-12">
                                    <label>Short Description</label>
                                    <textarea name="short_description" cols="30" rows="4" class="form-control text-area-5"></textarea>
                                </div>
                                <div class="form-group col-12">
                                    <label>Key Responsibilities</label>
                                    <textarea name="key_responsibilities" cols="30" rows="4" class="form-control text-area-5" placeholder="One per line"></textarea>
                                </div>
                                <div class="form-group col-12">
                                    <label>Requirements</label>
                                    <textarea name="requirements" cols="30" rows="4" class="form-control text-area-5" placeholder="One per line"></textarea>
                                </div>
                                <div class="form-group col-12">
                                    <label>Why Join Us</label>
                                    <textarea name="why_join_us" cols="30" rows="4" class="form-control text-area-5" placeholder="One per line"></textarea>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Experience</label>
                                    <input type="text" class="form-control" name="experience" placeholder="5 Years">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Salary</label>
                                    <input type="text" class="form-control" name="salary" placeholder="$55,000">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Deadline</label>
                                    <input type="date" class="form-control" name="deadline">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Apply URL</label>
                                    <input type="text" class="form-control" name="apply_url" placeholder="https://">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Apply Email</label>
                                    <input type="email" class="form-control" name="apply_email" placeholder="jobs@blacktechcorp.com">
                                </div>
                                <div class="form-group col-12">
                                    <label>Apply Details</label>
                                    <textarea name="apply_details" cols="30" rows="4" class="form-control text-area-5"></textarea>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Serial</label>
                                    <input type="number" class="form-control" name="serial" value="0">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Status <span class="text-danger">*</span></label>
                                    <select name="status" class="form-control">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                                <div class="form-group col-12">
                                    <label>Image <span class="text-danger">*</span></label>
                                    <input type="file" name="image" class="form-control-file">
                                </div>
                                <div class="form-group col-12">
                                    <label>Meta Title</label>
                                    <input type="text" class="form-control" name="meta_title">
                                </div>
                                <div class="form-group col-12">
                                    <label>Meta Description</label>
                                    <textarea name="meta_description" cols="30" rows="3" class="form-control text-area-5"></textarea>
                                </div>
                                <div class="form-group col-12">
                                    <label>Meta Keywords</label>
                                    <textarea name="meta_keywords" cols="30" rows="2" class="form-control text-area-5" placeholder="comma separated"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <button class="btn btn-primary">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                  </div>
                </div>
          </div>
        </section>
      </div>
@endsection
