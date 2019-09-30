@extends('layouts.admin')
@section('content')

@include('flash-message')

<h1>Cities</h1>
@if(auth()->user()->can('city-create'))
<a class="btn btn-primary btn-sm" href="cities/create"><i class="fa fa-plus"></i><span>Add New City</span></a><br><br>
@endif
<table id="table" >
    <thead>
    <tr>
    <th>Id</th>
            <th>City Name</th>
            <th>Country</th>
            @if(auth()->user()->can('city-edit') || auth()->user()->can('city-delete')) {
            <th>Actions</th>
            </tr>
            @endif
    </thead>
    </table>

<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script>
    $('#table').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,

        ajax: {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            
            dataType: 'json',
            type: 'get',
            
        },
        columns: [{
                data: 'id'
            },
            {
                data: 'city_name'
            },
            {
                data: 'country.name'
            },
            @if(auth()->user()->can('city-edit') || auth()->user()->can('city-delete')) {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
            @endif

   
        ],

    });

</script>


</div>
@endsection