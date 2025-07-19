@extends('Template::layouts.master')
@php
    $gesBon = App\Models\GuessBonus::where('alias', $game->alias)
        ->orderBy('chance', 'asc')
        ->pluck('percent')
        ->toArray();
@endphp
@section('content')
    <section class="pt-120 pb-120">
        <div class="container">
            <div class="row gy-4">
                <div class="col-xl-9" id="game--card">
                    <div class="card poker-card">
                        <div class="card-body">
                            <div class="row align-items-center gy-4">
                                <div class="col-md-3">
                                    <div class="card-item">
                                        <div class="card-item__thumb">
                                            <img src="{{ asset($activeTemplateTrue . 'images/poker/royal_flush.png') }}"
                                                alt="@lang('image')">
                                        </div>
                                        <div class="card-item__text">
                                            <span class="card-item__icon"> <i class="las la-times"></i></span>
                                            {{ getAmount($gesBon[0]) }}@lang('%')
                                        </div>
                                    </div>
                                    <div class="card-item">
                                        <div class="card-item__thumb">
                                            <img src="{{ asset($activeTemplateTrue . 'images/poker/straight_flush.png') }}"
                                                alt="@lang('image')">
                                        </div>
                                        <div class="card-item__text">
                                            <span class="card-item__icon"> <i class="las la-times"></i></span>
                                            {{ getAmount($gesBon[1]) }}@lang('%')
                                        </div>
                                    </div>
                                    <div class="card-item">
                                        <div class="card-item__thumb">
                                            <img src="{{ asset($activeTemplateTrue . 'images/poker/four_kind.png') }}"
                                                alt="@lang('image')">
                                        </div>
                                        <div class="card-item__text">
                                            <span class="card-item__icon"> <i class="las la-times"></i></span>
                                            {{ getAmount($gesBon[2]) }}@lang('%')
                                        </div>
                                    </div>
                                    <div class="card-item">
                                        <div class="card-item__thumb">
                                            <img src="{{ asset($activeTemplateTrue . 'images/poker/full_house.png') }}"
                                                alt="@lang('image')">
                                        </div>
                                        <div class="card-item__text">
                                            <span class="card-item__icon"> <i class="las la-times"></i></span>
                                            {{ getAmount($gesBon[3]) }}@lang('%')
                                        </div>
                                    </div>
                                    <div class="card-item">
                                        <div class="card-item__thumb">
                                            <img src="{{ asset($activeTemplateTrue . 'images/poker/flash.png') }}"
                                                alt="@lang('image')">
                                        </div>
                                        <div class="card-item__text">
                                            <span class="card-item__icon"> <i class="las la-times"></i></span>
                                            {{ getAmount($gesBon[4]) }}@lang('%')
                                        </div>
                                    </div>
                                    <div class="card-item">
                                        <div class="card-item__thumb">
                                            <img src="{{ asset($activeTemplateTrue . 'images/poker/straight.png') }}"
                                                alt="@lang('image')">
                                        </div>
                                        <div class="card-item__text">
                                            <span class="card-item__icon"> <i class="las la-times"></i></span>
                                            {{ getAmount($gesBon[5]) }}@lang('%')
                                        </div>
                                    </div>
                                    <div class="card-item">
                                        <div class="card-item__thumb">
                                            <img src="{{ asset($activeTemplateTrue . 'images/poker/three_kind.png') }}"
                                                alt="@lang('image')">
                                        </div>
                                        <div class="card-item__text">
                                            <span class="card-item__icon"> <i class="las la-times"></i></span>
                                            {{ getAmount($gesBon[6]) }}@lang('%')
                                        </div>
                                    </div>
                                    <div class="card-item">
                                        <div class="card-item__thumb">
                                            <img src="{{ asset($activeTemplateTrue . 'images/poker/two_pair.png') }}"
                                                alt="@lang('image')">
                                        </div>
                                        <div class="card-item__text">
                                            <span class="card-item__icon"> <i class="las la-times"></i></span>
                                            {{ getAmount($gesBon[7]) }}@lang('%')
                                        </div>
                                    </div>
                                    <div class="card-item">
                                        <div class="card-item__thumb">
                                            <img src="{{ asset($activeTemplateTrue . 'images/poker/one_pair.png') }}"
                                                alt="@lang('image')">
                                        </div>
                                        <div class="card-item__text">
                                            <span class="card-item__icon"> <i class="las la-times"></i></span>
                                            {{ getAmount($gesBon[8]) }}@lang('%')
                                        </div>
                                    </div>
                                    <div class="card-item">
                                        <div class="card-item__thumb">
                                            <img src="{{ asset($activeTemplateTrue . 'images/poker/high_card.png') }}"
                                                alt="@lang('image')">
                                        </div>
                                        <div class="card-item__text">
                                            <span class="card-item__icon"> <i class="las la-times"></i></span>
                                            {{ getAmount($gesBon[9]) }}@lang('%')
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="poker-card-table">
                                        <div class="poker-table">
                                            <div class="poker-table__wrapper">
                                                <div class="poker-table__thumb">
                                                    <img src="{{ asset($activeTemplateTrue . 'images/cards/BACK.png') }}"
                                                        alt="@lang('image')">
                                                </div>
                                                <div class="poker-table__thumb">
                                                    <img src="{{ asset($activeTemplateTrue . 'images/cards/BACK.png') }}"
                                                        alt="@lang('image')">
                                                </div>
                                                <div class="poker-table__thumb">
                                                    <img src="{{ asset($activeTemplateTrue . 'images/cards/BACK.png') }}"
                                                        alt="@lang('image')">
                                                </div>
                                                <div class="poker-table__thumb">
                                                    <img src="{{ asset($activeTemplateTrue . 'images/cards/BACK.png') }}"
                                                        alt="@lang('image')">
                                                </div>
                                                <div class="poker-table__thumb">
                                                    <img src="{{ asset($activeTemplateTrue . 'images/cards/BACK.png') }}"
                                                        alt="@lang('image')">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="poker-card__bottom refresh-area">
                                            <button class="cmn--btn refreshBtn" type="button">
                                                <div class="cmn--btn-border"></div>
                                                @lang('Refresh')
                                            </button>
                                        </div>

                                        <div class="poker-card__bottom deal-area">
                                            <button class="cmn--btn dealBtn" type="button">
                                                @lang('DEAL')
                                            </button>
                                        </div>

                                        <div class="poker-card__bottom action-area">
                                            <button class="cmn--btn text--success callBtn" type="button">
                                                @lang('CALL')
                                            </button>
                                            <button class="cmn--btn text--danger foldBtn" type="button">
                                                @lang('FOLD')
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-xl-3" id="form--area">
                    <div class="card custom--card">
                        <div class="card-body">
                            <h3 class="f-size--28 mb-4 text-center">
                                {{ $isDemo ? trans('Demo Balance:') : trans('Current Balance:') }}
                                <span class="base--color">
                                    <span
                                        class="balance text-white">{{ showAmount($balance, currencyFormat: false) }}</span>
                                    {{ __(gs('cur_text')) }}
                                </span>
                            </h3>
                            <form id="game" method="post">
                                @csrf
                                <div class="form-group">
                                    <div class="input-group mb-3">
                                        <input class="form-control" name="invest" type="number" step="any"
                                            value="{{ old('invest') }}" placeholder="@lang('Enter amount')"
                                            autocomplete="off">
                                        <span class="input-group-text">{{ __(gs('cur_text')) }}</span>
                                    </div>
                                    <small class="form-text text-muted"><i class="fas fa-info-circle mr-2"></i>
                                        @lang('Invest Limit')
                                        : {{ showAmount($game->min_limit) }} - {{ showAmount($game->max_limit) }}
                                    </small>
                                </div>
                                <button class="cmn-btn w-100 investBtn" id="flip"
                                    type="submit">@lang('Play Now')</button>
                            </form>
                            <div class="text-center">
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
                        </div>
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

