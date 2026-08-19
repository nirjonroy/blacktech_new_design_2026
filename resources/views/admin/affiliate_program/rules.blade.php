@extends('admin.master_layout')
@section('title')
<title>Affiliate Rules</title>
@endsection
@section('admin-content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Affiliate Rules</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{__('admin.Dashboard')}}</a></div>
                <div class="breadcrumb-item">Affiliate Rules</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('admin.affiliate-rules.update') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label>Title <span class="text-danger">*</span></label>
                                    <input type="text" name="title" class="form-control" value="{{ old('title', optional($rule)->title ?? 'Affiliate Marketing Rules & Regulations') }}" required>
                                </div>
                                <div class="form-group">
                                    <label>Rules & Regulations <span class="text-danger">*</span></label>
                                    <textarea name="description" cols="30" rows="12" class="form-control text-area-5 summernote" required>{{ old('description', optional($rule)->description) }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>
                                        <input type="checkbox" name="status" value="1" {{ optional($rule)->status === false ? '' : 'checked' }}>
                                        Active
                                    </label>
                                </div>
                                <button class="btn btn-primary">{{__('admin.Update')}}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
