<div @class(['card mb-4' => empty($compact), 'mb-3' => ! empty($compact)]) data-creatorcodes-box>
    @if(empty($compact))
    <div class="card-body">
    @endif
        <h6 class="fw-bold mb-3">{{ trans('creatorcodes::messages.title') }}{{ ! empty($compact) ? ':' : '' }}</h6>
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
                <div class="input-group mb-3 @error('creator_code') has-validation @enderror">
                    <input type="text" class="form-control @error('creator_code') is-invalid @enderror" name="creator_code"
                           value="{{ old('creator_code') }}" placeholder="{{ trans('creatorcodes::messages.placeholder') }}"
                           maxlength="32" required @guest disabled @endguest>
                    <button type="submit" class="btn btn-primary" @guest disabled @endguest>
                        <i class="bi bi-plus-lg"></i> {{ trans('creatorcodes::messages.apply') }}
                    </button>
                    @error('creator_code')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
            </form>
        @endif
    @if(empty($compact))
    </div>
    @endif
</div>
