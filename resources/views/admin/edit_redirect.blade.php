@extends('admin.master_layout')
@section('title')
<title>{{ __('admin.Edit Redirect') }}</title>
@endsection
@section('admin-content')
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>{{ __('admin.Edit Redirect') }}</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{ __('admin.Dashboard') }}</a></div>
              <div class="breadcrumb-item active"><a href="{{ route('admin.redirect.index') }}">{{ __('admin.Redirects') }}</a></div>
              <div class="breadcrumb-item">{{ __('admin.Edit Redirect') }}</div>
            </div>
          </div>

          <div class="section-body">
            <a href="{{ route('admin.redirect.index') }}" class="btn btn-primary"><i class="fas fa-list"></i> {{ __('admin.Redirects') }}</a>
            <div class="row mt-4">
                <div class="col-12">
                  <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.redirect.update', $redirect->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="form-group col-12">
                                    <label>{{ __('admin.Source URL') }} <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="source_url" value="{{ old('source_url', $redirect->source_url) }}" placeholder="/old-path">
                                    @error('source_url')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-12">
                                    <label>{{ __('admin.Match Type') }} <span class="text-danger">*</span></label>
                                    <select name="match_type" class="form-control">
                                        @foreach ($matchTypes as $value => $label)
                                            <option value="{{ $value }}" {{ old('match_type', $redirect->match_type) === $value ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    @error('match_type')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-12">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="ignore_case" name="ignore_case" value="1" {{ old('ignore_case', $redirect->is_case_sensitive ? 0 : 1) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="ignore_case">{{ __('admin.Ignore Case') }}</label>
                                    </div>
                                </div>

                                <div class="form-group col-12">
                                    <label>{{ __('admin.Destination URL') }} <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="destination_url" value="{{ old('destination_url', $redirect->destination_url) }}" placeholder="/new-path or https://example.com/new-path">
                                    @error('destination_url')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-12">
                                    <label>{{ __('admin.Redirect Type') }} <span class="text-danger">*</span></label>
                                    <div>
                                        @foreach ($httpCodes as $code)
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="redirect_type_{{ $code }}" name="http_code" class="custom-control-input" value="{{ $code }}" {{ (int) old('http_code', $redirect->http_code) === $code ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="redirect_type_{{ $code }}">{{ __('admin.redirect_type_' . $code) }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                    @error('http_code')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-12">
                                    <label>{{ __('admin.Status') }} <span class="text-danger">*</span></label>
                                    <div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="redirect_status_active" name="status" class="custom-control-input" value="1" {{ old('status', $redirect->is_active ? 1 : 0) ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="redirect_status_active">{{ __('admin.Active') }}</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="redirect_status_inactive" name="status" class="custom-control-input" value="0" {{ old('status', $redirect->is_active ? 1 : 0) ? '' : 'checked' }}>
                                            <label class="custom-control-label" for="redirect_status_inactive">{{ __('admin.Inactive') }}</label>
                                        </div>
                                    </div>
                                    @error('status')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <button class="btn btn-primary">{{ __('admin.Update') }}</button>
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

