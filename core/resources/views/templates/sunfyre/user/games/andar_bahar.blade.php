@extends('Template::layouts.master')
@section('content')
    <div class="row gy-5 gx-lg-5 align-items-center">
        <div class="col-lg-6">
            <div class="headtail-body style-two overflow-hidden">
                <div class="headtail-body__shape">
                    @include('Template::partials.game_shape')
                </div>
                <div class="headtail-body__flip">
                    <div class="game-details-left">
                        <div class="ab-card-wrapper">
                            <div class="ab-card">
                                <h4 class="ab-card-title">@lang('Andar')</h4>
                                <div class="ab-card-img">
                                    <img class="static-image"
                                        src="{{ asset($activeTemplateTrue . 'images/cards/BACK.png') }}" alt="">
                                    <div class="showAndarCard"></div>
                                </div>
                            </div>
                            <div class="ab-card">
                                <h4 class="ab-card-title">@lang('Joker')</h4>
                                <div class="ab-card-img">
                                    <img class="static-image"
                                        src="{{ asset($activeTemplateTrue . 'images/cards/J-B.png') }}" alt="">
                                    <div class="result-card"></div>
                                </div>
                            </div>
                            <div class="ab-card">
                                <h4 class="ab-card-title">@lang('Bahar')</h4>
                                <div class="ab-card-img">
                                    <img class="static-image"
                                        src="{{ asset($activeTemplateTrue . 'images/cards/BACK.png') }}" alt="">
                                    <div class="showBaharCard"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="headtail-wrapper">
                <h4 class="game-contet-title">
                    {{ $isDemo ? trans('Demo Balance:') : trans('Current Balance:') }}
                    <span class="text bal">{{ showAmount($balance, currencyFormat: false) }} </span>
                    {{ __(gs('cur_text')) }}
                </h4>
                <form id="game" method="post">
                    @csrf
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-text">{{ gs('cur_sym') }}</span>
                            <input type="number" step="any" class="form-control form--control"
                                placeholder="@lang('Enter amount')" name="invest" value="{{ old('invest') }}">
                            <button type="button" class="input-group-text minmax-btn minBtn">@lang('Min')</button>
                            <button type="button" class="input-group-text minmax-btn maxBtn">@lang('Max')</button>
                        </div>
                        <small class="fw-light mt-3 d-inline-block input-inner-note">
                            <i class="fas fa-info-circle mr-2"></i>
                            @lang('Minimum'): {{ showAmount($game->min_limit) }}
                            |
                            @lang('Maximum'): {{ showAmount($game->max_limit) }}
                            |
                            <span class="text--warning">
                                @lang('Win Amount')
                                @if ($game->invest_back == 1)
                                    {{ getAmount($game->win + 100) }}%
                                @else
                                    {{ getAmount($game->win) }}%
                                @endif
                            </span>
                        </small>
                    </div>

                    <div class="headtail-slect">
                        <div class="headtail-slect__box game-select-box single-select andar">
                            <div class="card-box-image">
                                <img class="red" src="{{ asset($activeTemplateTrue . 'images/games/andar.png') }}"
                                    alt="">
                            </div>
                        </div>
                        <div class="headtail-slect__box game-select-box single-select bahar">
                            <div class="card-box-image">
                                <img class="black" src="{{ asset($activeTemplateTrue . 'images/games/bahar.png') }}"
                                    alt="">
                            </div>
                        </div>
                        <input name="choose" type="hidden">
                    </div>

                    <div class="form-submit game-playbtn">
                        <button type="submit" id="playBtn" class="btn btn--gradient w-100">@lang('Play Now')</button>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-3 w-100">
                        <button type="button" class="d-block text-white text-center mx-auto" data-bs-toggle="modal"
                            data-bs-target="#exampleModalCenter"><i class="fas fa-info-circle mr-2"></i>
                            @lang('Game Instruction')
                        </button>
                        <button type="button" class="sound--btn audioBtn">
                            <i class="fas fa-volume-up"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal custom--modal fade" id="exampleModalCenter">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content section--bg">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">@lang('Game Rule')</h5>
                    <span class="close" data-bs-dismiss="modal" type="button" aria-label="Close">
                        <i class="las la-times"></i>
                    </span>
                </div>
                <div class="modal-body">
                    @php echo $game->instruction @endphp
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style-lib')
    <link href="{{ asset('assets/global/css/game/card.css') }}" rel="stylesheet">
@endpush

@push('script-lib')
    <script src="{{ asset('assets/global/js/soundControl.js') }}"></script>
    <script src="{{ asset('assets/global/js/game/game.js') }}"></script>
    <script src="{{ asset('assets/global/js/game/andarBahar.js') }}"></script>
@endpush

@push('script')
    <script>
        "use strict";

        let timerA;
        let investField = $("[name=invest]");
        let minLimit = Number("{{ $game->min_limit }}");
        let maxLimit = Number("{{ $game->max_limit }}");
        let imagePath = "{{ asset($activeTemplateTrue . 'images/cards/') }}";
        investUrl = "{{ route('user.play.invest', ['andar_bahar', @$isDemo]) }}";
        gameEndUrl = "{{ route('user.play.end', ['andar_bahar', @$isDemo]) }}";
        audioAssetPath = `{{ asset('assets/audio') }}`;


        $(".minBtn").on('click', function(e) {
            playAudio(audioAssetPath, "click.mp3");
            investField.val(minLimit);
        });

        $(".maxBtn").on('click', function(e) {
            playAudio(audioAssetPath, "click.mp3");
            investField.val(maxLimit);
        });
    </script>
@endpush

@push('style')
    <style type="text/css">
        .headtail-slect__box {
            height: 150px;
            width: 150px;
            overflow: hidden;
        }

        .card-box-image {
            height: 100%;
            width: 100%;
        }

        .card-box-image img {
            width: 100%;
        }

        @media(max-width: 767px) {

            .headtail-body.style-two {
                padding: 20px;
                background-color: hsl(var(--black));
                border-top: 5px solid hsl(var(--base));
                border-radius: 12px;
            }

            .headtail-body.style-two .headtail-body__shape {
                display: none;
            }

            .headtail-body.style-two .headtail-body__flip {
                position: relative;
                transform: unset;
                top: 0;
                left: 0;
            }
        }

        .ab-card-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
            max-width: 520px;
            width: 100%;
        }

        @media(max-width: 1399px) {
            .ab-card-wrapper {
                max-width: 480px;
                gap: 16px;
            }
        }

        @media(max-width: 1199px) {
            .ab-card-wrapper {
                max-width: 400px;
                gap: 12px;
            }
        }

        .static-image {
            border-radius: 10px;
            width: 100%;
            border: 1px solid rgb(255 255 255 / 0.1);
            position: relative;
        }

        .ab-card {
            width: 30%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            gap: 16px;
        }

        .ab-card-title {
            font-size: 18px;
            padding: 5px 16px;
            background: hsl(var(--white) / .05);
            border-radius: 6px;
        }

        @media(max-width: 575px) {
            .ab-card-title {
                font-size: 16px;
                padding: 4px 12px;
                border-radius: 4px;
            }
        }

        .ab-card-img {
            border-radius: 6px;
            width: 100%;
            border: 1px solid rgb(255 255 255 / 0.1);
            position: relative;
        }

        .ab-card:has(.result-card) {
            width: 34%;
        }

        .result-card {
            position: absolute;
            top: 0;
            left: 0;
        }

        .result-card img {
            animation: resultCardAnimation 0.3s ease-in-out forwards;
            transform: translateY(-137%);
        }

        @keyframes resultCardAnimation {
            0% {
                transform: translateY(-137%);
            }

            100% {
                transform: translateY(-0%);
            }
        }

        .andar-image,
        .bahar-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: inherit;
            position: absolute;
        }

        .andar-image {
            left: -126%;
            animation: cardAnimationAnder 0.2s ease-in-out forwards;
        }

        @keyframes cardAnimationAnder {
            0% {
                top: -135%;
                left: -126%;
                transform: rotate(-20deg);
                opacity: 0;
            }

            25% {
                top: -30%;
                left: -30%;
                transform: rotate(-12deg);
                opacity: 0.5;
            }

            50% {
                top: 0;
                left: 0;
                transform: rotate(-8deg);
                opacity: 0.75;
            }

            75% {
                top: 0;
                left: 0;
                transform: rotate(-4deg);
                opacity: 0.95;
            }

            100% {
                top: 0;
                left: 0;
                transform: rotate(0deg);
                opacity: 1;
            }
        }

        .bahar-image {
            right: -126%;
            animation: cardAnimationBahar 0.2s ease-in-out forwards;
        }

        @keyframes cardAnimationBahar {
            0% {
                top: -135%;
                right: -126%;
                transform: rotate(-20deg);
                opacity: 0;
            }

            25% {
                top: -30%;
                right: -30%;
                transform: rotate(-12deg);
                opacity: 0.5;
            }

            50% {
                top: 0;
                right: 0;
                transform: rotate(-8deg);
                opacity: 0.75;
            }

            75% {
                top: 0;
                right: 0;
                transform: rotate(-4deg);
                opacity: 0.95;
            }

            100% {
                top: 0;
                right: 0;
                transform: rotate(0deg);
                opacity: 1;
            }
        }
    </style>
@endpush
