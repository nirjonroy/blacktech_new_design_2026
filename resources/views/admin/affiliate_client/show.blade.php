@extends('admin.master_layout')
@section('title')
<title>Affiliate Client</title>
@endsection
@section('admin-content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Affiliate Client</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{__('admin.Dashboard')}}</a></div>
                <div class="breadcrumb-item">Affiliate Client</div>
            </div>
        </div>

        <div class="section-body">
            <a class="btn btn-primary" href="{{ route('admin.affiliate-client') }}"> <i class="fa fa-list" aria-hidden="true"></i> Affiliate Clients</a>
            <div class="row mt-4">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive table-invoice">
                                <table class="table table-striped">
                                    <tbody>
                                        <tr><td>Client Name</td><td>{{ $clientSubmission->client_name }}</td></tr>
                                        <tr><td>Client Email</td><td>{{ $clientSubmission->client_email }}</td></tr>
                                        <tr><td>Client Phone</td><td>{{ $clientSubmission->client_phone }}</td></tr>
                                        <tr><td>Company</td><td>{{ $clientSubmission->company_name }}</td></tr>
                                        <tr><td>Service Interest</td><td>{{ $clientSubmission->service_interest }}</td></tr>
                                        <tr><td>Budget</td><td>{{ $clientSubmission->budget }}</td></tr>
                                        <tr><td>Message</td><td>{{ $clientSubmission->message }}</td></tr>
                                        <tr><td>Status</td><td>{{ ucfirst($clientSubmission->status) }}</td></tr>
                                        <tr><td>Affiliate</td><td>{{ optional($clientSubmission->affiliateMarketer)->name }} ({{ optional($clientSubmission->affiliateMarketer)->email }})</td></tr>
                                        <tr><td>Submitted At</td><td>{{ optional($clientSubmission->created_at)->format('Y-m-d H:i') }}</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
