@extends('Template::layouts.master')
@section('content')
    <section class="pt-120 pb-120">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-6">
                    <div class="card custom--card">
                        <div class="card-body">
                            <div class="keno-number-plate" id="grid">
                                @for ($i = 1; $i <= 80; $i++)
                                    <button class="slot" data-slot="{{ $i }}" number="{{ $i }}">
                                        {{ getAmount($i) }}
                                    </button>
                                @endfor
                            </div>

                            <form class="mt-5" id="kenoForm" action="" method="POST">
                                <div class="d-flex justify-content-between mb-3 flex-wrap gap-3">
                                    <button class="random-btn btn-sm" type="button">
                                        <i class="las la-random"></i> @lang('Random')
                                    </button>
                                    <button class="refresh-btn btn-sm" type="button">
                                        <i class="las la-undo-alt"></i> @lang('Refresh')
                                    </button>
                                </div>
                                <div class="form-group">
                                    <div class="input-group mb-3">
                                        <input class="form-control amount-field" name="invest" type="text"
                                            placeholder="Enter amount" autocomplete="off" required>
                                        <span class="input-group-text" id="basic-addon2">{{ __(gs('cur_text')) }}</span>
                                    </div>
                                    <small class="form-text text-muted">
                                        <i class="fas fa-info-circle mr-2"></i>
                                        @lang('Minimum'): {{ showAmount($game->min_limit) }}
                                        |
                                        @lang('Maximum'): {{ showAmount($game->max_limit) }}
                                    </small>
                                </div>
                                <button class="cmn-btn w-100 text-center" id="playBtn"
                                    type="submit">@lang('Play Now')</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card custom--card">
                        <div class="card-body">
                            <h3 class="f-size--28 mb-5 text-center">
                                {{ $isDemo ? trans('Demo Balance:') : trans('Current Balance:') }}
                                <span class="base--color">
                                    <span class="bal text-white">
                                        {{ showAmount($balance, currencyFormat: false) }}
                                    </span>
                                    {{ __(gs('cur_text')) }}
                                </span>
                            </h3>
                            <h3 class="f-size--28">@lang('How To Win')?</h3>
                            <p class="my-3">
                                @lang('Click the')
                                <span class="text--base">{{ $game->level->max_select_number }}</span>
                                @lang('number that are on your scratch off, and then click ')
                                <strong class="text--base">@lang('"play Now"')</strong>
                                @lang('button to see if you are a winner!')
                            </p>
                            <ul class="list-group list-group-flush payment-list">
                                @foreach ($game->level->levels as $item)
                                    <li class="list-group-item d-flex justify-content-between flex-wrap px-0">
                                        <span>@lang('If match '){{ getAmount($item->level) }} @lang('number')</span>
                                        <span class="text--base">{{ getAmount($item->percent) }}%</span>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="d-flex justify-content-between align-items-center mt-4">
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
    <link href="{{ asset('assets/global/css/game/keno.css') }}" rel="stylesheet">
@endpush

@push('script-lib')
    <script src="{{ asset('assets/global/js/soundControl.js') }}"></script>
@endpush

