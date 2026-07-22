@extends('layouts.staff')
@section('title', 'Accept invitation')
@section('content')
<div class="row justify-content-center pt-5"><div class="col-md-6 col-lg-5"><div class="staff-card p-4 p-md-5"><h1 class="h3 fw-bold">Set up your account</h1><p class="text-muted">Invited as <strong>{{ $invitation->email }}</strong></p>
@if($errors->any())<div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
<form method="POST">@csrf
<div class="mb-3"><label class="form-label">Full name</label><input name="name" value="{{ old('name', $invitation->name) }}" class="form-control" required></div>
<div class="mb-3"><label class="form-label">Password</label><input type="password" name="password" class="form-control" required><small class="text-muted">At least 10 characters with upper/lowercase letters and a number.</small></div>
<div class="mb-4"><label class="form-label">Confirm password</label><input type="password" name="password_confirmation" class="form-control" required></div>
<button class="btn btn-staff w-100">Create staff account</button></form></div></div></div>
@endsection
