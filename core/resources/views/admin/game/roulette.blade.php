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
                            <input class="form-control" name="name" type="text" value="{{ $game->name }}" required>
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
                        <h5 class="card-title">@lang('Game Setting')</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>@lang('Minimum Invest Amount')</label>
                            <div class="input-group">
                                <input class="form-control" name="min" type="number"
                                    value="{{ getAmount($game->min_limit) }}" step="any" min="1" required>
                                <span class="input-group-text">{{ gs('cur_text') }}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>@lang('Maximum Invest Amount')</label>
                            <div class="input-group">
                                <input class="form-control" name="max" type="number"
                                    value="{{ getAmount($game->max_limit) }}" step="any" min="1" required>
                                <span class="input-group-text">{{ gs('cur_text') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-12">
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
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">@lang('For App')</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Trending')</label>
                                    <input name="trending" data-width="100%" data-onstyle="-success" data-offstyle="-danger"
                                        data-bs-toggle="toggle" data-on="@lang('Yes')" data-off="@lang('No')"
                                        type="checkbox" @checked($game->trending)>
                                </div>
                            </div>
                            <div class="col-md-6">
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
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <button class="btn btn--primary w-100 h-45" type="submit">@lang('Submit')</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('breadcrumb-plugins')
    <x-back route="{{ route('admin.game.index') }}" />
@endpush
