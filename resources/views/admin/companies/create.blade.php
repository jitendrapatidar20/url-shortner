@extends('layouts.admin')
@section('content')
<div class="container">
   <div class="col-md-10">
      <div class="card card-primary card-outline mb-2" style="padding: 20px;">
         <div class="card-header">
            <div class="card-title">Create Client</div>
         </div>
         <form action="{{ route('admin.companies.store') }}" method="POST">
            @csrf
            @include('admin.companies.form')
            <button type="submit" class="btn btn-success">Create</button>
            <a href="{{ route('admin.companies.index') }}" class="btn btn-secondary">Cancel</a>
         </form>
      </div>
   </div>
</div>
@endsection