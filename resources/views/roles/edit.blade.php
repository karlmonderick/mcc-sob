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
				<div class="col-sm-12">
					<section class="row">
						<div class="col-md-12 col-lg-12">
							
							<div class="card mb-4">
								<div class="card-block">
									<h3 class="card-title">Roles</h3>
									
									<h6 class="card-subtitle mb-2 text-muted">Edit</h6>
									
									
									<div class="articles-container">
										<div class="divider" style="margin-top: 1rem;"></div>
										<form action="{{route('roles.update', $roles->id)}}" method="post">
											<input type="hidden" name="_method" value="PATCH">
											{{ csrf_field()}}
											<div class="form-group{{ ($errors->has('name')) ? $errors->first('name') : '' }}">
												<input type="text" name="name" class="form-control" placeholder="Enter role name" value="{{ $roles->name }}"required>
												{!! $errors->first('name', '<p class="help-block">:message</p>') !!}

											</div>
											<div class="form-group">
												<input type="submit" class="btn btn-primary btn-xs" value="Save"> <a href="{{ route('roles.index') }}" id="btn-add" class="btn btn-info btn-xs" >Cancel</a>
											</div>
										</form>
										
									</div>
								</div>
							</div>
						</div>

					</section>
				</div>
			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.col-lg-12 -->
</div>

        
@endsection