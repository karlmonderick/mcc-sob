@extends('layouts.master')

@section('content')
      
<!-- START BREADCRUMB -->
<ul class="breadcrumb push-down-0">
	<li><a href="#"> Activities {{ $ay->ay_from }} - {{ $ay->ay_to }}</a></li>
</ul>
<!-- END BREADCRUMB -->      

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
	@if($auth->role_id == 1)
	<div class="row">
		<div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                	
                    <h3 class="panel-title">Student Activities A.Y {{ $ay->ay_from }} - {{ $ay->ay_to }}</h3>

                </div>
                <div class="panel-body">
                    <ul class="list-group border-bottom">
                        <button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#myModal">Add Activity</button>
                        <li class="list-group-item">Not yet reviewed<span class="badge badge-info">{{$count_activity_not}}</span></li>
                        <li class="list-group-item">Reviewed request/s<span class="badge badge-success">{{$count_activity}}</span></li>
                    </ul>                                
                </div>

            </div>

         </div>

         <div class="col-md-9">
         	<div class="panel panel-default tabs">
				<ul class="nav nav-tabs nav-justified">
					<li class="active"><a href="#tab7" data-toggle="tab">Calendar of Activities</a></li>
					<li><a href="#tab8" data-toggle="tab">Not yet reviewed</a></li>
					<li><a href="#tab9" data-toggle="tab">Reviewed request/s</a></li>
				</ul>
				<div class="panel-body tab-content">
				<div class="tab-pane active" id="tab7">
					<div class="table-responsive">
						<table width="100%" class="table table-striped table-bordered table-hover datatable" >
							<thead>
								<tr>
									<th>#</th>
									<th>Date</th>
									<th>Activity Title</th>
									<th>Nature of Activity</th>
									<th>Requestor</th>
									<th>Budget</th>
									<th>
										Option
									</th>
									
								</tr>
							</thead>
							<tbody>
								<?php $i=1; ?>
								@foreach($cal_activities as $cal_activitiess)
								<tr>
									<td>{{ $i++ }}</td>
									<td><?php echo \Carbon\Carbon::createFromFormat('Y-m-d', $cal_activitiess->date)->format('M-d-Y'); ?></td>
									<td>{{ $cal_activitiess->name }}</td>
									<td>{{ $cal_activitiess->nature }}</td>
									<td>{{ $cal_activitiess->org_name}}</td>
									<td><?php echo number_format($cal_activitiess->p_budget); ?></td>
									<td>
										<form action="{{route('calendar_of_activities.destroy', $cal_activitiess->id)}}" method="POST">
											<input type="hidden" name="_method" value="delete">
											<input type="hidden" name="_token" value="{{ csrf_token() }}">
											<div class="btn-group ">
											<button type="button" class="btn btn-warning btn-xs btn-rounded" data-toggle="modal" data-target="#myModal{{$cal_activitiess->id}}"><i class="fa fa-edit"></i>Edit</button>
											<button type="submit" class="btn btn-xs btn-danger btn-rounded" onclick="return confirm('Are you sure?')"><i class="fa fa-trash-o"></i>Delete</button>
										</div>
										</form>
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
				<div class="tab-pane" id="tab8">
					<div class="table-responsive">
						<table width="100%" class="table table-striped table-bordered table-hover datatable" >
							<thead>
								<tr>
									<th>#</th>
									<th>Date</th>
									<th>Activity Title</th>
									<th>Nature of Activity</th>
									<th>Requestor</th>
									
									<th>
										Option
									</th>
									
								</tr>
							</thead>
							<tbody>
								<?php $i=1; ?>
								@foreach($not_rev_activity as $not_rev_activity)
								<tr>
									<td>{{ $i++ }}</td>
									<td><?php echo \Carbon\Carbon::createFromFormat('Y-m-d', $not_rev_activity->date)->format('M-d-Y'); ?></td>
									<td>{{ $not_rev_activity->title }}</td>
									<td>{{ $not_rev_activity->nature }}</td>
									<td>{{ $not_rev_activity->org_name}}</td>
									
									<td>
										<form action="{{route('activities.destroy', $not_rev_activity->id)}}" method="POST">      
											<input type="hidden" name="_method" value="delete">
											<input type="hidden" name="_token" value="{{ csrf_token() }}">
											<a href="{{route('activities.view_content', $not_rev_activity->id)}}" class="btn btn-xs btn-info btn-rounded"><i class="fa fa-eye"></i>View</a>
										</form>
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
				<div class="tab-pane" id="tab9">
					<div class="table-responsive">
						<table width="100%" class="table table-striped table-bordered table-hover datatable" >
							<thead>
								<tr>
									<th>#</th>
									<th>Date</th>
									<th>Activity Title</th>
									<th>Nature of Activity</th>
									<th>Requestor</th>
									<th>
										Option
									</th>
									
								</tr>
							</thead>
							<tbody>
								<?php $i=1; ?>
								@foreach($rev_activity as $rev_activity)
								<tr>
									<td>{{ $i++ }}</td>
									<td><?php echo \Carbon\Carbon::createFromFormat('Y-m-d', $rev_activity->date)->format('M-d-Y'); ?></td>
									<td>{{ $rev_activity->title }}</td>
									<td>{{ $rev_activity->nature }}</td>
									<td>{{ $rev_activity->org_name}}</td>
									<td>
										<form action="{{route('activities.destroy', $rev_activity->id)}}" method="POST">      
											<input type="hidden" name="_method" value="delete">
											<input type="hidden" name="_token" value="{{ csrf_token() }}">
											<a href="{{route('activities.view_content', $rev_activity->id)}}" class="btn btn-xs btn-info btn-rounded"><i class="fa fa-eye"></i>View</a>
										</form>
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
					<!-- /.table-responsive -->
				</div>
				<!-- /.panel-body -->
			</div>
			<!-- /.panel -->
		</div>
	</div>
	@endif
	@if(Auth::user()->role_id == 3)

	<div class="row">
		<div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">No. of request/s</h3>
                </div>
                <div class="panel-body">
                    <ul class="list-group border-bottom">
                        
                        <li class="list-group-item">New request/s<span class="badge badge-info">{{$count_not_approve}}</span></li>
                        <li class="list-group-item">Approved request/s<span class="badge badge-success">{{$count_approve}}</span></li>
                        <li class="list-group-item">Disapproved request/s<span class="badge badge-danger">{{$count_disapprove}}</span></li>
                    </ul>                                
                </div>
            </div>
         </div>

         <div class="col-md-9">
			<div class="panel panel-default tabs">
				<ul class="nav nav-tabs nav-justified">
					<li class="active"><a href="#tab7" data-toggle="tab">New request</a></li>
					<li><a href="#tab8" data-toggle="tab">Approved Request</a></li>
					<li><a href="#tab9" data-toggle="tab">Disapproved Request</a></li>
				</ul>
				<div class="panel-body tab-content">
				<div class="tab-pane active " id="tab7">
					<table width="100%" class="table table-striped table-bordered table-hover datatable" >
						<thead>
							<tr>
								<th>#</th>
								<th>Activity Title</th>
								<th>Nature of Activity</th>
								<th>Date</th>
								<th>Reviewed</th>
								<th>
									Option
								</th>
								
							</tr>
						</thead>
						<tbody>
							
							@if(Auth::user()->role_id == 3 )
							<?php $i=1; ?>
							@foreach($not_approve as $not_approve)
							<tr>
								<td>{{ $i++ }}</td>
								<td>{{ $not_approve->title }}</td>
								<td>{{ $not_approve->nature }}</td>
								<td><?php echo \Carbon\Carbon::createFromFormat('Y-m-d', $not_approve->date)->format('M-d-Y'); ?></td>
								<td>@if($not_approve->review_id == 1)<span class="badge badge-success">yes</span>@else<span class="badge badge-danger">No</span>@endif</td>
								<td>
									<form action="{{route('activities.destroy', $not_approve->id)}}" method="POST">      
										<input type="hidden" name="_method" value="delete">
										<input type="hidden" name="_token" value="{{ csrf_token() }}"> 
										<a href="{{route('activities.view_content', $not_approve->id)}}" class="btn btn-xs btn-info btn-rounded">View</a>
									</form>
								</td>
							</tr>
							@endforeach
							@endif
						</tbody>
					</table>
					<!-- /.table-responsive -->
				</div>


				<div class="tab-pane" id="tab8">
					<table width="100%" class="table table-striped table-bordered table-hover datatable" >
						<thead>
							<tr>
								<th>#</th>
								<th>Activity Title</th>
								<th>Nature of Activity</th>
								<th>Date</th>
								<th>Reviewed</th>
								<th>
									Option
								</th>
								
							</tr>
						</thead>
						<tbody>
							@if(Auth::user()->role_id == 3 )
							<?php $i=1; ?>
							@foreach($approve_activity as $approve_activity)
							<tr>
								<td>{{ $i++ }}</td>
								<td>{{ $approve_activity->title }}</td>
								<td>{{ $approve_activity->nature }}</td>
								<td><?php echo \Carbon\Carbon::createFromFormat('Y-m-d', $approve_activity->date)->format('M-d-Y'); ?></td>
								<td>@if($approve_activity->review_id == 1)<span class="badge badge-success">yes</span>@else<span class="badge badge-danger">No</span>@endif</td>
								<td>
									<form action="{{route('activities.destroy', $approve_activity->id)}}" method="POST">      
										<input type="hidden" name="_method" value="delete">
										<input type="hidden" name="_token" value="{{ csrf_token() }}">
										<a href="{{route('activities.view_content', $approve_activity->id)}}" class="btn btn-xs btn-info">View</a>
									</form>
								</td>
							</tr>
							@endforeach
							@endif
						</tbody>
					</table>
				</div>

				<div class="tab-pane" id="tab9">
					<table width="100%" class="table table-striped table-bordered table-hover datatable" >
						<thead>
							<tr>
								<th>#</th>
								<th>Activity Title</th>
								<th>Nature of Activity</th>
								<th>Date</th>
								<th>Reviewed</th>
								<th>
									Option
								</th>
								
							</tr>
						</thead>
						<tbody>
							@if(Auth::user()->role_id == 3 )
							<?php $i=1; ?>
							@foreach($disapprove_activity as $disapprove_activity)
							<tr>
								<td>{{ $i++ }}</td>
								<td>{{ $disapprove_activity->title }}</td>
								<td>{{ $disapprove_activity->nature }}</td>
								<td><?php echo \Carbon\Carbon::createFromFormat('Y-m-d', $disapprove_activity->date)->format('M-d-Y'); ?></td>
								<td>@if($disapprove_activity->review_id == 1)<span class="badge badge-success">yes</span>@else<span class="badge badge-danger">No</span>@endif</td>
								<td>
									<form action="{{route('activities.destroy', $disapprove_activity->id)}}" method="POST">      
										<input type="hidden" name="_method" value="delete">
										<input type="hidden" name="_token" value="{{ csrf_token() }}">
										<a href="{{route('activities.view_content', $disapprove_activity->id)}}" class="btn btn-xs btn-info">View</a>
									</form>
								</td>
							</tr>
							@endforeach
							@endif
						</tbody>
					</table>
				</div>
				<!-- /.panel-body -->
			</div>
			<!-- /.panel -->
		</div>
	</div>
