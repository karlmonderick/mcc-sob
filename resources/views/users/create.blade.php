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
					<form class="form-horizontal" method="POST" action="{{ route('users.store') }}">
						{{ csrf_field() }}

						<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
							<label for="name" class="col-md-4 control-label">Employee ID/ Student ID</label>

							<div class="col-md-6">
								<input id="name" type="text" class="form-control" pattern="\d*([-]?\d+)" name="es_id" required autofocus>

								@if ($errors->has('es_id'))
									<span class="help-block">
										<strong>{{ $errors->first('es_id') }}</strong>
									</span>
								@endif
							</div>
						</div>

						<div class="col-md-6">
							<div class="col-md-4">
								<input id="name" type="text" class="form-control" pattern="^[A-Za-z _]*[A-Za-z][A-Za-z _]*$" name="first_name"  placeholder="First Name" required autofocus>
							</div>
							<div class="col-md-4">
								<input id="name" type="text" class="form-control" pattern="^[A-Za-z _]*[A-Za-z][A-Za-z _]*$" name="middle_name"  placeholder="Middle Name" required autofocus>
							</div>
							<div class="col-md-4">
								<input id="name" type="text" class="form-control" pattern="^[A-Za-z _]*[A-Za-z][A-Za-z _]*$" name="last_name"  placeholder="Last Name" required autofocus>
							</div>
							
							@if ($errors->has('name'))
								<span class="help-block">
									<strong>{{ $errors->first('name') }}</strong>
								</span>
							@endif
						</div>

						<div class="form-group{{ $errors->has('role_id') ? ' has-error' : '' }}">
							<label for="role_id" class="col-md-4 control-label">Role</label>

							<div class="col-md-6">
								<select class="form-control" name="role_id" required>
										<option value="">--Select--</option>
									@foreach($role as $roles)
									@if($roles->id == 3)
										<option value="{{ $roles->id }}">{{ $roles->name }}</option>
									@endif
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
								<select class="form-control" name="organization_id" required>
									<option value="">None</option>
									@foreach($org as $organization)
										<option value="{{ $organization->id }}">{{ $organization->name }}</option>
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
								<input id="contact" type="text" class="form-control" pattern="[0-9]{11}"  name="contact" value="{{ old('contact') }}" required>

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
								<input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

								@if ($errors->has('email'))
									<span class="help-block">
										<strong>{{ $errors->first('email') }}</strong>
									</span>
								@endif
							</div>
						</div>

						<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
							<label for="password" class="col-md-4 control-label">Password</label>

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
							<label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

							<div class="col-md-6">
								<input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">
									Register
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