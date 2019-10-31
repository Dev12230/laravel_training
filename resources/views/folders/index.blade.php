
@extends('layouts.admin')
@section('content')

@include('flash-message')

<h1>Folders</h1>

<a class="btn btn-primary btn-sm" href="folders/create"><i class="fa fa-plus"></i><span>Add New Folder</span></a><br><br>

<table id="table" >
    <thead>
    <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Actions</th>
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
            
            dataType: 'json',
            type: 'get',
            url: "{{ route('folders.index') }}",
            
        },
        columns: [
            {data: 'name',
                mRender: function(data, type, row) {
                        return '<a href="/folders/'+ row.id + '" title="'+row.name+'">' +
                        '<img src="{{ asset('theme/img/folder-Icon.jpg') }}" style="height:50px; width:70px;0"/>'+
                        '<figcaption style=" text-align: center;">'+row.name+'</figcaption></a>'
                    }
            },
            {data: 'description'},
            {data: 'action',name: 'action', orderable: false,searchable: false},  
        ],

    });

</script>
@endpush

</div>
@endsection