@extends('Template::layouts.frontend')
@section('content')

    <section class="pt-120 pb-120 section--bg">
        <div class="container">
            <div class="row justify-content-center mb-none-30">
                @include('Template::partials.game_card')
            </div>
        </div>
    </section>

    @if ($sections->secs != null)
        @foreach (json_decode($sections->secs) as $sec)
            @include('Template::sections.' . $sec)
        @endforeach
    @endif
@endsection
