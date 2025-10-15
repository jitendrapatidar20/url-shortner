

@extends('layouts.admin')
@section('content')
<div class="col-md-12" style="padding: 20px;">
    <div class="card card-primary card-outline" style="padding: 20px;">
        <div class="card-header">
            <div class="card-title">Client List</div>
        </div>

        <div class="mb-3">
            <a href="{{ route('admin.companies.create') }}" class="btn btn-primary btn-sm">Create Client</a>
            <a href="{{ route('admin.companies.index', ['filter'=>'week']) }}" class="btn btn-secondary btn-sm">Last Week</a>
            <a href="{{ route('admin.companies.index', ['filter'=>'month']) }}" class="btn btn-secondary btn-sm">Last Month</a>
            <a href="{{ route('admin.companies.index') }}" class="btn btn-secondary btn-sm">View All</a>
        </div>

        <table class="table table-bordered" id="companyTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Company Name</th>
                    <th>Total Users</th>
                    <th>Total URLs</th>
                    <th>Total Hits</th>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<script>
$('#companyTable').DataTable({
    ajax: "{{ route('admin.companies.list') }}",
    columns: [
        { data: 'id' },
        { data: 'name' },
        { data: 'total_users' },
        { data: 'total_urls' },
        { data: 'total_hits' },
        {
                data: 'id',
                render: function(data) {
                    return `
                        <a href="/admin/companies/${data}/edit" class="btn btn-sm btn-info">Edit</a>
                        <button class="btn btn-sm btn-danger delete-btn" data-id="${data}">Delete</button>
                    `;
                }
         },
    ]
});

    $(document).on('click', '.delete-btn', function () {
        let id = $(this).data('id');
        if(confirm("Are you sure?")) {
            $.ajax({
                url: `/admin/companies/${id}`,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(res) {
                    Lobibox.notify('success', {
                            pauseDelayOnHover: true,
                            continueDelayOnInactiveTab: false,
                            msg: 'Client Successfully Deleted'
                    });
                    setTimeout(function(){
                            location.reload();
                    }, 2000);
                }
            });
        }
    });
</script>
@endsection