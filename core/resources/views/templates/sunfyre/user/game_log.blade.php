@extends('Template::layouts.master')
@section('content')
    <section class="transection-section">
        <div class="latest-transection">
            <ul class="d-flex align-items-center gap-3 gap-sm-4 mb-3 mb-sm-4" id="myTab" role="tablist">
                <li class="flex-grow-1">
                    <a href="{{ route('user.game.log') }}" class="w-100 log-tab-btn {{ !$isDemo ? 'active' : '' }}">
                        @lang('Game Logs')
                    </a>
                </li>
                <li class="flex-grow-1">
                    <a href="{{ route('user.game.log.demo') }}" class="w-100 log-tab-btn {{ $isDemo ? 'active' : '' }}">
                        @lang('Demo Game Logs')
                    </a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="transection-table-scroller">
                    <table class="transection-table table table--responsive--xl">
                        <thead>
                            <tr>
                                <th>@lang('Game Name')</th>
                                <th>@lang('You Select')</th>
                                <th>@lang('Result')</th>
                                <th>@lang('Invest')</th>
                                <th>@lang('Win or Lost')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($logs as $log)
                                <tr>
                                    <td>
                                        <span class="text-end">{{ __(@$log->game->name) }}</span>
                                    </td>
                                    <td>
                                        <div>
                                            @if (gettype(json_decode($log->user_select)) == 'array')
                                                {{ implode(', ', json_decode($log->user_select)) }}
                                            @else
                                                {{ __($log->user_select ?? 'N/A') }}
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            @if (gettype(json_decode($log->result)) == 'array')
                                                {{ implode(', ', json_decode($log->result)) }}
                                            @else
                                                @if ($log->game->alias == 'mines')
                                                    @lang('N/A')
                                                @else
                                                    {{ __($log->result) }}
                                                @endif
                                            @endif
                                        </div>
                                    </td>
                                    <td><span>{{ showAmount($log->invest) }}</span> </td>
                                    <td>
                                        @if ($log->win_status != Status::LOSS)
                                            <span class="badge badge--success"><i class="las la-smile"></i>
                                                @lang('Win')</span>
                                        @else
                                            <span class="badge badge--danger"><i class="las la-frown"></i>
                                                @lang('Lost')</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ paginateLinks($logs) }}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('style')
    <style>
        .log-tab-btn {
            color: hsl(var(--white));
            font-family: var(--heading-font);
            padding: 6px 16px;
            font-weight: 600;
            font-size: 24px;
            white-space: nowrap;
            text-align: center;
        }

        .log-tab-btn:hover,
        .log-tab-btn:focus {
            color: hsl(var(--base));
        }

        @media screen and (max-width: 575px) {
            .log-tab-btn {
                font-size: 20px;
                padding: 6px 12px;
            }
        }

        .log-tab-btn.active {
            color: hsl(var(--base));
            border-bottom: 2px solid hsl(var(--base));
        }
    </style>
@endpush