@push('script')
    <script>
        "use strict";

        let investUrl = "{{ route('user.play.invest', ['keno', @$isDemo]) }}";
        let gameEndUrl = "{{ route('user.play.end', ['keno', @$isDemo]) }}";
        let slotNumbers = [];
        let maxSelectNumber = "{{ $game->level->max_select_number }}";
        audioAssetPath = `{{ asset('assets/audio') }}`;

        $('.slot').on('click', function(e) {
            if ($('.slot').hasClass('win') || $('.slot').hasClass('loss')) {
                notify('error', 'You have to refresh number slot');
                return;
            }

            if ($(this).hasClass('active')) {
                notify('error', 'Already select this number');
                return;
            }

            let activeSlotNumber = $('.slot.active').length;
            if (activeSlotNumber >= maxSelectNumber) {
                notify('error', `You have to select max ${maxSelectNumber} number`);
                return;
            }

            var slotNumber = Number($(this).data('slot'));
            if (slotNumbers.includes(slotNumber)) {
                notify('error', `You already selected this number`);
                return;
            }
            playAudio(audioAssetPath, 'keno.wav');
            slotNumbers.push(slotNumber);
            $(this).addClass('active');
            $(this).attr('disabled', true)
        });

        $('.refresh-btn').on('click', function(e) {
            refreshSlot();
            playAudio(audioAssetPath, 'keno.wav')
        });

        $('.random-btn').on('click', function(e) {
            playAudio(audioAssetPath, 'keno.wav')
            randomSlot(3)
        });

        let totalSetTimeOut = 0;

        function randomSlot(maxLimit) {
            for (let j = 0; j < maxLimit; j++) {
                totalSetTimeOut = totalSetTimeOut + j * 100;
                setTimeout(function() {
                    refreshSlot();
                    slotNumbers = [];
                    while (slotNumbers.length < maxSelectNumber) {
                        var randomValue = Math.floor(Math.random() * 80) + 1;
                        if (!slotNumbers.includes(randomValue)) {
                            slotNumbers.push(randomValue);
                        }
                    }
                    for (let k = 0; k < maxSelectNumber; k++) {
                        var slot = $(`.slot[number="${slotNumbers[k]}"]`);
                        slot.addClass('active');
                        slot.attr('disabled', true);
                    }
                }, j * 100);
            }
        }

        function refreshSlot() {
            $('.slot').removeClass('active').removeAttr('disabled');
            $('.slot').removeClass('win');
            $('.slot').removeClass('loss');
            $('#playBtn').removeAttr('disabled')
            slotNumbers = [];
        }

        $("#kenoForm").on('submit', function(e) {
            e.preventDefault();
            totalSetTimeOut = 0;

            if ($('.slot').hasClass('win') || $('.slot').hasClass('loss')) {
                notify('error', 'You have to refresh number slot');
                return;
            }

            let data = {
                _token: "{{ csrf_token() }}",
                invest: $('[name=invest]').val(),
                choose: slotNumbers
            };
            if (data.invest < 1) {
                notify('error', 'Invest value is required');
                return;
            }
            if (slotNumbers.length != maxSelectNumber) {
                notify('error', `You have to select minimum ${maxSelectNumber} number`);
                return;
            }

            $('#playBtn').attr('disabled', true);
            $('#playBtn').html('<i class="la la-gear fa-spin"></i> Processing...');
            playAudio(audioAssetPath, 'keno_start.wav');
            isRequest = true;
            $.ajax({
                type: "POST",
                url: investUrl,
                data: data,
                success: function(response) {
                    if (response.error) {
                        audio.pause()
                        notify('error', response.error);
                        $('#playBtn').attr('disabled', false);
                        $('#playBtn').html('@lang("Play Now")');
                        return false;
                    } else {
                        randomSlot(5);
                        $('[name=invest]').val(0);
                        setTimeout(() => {
                            refreshSlot();
                            endGame(response);
                        }, totalSetTimeOut);
                    }
                    $('.bal').html(response.balance);
                }
            });
        });

        function endGame(response) {
            for (let i = 0; i < response.user_select.length; i++) {
                var slot = $(`.slot[number="${response.user_select[i]}"]`);
                if (response.match_number.length == 0) {
                    slot.addClass('loss')
                } else {
                    slot.addClass('active');
                }
                slot.attr('disabled', true);
            }
            for (let j = 0; j < response.match_number.length; j++) {
                var slot = $(`.slot[number="${response.match_number[j]}"]`);
                slot.addClass('win');
            }
            var totalMatched = response.match_number.length;
            let data = {
                _token: "{{ csrf_token() }}",
                game_log_id: response.game_log_id,
            }
            $.ajax({
                type: "POST",
                url: gameEndUrl,
                data: data,
                success: function(response) {
                    audio.pause();
                    totalSetTimeOut = 0;
                    $(".win-loss-popup").addClass("active");
                    $(".win-loss-popup__body").find("img").addClass("d-none");
                    if (response.win_status === 0) {
                        playAudio(audioAssetPath, 'lose.wav');
                        $(".win-loss-popup__body").find(".lose").removeClass("d-none");
                    } else {
                        playAudio(audioAssetPath, 'win.wav');
                        $(".win-loss-popup__body").find(".win").removeClass("d-none");
                    }
                    $(".win-loss-popup__footer").find("h2").addClass("d-none");
                    $(".win-loss-popup__footer").find('h5').text(`@lang('Total ${totalMatched} number matched')`);
                    $('.bal').html(response.bal);
                    $("#playBtn").html("Play Now");
                    $("#playBtn").removeAttr("disabled");
                    isRequest = false;
                }
            });
        }
    </script>
@endpush
