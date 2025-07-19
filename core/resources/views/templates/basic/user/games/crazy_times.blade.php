@extends('Template::layouts.master')
@section('content')
    <section class="pt-120 pb-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card-body h-100 middle-el">
                        <div class="cd-ft"></div>
                        <div class="game-details-left">
                            <div class="game-details-left__body">
                                <div class="spin-card">
                                    <div class="wheel-wrapper">
                                        <div class="arrow text-center">
                                            <img src="{{ asset($activeTemplateTrue . 'images/play/down.png') }}"
                                                height="50" width="50">
                                        </div>
                                        <div class="wheel the_wheel text-center">
                                            <canvas class="w-100" id="canvas" width="434" height="434">
                                                <p class="text-white" align="center">
                                                    @lang("Sorry, your browser doesn't support canvas. Please try another.")
                                                </p>
                                            </canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mt-lg-0 mt-5">
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
                                    <input class="form-control amount-field" name="invest" type="text"
                                        placeholder="Enter amount" autocomplete="off" required>
                                    <span class="input-group-text" id="basic-addon2">{{ __(gs('cur_text')) }}</span>
                                </div>
                                <small class="form-text text-muted">
                                    <i class="fas fa-info-circle mr-2"></i>
                                    @lang('Minimum'): {{ showAmount($game->min_limit + 0) }}
                                    |
                                    @lang('Maximum'): {{ showAmount($game->max_limit + 0) }}
                                </small>
                            </div>
                            <div class="headtail-slect">
                                <div class="single-select game-select-box" data-value="1">
                                    <div class="headtail-slect__image">
                                        <img src="{{ asset($activeTemplateTrue . 'images/games/1.png') }}" alt="">
                                    </div>
                                </div>
                                <div class="single-select game-select-box" data-value="2">
                                    <div class="headtail-slect__image">
                                        <img src="{{ asset($activeTemplateTrue . 'images/games/2.png') }}" alt="">
                                    </div>
                                </div>
                                <div class="single-select game-select-box" data-value="coin_flip">
                                    <div class="headtail-slect__image">
                                        <img src="{{ asset($activeTemplateTrue . 'images/games/coin_flip.png') }}"
                                            alt="">
                                    </div>
                                </div>
                                <div class="single-select game-select-box" data-value="pachinko">
                                    <div class="headtail-slect__image">
                                        <img src="{{ asset($activeTemplateTrue . 'images/games/pachinko.png') }}"
                                            alt="">
                                    </div>
                                </div>
                                <div class="single-select game-select-box" data-value="5">
                                    <div class="headtail-slect__image">
                                        <img src="{{ asset($activeTemplateTrue . 'images/games/5.png') }}" alt="">
                                    </div>
                                </div>
                                <div class="single-select game-select-box" data-value="10">
                                    <div class="headtail-slect__image">
                                        <img src="{{ asset($activeTemplateTrue . 'images/games/10.png') }}" alt="">
                                    </div>
                                </div>
                                <div class="single-select game-select-box" data-value="cash_hunt">
                                    <div class="headtail-slect__image">
                                        <img src="{{ asset($activeTemplateTrue . 'images/games/cash_hunt.png') }}"
                                            alt="">
                                    </div>
                                </div>
                                <div class="single-select game-select-box" data-value="crazy_times">
                                    <div class="headtail-slect__image">
                                        <img src="{{ asset($activeTemplateTrue . 'images/games/crazy_times.png') }}"
                                            alt="">
                                    </div>
                                </div>
                            </div>
                            <div class="mt-5 text-center">
                                <button class="cmn-btn w-100 text-center" id="playBtn" type="submit">@lang('Play Now')</button>
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

@push('script-lib')
    <script src="{{ asset('assets/global/js/soundControl.js') }}"></script>
    <script src="{{ asset('assets/global/js/game/TweenMax.min.js') }}"></script>
    <script src="{{ asset('assets/global/js/game/Winwheel.js') }}"></script>
    <script src="{{ asset('assets/global/js/game/crazyFunctions.js') }}"></script>
@endpush

@push('script')
    <script>
        "use strict";

        let choose;
        let investField = $("[name=invest]");
        let minLimit = Number("{{ $game->min_limit }}");
        let maxLimit = Number("{{ $game->max_limit }}");
        let currency = "{{ gs('cur_text') }}";
        audioAssetPath = `{{ asset('assets/audio') }}`;

        $(".minBtn").on('click', function(e) {
            playAudio(audioAssetPath, "click.mp3");
            investField.val(minLimit);
        });

        $(".maxBtn").on('click', function(e) {
            playAudio(audioAssetPath, "click.mp3");
            investField.val(maxLimit);
        });

        $(".game-select-box").on('click', function(e) {
            playAudio(audioAssetPath, "click.mp3");
        });

        $('.game-select-box').on('click', function() {
            choose = $(this).data('value');
        });

        function hasDecimalPlace(value, x) {
            var pointIndex = value.indexOf('.');
            return pointIndex >= 0 && pointIndex < value.length - x;
        }

        $('#game').on('submit', function(e) {
            e.preventDefault();
            if (!investField.val()) {
                notify('error', 'Invest amount is required')
                return;
            }
            let invest = investField.val();
            if (!choose) {
                notify('error', 'Choose option selection is required')
                return;
            }
            playAudio(audioAssetPath, "spin-wheel.mp3");
            beforeProcess();
            var data = {
                invest: invest,
                choose: choose
            };
            var url = "{{ route('user.play.invest', [$game->alias, @$isDemo]) }}";
            game(url, data);
        });

        function endGame(data) {
            var url = "{{ route('user.play.end', [$game->alias, @$isDemo]) }}";
            if (audioSound == 'true') {
                audioPause();
            }
            complete(data, url)
        }
    </script>
@endpush

@push('style')
    <style type="text/css">
        .headtail-body {
            display: flex;
            justify-content: center;
        }

        .the_wheel {
            max-width: 600px !important;
        }

        .headtail-slect {
            justify-content: space-around;
            gap: 10px;
        }

        .headtail-slect__image {
            max-width: 80px;
        }

        .headtail-slect__box {
            max-width: 150px;
            height: 100px;
            width: unset !important;
            padding: 20px;
            overflow: hidden;
        }

        .headtail-slect {
            align-items: center;
            margin-block: 40px;
            cursor: pointer;
            grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
            display: grid;
            grid-gap: 20px;
        }

        @media (max-width:991px) {
            .headtail-slect {
                grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));

            }
        }

        @media (max-width:767px) {
            .headtail-slect {
                grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));

            }

            .headtail-slect__box {
                max-width: 120px;
                height: 80px;
                width: unset !important;
            }

            .headtail-slect__image {
                font-size: 13px;
            }
        }

        @media (max-width:575px) {
            .headtail-slect {
                grid-template-columns: repeat(auto-fit, minmax(82px, 1fr));

            }

            .headtail-slect__box {
                max-width: 130px;
                height: 80px;
                width: unset !important;
            }

            .headtail-slect__image {
                font-size: 13px;
            }
        }
    </style>
@endpush
