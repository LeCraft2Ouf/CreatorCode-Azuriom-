<div class="card mb-4" data-creatorcodes-box>
    <div class="card-body">
        <h5 class="fw-bold mb-2">{{ trans('creatorcodes::messages.title') }}</h5>
        <p class="text-muted small mb-3">{{ trans('creatorcodes::messages.hint') }}</p>

        @if($creatorCode ?? null)
            <p class="mb-2">
                {{ trans('creatorcodes::messages.current', [
                    'code' => $creatorCode->code,
                    'percent' => $creatorCode->percentage,
                    'name' => $creatorCode->user->name,
                ]) }}
            </p>
            <form action="{{ route('creatorcodes.remove') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-sm">
                    {{ trans('creatorcodes::messages.remove') }}
                </button>
            </form>
        @else
            <form action="{{ route('creatorcodes.apply') }}" method="POST">
                @csrf
                <div class="input-group @error('creator_code') has-validation @enderror">
                    <input type="text" name="creator_code" class="form-control @error('creator_code') is-invalid @enderror"
                           value="{{ old('creator_code') }}" placeholder="{{ trans('creatorcodes::messages.placeholder') }}"
                           maxlength="32" required @guest disabled @endguest>
                    <button type="submit" class="btn btn-primary" @guest disabled @endguest>
                        {{ trans('creatorcodes::messages.apply') }}
                    </button>
                    @error('creator_code')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
            </form>
        @endif
    </div>
</div>
