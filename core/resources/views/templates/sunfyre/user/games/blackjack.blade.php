@extends('Template::layouts.master')
@section('content')
    <div class="row justify-content-center" id="game-start-area">
        <div class="col-lg-6">
            <div class="headtail-wrapper  game-contet__sm">
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
                            <input type="number" step="any" class="form-control form--control" name="invest"
                                value="{{ old('invest') }}" placeholder="@lang('Enter amount')">
                            <button type="button" class="input-group-text minmax-btn minBtn">@lang('Min')</button>
                            <button type="button" class="input-group-text minmax-btn maxBtn">@lang('Max')</button>
                        </div>
                        <small class="fw-light mt-3 d-inline-block input-inner-note">
                            <i class="fas fa-info-circle mr-2"></i>
                            @lang('Minimum'): {{ showAmount($game->min_limit) }}
                            |
                            @lang('Maximum'): {{ showAmount($game->max_limit) }} |
                            <span class="text--warning">@lang('Win Amount')
                                {{ getAmount($game->win + 100) }} %
                            </span>
                        </small>
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

    <div class="row d-none" id="game-result-area">
        <div class="dealer-area">
            <div class="dealer-image mb-4">
                <img src="{{ asset($activeTemplateTrue . 'images/dealer.png') }}" alt="@lang('Dealer')">
                <h4>@lang('Dealer')</h4>
                <h6 class="dealer-score d-none">@lang('Dealer Score') : <span id="dealer-sum"></span></h6>
            </div>
            <div id="dealer-cards">
                <img id="hidden" src="{{ asset($activeTemplateTrue . 'images/cards/BACK.png') }}">
            </div>
        </div>

        <div class="user-area mt-5">
            <div id="user-cards"></div>
            <div class="dealer-image mt-4">
                <img src="{{ asset($activeTemplateTrue . 'images/player.png') }}" alt="@lang('Player')">
                <h4>@lang('You')</h4>
                <h6 class="user-score d-none">@lang('Your Score') : <span id="user-sum"></span></h6>
            </div>
        </div>

        <div class="action-area d-flex justify-content-center mt-4 gap-4">
            <button class="btn btn--gradient" id="hit" type="button">@lang('Hit')</button>
            <button class="btn btn--gradient" id="stay" type="button">@lang('Stay')</button>
        </div>

        <div class="back-blackjack d-flex justify-content-center d-none mt-4 gap-4">
            <a class="btn btn--gradient"
                href="{{ route('user.play.game', [$game->alias, @$isDemo]) }}">@lang('Back')</a>
            <button class="btn btn--gradient play-again-btn" data-gameLog_id="" type="button">@lang('Play Again')</button>
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
    <link href="{{ asset('assets/global/css/game/blackjack.css') }}" rel="stylesheet">
@endpush

@push('script-lib')
    <script src="{{ asset('assets/global/js/soundControl.js') }}"></script>
    <script src="{{ asset('assets/global/js/game/blackjack.js') }}"></script>
@endpush

@push('script')
    <script>
        "use strict";

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

        $('#game').on('submit', function(e) {
            e.preventDefault();
            if (!$('[name=invest]').val()) {
                notify('error', 'Invest field is required');
                return;
            }
            $('.play-btn').html('<i class="la la-gear fa-spin"></i> Processing...');
            $('.play-btn').attr('disabled', true);
            var data = $(this).serialize();
            var url = "{{ route('user.play.invest', ['blackjack', @$isDemo]) }}";
            game(data, url);
        });

        let gameLog = null;

        function resultArea(data) {
            var dealerSrc = ``;
            var userSrc = ``;
            $.each(data.cardImg, function(index, value) {
                userSrc =
                    `<img src="{{ asset($activeTemplateTrue . 'images/cards/${value}.png') }}" alt="${value}"/>`;
                $(document).find("#user-cards").append(userSrc);
            });
            $.each(data.dealerCardImg, function(index, value) {
                dealerSrc =
                    `<img src="{{ asset($activeTemplateTrue . 'images/cards/${value}.png') }}" alt="${value}"/>`;
                $(document).find("#dealer-cards").append(dealerSrc);
            });
            gameLog = data;
        }

        function hitArea(data) {
            if (data.error) {
                $(document).find("#hit").attr("disabled", 'disabled');
                notify("error", data.error);
                return false;
            }
            var userSrc = ``;
            $.each(data.cardImg, function(index, value) {
                userSrc =
                    `<img src="{{ asset($activeTemplateTrue . 'images/cards/${value}.png') }}" alt="${value}"/>`;
                $(document).find("#user-cards").append(userSrc);
            });
            gameLog = data;
        }

        $('#hit').on('click', function(e) {
            let data = gameLog;
            var url = `{{ route('user.play.end', ['blackjack', @$isDemo]) }}`;
            hitAction(url, data);
        });

        $('#stay').on('click', function(e) {
            $(document).find("#stay").attr("disabled", 'disabled');
            let gameData = gameLog;
            var url = `{{ route('user.play.end', ['blackjack', @$isDemo]) }}`;
            stayAction(url, gameData);
        });

        let gameLogId = 0;

        function stayArea(data) {
            if (data.error) {
                $(document).find("#hit").attr("disabled", 'disabled');
                notify("error", data.error);
                return false;
            }
            var hiddenImage = `{{ asset($activeTemplateTrue . 'images/cards/${data.hiddenImage}.png') }}`;
            $("#hidden").attr('src', hiddenImage);
            $('.dealer-score').removeClass('d-none');
            $('#dealer-sum').text(data.dealerSum);
            $('.user-score').removeClass('d-none');
            $('#user-sum').text(data.userSum);

            $('.action-area').addClass('d-none');
            $('.back-blackjack').removeClass('d-none');
            gameLogId = data.game_log_id;

            $(".win-loss-popup").addClass("active");
            $(".win-loss-popup__body").find("img").addClass("d-none");

            if (data.win_status == 0) {
                $(".win-loss-popup__body").find(".lose").removeClass("d-none");
            } else {
                $(".win-loss-popup__body").find(".win").removeClass("d-none");
            }
            $(".win-loss-popup__footer").find(".data-result").text(data.userSum);
        }

        $('.play-again-btn').on('click', function(e) {
            $("#game").trigger("submit");
            $("#stay").removeAttr("disabled");
            $("#hit").removeAttr("disabled");

            $('.dealer-score').addClass('d-none');
            $('.user-score').addClass('d-none');

            $('.action-area').removeClass('d-none');
            $('.back-blackjack').addClass('d-none');
            $("#dealer-cards").html('');
            $("#dealer-cards").html(
                `<img id="hidden" src="{{ asset($activeTemplateTrue . 'images/cards/BACK.png') }}">`
            );
            $("#user-cards").html('');
            $("#game-start-area").addClass("d-none");
            $("#game-result-area").removeClass("d-none");
        });
    </script>
@endpush
