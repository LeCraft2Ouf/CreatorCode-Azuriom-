@extends('admin.layouts.admin')

@section('title', trans('creatorcodes::admin.title'))

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold">{{ trans('creatorcodes::admin.add') }}</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('creatorcodes.admin.store') }}">
                @csrf
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label" for="pseudo">{{ trans('creatorcodes::admin.fields.pseudo') }}</label>
                        <input type="text" id="pseudo" name="pseudo" class="form-control @error('pseudo') is-invalid @enderror"
                               value="{{ old('pseudo') }}" required>
                        @error('pseudo')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        <div class="form-text">{{ trans('creatorcodes::admin.help.pseudo') }}</div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label" for="code">{{ trans('creatorcodes::admin.fields.code') }}</label>
                        <input type="text" id="code" name="code" class="form-control @error('code') is-invalid @enderror"
                               value="{{ old('code') }}" required>
                        @error('code')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-2">
                        <label class="form-label" for="percentage">{{ trans('creatorcodes::admin.fields.percentage') }}</label>
                        <div class="input-group">
                            <input type="number" id="percentage" name="percentage" class="form-control @error('percentage') is-invalid @enderror"
                                   value="{{ old('percentage', 5) }}" min="0.01" max="100" step="0.01" required>
                            <span class="input-group-text">%</span>
                            @error('percentage')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_enabled" id="is_enabled" value="1"
                                   @checked(old('is_enabled', true))>
                            <label class="form-check-label" for="is_enabled">
                                {{ trans('creatorcodes::admin.status.enabled') }}
                            </label>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-plus-lg"></i> {{ trans('messages.actions.add') }}
                        </button>
                    </div>
                </div>
                <p class="text-muted small mt-3 mb-0">{{ trans('creatorcodes::admin.help.percentage') }}</p>
            </form>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>{{ trans('creatorcodes::admin.fields.pseudo') }}</th>
                        <th>{{ trans('creatorcodes::admin.fields.code') }}</th>
                        <th>{{ trans('creatorcodes::admin.fields.percentage') }}</th>
                        <th>{{ trans('creatorcodes::admin.fields.status') }}</th>
                        <th>{{ trans('creatorcodes::admin.fields.neos') }}</th>
                        <th>{{ trans('messages.fields.action') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($creators as $creator)
                        <tr>
                            <td>
                                <a href="{{ route('admin.users.edit', $creator->user) }}">{{ $creator->user->name }}</a>
                            </td>
                            <td><code>{{ $creator->code }}</code></td>
                            <td>{{ $creator->percentage }} %</td>
                            <td>
                                <span class="badge bg-{{ $creator->is_enabled ? 'success' : 'secondary' }}">
                                    {{ trans('creatorcodes::admin.status.'.($creator->is_enabled ? 'enabled' : 'disabled')) }}
                                </span>
                            </td>
                            <td>{{ format_money($creator->rewards_sum_neos_rewarded ?? 0) }}</td>
                            <td>
                                <form action="{{ route('creatorcodes.admin.toggle', $creator) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button class="btn btn-sm btn-outline-secondary" type="submit">
                                        {{ $creator->is_enabled ? trans('creatorcodes::admin.status.disabled') : trans('creatorcodes::admin.status.enabled') }}
                                    </button>
                                </form>
                                <form action="{{ route('creatorcodes.admin.destroy', $creator) }}" method="POST" class="d-inline"
                                      data-confirm="delete">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" type="submit" title="{{ trans('messages.actions.delete') }}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-muted">{{ trans('creatorcodes::admin.empty') }}</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
