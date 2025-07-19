@extends('Template::layouts.master')
@section('content')
    <section class="pt-120 pb-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card-body h-100 middle-el overflow-hidden">
                        <div class="game-details-left">
                            <div class="fly">
                                <div class="d-none" id="cards"></div>
                                <div class="flying text-center">
                                    <div class="card-holder">
                                        <div class="back"></div>
                                        <div class="flying-card clubs">
                                            <img class="w-100"
                                                src="{{ asset($activeTemplateTrue . 'images/play/cards/01.png') }}">
                                        </div>
                                    </div>
                                    <div class="card-holder">
                                        <div class="back"></div>
                                        <div class="flying-card clubs">
                                            <img class="w-100"
                                                src="{{ asset($activeTemplateTrue . 'images/play/cards/34.png') }}">
                                        </div>
                                    </div>
                                    <div class="card-holder">
                                        <div class="back"></div>
                                        <div class="flying-card clubs">
                                            <img class="w-100"
                                                src="{{ asset($activeTemplateTrue . 'images/play/cards/20.png') }}">
                                        </div>
                                    </div>
                                    <div class="card-holder">
                                        <div class="back"></div>
                                        <div class="flying-card clubs">
                                            <img class="w-100"
                                                src="{{ asset($activeTemplateTrue . 'images/play/cards/29.png') }}">
                                        </div>
                                    </div>
                                    <div class="card-holder">
                                        <div class="back"></div>
                                        <div class="flying-card clubs">
                                            <img class="w-100"
                                                src="{{ asset($activeTemplateTrue . 'images/play/cards/09.png') }}">
                                        </div>
                                    </div>
                                    <div class="card-holder">
                                        <div class="back"></div>
                                        <div class="flying-card clubs">
                                            <img class="w-100"
                                                src="{{ asset($activeTemplateTrue . 'images/play/cards/53.png') }}">
                                        </div>
                                    </div>
                                    <div class="card-holder">
                                        <div class="back"></div>
                                        <div class="flying-card clubs">
                                            <img class="w-100"
                                                src="{{ asset($activeTemplateTrue . 'images/play/cards/2.png') }}">
                                        </div>
                                    </div>
                                    <div class="card-holder">
                                        <div class="back"></div>
                                        <div class="flying-card clubs">
                                            <img class="w-100"
                                                src="{{ asset($activeTemplateTrue . 'images/play/cards/52.png') }}">
                                        </div>
                                    </div>
                                    <div class="card-holder">
                                        <div class="back"></div>
                                        <div class="flying-card clubs">
                                            <img class="w-100"
                                                src="{{ asset($activeTemplateTrue . 'images/play/cards/36.png') }}">
                                        </div>
                                    </div>
                                    <div class="card-holder">
                                        <div class="back"></div>
                                        <div class="flying-card clubs">
                                            <img class="w-100"
                                                src="{{ asset($activeTemplateTrue . 'images/play/cards/25.png') }}">
                                        </div>
                                    </div>
                                    <div class="card-holder">
                                        <div class="back"></div>
                                        <div class="flying-card clubs">
                                            <img class="w-100"
                                                src="{{ asset($activeTemplateTrue . 'images/play/cards/40.png') }}">
                                        </div>
                                    </div>
                                    <div class="card-holder">
                                        <div class="back"></div>
                                        <div class="flying-card clubs">
                                            <img class="w-100"
                                                src="{{ asset($activeTemplateTrue . 'images/play/cards/30.png') }}">
                                        </div>
                                    </div>
                                    <div class="card-holder">
                                        <div class="back"></div>
                                        <div class="flying-card clubs">
                                            <img class="w-100"
                                                src="{{ asset($activeTemplateTrue . 'images/play/cards/19.png') }}">
                                        </div>
                                    </div>
                                    <div class="card-holder">
                                        <div class="back"></div>
                                        <div class="flying-card clubs">
                                            <img class="w-100"
                                                src="{{ asset($activeTemplateTrue . 'images/play/cards/53.png') }}">
                                        </div>
                                    </div>
                                    <div class="card-holder">
                                        <div class="back"></div>
                                        <div class="flying-card clubs">
                                            <img class="w-100"
                                                src="{{ asset($activeTemplateTrue . 'images/play/cards/13.png') }}">
                                        </div>
                                    </div>
                                    <div class="card-holder">
                                        <div class="back"></div>
                                        <div class="flying-card clubs">
                                            <img class="w-100"
                                                src="{{ asset($activeTemplateTrue . 'images/play/cards/51.png') }}">
                                        </div>
                                    </div>
                                    <div class="card-holder">
                                        <div class="back"></div>
                                        <div class="flying-card clubs">
                                            <img class="w-100"
                                                src="{{ asset($activeTemplateTrue . 'images/play/cards/16.png') }}">
                                        </div>
                                    </div>
                                    <div class="card-holder">
                                        <div class="back"></div>
                                        <div class="flying-card clubs">
                                            <img class="w-100"
                                                src="{{ asset($activeTemplateTrue . 'images/play/cards/50.png') }}">
                                        </div>
                                    </div>
                                    <div class="card-holder">
                                        <div class="back"></div>
                                        <div class="flying-card clubs">
                                            <img class="w-100"
                                                src="{{ asset($activeTemplateTrue . 'images/play/cards/08.png') }}">
                                        </div>
                                    </div>
                                    <div class="card-holder">
                                        <div class="back"></div>
                                        <div class="flying-card clubs">
                                            <img class="w-100"
                                                src="{{ asset($activeTemplateTrue . 'images/play/cards/47.png') }}">
                                        </div>
                                    </div>
                                    <div class="card-holder">
                                        <div class="back"></div>
                                        <div class="flying-card clubs">
                                            <img class="w-100"
                                                src="{{ asset($activeTemplateTrue . 'images/play/cards/24.png') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="d-none res res-thumb-img t--60px m-0">
                                    <div class="res--card--img">
                                        <div class="back"></div>
                                        <div class="flying-card clubs resImg">
                                            <img class="w-100"
                                                src="{{ asset($activeTemplateTrue . 'images/play/cards/24.png') }}">
                                        </div>
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
                            <div class="form-group justify-content-center d-flex mt-5">
                                <div class="single-select red">
                                    <img class="red"
                                        src="{{ asset($activeTemplateTrue . 'images/play/cards/27.png') }}"
                                        alt="">
                                </div>
                                <div class="single-select black">
                                    <img class="black"
                                        src="{{ asset($activeTemplateTrue . 'images/play/cards/40.png') }}"
                                        alt="">
                                </div>
                            </div>
                            <input name="choose" type="hidden">
                            <input name="type" type="hidden" value="ht">

                            <div class="mt-5 text-center">
                                <button class="cmn-btn w-100 text-center" id="playBtn" type="submit">@lang('Play Now')</button>
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <a class="game-instruction" data-bs-toggle="modal"
                                        data-bs-target="#exampleModalCenter">
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
    <link href="{{ asset('assets/global/css/game/deck.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/global/css/game/card.css') }}" rel="stylesheet">
@endpush

@push('script-lib')
    <script src="{{ asset('assets/global/js/soundControl.js') }}"></script>
    <script src="{{ asset('assets/global/js/game/game.js') }}"></script>
    <script src="{{ asset('assets/global/js/game/deck.js') }}"></script>
    <script src="{{ asset('assets/global/js/game/deckinit.js') }}"></script>
    <script src="{{ asset('assets/global/js/game/cardgame.js') }}"></script>
@endpush

@push('script')
    <script>
        "use strict";

        let timerA;
        let imagePath = "{{ asset($activeTemplateTrue . 'images/play/cards/') }}";
        investUrl = "{{ route('user.play.invest', ['card_finding', @$isDemo]) }}";
        gameEndUrl = "{{ route('user.play.end', ['card_finding', @$isDemo]) }}";
        audioAssetPath = `{{ asset('assets/audio') }}`;
    </script>
@endpush

@push('style')
    <style type="text/css">
        .game-details-left {
            padding: 10px;
        }
    </style>
@endpush
