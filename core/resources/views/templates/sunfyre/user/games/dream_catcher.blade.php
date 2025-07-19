@extends('Template::layouts.master')
@section('content')
    <div class="row gy-5 gx-lg-5 align-items-center">
        <div class="col-lg-6">
            <div class="game--card">
                <div class="headtail-body">
                    <div class="wheel-wrapper">
                        <div class="arrow text-center">
                            <img src="{{ asset($activeTemplateTrue . 'images/play/down.png') }}" height="50" width="50">
                        </div>
                        <div class="wheel the_wheel text-center">
                            <canvas class="w-100" id="canvas" width="434" height="434">
                                <p class="text-white" align="center">@lang("Sorry, your browser doesn't support canvas. Please try another.")</p>
                            </canvas>
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
                        </small>
                    </div>

                    <div class="headtail-slect">
                        <div class="headtail-slect__box game-select-box" data-value="1">
                            <div class="headtail-slect__image">
                                <img src="{{ asset($activeTemplateTrue . 'images/games/dc_01.png') }}" alt="">
                            </div>
                        </div>
                        <div class="headtail-slect__box game-select-box" data-value="2">
                            <div class="headtail-slect__image">
                                <img src="{{ asset($activeTemplateTrue . 'images/games/dc_02.png') }}" alt="">
                            </div>
                        </div>

                        <div class="headtail-slect__box game-select-box" data-value="5">
                            <div class="headtail-slect__image">
                                <img src="{{ asset($activeTemplateTrue . 'images/games/dc_05.png') }}" alt="">
                            </div>
                        </div>
                        <div class="headtail-slect__box game-select-box" data-value="10">
                            <div class="headtail-slect__image">
                                <img src="{{ asset($activeTemplateTrue . 'images/games/dc_10.png') }}" alt="">
                            </div>
                        </div>
                        <div class="headtail-slect__box game-select-box" data-value="20">
                            <div class="headtail-slect__image">
                                <img src="{{ asset($activeTemplateTrue . 'images/games/dc_20.png') }}" alt="">
                            </div>
                        </div>
                        <div class="headtail-slect__box game-select-box" data-value="40">
                            <div class="headtail-slect__image">
                                <img src="{{ asset($activeTemplateTrue . 'images/games/dc_40.png') }}" alt="">
                            </div>
                        </div>
                    </div>

                    <div class="form-submit game-playbtn">
                        <button type="submit" id="playBtn" class="btn btn--gradient w-100">@lang('Play Now')</button>
                        <button class="btn btn--gradient w-100 d-none" id="reSpinBtn" type="button">@lang('Re-spin')</button>
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
    <script src="{{ asset('assets/global/js/game/TweenMax.min.js') }}"></script>
    <script src="{{ asset('assets/global/js/game/Winwheel.js') }}"></script>
    <script src="{{ asset('assets/global/js/game/dreamCatcher.js') }}"></script>
@endpush

@push('script')
    <script>
        "use strict";

        investField = $("[name=invest]");
        minLimit = Number("{{ $game->min_limit }}");
        maxLimit = Number("{{ $game->max_limit }}");
        currency = "{{ gs('cur_text') }}";
        audioAssetPath = `{{ asset('assets/audio') }}`;
        investUrl = "{{ route('user.play.invest', [$game->alias, @$isDemo]) }}";
        endUrl = "{{ route('user.play.end', [$game->alias, @$isDemo]) }}";
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
            overflow: hidden;
            border-radius: inherit;
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
            grid-template-columns: repeat(3, 1fr);
            display: grid;
            grid-gap: 20px;
        }

        @media (max-width:767px) {
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
