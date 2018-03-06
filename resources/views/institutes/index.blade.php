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
						</p>
					@endif
					<table width="100%" class="table table-striped table-bordered table-hover datatable">
						<thead>
							<tr>
								<th>#</th>
								<th>Code</th>
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
								<td>{{ $institute->code }}</td>
								<td>{{ $institute->name }}</td>
								@if(Auth::user()->role_id == 3)
									<td>
										<form action="{{route('institutes.destroy', $institute->id)}}" method="POST">      
											<input type="hidden" name="_method" value="delete">
											<input type="hidden" name="_token" value="{{ csrf_token() }}"> 
											@if(Auth::user()->role_id == 3)
											<button type="button" class="btn btn-warning btn-sm btn-xs" data-toggle="modal" data-target="#myModal_2{{$institute->id}}"><i class="fa fa-edit"></i>Edit</button>
											<!--<input type="submit" class="btn btn-xs" onclick="return confirm('Are you sure?')" value="delete">-->
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
	</div>

</div>


<!-- Modal -->
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

<!-- Modal -->
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
        
@endsection