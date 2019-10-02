@extends('layouts.admin')
@section('content')

@include('flash-message')
<h1>Roles</h1>
    <br>
@if(auth()->user()->can('role-create'))   
<a class="btn btn-primary btn-sm" href="roles/create"><i class="fa fa-plus"></i><span>Add New Role</span></a><br><br>
@endif
<table id="table" >
    <thead>
    <tr>
    <th>Id</th>
            <th>Role Name</th>
            <th>Description</th>
            <th>Permissions</th>
            @if(auth()->user()->can('role-edit') || auth()->user()->can('role-delete'))
            <th>Actions</th>
            @endif
            </tr>
    </thead>
    </table>

@push('scripts')
<script>
    $('#table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ route('roles.index') }}",
            dataType: 'json',
            type: 'get',
        },
        columns: [{
                data: 'id'
            },
            {
                data: 'name'
            },
            {
                data: 'description'
            },
            {
                data: null,
                render: function(data, type, row, meta) {
                    var permissions = '';
                    for (var item in row.permissions) {
                        var r = row.permissions[item];
                        permissions = permissions + r.name + '</br>';
                    }
                    return permissions;
                }   
            },

            @if(auth()->user()->can('role-edit') || auth()->user()->can('role-delete')) {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
            @endif


        ],

    });
    function myFunction() {
        var agree = confirm("Are you sure\?");
        if (agree == true) {
            return true
        } else {
            return false;
        }
    }
</script>
@endpush

</div>
@endsection