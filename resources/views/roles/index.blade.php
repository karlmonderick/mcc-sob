@extends('layouts.app')

@section('content')
<style type="text/css">
    a[disabled="disabled"] {
        pointer-events: none;
    }
</style>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Roles</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                List
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Role</th>
                    @if(Auth::user()->role_id == 1)
                    <th>
                        <a href="{{ route('roles.create') }}" id="btn-add" class="btn btn-success btn-xs" >Add New role</a>
                    </th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach($roles as $role)
                <tr>
                    <td>{{ $role->id }}</td>
                    <td>{{ $role->name }}</td>
                    @if(Auth::user()->role_id == 1)
                    <td>
                        <form action="{{route('roles.destroy', $role->id)}}" method="POST">      
                            <input type="hidden" name="_method" value="delete">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}"> 
                            @if($role->id == 0)
                            <a href="{{route('roles.edit', $role->id)}}" class="btn btn-xs btn-warning">Edit</a>
                            
                            <input type="submit" class="btn btn-xs" onclick="return confirm('Are you sure?')" value="delete">
                            
                            @endif
                        </form>
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
                </table>
                <!-- /.table-responsive -->
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>


        
@endsection