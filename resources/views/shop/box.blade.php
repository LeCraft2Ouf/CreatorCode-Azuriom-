<div data-creatorcodes-box>
    <h6 class="fw-bold text-uppercase text-muted text-sm mb-3 mt-2">
        {{ trans('creatorcodes::messages.title') }}
    </h6>
    <div class="card mb-3">
        @if($creatorCode ?? null)
            <div class="btn shop-nav-cat d-flex justify-content-between align-items-center active">
                <span>{{ $creatorCode->code }}</span>
                <form action="{{ route('creatorcodes.remove') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="creatorcodes-icon-btn" title="{{ trans('creatorcodes::messages.remove') }}">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </form>
            </div>
        @else
            <form action="{{ route('creatorcodes.apply') }}" method="POST" class="m-0">
                @csrf
                <div class="btn shop-nav-cat d-flex justify-content-between align-items-center">
                    <input type="text" name="creator_code" value="{{ old('creator_code') }}"
                           placeholder="{{ trans('creatorcodes::messages.placeholder') }}"
                           maxlength="32" required autocomplete="off" @guest disabled @endguest
                           class="@error('creator_code') is-invalid @enderror">
                    <button type="submit" class="creatorcodes-icon-btn" @guest disabled @endguest title="{{ trans('creatorcodes::messages.apply') }}">
                        <span class="arr"><i class="bi bi-arrow-right"></i></span>
                    </button>
                </div>
            </form>
        @endif
    </div>
</div>
