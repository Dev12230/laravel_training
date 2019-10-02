@extends('layouts.admin')
@section('content')

@include('flash-message')
<h1>Visitors</h1>
    <br>


<br>
@if(auth()->user()->can('visitor-create'))  
<a class="btn btn-primary btn-sm" href="visitors/create"><i class="fa fa-plus"></i><span>Add New </span></a><br><br>
@endif
<table id="table" >
    <thead>
    <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Gender</th>
            <th>City</th>
            <th>Country</th>
            <th>Image</th>
            @if(auth()->user()->can('visitor-edit') || auth()->user()->can('visitor-delete'))
            <th>Actions</th>
            @endif
            @if(auth()->user()->can('visitor-active'))
            <th>Status</th>
            @endif
            
            </tr>
    </thead>
    </table>


@push('scripts')
<script>
    $('#table').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ route('visitors.index') }}",
            dataType: 'json',
            type: 'get',
        },
        dom: 'lBfrtip',
        buttons: [
                    {
                        extend: 'collection',
                        text: 'Export',
                        buttons: [
                            'copy',
                            'excel',
                            'csv',
                            'pdf',
                            'print'
                        ]
                    }
                ],
        columns: [ 
            {data: 'user.first_name',name: 'user.first_name',orderable: false}, 
            {data: 'user.last_name',name: 'user.last_name',orderable: false}, 
            {data: 'user.email',name: 'user.email',orderable: false}, 
            {data: 'user.phone',name: 'user.phone',orderable: false}, 
            {data: 'user.gender',name: 'user.gender',orderable: false}, 
            {data: 'city.city_name',name: 'city.city_name',orderable: false},
            {data: 'city.country.name',name: 'city.country.name',orderable: false},    
            {data: 'image',
                    render: function( data, type, row, meta ) {
                        return `<img src="{{ Storage::url('${row.image.image}') }}" style="height:50px; width:50px;">`;
                    }
            },  
            @if(auth()->user()->can('visitor-edit') || auth()->user()->can('visitor-delete'))
            {data: 'action',name: 'action',orderable: false, searchable: false},
            @endif
            @if(auth()->user()->can('visitor-active'))
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
@endpush


</div>
@endsection
