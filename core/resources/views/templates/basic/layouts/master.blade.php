@extends('Template::layouts.app')
@section('app')
    @include('Template::partials.user_header')

    @if (!request()->routeIs('home'))
        @include('Template::partials.breadcrumb')
    @endif

    @yield('content')

    @include('Template::partials.footer')
@endsection

@push('script')
    <script>
        "use strict";
        $(document).on('click touchstart', function(e) {
            $('.win-loss-popup').removeClass('active');
        });

        function formatState(state) {
            if (!state.id) return state.text;
            let gatewayData = $(state.element).data();
            return $(`<div class="d-flex gap-2">${gatewayData.imageSrc ? `<div class="select2-image-wrapper"><img class="select2-image" src="${gatewayData.imageSrc}"></div>` : '' }<div class="select2-content"> <p class="select2-title">${gatewayData.title}</p><p class="select2-subtitle">${gatewayData.subtitle}</p></div></div>`);
        }

        $('.select2').each(function(index, element) {
            $(element).select2();
        });
    </script>
@endpush
