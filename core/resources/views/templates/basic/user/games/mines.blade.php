@extends('Template::layouts.master')
@section('content')
    <section class="pt-120 pb-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mt-lg-0 mt-5">
                    <div class="card custom--card">
                        <div class="card-body">
                            <div class="mine-box-wrapper">
                                @for ($i = 1; $i <= 25; $i++)
                                    <div class="mine-box mineBox gold-box" id="mine{{ $i }}">
                                        <div class="mine-box-wrapper">
                                            <div class="mine-box-front">
                                                <img src="{{ asset($activeTemplateTrue . 'images/mines/box.png') }}"
                                                    alt="@lang('image')">
                                            </div>
                                            <div class="mine-box-hidden"></div>
                                        </div>
                                    </div>
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
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
                            <div class="form-group">
                                <label>@lang('Bet Amount')</label>
                                <div class="input-group">
                                    <span class="input-group-text">{{ gs('cur_sym') }}</span>
                                    <input type="number" step="any" class="form-control form--control" name="invest">
                                    <button type="button" class="input-group-text minmax-btn minBtn">
                                        @lang('Min')
                                    </button>
                                    <button type="button" class="input-group-text minmax-btn maxBtn">
                                        @lang('Max')
                                    </button>
                                </div>
                                <div class="d-flex justify-content-between align-items-center gap-3">
                                    <small class="form-text text-muted">
                                        <i class="fas fa-info-circle mr-2"></i>
                                        @lang('Minimum'): {{ showAmount($game->min_limit) }}
                                        |
                                        @lang('Maximum'): {{ showAmount($game->max_limit) }}
                                    </small>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>@lang('Number of Mines')</label>
                                <input type="number" class="form-control form--control" name="mines" min="1"
                                    max="20">
                            </div>
                            <button type="button" class="cmn-btn w-100 betBtn">@lang('Start Game')</button>
                            <button type="button"
                                class="cmn-btn-success w-100 d-none cashoutBtn">@lang('Cashout')</button>
                            <div class="text-center">
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
    <script src="{{ asset('assets/global/js/game/mines.js') }}"></script>

    <script>
        "use strict";
        let minLimit = Number("{{ $game->min_limit }}");
        let maxLimit = Number("{{ $game->max_limit }}");
        let currency = "{{ gs('cur_text') }}";
        let userBalance = Number("{{ $balance }}");
        audioAssetPath = `{{ asset('assets/audio') }}`;

        $(".minBtn").on('click', function(e) {
            playAudio(audioAssetPath, "click.mp3");
            investField.val(minLimit);
        });

        $(".maxBtn").on('click', function(e) {
            playAudio(audioAssetPath, "click.mp3");
            investField.val(maxLimit);
        });

        $('.betBtn').on('click', function(e) {
            let invest = investField.val();
            let mines = minesField.val();

            if (!invest) {
                notify('error', `Amount field is required`);
                return;
            }
            if (!mines) {
                notify('error', `Mines field is required`);
                return;
            }

            if (minLimit > invest) {
                notify('error', `Minimum bet amount is ${minLimit} `);
                return;
            }

            if (invest > maxLimit) {
                notify('error', `Maximum bet amount is ${minLimit} `);
                return;
            }

            if (mines > 20) {
                notify('error', `Maximum mines amount is 20`);
                return;
            }

            if (invest > userBalance) {
                notify('error', `You have no sufficient balance`);
                return;
            }
            playAudio(audioAssetPath, "start.mp3");

            betBtn.prop('disabled', true);
            betBtn.addClass('d-none');

            let url = "{{ route('user.play.invest', ['mines', @$isDemo]) }}";
            let data = {
                _token: "{{ csrf_token() }}",
                invest: invest,
                mines: mines
            }
            game(url, data);
        });

        $('.mineBox').on('click', function(e) {
            playAudio(audioAssetPath, "click.mp3");
            let mineUrl = "{{ route('user.play.end', ['mines', @$isDemo]) }}";
            let mineData = {
                _token: "{{ csrf_token() }}",
                game_log_id: gameLogId,
                type: 'mine'
            }
            mineBox = $(this);
            gameEnd(mineUrl, mineData);
        });

        $('.cashoutBtn').on('click', function(e) {
            let cashoutUrl = "{{ route('user.play.end', ['mines', @$isDemo]) }}";
            let cashoutData = {
                _token: "{{ csrf_token() }}",
                game_log_id: gameLogId,
                type: 'cashout'
            }
            cashout(cashoutUrl, cashoutData);
        });
    </script>
@endpush

@push('style')
    <style>
        .minmax-btn {
            position: relative;
        }

        .minmax-btn:not(:last-child)::after {
            content: "";
            position: absolute;
            height: 20px;
            width: 1px;
            background-color: #01162f;
            top: 50%;
            transform: translateY(-50%);
            right: 0;
        }
    </style>
@endpush
