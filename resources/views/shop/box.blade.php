<div data-creatorcodes-box class="creatorcodes-inline mb-4 pb-4">
    <p class="fw-bold mb-1">{{ trans('creatorcodes::messages.title') }}</p>
    <p class="text-muted small">{{ trans('creatorcodes::messages.hint', ['money' => money_name()]) }}</p>

    @guest
        <p class="mb-0">{{ trans('creatorcodes::messages.login') }}</p>
    @endguest

    @auth
        @if(! empty($appliedCode))
            <div class="d-flex flex-wrap align-items-center gap-2">
                <span>{{ trans('creatorcodes::messages.current', ['code' => $appliedCode]) }}</span>
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
                <div class="d-flex flex-wrap gap-2">
                    <input type="text" name="creator_code" value="{{ old('creator_code') }}"
                           class="form-control @error('creator_code') is-invalid @enderror"
                           placeholder="{{ trans('creatorcodes::messages.placeholder') }}"
                           maxlength="32" required autocomplete="off" aria-label="{{ trans('creatorcodes::messages.title') }}">
                    <button type="submit" class="btn btn-primary">
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
