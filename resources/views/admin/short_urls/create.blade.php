@extends('layouts.admin')
@section('content')
<div class="container">
   <div class="col-md-10">
      <div class="card card-primary card-outline mb-2" style="padding: 20px;">
         <div class="card-header">
            <div class="card-title">Create ShortUrl</div>
         </div>
         <form action="{{ route('admin.short_urls.store') }}" method="POST">
            @csrf
            <div class="form-group mb-3">
              <label>Original URL</label>
              <input type="text" name="original_url" class="form-control" value="{{ old('original_url') }}" required>
            </div>
            <button type="submit" class="btn btn-success">Generate</button>
            <a href="{{ route('admin.short_urls.index') }}" class="btn btn-secondary">Cancel</a>
         </form>
      </div>
   </div>
</div>
@endsection