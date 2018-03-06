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
					@if(Auth::user()->role_id == 2)
						<p>
							<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#myModal">Add No. of Enrollee</button>
						</p>
					@endif
					<table width="100%" class="table table-striped table-bordered table-hover datatable">
						<thead>
							<tr>
								<th>#</th>
								<th>Code</th>
								<th>Institute</th>
								<th>Total Student</th>
								@if(Auth::user()->role_id == 2)
								<th>
									Option
								</th>
								@endif
							</tr>
						</thead>
						<tbody>
							<?php $i=1; ?>
							@foreach($institute as $institute)
							<tr>
								<td>{{ $i++ }}</td>
								<td>{{ $institute->code }}</td>
								<td>{{ $institute->name }}</td>
								<td>{{ $institute->no_of_students }}</td>
								@if(Auth::user()->role_id == 2)
									<td>
										<form action="{{route('institutes.destroy', $institute->id)}}" method="POST">      
											<input type="hidden" name="_method" value="delete">
											<input type="hidden" name="_token" value="{{ csrf_token() }}"> 
											@if(Auth::user()->role_id == 2)
											<a href="{{route('institutes.edit', $institute->id)}}"  
												class="btn btn-xs btn-warning">Update</a>
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
			<form method="POST" action="{{route('institutes.store2')}}">
			
				<div class="modal-body">
					{{ csrf_field()}}
						<div class="form-group{{ ($errors->has('institute_id')) ? $errors->first('institute_id') : '' }}">
							<label>Institute</label>
							<select name="institute_id" id="institute_id" class="form-control" required>
										<option value="">--Select--</option>
										@foreach($institutes as $ins)
										
										<option value="{{$institute->id}}" @foreach($eay as $eayear) @if($ins->id == $eayear->institute_id) disabled @endif @endforeach  >{{ $ins->name }}</option>
										
										@endforeach
										{!! $errors->first('institute_id', '<p class="help-block">:message</p>') !!}
							</select>
						</div>
						<div class="form-group{{ ($errors->has('no_of_students')) ? $errors->first('no_of_students') : '' }}">
							<label>No. of Enrollee</label>
							<input type="number" name="no_of_students" class="form-control" placeholder="Enter Number of Enrollee" required>
							
						</div>
				</div>
				@foreach($ay as $ay)
  				  <input type="hidden" name="ay_id" value="{{$ay->id}}">
   				 @endforeach
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
        
@endsection