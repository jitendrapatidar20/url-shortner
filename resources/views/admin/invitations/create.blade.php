@extends('layouts.admin')
@section('content')
<div class="col-md-8 offset-md-2 mt-5">
  <div class="card card-primary card-outline" style="padding: 20px;">
    <div class="card-header">
      <div class="card-title">Create Invitation</div>
    </div>

    <form action="{{ route('admin.invitations.store') }}" method="POST">
      @csrf

      <div class="form-group mb-3">
        <label>Name</label>
        <input type="text" name="name" class="form-control" required>
        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
      </div>

      <div class="form-group mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" required>
        @error('email') <small class="text-danger">{{ $message }}</small> @enderror
      </div>

      <div class="form-group mb-3">
        <label>Role</label>
        <select name="role_id" class="form-control" required>
          <option value="">Select Role</option>
          @foreach($roles as $role)
            <option value="{{ $role->id }}">{{ $role->name }}</option>
          @endforeach
        </select>
        @error('role_id') <small class="text-danger">{{ $message }}</small> @enderror
      </div>

      @if(auth()->user()->hasRole('SuperAdmin'))
      <div class="form-group mb-3">
        <label>Company</label>
        <select name="company_id" class="form-control" required>
          <option value="">Select Company</option>
          @foreach($companies as $company)
            <option value="{{ $company->id }}">{{ $company->name }}</option>
          @endforeach
        </select>
        @error('company_id') <small class="text-danger">{{ $message }}</small> @enderror
      </div>
      @endif

      <button type="submit" class="btn btn-success">Send Invitation</button>
    </form>
  </div>
</div>
@endsection
