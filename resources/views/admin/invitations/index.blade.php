@extends('layouts.admin')
@section('content')
<div class="col-md-12" style="padding: 20px;">
  <div class="card card-primary card-outline" style="padding: 20px;">
    <div class="card-header">
      <div class="card-title">Invitations</div>
    </div>

    @if(auth()->user()->hasAnyRole(['SuperAdmin','Admin']))
        <div class="mb-3">
           <a href="{{ route('admin.invitations.create') }}" class="btn btn-primary btn-sm">Create Invitation</a>
       </div>
    @endif
        
    <table class="table table-bordered" id="invitationTable">
    <thead>
        <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Role</th>
        <th>Company</th>
        <th>Invited By</th>
        <th>Status</th>
        <th>Action</th>
        </tr>
    </thead>
    </table>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<script>
$('#invitationTable').DataTable({
    processing: true,
    serverSide: false,
    ajax: "{{ route('admin.invitations.index') }}",
    columns: [
            { data: 'id' },
            { data: 'name' },
            { data: 'email' },
            { data: 'role.name', defaultContent: '' },
            { data: 'company.name', defaultContent: '' },
            { data: 'inviter.name', defaultContent: '' },
            { data: 'status' },
            {
                data: null,
                orderable: false,
                render: function (data, type, row) {
                    if (row.status === 'Pending') {
                        return `
                            <form method="POST" action="/admin/invitations/${row.id}/approve" class="approveForm" style="display:inline-block;">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">Approve</button>
                            </form>`;
                    } else {
                        return '<span class="badge bg-danger">Approved</span>';
                    }
                }
            }
        ]
 
});

$(document).on('submit', '.approveForm', function (e) {
    e.preventDefault();
    if (confirm('Are you sure you want to approve this invitation?')) {
        const form = $(this);
        $.post(form.attr('action'), form.serialize(), function() {
            alert('Invitation approved successfully!');
            $('#invitationTable').DataTable().ajax.reload(); // refresh table
        });
    }
});
</script>
@endsection
