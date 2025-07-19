@foreach ($games as $game)
    <div class="game-item">
        <div class="game-item__image">
            <img src="{{ getImage(getFilePath('game') . '/' . $game->image, getFileSize('game')) }}" alt="@lang('image')">
            <div class="game-item__play">
                <a href="{{ route('user.play.game', $game->alias) }}" class="btn btn--gradient btn--sm">@lang('Play')</a>
                <a href="{{ route('user.play.game', [$game->alias, 'demo']) }}" class="btn btn--gradient btn--sm">@lang('Demo')</a>
            </div>
        </div>
        <h4 class="game-item__title">{{ __($game->name) }}</h4>
    </div>
@endforeach
