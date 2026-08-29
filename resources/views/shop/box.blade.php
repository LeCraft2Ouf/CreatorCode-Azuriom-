<div data-creatorcodes-box class="creatorcodes-inline mb-3 pb-3">
    <p class="small text-muted mb-2" data-creatorcodes-title>{{ trans('creatorcodes::messages.title') }}
        <span class="fw-normal">({{ trans('creatorcodes::messages.optional') }})</span>
    </p>

    @guest
        <p class="small mb-0">{{ trans('creatorcodes::messages.login') }}</p>
    @endguest

    @auth
        @if(! empty($appliedCode))
            <div class="d-flex flex-wrap align-items-center gap-2">
                <span class="small">{{ trans('creatorcodes::messages.current', ['code' => $appliedCode]) }}</span>
                <form action="{{ route('creatorcodes.remove') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-secondary btn-sm">
                        {{ trans('creatorcodes::messages.remove') }}
                    </button>
                </form>
            </div>
        @else
            <form action="{{ route('creatorcodes.apply') }}" method="POST" class="m-0">
                @csrf
                <div class="creatorcodes-row">
                    <input type="text" name="creator_code" value="{{ old('creator_code') }}"
                           class="form-control form-control-sm @error('creator_code') is-invalid @enderror"
                           placeholder="{{ trans('creatorcodes::messages.placeholder') }}"
                           maxlength="32" required autocomplete="off" aria-label="{{ trans('creatorcodes::messages.title') }}">
                    <button type="submit" class="btn btn-primary btn-sm">
                        {{ trans('creatorcodes::messages.apply') }}
                    </button>
                </div>
                @error('creator_code')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </form>
        @endif
    @endauth
</div>
