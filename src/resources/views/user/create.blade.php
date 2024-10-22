@extends('layouts.main')

@section('title', 'Users')

@section('content')
<div class="container-fluid">
    <div class="row page-titles">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active"><a href="{{ route('user.list') }}">User</a></li>
            <li class="breadcrumb-item"><a href="#">Create</a></li>
        </ol>
    </div>
    <!-- row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Form Create User</h4>
                </div>
                <div class="card-body">
                    <div class="form-validation">
                        <form class="needs-validation" novalidate="" action="{{ route('user.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="mb-3 row">
                                        <label class="col-lg-2 col-form-label" for="name">Username <span class="text-danger">*</span></label>
                                        <div class="col-lg-10">
                                            <input type="text" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" id="name" placeholder="Enter a username...">
                                            <x-error-feedback field="name" />
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-lg-2 col-form-label" for="email">Email <span class="text-danger">*</span></label>
                                        <div class="col-lg-10">
                                            <input type="text" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" id="email" placeholder="Enter a email...">
                                            <x-error-feedback field="email" />
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-lg-2 col-form-label">Role</label>
                                        <div class="col-sm-9">
                                            <div class="col-lg-10">
                                                <input class="form-check-input" type="radio" name="role" value="1" checked>
                                                <label class="form-check-label">
                                                    User
                                                </label>
                                            </div>
                                            <div class="col-lg-10">
                                                <input class="form-check-input" type="radio" name="role" value="0">
                                                <label class="form-check-label">
                                                    Admin
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <div class="col-lg-12 ms-auto">
                                            <button type="submit" class="btn btn-primary">Submit</button>
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
@endsection