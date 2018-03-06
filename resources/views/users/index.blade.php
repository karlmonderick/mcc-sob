@extends('layouts.master')

@section('content')


<!-- START BREADCRUMB -->
<ul class="breadcrumb push-down-0">
	<li><a href="#">Users</a></li>
</ul>
<!-- END BREADCRUMB -->    

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

	<div class="row">

		<div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Options</h3>
                </div>
                <div class="panel-body">
					@if(Auth::user()->role_id == 3)
						<p>
							<button type="button" class="btn btn-success btn-block btn-rounded" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus-circle"></i>Add a New User.</button>
						</p>
					@endif
					
                </div>
            </div>
         </div>

		<div class="col-md-9">
			<div class="panel panel-default tabs">
				<ul class="nav nav-tabs nav-justified">
					<li class="active"><a href="#tab7" data-toggle="tab">Admins</a></li>
					<li><a href="#tab8" data-toggle="tab">Students</a></li>
				</ul>
				<div class="panel-body tab-content">
					<div class="tab-pane active" id="tab7">
						<div class="table-responsive">
							<table class="table table-bordered datatable">
								<thead>
									<tr>
										<th>#</th>
										<th>Employee/Student #</th>
										<th>Full Name</th>
										<th>Role</th>
										<th>Status</th>
									</tr>
								</thead>
								<tbody>
									<?php $i=1; ?>
									@foreach($user_e as $user)
										<tr>
											<td>{{ $i++ }}</td>
											<td>{{ $user->es_id }}</td>
											<td>{{ $user->first_name }} {{ $user->middle_name }} {{ $user->last_name }}</td>
											<td>{{ $user->role->name }}</td>
											<td>
												@if($user->status ==1)
													<span class="label label-success">Active</span>
												@else
													<span class="label label-danger">Inactive</span>
												@endif
											</td>
										</tr>
									@endforeach
								</tbody>
							</table>
							<!-- /.table-responsive -->
						</div>
					</div>
					<div class="tab-pane" id="tab8">
						<div class="table-responsive">
							<table class="table table-bordered datatable">
								<thead>
									<tr>
										<th>#</th>
										<th>Employee/Student #</th>
										<th>Full Name</th>
										<th>Role</th>
									</tr>
								</thead>
								<tbody>
									<?php $i=1; ?>
									@foreach($user_s as $user2)
										<tr>
											<td>{{ $i++ }}</td>
											<td>{{ $user2->es_id }}</td>
											<td>{{ $user2->first_name }} {{ $user2->middle_name }} {{ $user2->last_name }}</td>
											<td>
												@if($user2->status ==1)
													<span class="label label-success">Active</span>
												@else
													<span class="label label-danger">Inactive</span>
												@endif
											</td>
										</tr>
									@endforeach
								</tbody>
							</table>
							<!-- /.table-responsive -->
						</div>
					</div>
					<!-- /.table-responsive -->
				</div>
				<!-- /.panel-body -->
			</div>
			<!-- /.panel -->
		</div>
		
	</div>

</div>

<div id="myModal" class="modal fade" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">User Information</h4>
			</div>
			
			<form class="form-horizontal" method="POST" action="{{ route('users.store') }}">
			
				<div class="modal-body">
					
					{{ csrf_field() }}

					<div class="form-group{{ $errors->has('es_id') ? ' has-error' : '' }}">
						<label for="es_id" class="col-md-4 control-label">Employee ID</label>

						<div class="col-md-6">
							<input id="es_id" type="text" class="form-control" pattern="\d*([-]?\d+)" name="es_id" required autofocus>

							@if ($errors->has('es_id'))
								<span class="help-block">
									<strong>{{ $errors->first('es_id') }}</strong>
								</span>
							@endif
						</div>
					</div>

					<div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
						<label for="first_name" class="col-md-4 control-label">First Name</label>

						<div class="col-md-6">
							<input id="first_name" type="text" class="form-control" pattern="^[A-Za-z _]*[A-Za-z][A-Za-z _]*$" name="first_name" required autofocus>

							@if ($errors->has('first_name'))
								<span class="help-block">
									<strong>{{ $errors->first('first_name') }}</strong>
								</span>
							@endif
						</div>
					</div>

					<div class="form-group{{ $errors->has('middle_name') ? ' has-error' : '' }}">
						<label for="middle_name" class="col-md-4 control-label">Middle Name</label>

						<div class="col-md-6">
							<input id="middle_name" type="text" class="form-control" pattern="^[A-Za-z _]*[A-Za-z][A-Za-z _]*$" name="middle_name" placeholder="Optional" autofocus>

							@if ($errors->has('middle_name'))
								<span class="help-block">
									<strong>{{ $errors->first('middle_name') }}</strong>
								</span>
							@endif
						</div>
					</div>

					<div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
						<label for="last_name" class="col-md-4 control-label">Last Name</label>

						<div class="col-md-6">
							<input id="last_name" type="text" class="form-control" pattern="^[A-Za-z _]*[A-Za-z][A-Za-z _]*$" name="last_name" required autofocus>

							@if ($errors->has('last_name'))
								<span class="help-block">
									<strong>{{ $errors->first('last_name') }}</strong>
								</span>
							@endif
						</div>
					</div>

					<div class="form-group{{ $errors->has('role_id') ? ' has-error' : '' }}">
						<label for="role_id" class="col-md-4 control-label">Role</label>

						<div class="col-md-6">
							<select name="role_id" id="role_id" class="form-control">
								<option value="3">SAS Director</option>
								<option value="1">OSCA Coordinator</option>
							</select>
						{!! $errors->first('role_id', '<p class="help-block">:message</p>') !!}
						</div>
					</div>

					<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
						<label for="contact" class="col-md-4 control-label">Contact Number</label>

						<div class="col-md-6">
							<input id="contact" type="text" class="mask_phone form-control"  name="contact"  required>

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
							<input id="email" type="email" class="form-control" name="email"  required>

							@if ($errors->has('email'))
								<span class="help-block">
									<strong>{{ $errors->first('email') }}</strong>
								</span>
							@endif
						</div>
					</div>
					<div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
						<label for="status" class="col-md-4 control-label">Activate</label>

						<div class="col-md-6">
							<label class="switch">
								<input name="status" type="checkbox" checked value="1"/>
								<span></span>
							</label>
							<br>
							<i class="help-block">If yes, this would deactivate the current active user</i>
						{!! $errors->first('status', '<p class="help-block">:message</p>') !!}
						</div>
					</div>	
				
				</div>
			
				
				<div class="modal-footer">
					<div class="form-group">
						<div class="col-md-6 col-md-offset-4">
							<button type="submit" class="btn btn-primary">
								Add
							</button>
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						</div>
					</div>
				</div>

			</form>
		</div>

	</div>
</div>

        

@endsection