</div>
	@endif
	@if(Auth::user()->role_id == 4)

<div class="row">
		<div class="col-md-3">
                <div class="panel panel-default tabs">
                                <ul class="nav nav-tabs nav-justified">
                                    <li class="active">
                                    	<a href="#tab1" data-toggle="tab">
                    					Activities
                                    	</a>
                                    </li>
                                    <li>
                                    	<a href="#tab2" data-toggle="tab">
                    					<span class="pull-right badge badge-warning">{{$released}}</span> Cash Request/s
                                    	</a>
                                    </li>
                                </ul>
                                <div class="panel-body tab-content">
                                    <div class="tab-pane active" id="tab1">
                                        <div class="panel-body">
											<a class="btn btn-success btn-block" href="{{ route('activities.create') }}">Add Activity</a>
						                    <ul class="list-group border-bottom">
						                        <li class="list-group-item">Pending<span class="badge badge-info">{{$act_count_pen}}</span></li>
						                        <li class="list-group-item">Approved<span class="badge badge-success">{{$act_count_app}}</span></li>
						                        <li class="list-group-item">Disapproved<span class="badge badge-danger">{{$act_count_dis}}</span></li>
						                    </ul>                                
               							 </div>
                                    </div>
                                <div class="tab-pane" id="tab2">
                                	<div class="panel-body">
                                			<?php $i=1; ?>
                                			@if($i >= 1)
											<table width="100%" class="table table-striped table-bordered table-hover">
												<thead>
												<tr>
													<th>#</th>
													<th>Activity</th>
													<th>Action</th>
												</tr>
												</thead>
												<tbody>
												@foreach($cash_code as $cash_code)
												<tr>
													<td>{{$i++}}</td>
													<td>{{$cash_code->title}}</td>
													<td><a target="_blank" href="{{route('activities.print', $cash_code->id)}}" class="btn btn-xs btn-success">Print</a></td>
												</tr>
												@endforeach
												</tbody>
											</table>  
											@else
											<div class="alert alert-danger" role="alert">
				                                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				                                No data available
				                            </div>  
											@endif                            
               							 </div>
            						</div>
            					</div>
           		</div>
        </div>


		<div class="col-md-9">
			<div class="panel panel-default tabs">
				<ul class="nav nav-tabs nav-justified">
					<li class="active"><a href="#tab7" data-toggle="tab">Pending request</a></li>
					<li><a href="#tab8" data-toggle="tab">Approved Request</a></li>
					<li><a href="#tab9" data-toggle="tab">Disapproved Request</a></li>
				</ul>
				<div class="panel-body tab-content">
				<div class="tab-pane active" id="tab7">
					<table width="100%" class="table table-striped table-bordered table-hover datatable" >
						<thead>
							<tr>
								<th>#</th>
								<th>Activity Title</th>
								<th>Nature of Activity</th>
								<th>Date</th>
								<th>Reviewed</th>
								<th>
									Option
								</th>
								
							</tr>
						</thead>
						<tbody>
							<?php $i=1; ?>
							@foreach($act_pending as $act_pending)
							<tr>
								<td>{{ $i++ }}</td>
								<td>{{ $act_pending->title }}</td>
								<td>{{ $act_pending->nature }}</td>
								<td><?php echo \Carbon\Carbon::createFromFormat('Y-m-d', $act_pending->date)->format('M-d-Y'); ?></td>
								<td>@if( $act_pending->review_id == 1) <span class="badge badge-success">Yes</span> @else <span class="badge badge-danger">No</span> @endif </td>
								<td>
									<form action="{{route('activities.destroy', $act_pending->id)}}" method="POST">      
										<input type="hidden" name="_method" value="delete">
										<input type="hidden" name="_token" value="{{ csrf_token() }}">
										<div class="btn-group">
										<a href="{{route('activities.view_content', $act_pending->id)}}" class="btn btn-xs btn-info btn-rounded"><i class="fa fa-eye"></i>View</a>
										@if(Auth::user()->role_id == 4)
										<a href="{{route('activities.edit', $act_pending->id)}}" class="btn btn-xs btn-warning btn-rounded"><i class="fa fa-edit"></i>Edit</a>
										<button type="submit" class="btn btn-xs btn-danger btn-rounded" onclick="return confirm('Are you sure?')"><i class="fa fa-trash-o"></i>Delete</button>
										@endif
										</div>
									</form>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
					<!-- /.table-responsive -->
				</div>

				<div class="tab-pane" id="tab8">
					<table width="100%" class="table table-striped table-bordered table-hover datatable" >
						<thead>
							<tr>
								<th>#</th>
								<th>Activity Title</th>
								<th>Nature of Activity</th>
								<th>Date</th>
								<th>Cashout</th>
								<th>
									Option
								</th>
								
							</tr>
						</thead>
						<tbody>
							
							<?php $i=1; ?>
							@foreach($act_app as $act_app)
							<tr>
								<td>{{ $i++ }}</td>
								<td>{{ $act_app->title }}</td>
								<td>{{ $act_app->nature }}</td>
								<td><?php echo \Carbon\Carbon::createFromFormat('Y-m-d', $act_app->date)->format('M-d-Y'); ?></td>
								<td>@if( $act_app->released_by_igp == 1) <span class="badge badge-success">Released</span> @else <span class="badge badge-danger">Not yet</span> @endif </td>
								<td>
									<form action="{{route('cash_request.store')}}" method="POST">
												<input type="hidden" name="_token" value="{{ csrf_token() }}">
												<input type="hidden" name="amount" value="{{$act_app->buggetTotal}}">
												<input type="hidden" name="organization_ay_id" value="{{$act_app->organization_ay_id}}">
												<input type="hidden" name="act_id" value="{{$act_app->id}}">
												<input type="hidden" name="released" value="0">
												<div class="btn-group">
												<a href="{{route('activities.view_content', $act_app->id)}}" class="btn btn-xs btn-info btn-rounded">View</a>
												@if($act_app->released == 0)	
												<input type="submit" onclick="return confirm('Are you sure?')" value="CashOut" class="btn btn-xs btn-warning btn-rounded">
												@endif
												@if($act_app->released == 1)
												<a target="_blank" href="{{route('activities.print', $act_app->id)}}" class="btn btn-xs btn-success btn-rounded">Print</a>
												@endif
												</div>
									</form>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>


				<div class="tab-pane" id="tab9">
					<table width="100%" class="table table-striped table-bordered table-hover datatable" >
						<thead>
							<tr>
								<th>#</th>
								<th>Activity Title</th>
								<th>Nature of Activity</th>
								<th>Date</th>
								<th>Reviewed</th>
								<th>
									Option
								</th>
								
							</tr>
						</thead>
						<tbody>
							
							<?php $i=1; ?>
							@foreach($act_dis_app as $act_dis_app)  
							<tr>
								<td>{{ $i++ }}</td>
								<td>{{ $act_dis_app->title }}</td>
								<td>{{ $act_dis_app->nature }}</td>
								<td><?php echo \Carbon\Carbon::createFromFormat('Y-m-d', $act_dis_app->date)->format('M-d-Y'); ?></td>
								<td>@if( $act_dis_app->review_id == 1) <span class="badge badge-success">Yes</span> @else <span class="badge badge-danger">No</span> @endif </td>
								<td>
									@if($act_dis_app->approval == 1)
									<form action="{{route('cash_request.store')}}" method="POST">
										<input type="hidden" name="_token" value="{{ csrf_token() }}">
										<input type="hidden" name="amount" value="{{$act_dis_app->buggetTotal}}">
										<input type="hidden" name="organization_ay_id" value="{{$act_dis_app->organization_ay_id}}">
										<input type="hidden" name="released" value="0">
										<input type="hidden" name="verify" value="<?php echo uniqid(); ?>">
										<div class="btn-group">
										<input type="submit" onclick="return confirm('Are you sure?')" value="CashOut" class="btn btn-xs btn-warning btn-rounded">
										<a href="{{route('activities.view_content', $act_dis_app->id)}}" class="btn btn-xs btn-info btn-rounded">View</a>
										</div>
									</form>
									@endif
									@if($act_dis_app->approval != 1)
									<a href="{{route('activities.view_content', $act_dis_app->id)}}" class="btn btn-xs btn-info btn-rounded">View</a>
									<!-- <form action="{{route('activities.destroy', $act_dis_app->id)}}" method="POST">      
										<input type="hidden" name="_method" value="delete">
										<input type="hidden" name="_token" value="{{ csrf_token() }}">
										<div class="btn-group">
										<a href="{{route('activities.edit', $act_dis_app->id)}}" class="btn btn-xs btn-warning ">Edit</a>
										<input type="submit" class="btn btn-xs" onclick="return confirm('Are you sure?')" value="Delete">
										</div>
									</form> -->
									@endif
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>




		</div>
	</div>



