@extends('Template::layouts.master')
@section('content')
    @php
        $gesBon = App\Models\GuessBonus::where('alias', $game->alias)->get();
    @endphp
    <div class="row gy-5 gx-lg-5 align-items-center">
        <div class="col-lg-6">
            <div class="headtail-body">
                @include('Template::partials.game_shape')
                <div class="headtail-body__flip">
                    <div class="game-details-left number--guess">
                        <div class="game-details-left__body d-flex align-items-center">
                            <img class="vert-move-down vert down d-none"
                                src="{{ asset($activeTemplateTrue . 'images/play/Down-arrow.png') }}" height="70"
                                width="70" />
                            <img class="vert-move-up vert up d-none"
                                src="{{ asset($activeTemplateTrue . 'images/play/up-arrow.png') }}" height="70"
                                width="70" />
                            <div class="text">
                                <h2 class="custom-font base--color text-center">@lang('You Will Get') {{ $gesBon->count() }}
                                    @lang('Chances Per Game')</h2>
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
                    <span class="text bal">{{ showAmount($balance, currencyFormat: false) }}</span>
                    {{ __(gs('cur_text')) }}
                </h4>
                <form id="game" method="post">
                    @csrf
                    <div class="form-group">
                        <div class="input-group amf">
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
                            <span class="text--warning">
                                @lang('Win Bonus'): <span class="bon">{{ __(@$gesBon->first()->percent) }}%</span>
                            </span>
                        </small>
                    </div>

                    <div class="invBtn">
                        <div class="form-submit game-playbtn">
                            <button type="submit" class="btn btn--gradient w-100 my-submit-btn">@lang('Start Game')</button>
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
                    </div>
                </form>
                <form class="startGame" id="start">
                    @csrf
                    <input name="game_log_id" type="hidden">
                    <div class="numberGs numHide">
                        <div class="form-group">
                            <input class="form--control guess" name="number" type="number"
                                placeholder="@lang('Guess The Number')" autocomplete="off">
                        </div>
                        <div class="form-submit game-playbtn">
                            <button class="btn btn--gradient gmg w-100" type="submit">@lang('Guess The Number')</button>
                        </div>
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

@push('style')
    <link href="{{ asset('assets/global/css/game/guess.css') }}" rel="stylesheet">
@endpush

@push('script-lib')
    <script src="{{ asset('assets/global/js/soundControl.js') }}"></script>
    <script src="{{ asset('assets/global/js/game/game.js') }}"></script>
    <script src="{{ asset('assets/global/js/game/guess.js') }}"></script>
@endpush


@push('script')
    <script>
        "use strict";

        let investField = $("[name=invest]");
        let minLimit = Number("{{ $game->min_limit }}");
        let maxLimit = Number("{{ $game->max_limit }}");
        let currency = "{{ gs('cur_text') }}";
        investUrl = "{{ route('user.play.invest', ['number_guess', @$isDemo]) }}";
        gameEndUrl = "{{ route('user.play.end', ['number_guess', @$isDemo]) }}";
        audioAssetPath = `{{ asset('assets/audio') }}`;
        bon = {{ @$gesBon->first()->percent }};

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
