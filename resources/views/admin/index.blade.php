@extends('admin.layouts.admin')

@section('title', trans('creatorcodes::admin.title'))

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold">{{ trans('creatorcodes::admin.add') }}</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('creatorcodes.admin.store') }}">
                @include('creatorcodes::admin._form', ['creator' => new \Azuriom\Plugin\CreatorCodes\Models\Creator(['is_enabled' => true, 'percentage' => 10])])
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
                                <a href="{{ route('creatorcodes.admin.edit', $creator) }}" class="btn btn-sm btn-outline-primary" title="{{ trans('messages.actions.edit') }}">
                                    <i class="bi bi-pencil-square"></i> {{ trans('messages.actions.edit') }}
                                </a>
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
