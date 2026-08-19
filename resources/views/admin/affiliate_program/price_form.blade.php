<div class="row">
    <div class="form-group col-md-8">
        <label>Service Name <span class="text-danger">*</span></label>
        <input type="text" name="service_name" class="form-control" value="{{ old('service_name', optional($price)->service_name) }}" required>
    </div>
    <div class="form-group col-md-4">
        <label>Serial</label>
        <input type="number" name="serial" class="form-control" value="{{ old('serial', optional($price)->serial) }}">
    </div>
    <div class="form-group col-md-4">
        <label>Basic Price</label>
        <input type="number" step="0.01" min="0" name="basic_price" class="form-control" value="{{ old('basic_price', optional($price)->basic_price) }}">
    </div>
    <div class="form-group col-md-4">
        <label>Intermediate Price</label>
        <input type="number" step="0.01" min="0" name="intermediate_price" class="form-control" value="{{ old('intermediate_price', optional($price)->intermediate_price) }}">
    </div>
    <div class="form-group col-md-4">
        <label>Complex Price</label>
        <input type="number" step="0.01" min="0" name="complex_price" class="form-control" value="{{ old('complex_price', optional($price)->complex_price) }}">
    </div>
    <div class="form-group col-12">
        <label>Note</label>
        <textarea name="note" class="form-control" rows="3">{{ old('note', optional($price)->note) }}</textarea>
    </div>
    <div class="form-group col-12">
        <label>
            <input type="checkbox" name="status" value="1" {{ optional($price)->exists ? (optional($price)->status ? 'checked' : '') : 'checked' }}>
            Active
        </label>
    </div>
</div>
