@extends('Template::layouts.master')
@section('content')
    <section class="pt-120 pb-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card-body h-100 middle-el">
                        <div class="alt"></div>
                        <div class="game-details-left">
                            <div class="game-details-left__body">
                                <div class="flp">
                                    <div id="coin-flip-cont">
                                        <div class="flipcoin" id="coin">
                                            <div class="flpng coins-wrapper">
                                                <div class="front">
                                                    <img src="{{ asset($activeTemplateTrue . 'images/play/head.png') }}"
                                                        alt="">
                                                </div>
                                                <div class="back">
                                                    <img src="{{ asset($activeTemplateTrue . 'images/play/tail.png') }}"
                                                        alt="">
                                                </div>
                                            </div>
                                            <div class="headCoin d-none">
                                                <div class="front">
                                                    <img src="{{ asset($activeTemplateTrue . 'images/play/head.png') }}"
                                                        alt="">
                                                </div>
                                                <div class="back">
                                                    <img src="{{ asset($activeTemplateTrue . 'images/play/tail.png') }}"
                                                        alt="">
                                                </div>
                                            </div>
                                            <div class="tailCoin d-none">
                                                <div class="front">
                                                    <img src="{{ asset($activeTemplateTrue . 'images/play/tail.png') }}"
                                                        alt="">
                                                </div>
                                                <div class="back">
                                                    <img src="{{ asset($activeTemplateTrue . 'images/play/head.png') }}"
                                                        alt="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="cd-ft"></div>
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
                                        value="{{ old('invest') }}" placeholder="@lang('Enter amount')" autocomplete="off">
                                    <span class="input-group-text" id="basic-addon2">{{ __(gs('cur_text')) }}</span>
                                </div>
                                <small class="form-text text-muted">
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
                            <div class="form-group justify-content-center d-flex mt-5">
                                <div class="single-select head gmimg">
                                    <img src="{{ asset($activeTemplateTrue . '/images/play/head.png') }}" alt="game-image">
                                </div>
                                <div class="single-select tail gmimg">
                                    <img src="{{ asset($activeTemplateTrue . '/images/play/tail.png') }}" alt="game-image">
                                </div>
                                <input name="choose" type="hidden">
                            </div>
                            <div class="mt-5 text-center">
                                <div class="d-flex gap-2">
                                    <button class="cmn-btn w-100 game text-center" id="flip" type="submit">
                                        @lang('Play Now')
                                    </button>
                                </div>
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
        investUrl = "{{ route('user.play.invest', ['head_tail', @$isDemo]) }}";
        gameEndUrl = "{{ route('user.play.end', ['head_tail', @$isDemo]) }}";
        audioAssetPath = `{{ asset('assets/audio') }}`;
    </script>
@endpush
