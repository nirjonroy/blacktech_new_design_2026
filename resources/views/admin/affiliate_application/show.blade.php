@extends('admin.master_layout')
@section('title')
<title>Affiliate Application</title>
@endsection
@section('admin-content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Affiliate Application</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{__('admin.Dashboard')}}</a></div>
                <div class="breadcrumb-item">Affiliate Application</div>
            </div>
        </div>

        <div class="section-body">
            <a class="btn btn-primary" href="{{ route('admin.affiliate-application') }}"> <i class="fa fa-list" aria-hidden="true"></i> Affiliate Applications</a>
            <div class="row mt-4">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h4>Application Details</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive table-invoice">
                                <table class="table table-striped">
                                    <tbody>
                                        <tr><td>{{__('admin.Name')}}</td><td>{{ $affiliateApplication->name }}</td></tr>
                                        <tr><td>{{__('admin.Email')}}</td><td>{{ $affiliateApplication->email }}</td></tr>
                                        <tr><td>{{__('admin.Phone')}}</td><td>{{ $affiliateApplication->phone }}</td></tr>
                                        <tr><td>Company</td><td>{{ $affiliateApplication->company_name }}</td></tr>
                                        <tr><td>Website / Social Link</td><td>{{ $affiliateApplication->website }}</td></tr>
                                        <tr><td>Audience</td><td>{{ $affiliateApplication->audience }}</td></tr>
                                        <tr><td>Promotion Plan</td><td>{{ $affiliateApplication->promotion_plan }}</td></tr>
                                        <tr><td>{{__('admin.Message')}}</td><td>{{ $affiliateApplication->message }}</td></tr>
                                        <tr><td>Status</td><td>{{ ucfirst($affiliateApplication->status) }}</td></tr>
                                        <tr><td>Approved At</td><td>{{ optional($affiliateApplication->approved_at)->format('Y-m-d H:i') }}</td></tr>
                                        <tr><td>Submitted At</td><td>{{ optional($affiliateApplication->created_at)->format('Y-m-d H:i') }}</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h4>Affiliate Login</h4>
                        </div>
                        <div class="card-body">
                            @if ($affiliateApplication->status === 'approved' && $affiliateMarketer)
                                <div class="alert alert-success">
                                    This affiliate is approved and can login from:<br>
                                    <a href="{{ route('front.affiliate.login') }}" target="_blank">{{ route('front.affiliate.login') }}</a>
                                </div>
                                <p class="mb-1"><strong>Name:</strong> {{ $affiliateMarketer->name }}</p>
                                <p class="mb-0"><strong>Email:</strong> {{ $affiliateMarketer->email }}</p>
                            @else
                                <form action="{{ route('admin.approve-affiliate-application', $affiliateApplication->id) }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label>Login Email</label>
                                        <input type="email" class="form-control" value="{{ $affiliateApplication->email }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Set Password</label>
                                        <input type="password" name="password" class="form-control" required minlength="6">
                                    </div>
                                    <div class="form-group">
                                        <label>Confirm Password</label>
                                        <input type="password" name="password_confirmation" class="form-control" required minlength="6">
                                    </div>
                                    <button type="submit" class="btn btn-success btn-block">Approve & Create Dashboard</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
