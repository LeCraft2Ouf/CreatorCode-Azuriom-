@push('styles')
    <link rel="stylesheet" href="{{ plugin_asset('creatorcodes', 'css/creatorcodes.css') }}">
@endpush

@push('scripts')
    <script src="{{ plugin_asset('creatorcodes', 'js/creatorcodes.js') }}" defer></script>
@endpush

@push('footer-scripts')
    <div id="creatorcodes-mount" hidden>
        @include('creatorcodes::shop.box')
    </div>
@endpush
