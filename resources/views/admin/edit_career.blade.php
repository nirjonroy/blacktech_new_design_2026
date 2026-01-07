@extends('admin.master_layout')
@section('title')
<title>Career</title>
@endsection
@section('admin-content')
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Edit Career</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{__('admin.Dashboard')}}</a></div>
              <div class="breadcrumb-item active"><a href="{{ route('admin.career.index') }}">Careers</a></div>
              <div class="breadcrumb-item">Edit Career</div>
            </div>
          </div>

          <div class="section-body">
            <a href="{{ route('admin.career.index') }}" class="btn btn-primary"><i class="fas fa-list"></i> Careers</a>
            <div class="row mt-4">
                <div class="col-12">
                  <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.career.update', $career->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="form-group col-12">
                                    <label>Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="title" value="{{ $career->title }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Employment Type</label>
                                    <input type="text" class="form-control" name="employment_type" value="{{ $career->employment_type }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Location</label>
                                    <input type="text" class="form-control" name="location" value="{{ $career->location }}">
                                </div>
                                <div class="form-group col-12">
                                    <label>Short Description</label>
                                    <textarea name="short_description" cols="30" rows="4" class="form-control text-area-5">{{ $career->short_description }}</textarea>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Experience</label>
                                    <input type="text" class="form-control" name="experience" value="{{ $career->experience }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Salary</label>
                                    <input type="text" class="form-control" name="salary" value="{{ $career->salary }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Deadline</label>
                                    <input type="date" class="form-control" name="deadline" value="{{ $career->deadline ? $career->deadline->format('Y-m-d') : '' }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Apply URL</label>
                                    <input type="text" class="form-control" name="apply_url" value="{{ $career->apply_url }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Serial</label>
                                    <input type="number" class="form-control" name="serial" value="{{ $career->serial }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Status <span class="text-danger">*</span></label>
                                    <select name="status" class="form-control">
                                        <option value="1" {{ $career->status ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ !$career->status ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                                <div class="form-group col-12">
                                    <label>Existing Image</label>
                                    <div>
                                        @if (!empty($career->image))
                                            <img src="{{ asset($career->image) }}" alt="{{ $career->title }}" width="120">
                                        @else
                                            <span class="text-muted">No image</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group col-12">
                                    <label>New Image</label>
                                    <input type="file" name="image" class="form-control-file">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <button class="btn btn-primary">Update</button>
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
