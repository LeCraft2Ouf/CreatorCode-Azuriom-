@csrf

<style>
    .creatorcodes-switch {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        min-height: 38px;
    }
    .creatorcodes-switch .form-check-input {
        width: 2.75em;
        height: 1.4em;
        margin: 0 !important;
        float: none;
        flex-shrink: 0;
        cursor: pointer;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8'%3e%3ccircle r='3' fill='rgba%28255,255,255,0.8%29'/%3e%3c/svg%3e");
        background-position: left center;
        border-radius: 2em;
        transition: background-position .15s ease-in-out;
    }
    .creatorcodes-switch .form-check-input:checked {
        background-position: right center;
    }
</style>

<div class="row g-3 align-items-end">
    <div class="col-md-3">
        <label class="form-label" for="pseudo">{{ trans('creatorcodes::admin.fields.pseudo') }}</label>
        <input type="text" id="pseudo" name="pseudo" class="form-control @error('pseudo') is-invalid @enderror"
               value="{{ old('pseudo', $creator->user?->name ?? '') }}" required>
        @error('pseudo')
        <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
    <div class="col-md-3">
        <label class="form-label" for="code">{{ trans('creatorcodes::admin.fields.code') }}</label>
        <input type="text" id="code" name="code" class="form-control @error('code') is-invalid @enderror"
               value="{{ old('code', $creator->code ?? '') }}" required>
        @error('code')
        <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
    <div class="col-md-2">
        <label class="form-label" for="percentage">{{ trans('creatorcodes::admin.fields.percentage') }}</label>
        <div class="input-group">
            <input type="number" id="percentage" name="percentage" class="form-control @error('percentage') is-invalid @enderror"
                   value="{{ old('percentage', $creator->percentage ?? 10) }}" min="0.01" max="100" step="0.01" required>
            <span class="input-group-text">%</span>
            @error('percentage')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-md-2">
        <label class="form-label" for="is_enabled">{{ trans('creatorcodes::admin.fields.status') }}</label>
        <div class="creatorcodes-switch">
            <span class="text-muted small">Off</span>
            <input type="hidden" name="is_enabled" value="0">
            <input class="form-check-input" type="checkbox" role="switch" id="is_enabled" name="is_enabled" value="1"
                   @checked(old('is_enabled', $creator->is_enabled ?? true))>
            <span class="small">On</span>
        </div>
    </div>
    <div class="col-md-2">
        <label class="form-label d-none d-md-block">&nbsp;</label>
        <button type="submit" class="btn btn-primary w-100">
            @if($creator->exists)
                <i class="bi bi-save"></i> {{ trans('messages.actions.save') }}
            @else
                <i class="bi bi-plus-lg"></i> {{ trans('messages.actions.add') }}
            @endif
        </button>
    </div>
</div>
<p class="text-muted small mt-3 mb-1">{{ trans('creatorcodes::admin.help.pseudo') }}</p>
<p class="text-muted small mb-0">{{ trans('creatorcodes::admin.help.percentage') }}</p>
