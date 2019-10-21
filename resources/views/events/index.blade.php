@extends('layouts.admin')
@section('content')

@include('flash-message')

<h1>Events</h1>
<a class="btn btn-primary btn-sm" href="events/create"><i class="fa fa-plus"></i><span>Add Events</span></a><br><br>
<table id="table" >
    <thead>
    <tr>
            <th>Main title</th>
            <th>Secondary title</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Location</th>
            <th>Actions</th>
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
            url: "{{ route('events.index') }}",
            dataType: 'json',
            type: 'get',
        },
        columns: [ 
            {data: 'main_title',name: 'main_title',orderable: false}, 
            {data: 'secondary_title',name: 'secondary_title',orderable: false}, 
            {data: 'start_date',name: 'start_date',orderable: false},      
            {data: 'end_date',name: 'end_date',orderable: false},    
            {data: 'address_address',name: 'address_address',orderable: false},  
            {data: 'action',name: 'action',orderable: false, searchable: false},

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


