@extends('Template::layouts.master')
@section('content')
    <div class="row gy-5">
        <div class="col-lg-6">
            <div class="headtail-body">
                @include('Template::partials.game_shape')
                <div class="headtail-body__flip">
                    <div class="coin-flipbox">
                        <div class="flp">
                            <div id="coin-flip-cont">
                                <div class="flipcoin" id="coin">
                                    <div class="flpng coins-wrapper">
                                        <div class="front"><img
                                                src="{{ asset($activeTemplateTrue . 'images/games/head.png') }}"
                                                alt="im"></div>
                                        <div class="back"><img
                                                src="{{ asset($activeTemplateTrue . 'images/games/tail.png') }}"
                                                alt="im"></div>
                                    </div>
                                    <div class="headCoin d-none">
                                        <div class="front"><img
                                                src="{{ asset($activeTemplateTrue . 'images/games/head.png') }}"
                                                alt="im"></div>
                                        <div class="back"><img
                                                src="{{ asset($activeTemplateTrue . 'images/games/tail.png') }}"
                                                alt="im"></div>
                                    </div>
                                    <div class="tailCoin d-none">
                                        <div class="front"><img
                                                src="{{ asset($activeTemplateTrue . 'images/games/tail.png') }}"
                                                alt="im"></div>
                                        <div class="back"><img
                                                src="{{ asset($activeTemplateTrue . 'images/games/head.png') }}"
                                                alt="im"></div>
                                    </div>
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
                    <span class="text bal">{{ showAmount($balance, currencyFormat: false) }}</span>
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
                            @lang('Minimum'): {{ showAmount($game->min_limit) }} |
                            @lang('Maximum'): {{ showAmount($game->max_limit) }} |
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
                        <div class="headtail-slect__box game-select-box">
                            <div class="headtail-slect__image single-select head gmimg">
                                <img src="{{ asset($activeTemplateTrue . '/images/games/head.png') }}" alt="game-image">
                            </div>
                        </div>
                        <div class="headtail-slect__box game-select-box">
                            <div class="headtail-slect__image single-select tail gmimg">
                                <img src="{{ asset($activeTemplateTrue . '/images/games/tail.png') }}" alt="game-image">
                            </div>
                        </div>
                        <input name="choose" type="hidden">
                    </div>
                    <div class="form-submit game-playbtn">
                        <button type="submit" id="flip" class="btn btn--gradient w-100">@lang('Play Now')</button>
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
    <link href="{{ asset('assets/global/css/game/coinflipping.min.css') }}" rel="stylesheet">
@endpush

@push('script-lib')
    <script src="{{ asset('assets/global/js/soundControl.js') }}"></script>
    <script src="{{ asset('assets/global/js/game/game.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/global/js/game/coin.js') }}"></script>
@endpush

@push('script')
    <script>
        "use strict";

        let investField = $("[name=invest]");
        let minLimit = Number("{{ $game->min_limit }}");
        let maxLimit = Number("{{ $game->max_limit }}");
        investUrl = "{{ route('user.play.invest', ['head_tail', @$isDemo]) }}";
        gameEndUrl = "{{ route('user.play.end', ['head_tail', @$isDemo]) }}";
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
    <style>
        #coin,
        .coins-wrapper,
        #coin .front,
        #coin .back,
        #coin-flip-cont,
        .flp {
            width: 200px;
            height: 200px;
        }

        @media(max-width: 991px) {

            #coin,
            .coins-wrapper,
            #coin .front,
            #coin .back,
            #coin-flip-cont,
            .flp {
                width: 300px;
                height: 300px;
            }
        }


        @media(max-width: 767px) {

            #coin,
            .coins-wrapper,
            #coin .front,
            #coin .back,
            #coin-flip-cont,
            .flp {
                width: 200px !important;
                height: 200px !important;
            }

            .headtail-body .coin-flipbox {
                width: 200px;
                height: 200px;
            }
        }

        @media(max-width: 425px) {

            #coin,
            .coins-wrapper,
            #coin .front,
            #coin .back,
            #coin-flip-cont,
            .flp {
                width: 120px !important;
                height: 120px !important;
            }

            .headtail-body .coin-flipbox {
                width: 120px;
                height: 120px;
            }
        }
    </style>
@endpush
