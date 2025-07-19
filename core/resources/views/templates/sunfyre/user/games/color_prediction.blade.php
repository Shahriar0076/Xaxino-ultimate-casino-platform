@extends('Template::layouts.master')
@section('content')
    <section class="pt-120 pb-120">
        <div class="container">
            <div class="row justify-content-center gy-4">
                <div class="col-lg-6">
                    <div class="game--card">
                        <form method="POST" id="colorFormSubmit">
                            @csrf
                            <div class="color-predict-bar-wrapper">
                                <span class="color-predict-result d-none">
                                    <span class="title">@lang('Result')</span>
                                    <p class="text-inner result-area d-none">
                                        <span class="text show-result" style="--bar-color: 46, 75%, 57%;"></span>
                                    </p>
                                </span>
                                <div class="color-predict-bar">
                                    <p class="h-100 w-100">
                                        <span style="--bar-color: 281, 100%, 34%;">@lang('0')</span>
                                    </p>
                                    <p class="h-100 w-100">
                                        <span style="--bar-color: 133, 100%, 34%;">@lang('1')</span>
                                    </p>
                                    <p class="h-100 w-100">
                                        <span style="--bar-color: 0, 73%, 56%;">@lang('2')</span>
                                    </p>
                                    <p class="h-100 w-100">
                                        <span style="--bar-color: 133, 100%, 34%;">@lang('3')</span>
                                    </p>
                                    <p class="h-100 w-100">
                                        <span style="--bar-color: 0, 73%, 56%;">@lang('4')</span>
                                    </p>
                                    <p class="h-100 w-100">
                                        <span style="--bar-color: 281, 100%, 34%;">@lang('5')</span>
                                    </p>
                                    <p class="h-100 w-100">
                                        <span style="--bar-color: 0, 73%, 56%">@lang('6')</span>
                                    </p>
                                    <p class="h-100 w-100">
                                        <span style="--bar-color: 133, 100%, 34%;">@lang('7')</span>
                                    </p>
                                    <p class="h-100 w-100">
                                        <span style="--bar-color: 0, 73%, 56%">@lang('8')</span>
                                    </p>
                                    <p class="h-100 w-100">
                                        <span style="--bar-color: 133, 100%, 34%;">@lang('9')</span>
                                    </p>
                                    <p class="h-100 w-100">
                                        <span style="--bar-color: 0, 73%, 56%;">@lang('0')</span>
                                    </p>
                                    <p class="h-100 w-100">
                                        <span style="--bar-color: 133, 100%, 34%;">@lang('5')</span>
                                    </p>
                                </div>
                            </div>
                            <div class="color-predict-top">
                                <div class="color-predict-left">
                                    <p class="color-predict-title">
                                        {{ $isDemo ? trans('Demo Balance:') : trans('Current Balance:') }}
                                    </p>
                                    <h5 class="color-predict-text">
                                        {{ showAmount($balance, currencyFormat: false) }}
                                        <span class="text--base">{{ __(gs('cur_text')) }}</span>
                                    </h5>
                                </div>
                            </div>
                            <div class="color-predict-inner style-two">
                                <label class="color-predict-item style-two" for="predict1"
                                    style="--color-predict: #00ab26;">
                                    @lang('GREEN')
                                    <input type="radio" name="choose" id="predict1" value="green">
                                </label>
                                <label class="color-predict-item style-two" for="predict2"
                                    style="--color-predict: #7400ab;">
                                    @lang('VIOLET')
                                    <input type="radio" name="choose" id="predict2" value="violet">
                                </label>
                                <label class="color-predict-item style-two" for="predict3"
                                    style="--color-predict: #e03c3c;">
                                    @lang('RED')
                                    <input type="radio" name="choose" id="predict3" value="red">
                                </label>
                            </div>
                            <div class="color-predict-inner">
                                <label class="color-predict-item predict-gradient" for="predict5">
                                    0
                                    <input type="radio" name="choose" value="0" id="predict5">
                                </label>
                                <label class="color-predict-item" for="predict4">
                                    @lang('1')
                                    <input type="radio" name="choose" value="1" id="predict4">
                                </label>
                                <label class="color-predict-item" for="predict6">
                                    @lang('2')
                                    <input type="radio" name="choose" value="2" id="predict6">
                                </label>
                                <label class="color-predict-item" for="predict7">
                                    @lang('3')
                                    <input type="radio" name="choose" value="3" id="predict7">
                                </label>
                                <label class="color-predict-item" for="predict8">
                                    @lang('4')
                                    <input type="radio" name="choose" value="4" id="predict8">
                                </label>
                                <label class="color-predict-item predict-gradient" for="predict9">
                                    @lang('5')
                                    <input type="radio" name="choose" value="5" id="predict9">
                                </label>
                                <label class="color-predict-item" for="predict10">
                                    @lang('6')
                                    <input type="radio" name="choose" value="6" id="predict10">
                                </label>
                                <label class="color-predict-item" for="predict11">
                                    @lang('7')
                                    <input type="radio" name="choose" value="7" id="predict11">
                                </label>
                                <label class="color-predict-item" for="predict12">
                                    @lang('8')
                                    <input type="radio" name="choose" value="8" id="predict12">
                                </label>
                                <label class="color-predict-item" for="predict13">
                                    @lang('9')
                                    <input type="radio" name="choose" value="9" id="predict13">
                                </label>
                            </div>

                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <span class="input-group-text">{{ gs('cur_sym') }}</span>
                                    <input class="form-control form--control" name="invest" type="number"
                                        step="any" value="{{ old('invest') }}" placeholder="@lang('Enter amount')"
                                        autocomplete="off">
                                    <button type="button"
                                        class="input-group-text minmax-btn minBtn">@lang('Min')</button>
                                    <button type="button"
                                        class="input-group-text minmax-btn maxBtn">@lang('Max')</button>
                                </div>
                                <small class="form-text text-muted">
                                    <i class="fas fa-info-circle me-2"></i>
                                    @lang('Minimum'): {{ showAmount($game->min_limit) }}
                                    |
                                    @lang('Maximum'): {{ showAmount($game->max_limit) }}
                                </small>
                            </div>
                            <button class="btn btn--gradient w-100" id="playBtn"
                                type="submit">@lang('Play Now')</button>
                        </form>
                        <div class="text-center mt-2">
                            <div class="d-flex justify-content-between align-items-center mt-3 w-100">
                                <button type="button" class="d-block text-white text-center mx-auto"
                                    data-bs-toggle="modal" data-bs-target="#exampleModalCenter"><i
                                        class="fas fa-info-circle mr-2"></i>
                                    @lang('Game Instruction')
                                </button>
                                <button type="button" class="sound--btn audioBtn">
                                    <i class="fas fa-volume-up"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

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
    <link href="{{ asset($activeTemplateTrue . 'css/slick.css') }}" rel="stylesheet">
