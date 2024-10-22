@extends('layouts.main')

@section('title', 'Users')

@section('content')
<div class="container-fluid">
    <div class="row page-titles">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active"><a href="{{ route('user.list') }}">User</a></li>
            <li class="breadcrumb-item"><a href="#">Detail</a></li>
        </ol>
    </div>
    <!-- row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Form Detail User</h4>
                </div>
                <div class="card-body">
                    <div class="form-validation">
                        <form class="needs-validation" novalidate="" action="{{ route('user.update', $user->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="mb-3 row">
                                        <label class="col-lg-2 col-form-label" for="validationCustom01">Username
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-10">
                                            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control" id="validationCustom01" placeholder="Enter a username..">
                                            <x-error-feedback field="name" />
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-lg-2 col-form-label" for="validationCustom02">Email <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-10">
                                            <input type="text" name="email" value="{{ old('email', $user->email) }}" class="form-control" id="validationCustom02" placeholder="Your valid email..">
                                            <x-error-feedback field="email" />
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-lg-2 col-form-label">Role</label>
                                        <div class="col-sm-9">
                                            <div class="col-lg-10">
                                                <input class="form-check-input" type="radio" name="role" value="1" {{ $user->role == 1 ? 'checked' : '' }}>
                                                <label class="form-check-label">
                                                    User
                                                </label>
                                            </div>
                                            <div class="col-lg-10">
                                                <input class="form-check-input" type="radio" name="role" value="0" {{ $user->role == 0 ? 'checked' : '' }}>
                                                <label class="form-check-label">
                                                    Admin
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <div class="col-lg-12 ms-auto">
                                            <button type="submit" class="btn btn-primary btn-sm">update</button>
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-danger btn-sm" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#modal-notification" 
                                                    onclick="document.getElementById('delete-user-form').action='{{ route('user.destroy',$user->id) }}'">
                                                Delete
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Delete Confirmation -->
@include('user.delete-modal')
@endsection