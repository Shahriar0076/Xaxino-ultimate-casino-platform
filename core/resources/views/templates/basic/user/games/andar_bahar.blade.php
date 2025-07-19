@extends('Template::layouts.master')
@section('content')
    <section class="pt-120 pb-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card-body h-100 middle-el overflow-hidden">
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
                <div class="col-lg-4 mt-lg-0 mt-5">
                    <div class="game-details-right">
                        <form id="game" method="post">
                            @csrf
                            <h3 class="f-size--28 mb-4 text-center">
                                {{ $isDemo ? trans('Demo Balance:') : trans('Current Balance:') }}
                                <span class="base--color">
                                    <span class="bal text-white">{{ showAmount($balance, currencyFormat: false) }}</span>
                                    {{ __(gs('cur_text')) }}
                                </span>
                            </h3>
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <input class="form-control amount-field custom-amount-input" name="invest"
                                        type="text" placeholder="@lang('Enter Amount')" autocomplete="off" required>
                                    <span class="input-group-text" id="basic-addon2">{{ __(gs('cur_text')) }}</span>
                                </div>
                                <small class="form-text text-muted">
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
                            <div class="form-group justify-content-center d-flex mt-5 gap-3">
                                <div class="single-select andar">
                                    <img class="red" src="{{ asset($activeTemplateTrue . 'images/games/andar.png') }}"
                                        alt="">
                                </div>
                                <div class="single-select bahar">
                                    <img class="black" src="{{ asset($activeTemplateTrue . 'images/games/bahar.png') }}"
                                        alt="">
                                </div>
                            </div>
                            <input name="choose" type="hidden">
                            <input name="type" type="hidden" value="ht">

                            <div class="mt-5 text-center">
                                <button class="cmn-btn w-100 text-center" id="playBtn"
                                    type="submit">@lang('Play Now')</button>
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <a class="game-instruction" data-bs-toggle="modal" data-bs-target="#exampleModalCenter">
                                        @lang('Game Instruction')
                                        <i class="las la-info-circle"></i>
                                    </a>
                                    <button type="button" class="cmn-btn btn-sm sound-btn bg--two audioBtn">
                                        <i class="fas fa-volume-up"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="exampleModalCenter">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content section--bg">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">@lang('Game Rule')</h5>
                    <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
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
        let imagePath = "{{ asset($activeTemplateTrue . 'images/cards/') }}";
        investUrl = "{{ route('user.play.invest', ['andar_bahar', @$isDemo]) }}";
        gameEndUrl = "{{ route('user.play.end', ['andar_bahar', @$isDemo]) }}";
        audioAssetPath = `{{ asset('assets/audio') }}`;
    </script>
@endpush

@push('style')
    <style type="text/css">
        .ab-card-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
            max-width: 620px;
            width: 100%;
        }

        @media (max-width: 575px) {
            .ab-card-wrapper {
                gap: 10px;
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
            font-size: 16px;
            padding: 5px 16px;
            background: #0e223a;
            border-radius: 6px;
        }

        @media (max-width: 575px) {
            .ab-card-title {
                font-size: 14px;
                padding: 4px 14px;
                border-radius: 4px;
                font-weight: 400;
            }
        }

        .single-select {
            padding: 0px;
        }

        .single-select img {
            border-radius: 8px;
        }

        .ab-card-img {
            border-radius: 5px;
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

        @media (max-width: 575px) {
            .game-details-left {
                padding: 24px;
            }
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
