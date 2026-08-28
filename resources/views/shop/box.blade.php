<div class="creatorcodes-box mt-4 pt-3" data-creatorcodes-box>
    <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
        <span class="small text-muted mb-0">{{ trans('creatorcodes::messages.title') }}</span>
        <span class="small text-muted">— {{ trans('creatorcodes::messages.hint') }}</span>
    </div>

    @if($creatorCode ?? null)
        <div class="d-flex flex-wrap align-items-center gap-2">
            <span class="small mb-0">
                {{ trans('creatorcodes::messages.current', [
                    'code' => $creatorCode->code,
                    'percent' => $creatorCode->percentage,
                    'name' => $creatorCode->user->name,
                ]) }}
            </span>
            <form action="{{ route('creatorcodes.remove') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-sm">
                    {{ trans('creatorcodes::messages.remove') }}
                </button>
            </form>
        </div>
    @else
        <form action="{{ route('creatorcodes.apply') }}" method="POST" class="creatorcodes-form">
            @csrf
            <div class="input-group input-group-sm @error('creator_code') has-validation @enderror" style="max-width: 320px">
                <input type="text" class="form-control @error('creator_code') is-invalid @enderror" name="creator_code"
                       value="{{ old('creator_code') }}" placeholder="{{ trans('creatorcodes::messages.placeholder') }}"
                       maxlength="32" required @guest disabled @endguest>
                <button type="submit" class="btn btn-outline-primary" @guest disabled @endguest>
                    {{ trans('creatorcodes::messages.apply') }}
                </button>
                @error('creator_code')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
        </form>
    @endif
</div>
