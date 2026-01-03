@extends('admin.master_layout')
@section('title')
<title>{{ __('admin.Add Redirect') }}</title>
@endsection
@section('admin-content')
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>{{ __('admin.Add Redirect') }}</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{ __('admin.Dashboard') }}</a></div>
              <div class="breadcrumb-item active"><a href="{{ route('admin.redirect.index') }}">{{ __('admin.Redirects') }}</a></div>
              <div class="breadcrumb-item">{{ __('admin.Add Redirect') }}</div>
            </div>
          </div>

          <div class="section-body">
            <a href="{{ route('admin.redirect.index') }}" class="btn btn-primary"><i class="fas fa-list"></i> {{ __('admin.Redirects') }}</a>
            <div class="row mt-4">
                <div class="col-12">
                  <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.redirect.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="form-group col-12">
                                    <label>{{ __('admin.Source URLs') }} <span class="text-danger">*</span></label>
                                    <div id="redirect-source-wrapper">
                                        @php
                                            $oldSources = old('source_urls', ['']);
                                        @endphp
                                        @foreach ($oldSources as $idx => $source)
                                            <div class="form-row redirect-source-item mb-2">
                                                <div class="col-md-6 mb-2 mb-md-0">
                                                    <input type="text" class="form-control" name="source_urls[]" value="{{ $source }}" placeholder="/old-path">
                                                </div>
                                                <div class="col-md-4 mb-2 mb-md-0">
                                                    <select name="match_types[]" class="form-control">
                                                        @foreach ($matchTypes as $value => $label)
                                                            <option value="{{ $value }}" {{ (old('match_types.' . $idx, 'exact') === $value) ? 'selected' : '' }}>{{ $label }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-2 d-flex align-items-center">
                                                    <button type="button" class="btn btn-danger btn-sm remove-source {{ $idx === 0 ? 'd-none' : '' }}"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <button type="button" class="btn btn-outline-primary btn-sm" id="add-source-row"><i class="fas fa-plus"></i> {{ __('admin.Add another') }}</button>
                                    @error('source_urls')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                    @error('source_urls.*')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-12">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="ignore_case" name="ignore_case" value="1" {{ old('ignore_case', 1) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="ignore_case">{{ __('admin.Ignore Case') }}</label>
                                    </div>
                                </div>

                                <div class="form-group col-12">
                                    <label>{{ __('admin.Destination URL') }} <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="destination_url" value="{{ old('destination_url') }}" placeholder="/new-path or https://example.com/new-path">
                                    @error('destination_url')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-12">
                                    <label>{{ __('admin.Redirect Type') }} <span class="text-danger">*</span></label>
                                    <div>
                                        @foreach ($httpCodes as $code)
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="redirect_type_{{ $code }}" name="http_code" class="custom-control-input" value="{{ $code }}" {{ (int) old('http_code', 301) === $code ? 'checked' : '' }}>
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
                                            <input type="radio" id="redirect_status_active" name="status" class="custom-control-input" value="1" {{ old('status', 1) ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="redirect_status_active">{{ __('admin.Active') }}</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="redirect_status_inactive" name="status" class="custom-control-input" value="0" {{ old('status', 1) ? '' : 'checked' }}>
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
                                    <button class="btn btn-primary">{{ __('admin.Save') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                  </div>
                </div>
          </div>
        </section>
      </div>

<script>
    (function () {
        const wrapper = document.getElementById('redirect-source-wrapper');
        const addButton = document.getElementById('add-source-row');

        const template = (function () {
            const div = document.createElement('div');
            div.className = 'form-row redirect-source-item mb-2';
            div.innerHTML = `
                <div class="col-md-6 mb-2 mb-md-0">
                    <input type="text" class="form-control" name="source_urls[]" placeholder="/old-path">
                </div>
                <div class="col-md-4 mb-2 mb-md-0">
                    <select name="match_types[]" class="form-control">
                        @foreach ($matchTypes as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-center">
                    <button type="button" class="btn btn-danger btn-sm remove-source"><i class="fa fa-trash" aria-hidden="true"></i></button>
                </div>
            `;
            return div;
        })();

        addButton.addEventListener('click', function () {
            const clone = template.cloneNode(true);
            wrapper.appendChild(clone);
        });

        wrapper.addEventListener('click', function (event) {
            if (event.target.closest('.remove-source')) {
                const rows = wrapper.querySelectorAll('.redirect-source-item');
                if (rows.length <= 1) {
                    return;
                }
                event.target.closest('.redirect-source-item').remove();
            }
        });
    })();
</script>
@endsection