@endpush

@push('script-lib')
    <script src="{{ asset('assets/global/js/soundControl.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/slick.min.js') }}"></script>
@endpush

@push('script')
    <script>
        $(".color-predict-bar").slick({
            autoplay: false,
            dots: false,
            infinite: true,
            speed: 50,
            slidesToShow: 8,
            arrows: false,
            slidesToScroll: 1,
            cssEase: "linear",
            autoplaySpeed: 0,
            verticalSwiping: true,
            swipeToSlide: true,
            swipe: true,
            focusOnHover: false,
            pauseOnHover: false,
            responsive: [{
                    breakpoint: 465,
                    settings: {
                        slidesToShow: 7,
                    },
                },
                {
                    breakpoint: 400,
                    settings: {
                        slidesToShow: 6,
                    },
                },
                {
                    breakpoint: 374,
                    settings: {
                        slidesToShow: 5,
                    },
                },
            ],
        });

        "use strict";

        let minLimit = Number(`{{ $game->min_limit }}`);
        let maxLimit = Number(`{{ $game->max_limit }}`);
        let curText = `{{ gs('cur_text') }}`;
        let investField = $("[name=invest]");
        audioAssetPath = `{{ asset('assets/audio') }}`;

        $(".minBtn").on('click', function(e) {
            playAudio(audioAssetPath, "click.mp3");
            investField.val(minLimit);
        });

        $(".maxBtn").on('click', function(e) {
            playAudio(audioAssetPath, "click.mp3");
            investField.val(maxLimit);
        });

        $('.color-predict-item').on('click', function() {
            playAudio(audioAssetPath, "click.mp3");
        })


        $('#colorFormSubmit').on('submit', function(e) {
            e.preventDefault();
            $('#playBtn').html('<i class="la la-gear fa-spin"></i> Processing...');
            $('#playBtn').attr('disabled', true);
            $('.color-predict-result').addClass('d-none');
            let userChoice = $('[name=choose]:checked').val();
            if (!userChoice) {
                notify('error', 'Please select a color');
                return;
            }

            let invest = $('[name=invest]').val();
            if (invest < minLimit || invest > maxLimit) {
                notify('error',
                    `Investment should be between ${minLimit} ${curText} and ${maxLimit} ${curText}`);
                return;
            }

            let data = {
                _token: "{{ csrf_token() }}",
                invest: invest,
                choose: userChoice,
            };

            playAudio(audioAssetPath, "keno_start.wav");

            $(".color-predict-bar").slick('slickPlay');
            $('.color-predict-result').removeClass('d-none');
            isRequest = true;
            $.ajax({
                type: "POST",
                url: "{{ route('user.play.invest', [$game->alias, @$isDemo]) }}",
                data: data,
                success: function(response) {
                    if (response.errors) {
                        if (audioSound == 'true') {
                            audioPause();
                        }
                        $('.color-predict-result').addClass('d-none');
                        $('#playBtn').removeAttr('disabled');
                        notify("error", response.errors);
                        return;
                    }
                    if (response.error) {
                        if (audioSound == 'true') {
                            audioPause();
                        }
                        $('.color-predict-result').addClass('d-none');
                        notify('error', response.error);
                        $('#playBtn').removeAttr('disabled');
                        return;
                    } else {
                        $('.color-predict-text').text(response.balance);
                        setTimeout(() => {
                            endGame(response);
                        }, 5000);
                    }
                }
            });
        });

        function endGame(response) {
            let data = {
                _token: "{{ csrf_token() }}",
                game_log_id: response.game_log_id,
            }
            $.ajax({
                type: "POST",
                url: "{{ route('user.play.end', [$game->alias, @$isDemo]) }}",
                data: data,
                success: function(response) {
                    if (audioSound == 'true') {
                        audioPause();
                    }
                    $(".color-predict-bar").slick('slickPause');
                    addBeforeStyles();
                    $('.result-area').removeClass('d-none');
                    $('.show-result').text(response.result)
                    $('.color-predict-text').text(response.bal);
                    if (response.win_status) {
                        notify('success', response.message)
                    } else {
                        notify('error', response.message)
                    }

                    setTimeout(() => {
                        $('.color-predict-result').addClass('d-none');
                        closeBeforeStyles();
                        $('.show-result').text('');
                        $('.playBtn').removeAttr('disabled');
                    }, 5000);
                    $("#playBtn").html("Play Now");
                    $("#playBtn").removeAttr("disabled");
                    isRequest = false;
                }
            });
        }

        function addBeforeStyles() {
            var css =
                '.color-predict-bar-wrapper::before { display:block; background:rgb(255 255 255 / 10%); position:absolute; } .color-predict-result .text{border:4px solid hsl(var(--bar-color));background:hsla(var(--bar-color), 0.3);} .color-predict-result .text-inner{backdrop-filter:blur(5px);}';
            var style = document.createElement('style');
            style.type = 'text/css';
            if (style.styleSheet) {
                style.styleSheet.cssText = css;
            } else {
                style.appendChild(document.createTextNode(css));
            }
            document.getElementsByTagName('head')[0].appendChild(style);
        }

        function closeBeforeStyles() {
            var css =
                '.color-predict-bar-wrapper::before { display:none; background:unset; position:unset; } .color-predict-result .text{border:unset;background:unset;} .color-predict-result .text-inner{background-color:unset;backdrop-filter:unset;}';
            var style = document.createElement('style');
            style.type = 'text/css';
            if (style.styleSheet) {
                style.styleSheet.cssText = css;
            } else {
                style.appendChild(document.createTextNode(css));
            }
            document.getElementsByTagName('head')[0].appendChild(style);
        }
    </script>
