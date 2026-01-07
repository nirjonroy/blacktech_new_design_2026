@extends('admin.master_layout')
@section('title')
<title>Team Member</title>
@endsection
@section('admin-content')
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Edit Team Member</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{__('admin.Dashboard')}}</a></div>
              <div class="breadcrumb-item active"><a href="{{ route('admin.team-member.index') }}">Team Members</a></div>
              <div class="breadcrumb-item">Edit Team Member</div>
            </div>
          </div>

          <div class="section-body">
            <a href="{{ route('admin.team-member.index') }}" class="btn btn-primary"><i class="fas fa-list"></i> Team Members</a>
            <div class="row mt-4">
                <div class="col-12">
                  <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.team-member.update', $teamMember->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="form-group col-12">
                                    <label>Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name" value="{{ $teamMember->name }}">
                                </div>
                                <div class="form-group col-12">
                                    <label>Designation <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="designation" value="{{ $teamMember->designation }}">
                                </div>
                                <div class="form-group col-12">
                                    <label>Existing Image</label>
                                    <div>
                                        @if (!empty($teamMember->image))
                                            <img src="{{ asset($teamMember->image) }}" alt="{{ $teamMember->name }}" width="120">
                                        @else
                                            <span class="text-muted">No image</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group col-12">
                                    <label>New Image</label>
                                    <input type="file" name="image" class="form-control-file">
                                </div>
                                <div class="form-group col-12">
                                    <label>Biography</label>
                                    <textarea name="biography" cols="30" rows="5" class="form-control text-area-5">{{ $teamMember->biography }}</textarea>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Facebook</label>
                                    <input type="text" class="form-control" name="facebook" value="{{ $teamMember->facebook }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Instagram</label>
                                    <input type="text" class="form-control" name="instagram" value="{{ $teamMember->instagram }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>WhatsApp</label>
                                    <input type="text" class="form-control" name="whatsapp" value="{{ $teamMember->whatsapp }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Website</label>
                                    <input type="text" class="form-control" name="website" value="{{ $teamMember->website }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>LinkedIn</label>
                                    <input type="text" class="form-control" name="linkedin" value="{{ $teamMember->linkedin }}">
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
