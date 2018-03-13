@extends('layouts.master')

@section('content')

<!-- START BREADCRUMB -->
<ul class="breadcrumb push-down-0">
	<li><a href="#">Institute</a></li>
</ul>
<!-- END BREADCRUMB --> 

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

	<div class="row">
		<div class="col-md-12">

			
			<div class="panel panel-default">
				<!-- /.panel-heading -->
				<div class="panel-body">
					<h3 class="card-title">Institutes</h3>
					<h6 class="card-subtitle mb-2 text-muted">List</h6>

					@if(Auth::user()->role_id == 3)
						<p>
							<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus-circle"></i> Add Institute</button>
							<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#coursesModal"><i class="fa fa-plus-circle"></i> Add Course</button>
						</p>
					@endif
					<table width="100%" class="table table-striped table-bordered table-hover datatable">
						<thead>
							<tr>
								<th>#</th>
								<th>Institute</th>
								@if(Auth::user()->role_id == 3)
								<th>
									Option
								</th>
								@endif
							</tr>
						</thead>
						<tbody>
							<?php $i=1; ?>
							@foreach($institutes as $institute)
							<tr>
								<td>{{ $i++ }}</td>
								<td>
									
									<!-- START ACCORDION -->        
									<div class="panel-group accordion accordion-dc">
										<div class="panel panel-primary">
											<div class="panel-heading">
												<h5 class="panel-title">
													<a href="#{{ $institute->code }}">
														{{ $institute->name }} ({{ $institute->code }})
													</a>
												</h5>
												
											</div>                                
											<div class="panel-body" id="{{ $institute->code }}">
												<h6>Courses Offered:</h6>
												<ul>
													@foreach($courses as $course)
														@if($course->institute_id == $institute->id)
															<li>
																<a type="a" class="" data-toggle="modal" data-target="#coursesModal_2{{$course->id}}">
																	<i class="fa fa-edit" data-toggle="tooltip" data-placement="top" title="Edit Course"></i>
																</a>
																{{$course->name}} 
															</li>
														@endif
													@endforeach
												</ul>
											</div>                                
										</div>
                           			 </div>
                            		<!-- END ACCORDION -->
								</td>
								@if(Auth::user()->role_id == 3)
									<td>
										<!-- <form action="{{route('institutes.destroy', $institute->id)}}" method="POST">      
											<input type="hidden" name="_method" value="delete">
											<input type="hidden" name="_token" value="{{ csrf_token() }}"> 
											<button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#myModal_2{{$institute->id}}"><i class="fa fa-edit"></i>Edit</button>
											<input type="submit" class="btn btn-xs" onclick="return confirm('Are you sure?')" value="delete">
										</form> -->
										<div class="btn-group dropup">
											<button type="button" class="btn btn-info dropdown-toggle btn-block" data-toggle="dropdown">Option <span class="caret"></span></button>
											<ul class="dropdown-menu" role="menu">
												<li role="presentation" class="dropdown-header"><strong>What to do?</strong></li>
													<li><a href="#" data-toggle="modal" data-target="#myModal_2{{$institute->id}}">Edit</a></li>                   
											</ul>
										</div>
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
	</div>

</div>


<!-- Modal Add Institute -->
<div id="myModal" class="modal fade" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Institute Information</h4>
			</div>
			
			<form method="POST" action="{{route('institutes.store')}}">
			
				<div class="modal-body">
					{{ csrf_field()}}
						<div class="form-group{{ ($errors->has('name')) ? $errors->first('name') : '' }}">
							<input type="text" name="name" class="form-control" pattern="^[A-Za-z-'-. _]*[A-Za-z-'-.][A-Za-z-'-. _]*$" placeholder="Enter Institute name" required>
							{!! $errors->first('name', '<p class="help-block">:message</p>') !!}
						</div>
						<div class="form-group{{ ($errors->has('code')) ? $errors->first('code') : '' }}">
							<input type="text" name="code" class="form-control" pattern="^[A-Za-z-'-. _]*[A-Za-z-'-.][A-Za-z-'-. _]*$" placeholder="Enter Institute Code" required>
							{!! $errors->first('code', '<p class="help-block">:message</p>') !!}
						</div>
				</div>
				<div class="modal-footer">
					<div class="form-group">
						<input type="submit" class="btn btn-primary" value="Submit">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>

			</form>
		</div>

	</div>
</div>
<!--end-->

