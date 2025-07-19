@extends('admin.layouts.app')
@section('panel')
    <form action="{{ route('admin.game.dream.catcher.update', $game->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row gy-4">
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="form-group">
                            <label>@lang('Game Name')</label>
                            <input class="form-control" name="name" type="text" value="{{ $game->name }}"
                                placeholder="@lang('Game Name')" required>
                        </div>
                        <div class="form-group">
                            <label>@lang('Image')</label>
                            <x-image-uploader image="{{ $game->image }}" class="w-100" type="game" :required=false />
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">@lang('Win Setting')</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Win Probability For 1')</label>
                                    <div class="input-group">
                                        <input class="form-control" name="probable_win[one]" type="number"
                                            value="{{ @$game->probable_win->one }}" step="any" min="0"
                                            max="100"  required>
                                        <span class="input-group-text">@lang('%')</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Win Probability For 2')</label>
                                    <div class="input-group">
                                        <input class="form-control" name="probable_win[two]" type="number"
                                            value="{{ @$game->probable_win->two }}" step="any" min="0"
                                            max="100"  required>
                                        <span class="input-group-text">@lang('%')</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Win Probability For 5')</label>
                                    <div class="input-group">
                                        <input class="form-control" name="probable_win[five]" type="number"
                                            value="{{ @$game->probable_win->five }}" step="any" min="0"
                                            max="100"  required>
                                        <span class="input-group-text">@lang('%')</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Win Probability For 10')</label>
                                    <div class="input-group">
                                        <input class="form-control" name="probable_win[ten]" type="number"
                                            value="{{ @$game->probable_win->ten }}" step="any" min="0"
                                            max="100"  required>
                                        <span class="input-group-text">@lang('%')</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Win Probability For 20')</label>
                                    <div class="input-group">
                                        <input class="form-control" name="probable_win[twenty]" type="number"
                                            value="{{ @$game->probable_win->twenty }}" step="any" min="0"
                                            max="100"  required>
                                        <span class="input-group-text">@lang('%')</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Win Probability For 40')</label>
                                    <div class="input-group">
                                        <input class="form-control" name="probable_win[forty]" type="number"
                                            value="{{ @$game->probable_win->forty }}" step="any" min="0"
                                            max="100" required>
                                        <span class="input-group-text">@lang('%')</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Win Probability For 2x')</label>
                                    <div class="input-group">
                                        <input class="form-control" name="probable_win[twox]" type="number"
                                            value="{{ @$game->probable_win->twox }}" step="any" min="0"
                                            max="100" required>
                                        <span class="input-group-text">@lang('%')</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Win Probability For 7x')</label>
                                    <div class="input-group">
                                        <input class="form-control" name="probable_win[sevenx]" type="number"
                                            value="{{ @$game->probable_win->sevenx }}" step="any" min="0"
                                            max="100"  required>
                                        <span class="input-group-text">@lang('%')</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">@lang('Invest Amount')</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>@lang('Minimum Invest Amount')</label>
                            <div class="input-group mb-3">
                                <input class="form-control" name="min" type="number"
                                    value="{{ getAmount($game->min_limit) }}" step="any" min="1"
                                    placeholder="@lang('Minimum Invest Amount')" required>
                                <span class="input-group-text">{{ gs('cur_text') }}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>@lang('Maximum Invest Amount')</label>
                            <div class="input-group mb-3">
                                <input class="form-control" name="max" type="number"
                                    value="{{ getAmount($game->max_limit) }}" step="any" min="1"
                                    placeholder="@lang('Maximum Invest Amount')" required>
                                <span class="input-group-text">{{ gs('cur_text') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">@lang('For App')</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>@lang('Trending')</label>
                            <input name="trending" data-width="100%" data-onstyle="-success" data-offstyle="-danger"
                                data-bs-toggle="toggle" data-on="@lang('Yes')" data-off="@lang('No')"
                                type="checkbox" @checked($game->trending)>
                        </div>
                        <div class="form-group">
                            <label>@lang('Featured')</label>
                            <input name="featured" data-width="100%" data-onstyle="-success"
                                data-offstyle="-danger" data-bs-toggle="toggle" data-on="@lang('Yes')"
                                data-off="@lang('No')" type="checkbox" @checked($game->featured)>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 mt-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">@lang('Game Instruction')</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <textarea class="form-control border-radius-5 nicEdit" name="instruction" rows="8">@php echo $game->instruction @endphp</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 mt-4">
            <div class="card">
                <div class="card-body">
                    <button class="btn btn--primary w-100 h-45" type="submit">@lang('Submit')</button>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('breadcrumb-plugins')
    <x-back route="{{ route('admin.game.index') }}" />
@endpush
