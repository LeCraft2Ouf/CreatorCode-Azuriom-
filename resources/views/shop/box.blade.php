<div data-creatorcodes-box class="card mb-4">
    <div class="card-header">
        {{ trans('creatorcodes::messages.title') }}
    </div>
    <div class="card-body">
        <p class="text-muted">{{ trans('creatorcodes::messages.hint', ['money' => money_name()]) }}</p>

        @guest
            <p class="mb-0">{{ trans('creatorcodes::messages.login') }}</p>
        @endguest

        @auth
            @if(! empty($appliedCode))
                <p class="mb-3">{{ trans('creatorcodes::messages.current', ['code' => $appliedCode]) }}</p>
                <form action="{{ route('creatorcodes.remove') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-secondary">
                        {{ trans('creatorcodes::messages.remove') }}
                    </button>
                </form>
            @else
                <form action="{{ route('creatorcodes.apply') }}" method="POST" class="m-0">
                    @csrf
                    <input type="text" id="creator_code" name="creator_code" value="{{ old('creator_code') }}"
                           class="form-control @error('creator_code') is-invalid @enderror"
                           placeholder="{{ trans('creatorcodes::messages.placeholder') }}"
                           maxlength="32" required autocomplete="off" aria-label="{{ trans('creatorcodes::messages.title') }}">
                    @error('creator_code')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                    <button type="submit" class="btn btn-primary mt-3">
                        {{ trans('creatorcodes::messages.apply') }}
                    </button>
                </form>
            @endif
        @endauth
    </div>
</div>
