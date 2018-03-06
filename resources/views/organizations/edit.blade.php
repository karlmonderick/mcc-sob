      
@extends('layouts.master')

@section('content')

<ul class="breadcrumb push-down-0">
	<li><a href="#">Organizations</a></li>
	<li><a href="#">Edit</a></li>
</ul>
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

	<div class="row">
		<div class="col-md-12">

			<div class="panel panel-default">
				<!-- /.panel-heading -->
				<div class="panel-body">
					
					<div class="card-block">
						<h3 class="card-title">Institutes</h3>
						
						<h6 class="card-subtitle mb-2 text-muted">Edit</h6>
						<div class="articles-container">
							<div class="divider" style="margin-top: 1rem;"></div>
							<form action="{{route('organizations.update', $organization->id)}}" method="post">
								<input type="hidden" name="_method" value="PATCH">
								{{ csrf_field()}}
								<div class="form-group">
									<label>Organization Name:</label>
									<input type="text" name="name" class="form-control" pattern="^[A-Za-z-'-. _]*[A-Za-z-'-.][A-Za-z-'-. _]*$" placeholder="Enter Organization name" value="{{ $organization->name }}" required>
								</div>
								<div class="form-group">
									<label>Organization Code:</label>
									<input type="text" name="code" class="form-control" pattern="^[A-Za-z _]*[A-Za-z][A-Za-z _]*$" placeholder="Enter Organization code" value="{{ $organization->code }}" required>
								</div>
								<div class="form-group">	
									<label>Institute:</label>
									<select class="form-control" name="institute_id">
										<option value="">College Wide</option>
										@foreach($ins as $institute)
											<option value="{{ $institute->id }}"
											@if($organization->institute_id==$institute->id) selected
											@endif
											>{{ $institute->name }}</option>
										@endforeach
										
									</select>
								</div>
								<div class="form-group">
									<label>Type</label>
									<select class="form-control" name="type">
										<option value="CW">College Wide</option>
										<option value="CO">Cultural</option>
										<option value="IO">Institute Organization</option>
										<option value="SP">Student Publication</option>
										<option value="ISC">Institute Student Council</option>
										<option value="SSC">Supreme Student Council</option>
									</select>
								</div>
								<div class="form-group">
									<input type="submit" class="btn btn-primary" value="Save"> <a onclick="history.back()" id="btn-add" class="btn btn-info" >Cancel</a>
								</div>
							</form>
							
						</div>
					</div>
				</div>
			<!-- /.panel-body -->
			</div>
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.col-lg-12 -->
</div>

        
@endsection