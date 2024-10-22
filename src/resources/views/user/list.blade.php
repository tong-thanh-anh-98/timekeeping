@extends('layouts.main')

@section('title', 'Users')

@section('content')
<div class="container-fluid">
    <div class="row page-titles">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active"><a href="{{ route('user.list') }}">User</a></li>
            <li class="breadcrumb-item"><a href="#">List</a></li>
        </ol>
    </div>
    <div class="row">
        <div class="col-lg-12">
        <x-alert />
            <div class="card">
                <div class="card-header">

                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('user.list') }}" class="mb-4">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" name="name" value="{{ request('name') }}" class="form-control" placeholder="Search by Name">
                            </div>
                            <div class="col-md-4">
                                <input type="email" name="email" value="{{ request('email') }}" class="form-control" placeholder="Search by Email">
                            </div>
                            <div class="col-md-4">
                                <input type="date" name="join_date" value="{{ request('join_date') }}" class="form-control" placeholder="Search by Join Date">
                            </div>
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary btn-sm">Search</button>
                            <a href="{{ route('user.list') }}" class="btn btn-secondary btn-sm ms-0">Clear</a>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table table-hover table-responsive-sm">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Join Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($users->isNotEmpty())
                                    @foreach ($users as $user)
                                        <tr class="clickable table-link" data-href="{{ route('user.detail', $user->id) }}">
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->created_at->format('d/m/Y') }}</td>
                                        </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="3">Records Not Found</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    @if ($users->hasPages())
                        @include('components.pagination', ['paginator' => $users])
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection