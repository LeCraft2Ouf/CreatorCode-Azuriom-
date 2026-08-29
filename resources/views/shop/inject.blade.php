@push('styles')
    <link rel="stylesheet" href="{{ plugin_asset('creatorcodes', 'css/creatorcodes.css') }}?v=1.0.3">
@endpush

@push('scripts')
    <script src="{{ plugin_asset('creatorcodes', 'js/creatorcodes.js') }}?v=1.0.3" defer></script>
@endpush

@push('footer-scripts')
    <div id="creatorcodes-mount" hidden>
        @include('creatorcodes::shop.box')
    </div>
@endpush
