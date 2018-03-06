@extends('layouts.app')

@section('content')

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">User</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				Create new User
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<div class="articles-container">
					<form class="form-horizontal" method="POST" action="{{ route('users.update', $user->id)}}">
						{{ csrf_field() }}

						<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
							<label for="name" class="col-md-4 control-label">Employee ID/ Student ID</label>

							<div class="col-md-6">
								<input id="name" type="text" class="form-control" name="es_id" value="{{ $user->es_id }}" required autofocus>

								@if ($errors->has('es_id'))
									<span class="help-block">
										<strong>{{ $errors->first('es_id') }}</strong>
									</span>
								@endif
							</div>
						</div>

						<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
							<label for="name" class="col-md-4 control-label">Full Name</label>

							<div class="col-md-6">
								<input id="name" type="text" class="form-control" name="name" value="{{ $user->name }}" required autofocus>

								@if ($errors->has('name'))
									<span class="help-block">
										<strong>{{ $errors->first('name') }}</strong>
									</span>
								@endif
							</div>
						</div>

						<div class="form-group{{ $errors->has('role_id') ? ' has-error' : '' }}">
							<label for="role_id" class="col-md-4 control-label">Role</label>

							<div class="col-md-6">
								<select class="form-control" name="role_id" required>
									<option value="">--Select--</option>
									@foreach($role as $roles)
										<option value="{{ $roles->id }}"
											@if($roles->id == $user->role_id)
												selected
											@endif
										
										>{{ $roles->name }}</option>
									@endforeach
									
								</select>

								@if ($errors->has('email'))
									<span class="help-block">
										<strong>{{ $errors->first('role_id') }}</strong>
									</span>
								@endif
							</div>
						</div>

						<div class="form-group{{ $errors->has('organization_id') ? ' has-error' : '' }}">
							<label for="organization_id" class="col-md-4 control-label">Organization</label>

							<div class="col-md-6">
								<select class="form-control" name="organization_id">
									<option value="">None</option>
									@foreach($org as $organization)
										<option value="{{ $organization->id }}"
										@if($organization->id == $user->organization_id)
												selected
											@endif
										
										>{{ $organization->name }}</option>
									@endforeach
									
								</select>

								@if ($errors->has('email'))
									<span class="help-block">
										<strong>{{ $errors->first('organization_id') }}</strong>
									</span>
								@endif
							</div>
						</div>

						<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
							<label for="contact" class="col-md-4 control-label">Contact Number</label>

							<div class="col-md-6">
								<input id="contact" type="text" class="form-control" name="contact" value="{{ $user->contact }}" required>

								@if ($errors->has('contact'))
									<span class="help-block">
										<strong>{{ $errors->first('contact') }}</strong>
									</span>
								@endif
							</div>
						</div>

						<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
							<label for="email" class="col-md-4 control-label">E-Mail Address</label>

							<div class="col-md-6">
								<input id="email" type="email" class="form-control" name="email" value="{{ $user->email }}" required>

								@if ($errors->has('email'))
									<span class="help-block">
										<strong>{{ $errors->first('email') }}</strong>
									</span>
								@endif
							</div>
						</div>

						<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
							<label for="password" class="col-md-4 control-label">Input Password to Save</label>

							<div class="col-md-6">
								<input id="password" type="password" class="form-control" name="password" required>

								@if ($errors->has('password'))
									<span class="help-block">
										<strong>{{ $errors->first('password') }}</strong>
									</span>
								@endif
							</div>
						</div>

					
						

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">
									Save
								</button>
							</div>
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