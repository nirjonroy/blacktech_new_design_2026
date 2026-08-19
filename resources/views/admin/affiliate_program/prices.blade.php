@extends('admin.master_layout')
@section('title')
<title>Affiliate Service Prices</title>
@endsection
@section('admin-content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Affiliate Service Prices</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{__('admin.Dashboard')}}</a></div>
                <div class="breadcrumb-item">Affiliate Service Prices</div>
            </div>
        </div>

        <div class="section-body">
            <a href="javascript:;" data-toggle="modal" data-target="#createPrice" class="btn btn-primary"><i class="fas fa-plus"></i> {{__('admin.Add New')}}</a>
            <div class="row mt-4">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive table-invoice">
                                <table class="table table-striped" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>{{__('admin.SN')}}</th>
                                            <th>Service</th>
                                            <th>Basic</th>
                                            <th>Intermediate</th>
                                            <th>Complex</th>
                                            <th>Serial</th>
                                            <th>Status</th>
                                            <th>{{__('admin.Action')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($prices as $index => $price)
                                            <tr>
                                                <td>{{ ++$index }}</td>
                                                <td>{{ $price->service_name }}</td>
                                                <td>{{ $price->basic_price }}</td>
                                                <td>{{ $price->intermediate_price }}</td>
                                                <td>{{ $price->complex_price }}</td>
                                                <td>{{ $price->serial }}</td>
                                                <td><span class="badge badge-{{ $price->status ? 'success' : 'danger' }}">{{ $price->status ? 'Active' : 'Inactive' }}</span></td>
                                                <td>
                                                    <a href="javascript:;" data-toggle="modal" data-target="#editPrice-{{ $price->id }}" class="btn btn-primary btn-sm"><i class="fa fa-edit" aria-hidden="true"></i></a>
                                                    <a href="javascript:;" data-toggle="modal" data-target="#deleteModal" class="btn btn-danger btn-sm" onclick="deleteData({{ $price->id }})"><i class="fa fa-trash" aria-hidden="true"></i></a>
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

<div class="modal fade" id="createPrice" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create Service Price</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.affiliate-price.store') }}" method="POST">
                    @csrf
                    @include('admin.affiliate_program.price_form', ['price' => null])
                    <button type="button" class="btn btn-danger" data-dismiss="modal">{{__('admin.Close')}}</button>
                    <button type="submit" class="btn btn-primary">{{__('admin.Save')}}</button>
                </form>
            </div>
        </div>
    </div>
</div>

@foreach ($prices as $price)
    <div class="modal fade" id="editPrice-{{ $price->id }}" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Service Price</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.affiliate-price.update', $price->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        @include('admin.affiliate_program.price_form', ['price' => $price])
                        <button type="button" class="btn btn-danger" data-dismiss="modal">{{__('admin.Close')}}</button>
                        <button type="submit" class="btn btn-primary">{{__('admin.Update')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach

<script>
    function deleteData(id){
        $("#deleteForm").attr("action",'{{ url("admin/affiliate-price/") }}'+"/"+id)
    }
</script>
@endsection
