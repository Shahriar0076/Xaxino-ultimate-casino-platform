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
                                                <p class="text-white">@lang("Sorry, your browser doesn't support canvas. Please try another.")</p>
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
                                    <span class="bal">{{ showAmount($balance, currencyFormat: false) }}</span>
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
                                    |
                                    <span class="text--warning">
                                        @lang('Win Amount') @if ($game->invest_back == 1)
                                            {{ getAmount($game->win + 100) }}%
                                        @else
                                            {{ getAmount($game->win) }}%
                                        @endif
                                    </span>
                                </small>
                            </div>
                            <div class="form-group justify-content-center d-flex mt-5">
                                <div class="single-select black gmimg">
                                    <img src="{{ asset($activeTemplateTrue . 'images/play/moneyblack.png') }}"
                                        alt="game-image">
                                </div>
                                <div class="single-select red gmimg">
                                    <img src="{{ asset($activeTemplateTrue . 'images/play/money.png') }}" alt="game-image">
                                </div>
                            </div>
                            <input name="choose" type="hidden">
                            <div class="mt-5 text-center">
                                <button class="cmn-btn w-100 text-center" id="flip" type="submit">@lang('Play Now')</button>
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
    <script src="{{ asset('assets/global/js/game/game.js') }}"></script>
    <script src="{{ asset('assets/global/js/game/TweenMax.min.js') }}"></script>
    <script src="{{ asset('assets/global/js/game/Winwheel.js') }}"></script>
    <script src="{{ asset('assets/global/js/game/spinFunctions.js') }}"></script>
@endpush

@push('script')
    <script>
        "use strict";

        investUrl = "{{ route('user.play.invest', ['spin_wheel', @$isDemo]) }}";
        gameEndUrl = "{{ route('user.play.end', ['spin_wheel', @$isDemo]) }}";
        audioAssetPath = `{{ asset('assets/audio') }}`;
    </script>
@endpush

@push('style')
    <style type="text/css">
        .the_wheel {
            max-width: 450px;
        }

        @media (max-width: 425px) {
            .game-details-left {
                display: -ms-flexbox;
                display: flex;
                -ms-flex-wrap: wrap;
                flex-wrap: wrap;
                justify-content: center;
                align-items: center;
                padding: 20px;
            }
        }
    </style>
@endpush
