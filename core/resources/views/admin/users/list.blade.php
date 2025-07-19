@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('User')</th>
                                    <th>@lang('Email-Mobile')</th>
                                    <th>@lang('Country')</th>
                                    <th>@lang('Joined At')</th>
                                    <th>@lang('Balance')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                    <tr>
                                        <td>
                                            <span class="fw-bold">{{ $user->fullname }}</span>
                                            <br>
                                            <span class="small">
                                                <a
                                                   href="{{ route('admin.users.detail', $user->id) }}"><span>@</span>{{ $user->username }}</a>
                                            </span>
                                        </td>

                                        <td>
                                            {{ $user->email }}<br>{{ $user->mobileNumber }}
                                        </td>
                                        <td>
                                            <span class="fw-bold"
                                                  title="{{ @$user->country_name }}">{{ $user->country_code }}</span>
                                        </td>

                                        <td>
                                            {{ showDateTime($user->created_at) }} <br>
                                            {{ diffForHumans($user->created_at) }}
                                        </td>

                                        <td>
                                            <span class="fw-bold">

                                                {{ showAmount($user->balance) }}
                                            </span>
                                        </td>

                                        <td>
                                            <div class="button--group">
                                                <a href="{{ route('admin.users.detail', $user->id) }}"
                                                   class="btn btn-sm btn-outline--primary">
                                                    <i class="las la-desktop"></i> @lang('Details')
                                                </a>
                                                @if (request()->routeIs('admin.users.kyc.pending'))
                                                    <a href="{{ route('admin.users.kyc.details', $user->id) }}"
                                                       target="_blank" class="btn btn-sm btn-outline--dark">
                                                        <i class="las la-user-check"></i>@lang('KYC Data')
                                                    </a>
                                                @endif
                                            </div>
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                @if ($users->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($users) }}
                    </div>
                @endif
            </div>
        </div>


    </div>

    <div id="demoBalanceModal" class="modal fade">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        @lang('Update Demo Balance')
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{ route('admin.users.update.demo.balance') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="alert alert-warning p-3 mb-3 noAlert" role="alert">
                            @lang('Are you sure to update demo balance of all users?')
                        </div>
                        <div class="form-group">
                            <label>@lang('Demo Balance')</label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="demo_balance" value="{{ old('demo_balance') }}" required>
                                <span class="input-group-text">{{ gs('cur_text') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary h-45 w-100">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection



@push('breadcrumb-plugins')
    <x-search-form placeholder="Username / Email" />
    <button type="button" class="btn btn-outline--primary demoBalanceBtn" data-bs-toggle="modal"
            data-bs-target="#demoBalanceModal">
        <i class="las la-coins"></i> @lang('Update Demo Balance')
    </button>
@endpush