@endif


    <!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
	<div class="modal-dialog modal-sm">

		<!-- Modal content-->
		<div class="modal-content">

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Proposed Activity Information</h4>
			</div>
			
			<form method="POST" action="{{route('calendar_of_activities.store')}}">
			
				<div class="modal-body">
					{{ csrf_field()}}
					<div class="form-group">
						<label>Name of Activity <font color='red'>*</font></label>
						<input type="text" name="name" class="form-control" placeholder="Enter name" required>
					</div>
					<div class="form-group">
									<label>Nature of Activity <font color='red'>*</font></label>
									<div class="radio">
										<label>
											<input type="radio" name="nature" id="nature" value="Academic" checked> Academic
										</label>
									</div>
									<div class="radio">
										<label>
											<input type="radio" name="nature" id="nature" value="Non-Academic" checked> Non-Academic
										</label>
									</div>
								</div>
								<input type="hidden" name="ay_id" value="{{$ay->id}}">
					<div class="form-group">
						<label>Date of Activity <font color='red'>*</font></label>
						<input type="text"  class="form-control datepicker" name="date" placeholder="Enter date" required>
					</div>
					<div class="form-group">
						<label>Requestor <font color='red'>*</font></label>
						<select class="form-control" name="organization_ay_id">
	                                                @foreach($organizers as $organizer)
		                                          <option value="{{$organizer->id}}" >{{$organizer->org_name}}</option>
		                                        @endforeach
                                            	</select>
					</div>
					<div class="form-group">
						<label>Proposed Total Budget <font color='red'>*</font></label>
						<input type="number" name="p_budget" class="form-control"  placeholder="Enter budget" required>
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
<!--end modal -->

 <!-- Modal -->
 @foreach($cal_activities as $cal_activities_modal)
<div id="myModal{{$cal_activities_modal->id}}" class="modal fade" role="dialog">
	<div class="modal-dialog modal-sm">

		<!-- Modal content-->
		<div class="modal-content">

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Activity Information</h4>
			</div>
			
			<form method="POST" action="{{route('calendar_of_activities.update', $cal_activities_modal->id)}}">
			<input type="hidden" name="_method" value="PATCH">
				<div class="modal-body">
					{{ csrf_field()}}
					<div class="form-group">
						<label>Name of Activity</label>
						<input type="text" name="name" class="form-control" value="{{$cal_activities_modal->name}}" placeholder="Enter name" required>
					</div>
					<div class="form-group">
									<label>Nature of Activity</label>
									<div class="radio">
										<label>
											<input type="radio"  name="nature" id="nature" value="Academic" @if($cal_activities_modal->nature == 'Academic') checked @endif> Academic
										</label>
									</div>
									<div class="radio">
										<label>
											<input type="radio" name="nature" id="nature" value="Non-Academic" @if($cal_activities_modal->nature == 'Non-Academic') checked @endif> Non-Academic
										</label>
									</div>
								</div>
					<div class="form-group">
						<label>Date of Activity</label>
						<input type="text" value="{{$cal_activities_modal->date}}"  class="form-control datepicker" name="date" placeholder="Enter date" required>
					</div>
					<div class="form-group">
						<label>Budget</label>
						<input type="number" value="{{$cal_activities_modal->p_budget}}" name="p_budget" class="form-control"  placeholder="Enter budget" required>
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
@endforeach  
@endsection