@extends('Template::layouts.master')
@section('content')
    <div class="row gy-5 gx-lg-5 align-items-center">
        <div class="col-lg-6">
            <div class=" game--card">
                <div class=" number-slot-wrapper">
                    <div class="number-slot-box">
                        <div class='machine position-relative'>
                            <div class='slots'>
                                <ul class='slot' id="slot1">
                                    <li class='numbers'>0</li>
                                    <li class='numbers'>1</li>
                                    <li class='numbers'>2</li>
                                    <li class='numbers'>3</li>
                                    <li class='numbers'>4</li>
                                    <li class='numbers'>5</li>
                                    <li class='numbers'>6</li>
                                    <li class='numbers'>7</li>
                                    <li class='numbers'>8</li>
                                    <li class='numbers'>9</li>
                                </ul>
                                <ul class='slot' id="slot2">
                                    <li class='numbers'>0</li>
                                    <li class='numbers'>1</li>
                                    <li class='numbers'>2</li>
                                    <li class='numbers'>3</li>
                                    <li class='numbers'>4</li>
                                    <li class='numbers'>5</li>
                                    <li class='numbers'>6</li>
                                    <li class='numbers'>7</li>
                                    <li class='numbers'>8</li>
                                    <li class='numbers'>9</li>
                                </ul>
                                <ul class='slot' id="slot3">
                                    <li class='numbers'>0</li>
                                    <li class='numbers'>1</li>
                                    <li class='numbers'>2</li>
                                    <li class='numbers'>3</li>
                                    <li class='numbers'>4</li>
                                    <li class='numbers'>5</li>
                                    <li class='numbers'>6</li>
                                    <li class='numbers'>7</li>
                                    <li class='numbers'>8</li>
                                    <li class='numbers'>9</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="headtail-wrapper game-contet__sm">
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
                            @lang('Win Amount'):
                            <span class="text--warning">
                                @lang('Single') ({{ @$game->level[0] }}%)
                            </span>
                            |
                            <span class="text--warning">
                                @lang('Double') ({{ @$game->level[1] }}%)
                            </span>
                            |
                            <span class="text--warning">
                                @lang('Triple') ({{ @$game->level[2] }}%)
                            </span>
                        </small>
                    </div>
                    <div class="form-group">
                        <input class="form--control choose-number" name="choose" type="number" min="0"
                            max="9" placeholder="@lang('Enter Number')" required>
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
    <link href="{{ asset('assets/global/css/game/slot.css') }}" rel="stylesheet">
@endpush

@push('script-lib')
    <script src="{{ asset('assets/global/js/soundControl.js') }}"></script>
    <script src="{{ asset('assets/global/js/game/game.js') }}"></script>
    <script src="{{ asset('assets/global/js/game/slot.js') }}"></script>
@endpush

@push('script')
    <script>
        "use strict";

        let investField = $("[name=invest]");
        let minLimit = Number("{{ $game->min_limit }}");
        let maxLimit = Number("{{ $game->max_limit }}");
        let currency = "{{ gs('cur_text') }}";
        investUrl = "{{ route('user.play.invest', ['number_slot', @$isDemo]) }}";
        gameEndUrl = "{{ route('user.play.end', ['number_slot', @$isDemo]) }}";
        audioAssetPath = `{{ asset('assets/audio') }}`;
        winLossPopupFooterDisplay = false;

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
        .number-slot-box .machine {
            width: 100%;
        }

        .choose-number {
            border-radius: 12px;
        }
    </style>
@endpush