@push('script')
    <script src="{{ asset('assets/global/js/soundControl.js') }}"></script>
    <script src="{{ asset('assets/global/js/game/poker.js') }}"></script>

    <script>
        "use strict";
        let userBalance = Number("{{ $balance }}");
        let minLimit = Number("{{ $game->min_limit }}");
        let maxLimit = Number("{{ $game->max_limit }}");
        let currency = "{{ gs('cur_text') }}";
        audioAssetPath = `{{ asset('assets/audio') }}`;

        $('#game').on('submit', function(e) {
            e.preventDefault();
            invest = investField.val();
            if (!invest) {
                notify('error', 'Invest field is required');
                return;
            }
            if (minLimit > invest) {
                notify('error', `Minimum invest is ${minLimit} ${currency}`);
                return;
            }
            if (invest > maxLimit) {
                notify('error', `Maximum invest is ${maxLimit} ${currency}`);
                return;
            }
            if (invest > userBalance) {
                notify('error', 'You have no sufficent balance');
                return;
            }

            let previousId = localStorage.getItem("sessionId");
            if (previousId) {
                notify('error', 'Please refresh the card');
                return;
            }

            investBtn.addClass("d-none")
            let investUrl = "{{ route('user.play.invest', [$game->alias, @$isDemo]) }}";
            let data = {
                _token: "{{ csrf_token() }}",
                invest: invest
            };
            game(investUrl, data)
        });

        $('.dealBtn').on('click', function(e) {
            playAudio(audioAssetPath, "click.mp3");
            if (!gameLogId) {
                notify('error', 'Invalid request');
            }
            let dealUrl = "{{ route('user.play.end', [$game->alias, @$isDemo]) }}";
            let dealData = {
                _token: "{{ csrf_token() }}",
                game_log_id: gameLogId,
                type: "deal"
            }
            deal(dealUrl, dealData);
        });

        $('.callBtn').on('click', function(e) {
            playAudio(audioAssetPath, "click.mp3");
            if (!gameLogId) {
                notify('error', 'Invalid request');
            }
            $(this).prop('disabled', true);
            let callUrl = "{{ route('user.play.end', [$game->alias, @$isDemo]) }}";
            let callData = {
                _token: "{{ csrf_token() }}",
                game_log_id: gameLogId,
                type: "call"
            }
            call(callUrl, callData);
        });
        $('.foldBtn').on('click', function(e) {
            playAudio(audioAssetPath, "click.mp3");
            if (!gameLogId) {
                notify('error', 'Invalid request');
            }
            $(this).prop('disabled', true);
            let foldUrl = "{{ route('user.play.end', [$game->alias, @$isDemo]) }}";
            let foldData = {
                _token: "{{ csrf_token() }}",
                game_log_id: gameLogId,
                type: "fold"
            }
            fold(foldUrl, foldData);
        });
    </script>
@endpush
