@extends('admin.layouts.admin')

@section('title', trans('creatorcodes::admin.edit'))

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header">
            <h6 class="m-0 fw-bold">{{ trans('creatorcodes::admin.edit') }}</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('creatorcodes.admin.update', $creator) }}">
                @method('PUT')
                @include('creatorcodes::admin._form')
            </form>
        </div>
    </div>
@endsection
