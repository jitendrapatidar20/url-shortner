@extends('layouts.admin')
@section('content')
<div class="col-md-12" style="padding: 20px;">
    <div class="card card-primary card-outline" style="padding: 20px;">
        <div class="card-header">
            <div class="card-title">Short URLs</div>
        </div>

        <div class="mb-3">
            <a href="{{ route('admin.short_urls.create') }}" class="btn btn-primary btn-sm">Add Short URL</a>
            <a href="{{ route('admin.short_urls.index', ['filter'=>'week']) }}" class="btn btn-secondary btn-sm">Last Week</a>
            <a href="{{ route('admin.short_urls.index', ['filter'=>'month']) }}" class="btn btn-secondary btn-sm">Last Month</a>
            <a href="{{ route('admin.short_urls.index') }}" class="btn btn-secondary btn-sm">View All</a>
           
        </div>

        <table class="table table-bordered" id="shortUrlTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Short Code</th>
                    <th>Original URL</th>
                    <th>Resolve URL</th>
                    <th>Created By</th>
                    <th>Company</th>
                    <th>Total Hits</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<script>
$('#shortUrlTable').DataTable({
    ajax: "{{ route('admin.short_urls.index') }}",
    columns: [
        { data: 'id' },
        { data: 'short_code' },
        { data: 'original_url' },
        { data: 'resolve_url', render: function(data){ return '<a href="'+data+'" target="_blank">'+data+'</a>'; }},
        { data: 'created_by' },
        { data: 'company' },
        { data: 'hits' }
    ]
});
</script>
@endsection