<!-- Modal Edit Institute-->
@foreach($institutes as $institute_modal)
<div id="myModal_2{{$institute_modal->id}}" class="modal fade" role="dialog">
	<div class="modal-dialog">
	<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Edit Instititute</h4>
			</div>

			<form action="{{route('institutes.update', $institute_modal->id)}}" method="post">
				<div class="modal-body">
								<input type="hidden" name="_method" value="PATCH">
								{{ csrf_field()}}
								Institute Name
								<div class="form-group{{ ($errors->has('name')) ? $errors->first('name') : '' }}">
									<input type="text" name="name" pattern="^[A-Za-z-'-. _]*[A-Za-z-'-.][A-Za-z-'-. _]*$" class="form-control" placeholder="Enter Institute name" value="{{ $institute_modal->name }}"required>
									{!! $errors->first('name', '<p class="help-block">:message</p>') !!}
									<br>
									Institute Code:
									<input type="text" name="code" pattern="^[A-Za-z _]*[A-Za-z][A-Za-z _]*$" class="form-control" value="{{ $institute_modal->code }}" required>
									{!! $errors->first('code', '<p class="help-block">:message</p>') !!}
									
									{!! $errors->first('enrollee', '<p class="help-block">:message</p>') !!}
									<input type="hidden" name="ins_id" value="{{ $institute_modal->id }}">
								</div>
								@foreach($acad_years as $ay)
				  					<input type="hidden" name="ay_id" value="{{$ay->id}}"> 
				   				 @endforeach
							<div class="form-group" >
								<input type="submit" class="btn btn-primary" value="Submit"> 
								<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
							</div>
				</div>
			</form>
			
		</div>
	</div>
</div>
@endforeach
<!-- Modal --> 

<!-- Modal Add Course -->
<div id="coursesModal" class="modal fade" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Course Information</h4>
			</div>
			
			<form method="POST" action="{{route('courses.store')}}">
			
				<div class="modal-body">
					{{ csrf_field()}}
						<div class="form-group{{ ($errors->has('name')) ? $errors->first('name') : '' }}">
							Course Name:
							<input type="text" name="name" class="form-control" pattern="^[A-Za-z-'-. _]*[A-Za-z-'-.][A-Za-z-'-. _]*$" placeholder="Enter Course name" required>
							{!! $errors->first('name', '<p class="help-block">:message</p>') !!}
						</div>

						<div class="form-group{{ ($errors->has('code')) ? $errors->first('code') : '' }}">
							Course Code:
							<input type="text" name="code" class="form-control" pattern="^[A-Za-z-'-. _]*[A-Za-z-'-.][A-Za-z-'-. _]*$" placeholder="Enter Course Code" required>
							{!! $errors->first('code', '<p class="help-block">:message</p>') !!}
						</div>

						<div class="form-group{{ ($errors->has('code')) ? $errors->first('code') : '' }}">
							Institute:
							<select name="institute_id" class="select form-control" required>
								<option></option>
								@foreach($institutes as $institute_select)
									<option value="{{$institute_select->id}}"> {{ $institute_select->name }}</option>
								@endforeach
							</select>
							{!! $errors->first('code', '<p class="help-block">:message</p>') !!}
						</div>
				</div>
				<div class="modal-footer">
					<div class="form-group">
						<input type="submit" class="btn btn-primary" value="Submit">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>

			</form>
		</div>

	</div>
</div>
<!--end-->
        
<!-- Modal Edit Course-->
@foreach($courses as $course_modal)
<div id="coursesModal_2{{$course_modal->id}}" class="modal fade" role="dialog">
	<div class="modal-dialog">
	<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Edit Instititute</h4>
			</div>

			<form action="{{route('courses.update', $course_modal->id)}}" method="post">
				<div class="modal-body">
								<input type="hidden" name="_method" value="PATCH">
								{{ csrf_field()}}
								<div class="form-group{{ ($errors->has('name')) ? $errors->first('name') : '' }}">
									Course Name:
									<input type="text" name="name" pattern="^[A-Za-z-'-. _]*[A-Za-z-'-.][A-Za-z-'-. _]*$" class="form-control" placeholder="Enter Institute name" value="{{ $course_modal->name }}"required>
									{!! $errors->first('name', '<p class="help-block">:message</p>') !!}
									<br>

									Course Name Code:
									<input type="text" name="code" pattern="^[A-Za-z _]*[A-Za-z][A-Za-z _]*$" class="form-control" value="{{ $course_modal->code }}" required>
									{!! $errors->first('code', '<p class="help-block">:message</p>') !!}
									<br>

									Institute:
									<select name="institute_id" class="select form-control" required>
										<option></option>
										@foreach($institutes as $institute_select)
											<option value="{{$institute_select->id}}" @if($course_modal->institute_id == $institute_select->id) selected @endif> {{ $institute_select->name }}</option>
										@endforeach
									</select>
									{!! $errors->first('code', '<p class="help-block">:message</p>') !!}
									<input type="hidden" name="ins_id" value="{{ $course_modal->id }}">
								</div>
								@foreach($acad_years as $ay)
				  					<input type="hidden" name="ay_id" value="{{$ay->id}}"> 
				   				 @endforeach
							<div class="form-group" >
								<input type="submit" class="btn btn-primary" value="Submit"> 
								<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
							</div>
				</div>
			</form>
			
		</div>
	</div>
</div>
@endforeach
@endsection