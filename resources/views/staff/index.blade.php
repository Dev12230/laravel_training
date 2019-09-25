@extends('layouts.admin')
@section('content')

@include('flash-message')
<h1>Staff</h1>
    <br>

<a class="btn btn-primary btn-sm" href="staff/create"><i class="fa fa-plus"></i><span>Add New </span></a><br><br>

<table id="table" >
    <thead>
    <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Gender</th>
            <th>Roles</th>
            <th>Image</th>
            <th>Actions</th>
            
            </tr>
    </thead>
    </table>

<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script>
    $('#table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "/staff_list",
            dataType: 'json',
            type: 'get',
        },
        columns: [ {
                mRender: function(data, type, row) {
                    return row.user.first_name
                       
                }
            },
            {
                mRender: function(data, type, row) {
                    return row.user.last_name
                       
                }
            },
            {
                mRender: function(data, type, row) {
                    return row.user.email
                       
                }
            },
            {
                mRender: function(data, type, row) {
                    return row.user.phone
                       
                }
            },
            {
                mRender: function(data, type, row) {
                    return row.user.gender
                       
                }
            },
            {
                data: 'role',
                name: 'role',        
            },

            {
                data: 'image',
                name: 'image',
            },
            {
                data: 'action',
                name: 'action',
            },

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


</div>
@endsection
