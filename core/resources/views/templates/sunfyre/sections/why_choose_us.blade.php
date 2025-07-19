@php
    $chooseContent = getContent('why_choose_us.content', true);
    $chooseElements = getContent('why_choose_us.element', orderById: true);
    $achivements = getContent('achivement.element', orderById: true);
@endphp
<section class="choose-us py-50">
    <div class="container">
        <div class="choose-us-wrapper">
            <div class="row gy-5 align-items-center justify-content-between">
                <div class="col-xxl-5 col-xl-5 col-lg-7">
                    <div class="choose-us-content">
                        <div class="section-heading style-left">
                            <h1 class="section-heading__title" s-break="-1" s-color="title-color">
                                {{ __(@$chooseContent->data_values->heading) }}</h1>
                            <p class="section-heading__desc">{{ __(@$chooseContent->data_values->subheading) }}</p>
                        </div>
                        <div class="achievement-wrapper">
                            <div class="achievement-card">
                                <div class="achievement-card__icon">
                                    @php
                                        echo @$chooseContent->data_values->first_achievement_icon;
                                    @endphp
                                </div>
                                <div class="achievement-card__content">
                                    <h5 class="achievement-card__title">{{ __(@$chooseContent->data_values->first_achievement_title) }}</h5>
                                    <h2 class="achievement-card__count">{{ __(@$chooseContent->data_values->first_achievement_digit) }}</h2>
                                </div>
                            </div>
                            <div class="achievement-card">
                                <div class="achievement-card__icon">
                                    @php
                                        echo @$chooseContent->data_values->second_achievement_icon;
                                    @endphp
                                </div>
                                <div class="achievement-card__content">
                                    <h5 class="achievement-card__title">{{ __(@$chooseContent->data_values->second_achievement_title) }}</h5>
                                    <h2 class="achievement-card__count">{{ __(@$chooseContent->data_values->second_achievement_digit) }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-6 col-xl-7 col-lg-5">
                    <div class="card-slider choose-us-slider">
                        @foreach ($chooseElements ?? [] as $chooseElement)
                            <div class="card-item">
                                <div class="card-item__content">
                                    <div class="card-item__image">
                                        <img src="{{ frontendImage('why_choose_us', @$chooseElement->data_values->image, '35x35') }}"
                                            alt="@lang('image')">
                                    </div>
                                    <h5 class="card-item__title">{{ __(@$chooseElement->data_values->title) }}</h5>
                                    <p class="card-item__desc">{{ __(@$chooseElement->data_values->description) }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="card-slider-dots"></div>
                </div>
            </div>
        </div>
    </div>
</section>
