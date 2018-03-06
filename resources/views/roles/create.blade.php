@extends('layouts.app')

@section('content')

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Tables</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				DataTables Advanced Tables
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<div class="articles-container">
						<div class="divider" style="margin-top: 1rem;"></div>
						<form action="{{route('roles.store')}}" method="post">
							{{ csrf_field()}}
							<div class="form-group{{ ($errors->has('name')) ? $errors->first('name') : '' }}">
								Role Name:
								<input type="text" name="name" class="form-control" placeholder="Enter role name" required>
								{!! $errors->first('name', '<p class="help-block">:message</p>') !!}
								<br>
							</div>	
							<div class="form-group">
								<input type="submit" class="btn btn-primary btn-xs" value="Submit"> <a href="{{ route('roles.index') }}" id="btn-add" class="btn btn-info btn-xs" >Cancel</a>
							</div>
						</form>
						
					</div>
			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.col-lg-12 -->
</div>

        
@endsection