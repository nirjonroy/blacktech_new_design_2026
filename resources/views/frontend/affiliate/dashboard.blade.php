@extends('frontend.app')
@section('title', 'Affiliate Dashboard | Blacktech')
@section('content')
<div class="site-content">
    <div class="inner-header bg-holder">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12 text-center">
                    <h1 class="title">Affiliate Dashboard</h1>
                    <p>Submit client details and track your submitted leads.</p>
                    <a class="btn btn-effect mt-3" href="{{ route('front.affiliate.logout') }}"><span>Logout</span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="content-wrapper">
        <section class="space-ptb z-index-2">
            <div class="container">
                @if (Session::has('messege'))
                    <div class="alert alert-{{ Session::get('alert-type') === 'error' ? 'danger' : 'success' }}">
                        {{ Session::get('messege') }}
                    </div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif
                <div class="row">
                    <div class="col-lg-5">
                        <div class="section-title is-sticky">
                            <span class="sub-title"><img class="img-fluid" src="{{ asset(optional(siteInfo())->favicon ?? 'frontend/assets/images/favicon.ico') }}" alt=""> Welcome</span>
                            <h2 class="title">{{ $affiliate->name }}</h2>
                            <p>{{ $affiliate->email }}</p>
                            @if ($affiliate->company_name)
                                <p>{{ $affiliate->company_name }}</p>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="form-wrapper">
                            <form class="contact-form form-style-border" action="{{ route('front.affiliate.client.submit') }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" placeholder="Client Name *" name="client_name" value="{{ old('client_name') }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="email" class="form-control" placeholder="Client Email" name="client_email" value="{{ old('client_email') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-4 pe-1">
                                                <input type="text" class="form-control" placeholder="+1" name="client_phone_country_code" value="{{ old('client_phone_country_code') }}" pattern="^\+[0-9]{1,4}$" title="Enter country code. Example: +1">
                                            </div>
                                            <div class="col-8 ps-1">
                                                <input type="tel" class="form-control" placeholder="Client Phone" name="client_phone" value="{{ old('client_phone') }}" pattern="^[0-9\s().-]{6,20}$" title="Enter phone number without country code">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" placeholder="Company Name" name="company_name" value="{{ old('company_name') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" placeholder="Interested Service" name="service_interest" value="{{ old('service_interest') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" placeholder="Estimated Budget" name="budget" value="{{ old('budget') }}">
                                    </div>
                                    <div class="col-lg-12">
                                        <textarea class="form-control" rows="5" placeholder="Client requirements or notes" name="message">{{ old('message') }}</textarea>
                                    </div>
                                    <div class="col-lg-12">
                                        <button type="submit" class="btn btn-effect">
                                            <span>Submit Client</span>
                                            <svg width="20" height="22" viewBox="0 0 20 22" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_client_submit)"><path d="M19.4854 11.4293L17.0513 12.221C13.1214 13.4993 10.3036 16.9595 9.84784 21.0668C9.49371 16.981 6.71926 13.5081 2.81255 12.2604L0.210283 11.4293" stroke="white" stroke-width="2"/><path d="M9.83594 20.8889L9.83594 0" stroke="white" stroke-width="2"/></g><defs><clipPath id="clip0_client_submit"><rect width="21.3333" height="20" fill="white" transform="translate(20) rotate(90)"/></clipPath></defs></svg>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="row mt-5">
                    <div class="col-lg-12">
                        <div class="section-title">
                            <h3 class="title">Submitted Clients</h3>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-dark table-striped">
                                <thead>
                                    <tr>
                                        <th>Client</th>
                                        <th>Contact</th>
                                        <th>Service</th>
                                        <th>Budget</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($clientSubmissions as $submission)
                                        <tr>
                                            <td>{{ $submission->client_name }}<br><small>{{ $submission->company_name }}</small></td>
                                            <td>{{ $submission->client_email }}<br>{{ $submission->client_phone }}</td>
                                            <td>{{ $submission->service_interest }}</td>
                                            <td>{{ $submission->budget }}</td>
                                            <td>{{ ucfirst($submission->status) }}</td>
                                            <td>{{ optional($submission->created_at)->format('Y-m-d') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6">No client submissions yet.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
