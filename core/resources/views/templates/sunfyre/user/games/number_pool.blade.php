@extends('Template::layouts.master')
@section('content')
    <div class="row gy-5 gx-lg-5 align-items-center">
        <div class="col-lg-6">
            <div class="headtail-body">
                <div class="game--card pool--card">
                    <div class="game-details-left fly">
                        <div class="game-details-left__body">
                            <div class="alt"></div>
                            <div id="slot-view">
                                <div id="ball-1">
                                    <div class="poolNumber">1</div>
                                </div>
                                <div id="ball-2">
                                    <div class="poolNumber">2</div>
                                </div>
                                <div id="ball-3">
                                    <div class="poolNumber">3</div>
                                </div>
                                <div id="ball-4">
                                    <div class="poolNumber">4</div>
                                </div>
                                <div id="ball-5">
                                    <div class="poolNumber">5</div>
                                </div>
                                <div id="ball-6">
                                    <div class="poolNumber">6</div>
                                </div>
                                <div id="ball-7">
                                    <div class="poolNumber">7</div>
                                </div>
                                <div id="ball-8">
                                    <div class="poolNumber">8</div>
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
                            <span class="text--warning">@lang('Win Amount')
                                @if ($game->invest_back == 1)
                                    {{ getAmount($game->win + 100) }}%
                                @else
                                    {{ getAmount($game->win) }}%
                                @endif
                            </span>
                        </small>
                    </div>

                    <div class="poolselect-wrapper">
                        <div class="poolselect-box game-select-box ">
                            <div class="poolselect-box__image pool pool-01">
                                <img class="gmimg pool-01" src="{{ asset($activeTemplateTrue . 'images/games/pool1.png') }}"
                                    alt="@lang('image')">
                            </div>
                        </div>
                        <div class="poolselect-box game-select-box ">
                            <div class="poolselect-box__image pool pool-02">
                                <img class="gmimg pool-02"
                                    src="{{ asset($activeTemplateTrue . 'images/games/pool2.png') }}"
                                    alt="@lang('image')">
                            </div>
                        </div>
                        <div class="poolselect-box game-select-box">
                            <div class="poolselect-box__image pool pool-03">
                                <img class="gmimg pool-03"
                                    src="{{ asset($activeTemplateTrue . 'images/games/pool3.png') }}"
                                    alt="@lang('image')">
                            </div>
                        </div>
                        <div class="poolselect-box game-select-box  ">
                            <div class="poolselect-box__image pool pool-04">
                                <img class="gmimg pool-04"
                                    src="{{ asset($activeTemplateTrue . 'images/games/pool4.png') }}"
                                    alt="@lang('image')">
                            </div>
                        </div>
                        <div class="poolselect-box game-select-box">
                            <div class="poolselect-box__image pool pool-05">
                                <img class="gmimg pool-05"
                                    src="{{ asset($activeTemplateTrue . 'images/games/pool5.png') }}"
                                    alt="@lang('image')">
                            </div>
                        </div>
                        <div class="poolselect-box game-select-box">
                            <div class="poolselect-box__image pool pool-05">
                                <img class="gmimg pool-05"
                                    src="{{ asset($activeTemplateTrue . 'images/games/pool6.png') }}"
                                    alt="@lang('image')">
                            </div>
                        </div>
                        <div class="poolselect-box game-select-box">
                            <div class="poolselect-box__image pool pool-07">
                                <img class="gmimg pool-07"
                                    src="{{ asset($activeTemplateTrue . 'images/games/pool7.png') }}"
                                    alt="@lang('image')">
                            </div>
                        </div>
                        <div class="poolselect-box game-select-box">
                            <div class="poolselect-box__image pool pool-08">
                                <img class="gmimg pool-08"
                                    src="{{ asset($activeTemplateTrue . 'images/games/pool8.png') }}"
                                    alt="@lang('image')">
                            </div>
                        </div>
                        <input name="choose" type="hidden">
                    </div>
                    <div class="form-submit game-playbtn">
                        <button type="submit" class="btn btn--gradient w-100">@lang('Play Now')</button>
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
    <link href="{{ asset('assets/global/css/game/pool.css') }}" rel="stylesheet">
@endpush

@push('script')
    <script src="{{ asset('assets/global/js/soundControl.js') }}"></script>
    <script src="{{ asset('assets/global/js/game/game.js') }}"></script>
    <script src="{{ asset('assets/global/js/game/pool.js') }}"></script>

    <script>
        "use strict";

        let investField = $("[name=invest]");
        let minLimit = Number("{{ $game->min_limit }}");
        let maxLimit = Number("{{ $game->max_limit }}");
        let currency = "{{ gs('cur_text') }}";
        investUrl = "{{ route('user.play.invest', ['number_pool', @$isDemo]) }}";
        gameEndUrl = "{{ route('user.play.end', ['number_pool', @$isDemo]) }}";
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
        @media(max-width: 1400px) {
            .headtail-body__shape {
                display: none;
            }

            .headtail-body__flip {
                position: static;
                height: auto;
                width: auto;
                transform: translate(0, 0);
                background-color: hsl(var(--black));
                border-radius: 12px;
                border: 1px solid hsl(var(--white) / .1);
                border-top: 5px solid hsl(var(--base));
            }
        }

        .fly {
            height: 554px;
        }

        .pool--card {
            overflow: hidden;
            position: relative;
        }

        .game-details-left {
            display: -ms-flexbox;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            background-color: transparent;
            border-radius: 8px;
            min-height: 100%;
            position: relative;
            width: 100%;
        }
    </style>
@endpush
