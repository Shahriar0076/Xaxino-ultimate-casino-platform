@php
    $content = getContent('game.content', true);
    $games = \App\Models\Game::active()->get();
@endphp
<section class="pt-120 pb-120 section--bg">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="section-header text-center">
                    <h2 class="section-title">{{ __(@$content->data_values->heading) }}</h2>
                    <p class="mt-3">{{ __(@$content->data_values->subheading) }}</p>
                </div>
            </div>
        </div>
        <div class="row justify-content-center mb-none-30">
            @include('Template::partials.game_card')
        </div>
    </div>
</section>
