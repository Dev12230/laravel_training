@extends('layouts.admin')
@section('content')

@include('flash-message')

<a class="btn btn-primary btn-sm" href="cities/create"><i class="fa fa-plus"></i><span>Add New City</span></a>
<div class="wrapper wrapper-content animated fadeInRight">
<div class="row">
    <div class="col-lg-12">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Cities Table</h5>
        </div>

        <div class="ibox-content">
        <div class="table-responsive">
        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
        <table class="table table-striped table-bordered table-hover dataTables-example dataTable"
            id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" role="grid">
            <thead>
                <tr role="row">
                    <th class="sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" 
                    rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine:
                    activate to sort column descending" style="width: 175px;">#</th>
                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" 
                    rowspan="1" colspan="1" aria-label="Browser: activate to sort column 
                    ascending" style="width: 219px;">Name</th>
                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" 
                    rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column
                    ascending" style="width: 197px;">Country</th>
                    @can('city-edit','city-delete')
                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" 
                    rowspan="1" colspan="2" aria-label="CSS grade: activate to sort column 
                    ascending" style="width: 105px;">Actions</th>
                    @endcan
                </tr>
            </thead>
            <tbody>
                @if(!empty($cities))
                @foreach($cities as $city)
                <tr class="gradeA odd" role="row">
                    <td class="sorting_1">{{$city->id}}</td>
                    <td>{{$city->city_name}}</td>
                    <td>{{ $city->country->name }}</td>
                    
                    @can('city-edit')
                    <td >
                        <a href="{{route('cities.edit', $city->id)}}" class="btn btn-success btn-xs">Edit</a>
                    </td>
                        @endcan

                    @can('city-delete')
                    <td>
                        <form action="{{route('cities.destroy', $city->id)}}" method="post" style="display: inline-block;" onsubmit="return confirm('{{ __('Are you sure you want to delete this city ?') }}')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-xs" > <i class="far fa-trash-alt"></i>Delete</button>
                         </form>
                    </td>
                     @endcan
                    
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>

        </div>
        </div>
        </div>
        {{ $cities->links() }}
    </div>
    </div>
</div>
</div>


@endsection