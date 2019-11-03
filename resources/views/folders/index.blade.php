
@extends('layouts.admin')
@section('content')

@include('flash-message')

<h1>Folders</h1>

<a class="btn btn-primary btn-sm" href="folders/create"><i class="fa fa-plus"></i><span>Add New Folder</span></a><br><br>
{!! $dataTable->table() !!}
@push('scripts')
<script src="/vendor/datatables/buttons.server-side.js"></script>
{!! $dataTable->scripts() !!}
@endpush
@endsection