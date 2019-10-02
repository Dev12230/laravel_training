@extends('layouts.admin')
@section('content')

@include('flash-message')
<h1>Staff</h1>
    <br>
@if(auth()->user()->can('staff-create'))  
<a class="btn btn-primary btn-sm" href="staff/create"><i class="fa fa-plus"></i><span>Add New </span></a><br><br>
@endif
<table id="table" >
    <thead>
    <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Gender</th>
            <th>Job</th>
            <th>City</th>
            <th>Country</th>
            <th>Roles</th>
            <th>Image</th>
            @if(auth()->user()->can('staff-edit') || auth()->user()->can('staff-delete'))
            <th>Actions</th>
            @endif
            @if(auth()->user()->can('staff-active'))
            <th>Status</th>
            @endif
            
            </tr>
    </thead>
    </table>

<script src="http://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script>
    $('#table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "/staff",
            dataType: 'json',
            type: 'get',
        },
        columns: [ 
            {data: 'user.first_name',name: 'user.first_name',orderable: false}, 
            {data: 'user.last_name',name: 'user.last_name',orderable: false}, 
            {data: 'user.email',name: 'user.email',orderable: false}, 
            {data: 'user.phone',name: 'user.phone',orderable: false}, 
            {data: 'user.gender',name: 'user.gender',orderable: false}, 
            {data: 'job.name',name: 'job.name',orderable: false},    
            {data: 'user.city.city_name',name: 'user.city.city_name',orderable: false},
            {data: 'user.country.name',name: 'user.country.name',orderable: false},    
            {data: 'role',name: 'role',orderable: false},
            {data: 'image',
                    render: function( data, type, row, meta ) {
                        return `<img src="{{ Storage::url('${row.image.image}') }}" style="height:50px; width:50px;">`;
                    }
            },  
            @if(auth()->user()->can('staff-edit') || auth()->user()->can('staff-delete'))
            {data: 'action',name: 'action',orderable: false, searchable: false},
            @endif
            @if(auth()->user()->can('staff-active'))
            {data: 'status',name: 'status',orderable: false, searchable: false},
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


</div>
@endsection
