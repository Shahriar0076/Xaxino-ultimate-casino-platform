@extends('Template::layouts.master')
@section('content')
    <div class="row gy-5 gx-lg-5 align-items-center">
        <div class="col-lg-6">
            <div class="headtail-body">
                @include('Template::partials.game_shape')
                <div class="headtail-body__flip">
                    <div class="sld">
                        <div class="imgs sld-wrapper position-relative text-center">
                            <div class="img1">
                                <img src="{{ asset($activeTemplateTrue . 'images/games/rock.png') }}">
                            </div>
                            <div class="img2 op-0">
                                <img src="{{ asset($activeTemplateTrue . 'images/games/paper.png') }}">
                            </div>
                            <div class="img3 op-0">
                                <img src="{{ asset($activeTemplateTrue . 'images/games/scissors.png') }}">
                            </div>
                        </div>
                        <div class="result d-none align-items-center text-center">
                            <div class="">
                                <img class="im-1" src="{{ asset($activeTemplateTrue . 'images/games/rock.png') }}">
                            </div>
                            <h1 class="opac-0 vs-title">@lang('VS')</h1>
                            <div class="">
                                <img class="im-2 opac-0" src="{{ asset($activeTemplateTrue . 'images/games/paper.png') }}">
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
                    <div class="headtail-slect">
                        <div class="rockselect-box game-select-box single-select rock">
                            <div class="headtail-slect__image">
                                <img src="{{ asset($activeTemplateTrue . '/images/games/rock.pn') }}g" alt="game-image">
                            </div>
                        </div>
                        <div class="rockselect-box game-select-box single-select paper">
                            <div class="headtail-slect__image">
                                <img src="{{ asset($activeTemplateTrue . '/images/games/paper.png') }}" alt="game-image">
                            </div>
                        </div>
                        <div class="rockselect-box game-select-box single-select scissors">
                            <div class="headtail-slect__image">
                                <img src="{{ asset($activeTemplateTrue . '/images/games/scissors.png') }}"
                                    alt="game-image">
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



@push('script-lib')
    <script src="{{ asset('assets/global/js/soundControl.js') }}"></script>
    <script src="{{ asset('assets/global/js/game/game.js') }}"></script>
    <script src="{{ asset('assets/global/js/game/rockpaper.js') }}"></script>
@endpush

@push('script')
    <script>
        "use strict";

        let investField = $("[name=invest]");
        let minLimit = Number("{{ $game->min_limit }}");
        let maxLimit = Number("{{ $game->max_limit }}");
        let currency = "{{ gs('cur_text') }}";
        img1 = '{{ asset($activeTemplateTrue . 'images/play/rock.png') }}';
        img2 = '{{ asset($activeTemplateTrue . 'images/play/paper.png') }}';
        img3 = '{{ asset($activeTemplateTrue . 'images/play/scissors.png') }}';
        imgObj = {
            img1,
            img2,
            img3
        };
        investUrl = "{{ route('user.play.invest', ['rock_paper_scissors', @$isDemo]) }}";
        gameEndUrl = "{{ route('user.play.end', ['rock_paper_scissors', @$isDemo]) }}";
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
        .result {
            display: flex;
        }

        .game-details-left {
            border-radius: 5px;
        }

        .img1 {
            position: relative;
        }

        .img2 {
            position: absolute;
            height: 100%;
            width: 100%;
            left: 0;
            top: 0;
        }

        .img3 {
            position: absolute;
            height: 100%;
            width: 100%;
            left: 0;
            top: 0;
        }

        .op-1 {
            opacity: 1;
        }

        .op-0 {
            opacity: 0;
        }

        .vs-title {
            font-size: 20px;
        }

        .game-details-left {
            padding: 30px 10px;
        }

        @media screen and (min-width:576px) {
            .vs-title {
                font-size: 30px;
            }

            .game-details-left {
                padding: 50px;
            }
        }

        @media (max-width:424px) {
            .imgs.sld-wrapper {
                max-width: 171px;
            }

            .headtail-slect__image img {
                max-width: 80px;
                width: unset !important;
            }
        }
    </style>
@endpush
