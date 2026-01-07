@extends('admin.master_layout')
@section('title')
<title>Team Members</title>
@endsection
@section('admin-content')
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Team Members</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{__('admin.Dashboard')}}</a></div>
              <div class="breadcrumb-item">Team Members</div>
            </div>
          </div>

          <div class="section-body">
            <a href="{{ route('admin.team-member.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add New</a>
            <div class="row mt-4">
                <div class="col">
                  <div class="card">
                    <div class="card-body">
                      <div class="table-responsive table-invoice">
                        <table class="table table-striped" id="dataTable">
                            <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Name</th>
                                    <th>Designation</th>
                                    <th>Image</th>
                                    <th>Social</th>
                                    <th>Action</th>
                                  </tr>
                            </thead>
                            <tbody>
                                @foreach ($teamMembers as $index => $member)
                                    <tr>
                                        <td>{{ ++$index }}</td>
                                        <td>{{ $member->name }}</td>
                                        <td>{{ $member->designation }}</td>
                                        <td>
                                            @if (!empty($member->image))
                                                <img src="{{ asset($member->image) }}" alt="{{ $member->name }}" width="60" class="rounded-circle">
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                                $links = [
                                                    'Fb' => $member->facebook,
                                                    'Ig' => $member->instagram,
                                                    'Wa' => $member->whatsapp,
                                                    'Web' => $member->website,
                                                    'In' => $member->linkedin,
                                                ];
                                                $hasLink = false;
                                            @endphp
                                            @foreach ($links as $label => $url)
                                                @if (!empty($url))
                                                    @php $hasLink = true; @endphp
                                                    <span class="badge badge-light">{{ $label }}</span>
                                                @endif
                                            @endforeach
                                            @if (!$hasLink)
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.team-member.edit', $member->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit" aria-hidden="true"></i></a>
                                            <a href="javascript:;" data-toggle="modal" data-target="#deleteModal" class="btn btn-danger btn-sm" onclick="deleteData({{ $member->id }})"><i class="fa fa-trash" aria-hidden="true"></i></a>
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
        </section>
      </div>

<script>
    function deleteData(id){
        $("#deleteForm").attr("action",'{{ url("admin/team-member/") }}'+"/"+id)
    }
</script>
@endsection
