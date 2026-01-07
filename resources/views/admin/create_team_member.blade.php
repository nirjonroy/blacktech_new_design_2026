@extends('admin.master_layout')
@section('title')
<title>Team Member</title>
@endsection
@section('admin-content')
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Create Team Member</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{__('admin.Dashboard')}}</a></div>
              <div class="breadcrumb-item active"><a href="{{ route('admin.team-member.index') }}">Team Members</a></div>
              <div class="breadcrumb-item">Create Team Member</div>
            </div>
          </div>

          <div class="section-body">
            <a href="{{ route('admin.team-member.index') }}" class="btn btn-primary"><i class="fas fa-list"></i> Team Members</a>
            <div class="row mt-4">
                <div class="col-12">
                  <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.team-member.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="form-group col-12">
                                    <label>Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name">
                                </div>
                                <div class="form-group col-12">
                                    <label>Slug</label>
                                    <input type="text" class="form-control" name="slug" placeholder="leave blank to auto-generate">
                                </div>
                                <div class="form-group col-12">
                                    <label>Designation <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="designation">
                                </div>
                                <div class="form-group col-12">
                                    <label>Image <span class="text-danger">*</span></label>
                                    <input type="file" name="image" class="form-control-file">
                                </div>
                                <div class="form-group col-12">
                                    <label>Biography</label>
                                    <textarea name="biography" cols="30" rows="5" class="form-control text-area-5"></textarea>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Facebook</label>
                                    <input type="text" class="form-control" name="facebook">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Instagram</label>
                                    <input type="text" class="form-control" name="instagram">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>WhatsApp</label>
                                    <input type="text" class="form-control" name="whatsapp">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Website</label>
                                    <input type="text" class="form-control" name="website">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>LinkedIn</label>
                                    <input type="text" class="form-control" name="linkedin">
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
