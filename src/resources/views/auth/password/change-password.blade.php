@extends('layouts.main')
@section('title', 'Change Password')
@section('content')
<div class="container-fluid">
    <div class="row page-titles">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active"><a href="#">Password</a></li>
            <li class="breadcrumb-item"><a href="#">Change</a></li>
        </ol>
    </div>
    <!-- row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Form Change password</h4>
                </div>
                <div class="card-body">
                    <div class="basic-form">
                        <form action="{{ route('auth.password.update') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="text-label form-label" for="dlab-password">Password <span class="text-danger">*</span></label>
                                <div class="input-group transparent-append">
                                    <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                                    <input type="password" id="password" name="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" value="{{ old('password') }}" placeholder="Enter your password.">
                                </div>
                                <x-error-feedback field="password" />
                            </div>
                            <div class="mb-3">
                                <label class="text-label form-label" for="dlab-password">Confirm Password <span class="text-danger">*</span></label>
                                <div class="input-group transparent-append">
                                    <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}" value="{{ old('password_confirmation') }}" placeholder="Confirm your password.">
                                </div>
                                <x-error-feedback field="password_confirmation" />
                            </div>
                            <button type="submit" class="btn btn-sm btn-primary">Change Password</button>
                        </form>               
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection