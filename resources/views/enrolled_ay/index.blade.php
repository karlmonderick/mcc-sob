@extends('layouts.master')

@section('content')

<!-- START BREADCRUMB -->
<ul class="breadcrumb push-down-0">
	<li><a href="#">Enrolled</a></li>
</ul>
<!-- END BREADCRUMB --> 
                <!-- START CONTENT FRAME -->
                <div class="content-frame">
                    
                    <!-- START CONTENT FRAME TOP -->
                    <div class="content-frame-top">                        
                        <div class="page-title">                    
                            <h2> Enrolled Students</h2>
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
											<li class="list-group-item">1st Semester:<span class="badge badge-info"> @if($TotalEnrolled_1>0){{$TotalEnrolled_1}} @else N/A @endif</span></li>
											<li class="list-group-item">2nd Semester:<span class="badge badge-info"> @if($TotalEnrolled_2>0){{$TotalEnrolled_2}} @else N/A @endif</span></li>
										</ul>                                
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
                            <div class="panel-body">
								<table width="100%" class="table table-striped table-bordered table-hover datatable">
									<thead>
										<tr>
											<th>#</th>
											<th>Institute</th>
											<th>
												1st Semester
											</th>
											<th>
												2nd Semester
											</th>
										</tr>
									</thead>
									<tbody>
										<?php $i=1; ?>
										@foreach($institutes as $institute)
										<tr>
											<td>{{ $i++ }}</td>
											<td>{{ $institute->name }}</td>
											<td>
												@foreach($institute_enroll as $ins_enroll)
													@if($institute->id == $ins_enroll->institute_id && $ins_enroll->sem == 1 && $ins_enroll->ay_id == $ay->id)
														{{ $ins_enroll->no_of_students }}
													@endif
												@endforeach
											</td>
											<td>
											@foreach($institute_enroll as $ins_enroll2)
												@if($institute->id == $ins_enroll2->institute_id && $ins_enroll2->sem == 2 && $ins_enroll2->ay_id == $ay->id)
													{{ $ins_enroll2->no_of_students }}
												@endif
											@endforeach
											</td>
										</tr>

										@endforeach
									</tbody>
								</table>
								<!-- /.table-responsive -->
                            </div>
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

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Institute Information</h4>
			</div>
			<form method="POST" action="{{route('enrolled_ay.store')}}">
			
				<div class="modal-body">
					{{ csrf_field()}}
						@foreach($institutes as $institute)
						<div class="form-group">
							<label>{{ $institute->name }} <font color='red'>*</font></label>
							<input type="number" name="num_{{ $institute->code }}" class="form-control" required min=1>
							<input type="hidden" name="ins_id_{{ $institute->code }}" value="{{ $institute->id }}" >
						</div>
						@endforeach
						<label>Semester <font color='red'>*</font></label>
						<select name="sem" class="form-control">
		   					<option value="1">1st Semester</option>
		   					<option value="2">2nd Semester</option>
		   				</select>
						 
  				  <input type="hidden" name="ay_id" value="{{$ay->id}}">


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
        
        
@endsection