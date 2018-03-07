@extends('layouts.master')

@section('content')

<!-- START BREADCRUMB -->
<ul class="breadcrumb push-down-0">
	<li><a href="#"> Enrolled Students</a></li>
</ul>
<!-- END BREADCRUMB -->      

<!-- START CONTENT FRAME -->
<div class="content-frame">
	<!-- START CONTENT FRAME TOP -->
	<div class="content-frame-top">                        
		<div class="page-title">                    
			<h2>Enrolled Students A.Y.</h2>
		</div>                                      
		<div class="pull-right">
			<button class="btn btn-default content-frame-left-toggle"><span class="fa fa-bars"></span></button>
		</div>                        
	</div>
	<!-- END CONTENT FRAME TOP -->
	
	<!-- START CONTENT FRAME LEFT -->
	<div class="content-frame-left">
		<div class="panel panel-default">
			<div class="panel-body">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Total # of Enrollees:</h3>
					</div>
					<div class="panel-body">
						<ul class="list-group border-bottom">
							<li class="list-group-item">1st Semester:<span class="badge badge-info"> </span></li>
							<li class="list-group-item">2nd Semester:<span class="badge badge-info"> </span></li>
						</ul>       
						<button type="button" class="btn btn-success btn-sm btn-block" data-toggle="modal" data-target="#myModal">Add No. of Enrollees</button>                         
					</div>
				</div>
				<hr>
				@if(Auth::user()->role_id == 2)
					<p>
						<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#myModal">Add No. of Enrollees</button>
					</p>
				@endif
			</div>
		</div>
	</div>
	<!-- END CONTENT FRAME LEFT -->
	
	<!-- START CONTENT FRAME BODY -->
	<div class="content-frame-body">
		<div class="panel panel-default">	
			<!-- /.panel-heading -->
			<div class="panel-body">
				<!-- START JUSTIFIED TABS -->
				<div class="panel panel-default tabs">
					<ul class="nav nav-tabs nav-justified">
						<li class="active"><a href="#tab8" data-toggle="tab">First Semester</a></li>
						<li><a href="#tab9" data-toggle="tab">Second Semester</a></li>
					</ul>
					<div class="panel-body tab-content">
						<div class="tab-pane active" id="tab8">
							<table width="100%" class="table table-striped table-bordered table-hover datatable">
								<thead>
									<tr>
										<th>#</th>
										<th>Student ID</th>
										<th>Name</th>
										<th>Cource</th>
									</tr>
								</thead>
								<tbody>
									
									<?php $i=1; ?>
									@foreach($enrolled as $enrolled)
										</tr>
											<td>{{ $i++ }}</td>
											<td>{{ $enrolled->student_no }}</td>
											<td>{{ $enrolled->firstname_middlename }} {{ $enrolled->surname }}</td>
											<td>{{ $enrolled->course }}</td>
										</tr>
									@endforeach	
								</tbody>
							</table>	
						</div>
						<div class="tab-pane" id="tab9">
							<table width="100%" class="table table-striped table-bordered table-hover datatable">
								<thead>
									<tr>
										<th>#</th>
										<th>Organization</th>
										<th>Budget</th>
										<th>Source</th>
									</tr>
								</thead>
								<tbody>
									
									<?php $i=1; ?>
									<tr>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									</tr>
							</table>		
						</div>                      
					</div>
				</div>                                         
				<!-- END JUSTIFIED TABS -->


				<!-- /.table-responsive -->
			</div>
			<!-- /.panel-body -->
		</div>
	</div>
	<!-- END CONTENT FRAME BODY -->
</div>
<!-- END CONTENT FRAME -->





<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
	<div class="modal-dialog modal-sm">

		<!-- Modal content-->
		<div class="modal-content">

			<form action="{{ route('enrolled_students.store') }}" method="post" enctype="multipart/form-data">

				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Upload CSV of Enrolled Students</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<strong>Select .csv file to upload</strong>
						<input type="file" name="upload_file" id="upload_file" required>
								
						<input type="hidden" value="{{ csrf_token() }}" name="_token">
					</div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-sm btn-success btn-block" type="submit" name="submit"><i class="fa fa-cloud-upload"></i> Upload</button>
				</div>
			</form>
		</div>

	</div>
</div>

@endsection