@extends('Template::layouts.master')
@section('content')
    <div class="row gy-5 gx-lg-5 align-items-center">
        <div class="col-lg-6">
            <div class="card custom--card game--card">
                <div class="card-body p-0">
                    <div class="game-details-left overflow-hidden">
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
                        <div class="headtail-slect__box game-select-box single-select red">
                            <div class="card-box-image">
                                <img class="red" src="{{ asset($activeTemplateTrue . 'images/play/cards/27.png') }}"
                                    alt="">
                            </div>
                        </div>
                        <div class="headtail-slect__box game-select-box single-select black">
                            <div class="card-box-image">
                                <img class="black" src="{{ asset($activeTemplateTrue . 'images/play/cards/40.png') }}"
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
        let investField = $("[name=invest]");
        let minLimit = Number("{{ $game->min_limit }}");
        let maxLimit = Number("{{ $game->max_limit }}");
        let currency = "{{ gs('cur_text') }}";
        let imagePath = "{{ asset($activeTemplateTrue . 'images/play/cards/') }}";
        investUrl = "{{ route('user.play.invest', ['card_finding', @$isDemo]) }}";
        gameEndUrl = "{{ route('user.play.end', ['card_finding', @$isDemo]) }}";
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