@endpush

@push('style')
    <style>
        .color-predict-bar {
            background-color: #01162f;
            padding-block: 4px;
        }

        .color-predict-bar-wrapper {
            position: relative;
            z-index: 1;
            display: block;
            padding: 12px 12px;
            border-radius: 8px;
            max-width: 400px;
            margin: 0 auto;
        }

        .color-predict-result {
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            font-size: 24px;
            z-index: 2;
            height: calc(100% - 10px);
            width: 60px;
            border: 4px solid #E3BC3F;
            border-radius: 5px;
            display: flex;
            flex-direction: column;
        }

        .color-predict-result .title {
            line-height: 1;
            font-size: 12px;
            font-weight: 500;
            color: black;
            background: #e3bc3f;
            text-align: center;
        }

        .color-predict-result .text-inner {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: rgb(255 255 255 / 10%) !important;
            backdrop-filter: blur(5px);
        }

        .color-predict-result .text {
            font-size: 18px;
            display: flex !important;
            align-items: center;
            justify-content: center;
            height: 39px;
            font-weight: 700;
            width: 39px;
            border: 4px solid hsl(var(--bar-color));
            border-radius: 50%;
            margin-inline: 4px;
            background: hsla(var(--bar-color), 0.3);
            color: hsl(var(--white));
        }

        .color-predict-bar-wrapper::after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background: linear-gradient(90deg, rgba(0, 171, 38, 1) 0%, rgba(224, 60, 60, 1) 49%, rgba(116, 0, 171, 1) 100%);
            z-index: -1;
            border-radius: 8px;
        }

        /* aikhane display block kore  */
        .color-predict-bar-wrapper::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background: rgb(255 255 255 / 10%);
            border-radius: 8px;
            backdrop-filter: blur(5px);
            z-index: 1;
            display: none;
        }

        .color-predict-bar span {
            display: flex !important;
            align-items: center;
            justify-content: center;
            height: 39px;
            border: 4px solid hsl(var(--bar-color));
            border-radius: 50%;
            background: hsla(var(--bar-color), 0.3);
        }

        .color-predict-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-block: 24px;
        }

        .color-predict-title {
            font-size: 14px;
            font-weight: 500;
            color: #b7b6b6;
        }

        .color-predict {
            padding: 24px;
            border-radius: 12px;
            background-color: #01162f;
        }

        .color-predict-inner {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            gap: 16px;
            margin-block: 24px;
            flex-wrap: wrap;
        }

        @media (max-width: 425px) {
            .color-predict-inner {
                gap: 12px;
            }
        }


        .color-predict-inner.style-two .color-predict-item:nth-child(1) {
            --color-predict: #00ab26;
        }

        .color-predict-inner.style-two .color-predict-item:nth-child(3) {
            --color-predict: #e03c3c;
        }

        .color-predict-inner.style-two .color-predict-item:nth-child(2) {
            --color-predict: #7400ab;
        }

        .color-predict-inner .color-predict-item:is(:nth-child(1)) {
            --color-predict: #7400ab;
            --predict-after: #e03c3c;
        }

        .color-predict-inner .color-predict-item:is(:nth-child(6)) {
            --color-predict: #7400ab;
            --predict-after: #00ab26;
        }

        .color-predict-inner .color-predict-item:is(:nth-child(2), :nth-child(4), :nth-child(8), :nth-child(10)) {
            --color-predict: #00ab26;
        }

        .color-predict-inner .color-predict-item:is(:nth-child(3), :nth-child(5), :nth-child(7), :nth-child(9)) {
            --color-predict: #e03c3c;
        }

        .color-predict-item {
            background-color: var(--color-predict);
            border-radius: 6px;
            cursor: pointer;
            height: 42px;
            width: calc(100% / 5 - 13px);
            margin-bottom: 0;
            color: #FFF;
            font-weight: 700;
            display: grid;
            place-content: center;
            user-select: none;
        }


        @media (max-width: 424px) {

            .color-predict-item {
                width: calc(100% / 5 - 10px);
            }

            .color-predict-item {
                height: 36px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: 1px;
            }
        }

        .predict-gradient.color-predict-item {
            overflow: hidden;
            position: relative;
            z-index: 1;
        }

        .predict-gradient.color-predict-item::after {
            content: "";
            position: absolute;
            background-color: var(--predict-after);
            top: 0;
            right: 0;
            height: 100%;
            width: 100%;
            clip-path: polygon(90% 0, 100% 0, 100% 100%, 20% 100%);
            z-index: -1;
        }

        .color-predict-item.style-two {
            height: 52px;
            flex: 1;
            width: auto;
        }

        .color-predict-item:has(input:checked) {
            opacity: 0.3;
        }

        .color-predict-item input {
            display: none;
        }

        .refresh-btn {
            background: transparent;
            border: 1px solid #28c76f;
            color: #fff;
        }

        .refresh-btn:hover {
            background-color: #28c76f;
            transition: 0.5s;
        }

        button.refresh-btn.btn-sm:disabled {
            cursor: no-drop;
        }

        .slick-initialized.slick-slider .slick-list {
            margin: 0 !important;
        }

        .slick-initialized.slick-slider .slick-slide {
            height: auto;
            padding: 0px !important;
            margin-inline: 4px !important;
        }
    </style>
@endpush
