@extends('admin.layouts.app')

@section('panel')
    <form action="{{ route('admin.game.update', $game->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="form-group">
                            <label>@lang('Game Name')</label>
                            <input type="text" name="name" class="form-control" placeholder="@lang('Game Name')"
                                value="{{ $game->name }}" required>
                        </div>
                        <div class="form-group">
                            <label>@lang('Image')</label>
                            <x-image-uploader image="{{ $game->image }}" class="w-100" type="game" :required=false />
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="card-title mb-0">@lang('Game Setting')</h5>
                    </div>
                    <div class="card-body">
                        <h5 class="mb-3">@lang('Investment Setting')</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Minimum Invest Amount')</label>
                                    <div class="input-group mb-3">
                                        <input type="number" step="any" name="min" min="1"
                                            class="form-control" placeholder="@lang('Minimum Invest Amount')"
                                            value="{{ getAmount($game->min_limit) }}" required>
                                        <span class="input-group-text">{{ gs('cur_sym') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Maximum Invest Amount')</label>
                                    <div class="input-group mb-3">
                                        <input type="number" step="any" name="max" min="1"
                                            class="form-control" placeholder="@lang('Maximum Invest Amount')"
                                            value="{{ getAmount($game->max_limit) }}" required>
                                        <span class="input-group-text">{{ gs('cur_sym') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h5 class="my-3">@lang('Win Chance Setting')</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('No Win Chance')</label>
                                    <div class="input-group mb-3">
                                        <input type="number" class="form-control" name="chance[]"
                                            value="{{ getAmount(@$game->probable_win[0]) }}"
                                            placeholder="Triple Win Chance">
                                        <span class="input-group-text">@lang('%')</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Single Win Chance') </label>
                                    <div class="input-group mb-3">
                                        <input type="number" class="form-control" name="chance[]"
                                            value="{{ getAmount(@$game->probable_win[1]) }}"
                                            placeholder="Single Win Chance">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Double Win Chance') </label>
                                    <div class="input-group mb-3">
                                        <input type="number" class="form-control" name="chance[]"
                                            value="{{ getAmount(@$game->probable_win[2]) }}"
                                            placeholder="Double Win Chance">
                                        <span class="input-group-text">@lang('%')</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Triple Win Chance')</label>
                                    <div class="input-group mb-3">
                                        <input type="number" class="form-control" name="chance[]"
                                            value="{{ getAmount(@$game->probable_win[3]) }}"
                                            placeholder="Triple Win Chance">
                                        <span class="input-group-text">@lang('%')</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="card-title mb-0">@lang('Win Bonus Setting')</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>@lang('Single Win Bonus')</label>
                                    <div class="input-group mb-3">
                                        <input type="number" class="form-control" name="level[]"
                                            value="{{ getAmount($game->level[0]) }}" placeholder="Single Win Bonus">
                                        <span class="input-group-text">@lang('%')</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Double Win Bonus')</label>
                                    <div class="input-group mb-3">
                                        <input type="number" class="form-control" name="level[]"
                                            value="{{ getAmount($game->level[1]) }}" placeholder="Double Win Bonus">
                                        <span class="input-group-text">@lang('%')</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Triple Win Bonus')</label>
                                    <div class="input-group mb-3">
                                        <input type="number" class="form-control" name="level[]"
                                            value="{{ getAmount($game->level[2]) }}" placeholder="Triple Win Bonus">
                                        <span class="input-group-text">@lang('%')</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="card-title mb-0">@lang('For App')</h5>
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
                            <input name="featured" data-width="100%" data-onstyle="-success" data-offstyle="-danger"
                                data-bs-toggle="toggle" data-on="@lang('Yes')" data-off="@lang('No')"
                                type="checkbox" @checked($game->featured)>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">@lang('Game Instruction')</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <textarea rows="8" class="form-control border-radius-5 nicEdit" name="instruction">@php echo $game->instruction @endphp</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <button type="submit" class="btn btn--primary w-100 h-45">@lang('Submit')</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
@push('breadcrumb-plugins')
    <x-back route="{{ route('admin.game.index') }}" />
@endpush
