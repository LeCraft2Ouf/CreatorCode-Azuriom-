<div data-creatorcodes-box class="card mb-4">
    <div class="card-body">
        <h5 class="card-title">{{ trans('creatorcodes::messages.title') }}</h5>
        <p class="text-muted small">{{ trans('creatorcodes::messages.hint', ['money' => money_name()]) }}</p>

        @guest
            <p class="mb-0">{{ trans('creatorcodes::messages.login') }}</p>
        @endguest

        @auth
            @if(! empty($appliedCode))
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                    <p class="mb-0">{{ trans('creatorcodes::messages.current', ['code' => $appliedCode]) }}</p>
                    <form action="{{ route('creatorcodes.remove') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-outline-secondary btn-sm">
                            {{ trans('creatorcodes::messages.remove') }}
                        </button>
                    </form>
                </div>
            @else
                <form action="{{ route('creatorcodes.apply') }}" method="POST" class="m-0">
                    @csrf
                    <div class="input-group">
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
</div>
