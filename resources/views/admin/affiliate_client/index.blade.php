@extends('admin.master_layout')
@section('title')
<title>Affiliate Clients</title>
@endsection
@section('admin-content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Affiliate Clients</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{__('admin.Dashboard')}}</a></div>
                <div class="breadcrumb-item">Affiliate Clients</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row mt-4">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive table-invoice">
                                <table class="table table-striped" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>{{__('admin.SN')}}</th>
                                            <th>Client</th>
                                            <th>Contact</th>
                                            <th>Service</th>
                                            <th>Affiliate</th>
                                            <th>Status</th>
                                            <th>{{__('admin.Action')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($clientSubmissions as $index => $submission)
                                            <tr>
                                                <td>{{ ++$index }}</td>
                                                <td>{{ $submission->client_name }}</td>
                                                <td>{{ $submission->client_email }}<br>{{ $submission->client_phone }}</td>
                                                <td>{{ $submission->service_interest }}</td>
                                                <td>{{ optional($submission->affiliateMarketer)->name }}</td>
                                                <td><span class="badge badge-primary">{{ ucfirst($submission->status) }}</span></td>
                                                <td>
                                                    <a href="{{ route('admin.show-affiliate-client', $submission->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                                    <a href="javascript:;" data-toggle="modal" data-target="#deleteModal" class="btn btn-danger btn-sm" onclick="deleteData({{ $submission->id }})"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
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

<script>
    function deleteData(id){
        $("#deleteForm").attr("action",'{{ url("admin/delete-affiliate-client/") }}'+"/"+id)
    }
</script>
@endsection
