@extends('layouts.admin')
@section('content')

@include('flash-message')

<h1>News</h1>

<a class="btn btn-primary btn-sm" href="news/create"><i class="fa fa-plus"></i><span>Add News</span></a><br><br>
<table id="table" >
    <thead>
    <tr>
            <th>Main title</th>
            <th>Secondary title</th>
            <th>Type</th>
            <th>Author</th>
            <th>Actions</th>
            <th>Status</th>
        
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
            url: "{{ route('news.index') }}",
            dataType: 'json',
            type: 'get',
        },
        columns: [ 
            {data: 'main_title',name: 'main_title',orderable: false}, 
            {data: 'secondary_title',name: 'secondary_title',orderable: false}, 
            {data: 'type',name: 'type',orderable: false}, 
            {data: 'staff.user.first_name',searchable: false,
                render: function ( data, type, row ) {
                   return row.staff.user.first_name + " " + row.staff.user.last_name;
                }} ,
            {data: 'action',name: 'action',orderable: false, searchable: false},
            {data: 'status',name: 'status',orderable: false, searchable: false},


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



@endsection