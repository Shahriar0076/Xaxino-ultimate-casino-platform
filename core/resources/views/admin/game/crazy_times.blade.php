@extends('admin.layouts.app')
@section('panel')
    <form action="{{ route('admin.game.crazy.times.update', $game->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
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
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="card-title">@lang('Bet Amount & Win Chance')</h5>
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
                        <div class="form-group">
                            <label>@lang('Winning Chance')</label>
                            <div class="input-group mb-3">
                                <input class="form-control" name="probable" type="number"
                                    value="{{ getAmount($game->probable_win) }}">
                                <span class="input-group-text">@lang('%')</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card ">
                    <div class="card-header">
                        <h5 class="card-title">@lang('Win Bonus')</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive--md table-responsive">
                            <table class="table--light style--two table">
                                <thead>
                                    <tr>
                                        <th>@lang('Invest Number')</th>
                                        <th>@lang('Wheel Segments')</th>
                                        <th>@lang('Odds')</th>
                                        <th>@lang('Winings (based on a)') {{ gs('cur_sym') }} @lang('5 invest')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>@lang('1')</td>
                                        <td>@lang('21')</td>
                                        <td>@lang('1:1')</td>
                                        <td>{{ gs('cur_sym') }}{{ getAmount(10) }}</td>
                                    </tr>
                                    <tr>
                                        <td>@lang('2')</td>
                                        <td>@lang('13')</td>
                                        <td>@lang('2:1')</td>
                                        <td>{{ gs('cur_sym') }}{{ getAmount(15) }}</td>
                                    </tr>
                                    <tr>
                                        <td>@lang('5')</td>
                                        <td>@lang('7')</td>
                                        <td>@lang('5:1')</td>
                                        <td>{{ gs('cur_sym') }}{{ getAmount(30) }}</td>
                                    </tr>
                                    <tr>
                                        <td>@lang('10')</td>
                                        <td>@lang('4')</td>
                                        <td>@lang('10:1')</td>
                                        <td>{{ gs('cur_sym') }}{{ getAmount(50) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="card-title">@lang('More Win Ratio')</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-text justify-content-center">@lang('Coin Flip')</span>
                                <input class="form-control col-10" name="level[]" type="number"
                                    value="{{ getAmount($game->level[0]) }}">
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-text justify-content-center">@lang('Pachinko')</span>
                                <input class="form-control col-10" name="level[]" type="number"
                                    value="{{ getAmount($game->level[1]) }}">
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-text justify-content-center">@lang('Cash Hunt')</span>
                                <input class="form-control col-10" name="level[]" type="number"
                                    value="{{ getAmount($game->level[2]) }}">
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-text justify-content-center">@lang('Crazy Times')</span>
                                <input class="form-control col-10" name="level[]" type="number"
                                    value="{{ getAmount($game->level[3]) }}">
                                <span class="input-group-text">%</span>
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
                                    <input name="trending" data-width="100%" data-onstyle="-success"
                                        data-offstyle="-danger" data-bs-toggle="toggle" data-on="@lang('Yes')"
                                        data-off="@lang('No')" type="checkbox" @checked($game->trending)>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Featured')</label>
                                    <input name="featured" data-width="100%" data-onstyle="-success"
                                        data-offstyle="-danger" data-bs-toggle="toggle" data-on="@lang('Yes')"
                                        data-off="@lang('No')" type="checkbox" @checked($game->featured)>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-12">
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

@push('script')
    <script>
        (function($) {
            "use strict";


            $('[name=max_select_number]').on('focusout', function(e) {
                let numberOfLevel = $(this).val();
                generrateLevels(numberOfLevel)
            });

            function generrateLevels(numberOfLevel = 10) {
                let minimumLevel = 4;
                if (numberOfLevel < minimumLevel) {
                    notify('error', 'Wining bonus more than 4 level');
                    return;
                }
                if (numberOfLevel > 80) {
                    notify('error', 'Wining bonus less than 80 level');
                    return;
                }
                let html = '';
                if (numberOfLevel && numberOfLevel > 0) {
                    for (let i = minimumLevel; i <= numberOfLevel; i++) {
                        html += `<div class="input-group mb-3">
                                    <span class="input-group-text justify-content-center">@lang('Match') ${i} @lang('number get')</span>
                                    <input type="hidden" name="level[]" value="${i}" required>
                                    <input name="percent[]" class="form-control col-10" type="number" placeholder="@lang('Commission Percentage')">
                                    <span class="input-group-text">%</span>
                                </div>`
                    }
                    $('.winLevels').html(html);
                }
            }
        })(jQuery)
    </script>
@endpush
