@extends('layouts.admin')
@section('content')

@include('flash-message')

<a class="btn btn-primary btn-sm" href="roles/create"><i class="fa fa-plus"></i><span>Add New Role</span></a>
<div class="wrapper wrapper-content animated fadeInRight">
<div class="row">
    <div class="col-lg-12">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Roles Table</h5>
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
                    ascending" style="width: 197px;">Description</th>
                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" 
                    rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column
                    ascending" style="width: 197px;">Permissions</th>

                    @can('role-edit','role-delete')
                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" 
                    rowspan="1" colspan="2" aria-label="CSS grade: activate to sort column 
                    ascending" style="width: 105px;">Actions</th>
                    @endcan
                </tr>
            </thead>
            <tbody>
                @if(!empty($roles))
                @foreach($roles as $role)
                <tr class="gradeA odd" role="row">
                    <td class="sorting_1">{{$role->id}}</td>
                    <td>{{$role->name}}</td>
                    <td>{{$role->description }}</td>
                    <td>
                        @foreach($role->permissions as $p)
                        {{$p->name }} <br>
                        @endforeach
                    </td>

                    @can('role-edit')
                    <td >
                        <a href="{{route('roles.edit', $role->id)}}" class="btn btn-success btn-xs">Edit</a>
                      
                    </td>    
                    @endcan 
                    @can('role-delete')
                    <td>  
                        <form action="{{route('roles.destroy', $role->id)}}" method="post" style="display: inline-block;" onsubmit="return confirm('{{ __('Are you sure you want to delete this role ?') }}')">
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
        {{ $roles->links() }}
    </div>
    </div>
</div>
</div>


@endsection