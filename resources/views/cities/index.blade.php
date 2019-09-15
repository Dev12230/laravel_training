@extends('layouts.admin')
@section('content')

@include('flash-message')

<h1>Cities</h1>
    <br>
<a class="btn btn-primary btn-sm" href="cities/create"><i class="fa fa-plus"></i><span>Add New City</span></a><br><br>
<table id="table" >
    <thead>
        <tr>
            <th>Id</th>
            <th>City Name</th>
            <th>Country</th>
            <th>Actions</th>

        </tr>
    </thead>
</table>

<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script>
    $('#table').DataTable({
        serverSide: true,
        ajax: {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "/cities_list",
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
                mRender: function(data, type, row) {
                    return row.country.name
                       
                }
            },
            {
                mRender: function(data, type, row) {
                    return '<a  href="/cities/' + row.id + '/edit" class="bttn btn btn-xs btn-info " data-id="' + row.id + '"><i class="fa fa-edit"></i><span>Edit</span></a>' +
                        '<form method="POST" style="display: inline;" action="cities/'+row.id+'">@csrf {{ method_field('DELETE')}}<button type="submit" onclick="return myFunction();" class="bttn btn btn-xs btn-danger"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="Delete"></i><span>Delete</span></button></form>'
                }
            },
        ],
        'lengthChange': true,
        'searching': true,
        'ordering': true,
        'info': true,
        'autoWidth': true,
        'paging': true,
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