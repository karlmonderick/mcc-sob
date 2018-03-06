@extends('layouts.master')

@section('content')


<!-- START BREADCRUMB -->
<ul class="breadcrumb push-down-0">
	<li><a href="#">Dashboard</a></li>
</ul>
<!-- END BREADCRUMB -->                                                

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

	<!-- START WIDGETS -->                    
	<div class="row">
		<div class="col-md-3">
			
			<!-- START WIDGET SLIDER -->
			<div class="widget widget-default widget-carousel">
				<div class="owl-carousel" id="owl-example">
					@if($auth->role_id == 1 || $auth->role_id == 2 || $auth->role_id == 3 )      
					<div>                             
						<div class="widget-title">Student Funds {{ $date->year }} </div>                                                                        
						<div class="widget-subtitle">1st Semester</div>
						<div class="widget-int">{{number_format($tc1)}}</div>
					</div>
					@if($tc2 != NULL)
						<div>                             
							<div class="widget-title">Student Funds {{ $date->year }} </div>                                                                        
							<div class="widget-subtitle">2nd Semester</div>
							<div class="widget-int">{{number_format($tc2)}}</div>
						</div>
					@endif
					<div>                             
						<div class="widget-title">Student Funds {{ $date->year }} </div>                                                                        
						<div class="widget-subtitle">Total</div>
						<div class="widget-int">{{number_format($total_collection)}}</div>
					</div>

					@elseif(Auth::user()->role_id == 4)
					<div>                
						<div class="widget-title">Budget {{ $date->year }} </div>                                                                        
						<div class="widget-subtitle">1st Semester</div>
						<div class="widget-int">
							@if($budget_first != NULL)
							₱ {{number_format($budget_first->budget)}}
							@else 
							₱ 0
							@endif</div>
					</div>
						@if($budget_second != NULL)
						<div>                                    
							<div class="widget-title">Budget {{ $date->year }} </div>                                                                        
							<div class="widget-subtitle">2nd Semester</div>
							<div class="widget-int">₱ {{number_format($budget_second->budget)}}</div>
						</div>
						@else
						<div>                                    
							<div class="widget-title">Budget {{ $date->year }} </div>                                                                        
							<div class="widget-subtitle">2nd Semester</div>
							<div class="widget-int">₱ 0</div>
						</div>
						@endif
					@endif
				</div>                     
			</div>         
			<!-- END WIDGET SLIDER -->
			
		</div>
		
		<div class="col-md-3">
			
			<!-- START WIDGET MESSAGES -->
			<div class="widget widget-default widget-item-icon">
				<div class="widget-item-left">
					<span class="fa fa-envelope"></span>
				</div>                             
				<div class="widget-data">
					<div class="widget-int num-count">
						<?php $num_count=0; ?>
						@if(Auth::user()->role_id == 3){{ $a_approval1 }} @endif
						@if(Auth::user()->role_id == 2){{ $all_requests }} @endif
						@if(Auth::user()->role_id == 1){{ $a_approval2 }} @endif
						@if(Auth::user()->role_id == 4 ){{ $org_num_requests }} @endif

					</div>
					@if($auth->role_id == 3)      
					<div class="widget-title">New requests</div>
					<div class="widget-subtitle">You need to approve</div>
					@elseif($auth->role_id == 1)      
					<div class="widget-title">New requests</div>
					<div class="widget-subtitle">You need to review</div>
					@elseif($auth->role_id == 2)
					<div class="widget-title">Total New requests</div>
					@elseif($auth->role_id == 4)
					<div class="widget-title">Requests</div>
					<div class="widget-subtitle">Submitted</div>
					@endif
				</div>
			</div>                            
			<!-- END WIDGET MESSAGES -->
			
		</div>

		<div class="col-md-3">
			
			<!-- START WIDGET REGISTRED -->
			<div class="widget widget-default widget-item-icon">
				<div class="widget-item-left">
					<span class="fa fa-user"></span>
				</div>
				<div class="widget-data">
					@if($auth->role_id == 1 || $auth->role_id == 3 || $auth->role_id == 2)      
						<div class="widget-int num-count">{{$organization_num}}</div>
						<div class="widget-title">Accredited Organization</div>
						<div class="widget-subtitle">for {{$date->year}}</div>
					@elseif(Auth::user()->role_id == 4)
						<div class="widget-int num-count">{{ $org_officer_num }}</div>
						<div class="widget-title">Officers</div>
						<div class="widget-subtitle">for {{$date->year}}</div>
					@endif
				</div>
				                   
			</div>                            
			<!-- END WIDGET REGISTRED -->
			
		</div>

		<div class="col-md-3">
			
			<!-- START WIDGET CLOCK -->
			<div class="widget widget-info widget-padding-sm">
				<div class="widget-big-int plugin-clock">00:00</div>                            
				<div class="widget-subtitle plugin-date">Loading...</div>
				<div class="widget-controls">                                
					
				</div>                            
				<div class="widget-buttons widget-c3">
				<!-- 	<div class="col">
						<a href="#"><span class="fa fa-clock-o"></span></a>
					</div>
					<div class="col">
						<a href="#"><span class="fa fa-bell"></span></a>
					</div>
					<div class="col">
						<a href="#"><span class="fa fa-calendar"></span></a>
					</div> -->
				</div>                            
			</div>                        
			<!-- END WIDGET CLOCK -->
			
		</div>

	</div>

	<!-- END WIDGETS -->    

	<div class="row">
		
		@if(Auth::user()->role_id == 2 || Auth::user()->role_id == 3)
			<div class="col-lg-6">
				<div class="panel-heading">
					Funds available for {{ $date->year }}
				</div>
				<div class="panel panel-default tabs">
					
					<ul class="nav nav-tabs nav-justified">
						<li class="active"><a href="#tab8" data-toggle="tab">First Semester</a></li>
						<li><a href="#tab9" data-toggle="tab">Second Semester</a></li>
					</ul>
					<div class="panel-body tab-content">
						<div class="tab-pane active" id="tab8">
							<table width="100%" class="table table-striped table-bordered table-hover2 datatable">
								<thead>
									<tr>
										<th>#</th>
										<th>Funds Name</th>
										<th>Semester</th>
										<th>Usage</th>

									</tr>
								</thead>
								<tbody>
								<?php $i=1; ?>
									@foreach($funds1 as $funds1)
									<tr>
										<td>{{ $i++ }}</td>
										<td>{{ $funds1->name }}</td>
										<td>
											@if($funds1->semester == 1)
												1st
											@else
												2nd
											@endif
										</td>
										<td>
											<?php
												if($funds1->remaining>0 && $funds1->amount>0){
													$percent = ($funds1->remaining/$funds1->amount)*100;
													$usage = 100 - $percent;
												}
												else{
													$usage = 0 ;
												}

											if($usage<100)
												{ ?>	
											<div class="progress  progress-striped active">
												<div class="progress-bar @if($usage>=75&&$usage<100) progress-bar-danger @else progress-bar-success @endif" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: {{$usage}}%;"></div>
											</div>
											<?php } else { ?>
											<span class="label label-danger">No more Funds!</span>	
											<?php } ?>
										</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
						<div class="tab-pane" id="tab9">
							<table width="100%" class="table table-striped table-bordered table-hover2 datatable">
								<thead>
									<tr>
										<th>#</th>
										<th>Funds Name</th>
										<th>Semester</th>
										<th>Usage</th>

									</tr>
								</thead>
								<tbody>
								<?php $i=1; ?>
								@foreach($funds2 as $funds2)
									<tr>
										<td>{{ $i++ }}</td>
										<td>{{ $funds2->name }}</td>
										<td>
											@if($funds2->semester == 1)
												1st
											@else
												2nd
											@endif
										</td>
										<td>
											<?php
												$percent = ($funds2->remaining/$funds2->amount)*100;
												$usage = 100 - $percent;

											if($usage<100)
												{ ?>	
											<div class="progress progress-striped active">
												<div class="progress-bar @if($usage>=75&&$usage<100) progress-bar-danger @else progress-bar-success @endif" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: {{$usage}}%;"></div>
											</div>
											<?php } else { ?>
											<span class="label label-danger">No more Funds!</span>	
											<?php } ?>
										</td>
									</tr>
									@endforeach
								</tbody>
							</table>	
						</div>                      
					</div>
				</div>  
			</div>
		@endif
				
		@if(Auth::user()->role_id == 1 || Auth::user()->role_id == 3)
			<div class="col-lg-6">
				<div class="panel panel-default">
					<div class="panel-heading">
						@if(Auth::user()->role_id == 3)
						Activities Needed for Approval
						@else
						Activities need to review
						@endif
					</div>
					<!-- /.panel-heading -->
					<div class="panel-body">
						<table width="100%" class="table table-striped table-bordered table-hover datatable">
							<thead>
								<tr>
									<th>#</th>
									<th>Activity Title</th>
									<th>Nature of Activity</th>
									<th>Status</th>
									<th>
										Option
									</th>
								</tr>
							</thead>
							<tbody>
								@if(Auth::user()->role_id == 3)
									@foreach($activity as $act)
									@if($act->approval == 2)
									<tr>
										<td>{{ $act->id }}</td>
										<td>{{ $act->title }}</td>
										<td>{{ $act->nature }}</td>
										<td>@if($act->approval == 1)
												Approved
											@elseif($act->approval == 0)
												Disapproved
											@elseif($act->approval == 2)
												Pending
											@else
			
											@endif
										</td>
										<td>
											<form action="{{route('activities.destroy', $act->id)}}" method="POST">      
												<input type="hidden" name="_method" value="delete">
												<input type="hidden" name="_token" value="{{ csrf_token() }}"> 
												<a href="{{route('activities.view_content', $act->id)}}" class="btn btn-xs btn-info">View</a>
												@if(Auth::user()->role_id == 4)
												<a href="{{route('activities.edit', $act->id)}}" class="btn btn-xs btn-warning">Edit</a>
												<input type="submit" class="btn btn-xs" onclick="return confirm('Are you sure?')" value="delete">
												@endif
											</form>
										</td>
									</tr>
									@endif
									@endforeach
								@endif

								@if(Auth::user()->role_id == 1)
									@foreach($activity as $act)
									@if($act->review_id == 0)
									<tr>
										<td>{{ $act->id }}</td>
										<td>{{ $act->title }}</td>
										<td>{{ $act->nature }}</td>
										<td>@if($act->review_id == 1)
												Reviewed
											@elseif($act->review_id == 0)
												Not yet Reviewed
											@else
			
											@endif
										</td>
										<td>
											<form action="{{route('activities.destroy', $act->id)}}" method="POST">      
												<input type="hidden" name="_method" value="delete">
												<input type="hidden" name="_token" value="{{ csrf_token() }}"> 
												<a href="{{route('activities.view_content', $act->id)}}" class="btn btn-xs btn-info">View</a>
			
												@if(Auth::user()->role_id == 4)
												<a href="{{route('activities.edit', $act->id)}}" class="btn btn-xs btn-warning">Edit</a>
												<input type="submit" class="btn btn-xs" onclick="return confirm('Are you sure?')" value="delete">
												@endif
											</form>
										</td>
										
									</tr>
									@endif
									@endforeach
								@endif
			
								@if(Auth::user()->role_id == 4)
									@foreach($activity as $activity)
									@if($activity->approval == 1 && $activity->review_id != 1)
									<tr>
										<td>{{ $activity->id }}</td>
										<td>{{ $activity->title }}</td>
										<td>{{ $activity->nature }}</td>
										<td>@if($activity->approval == 1)
												Approved
											@elseif($activity->approval == 0)
												Not Yet Approved
											@elseif($activity->approval)
												Pending
											@else
			
											@endif
										</td>
										<td>
											<form action="{{route('activities.destroy', $activity->id)}}" method="POST">      
												<input type="hidden" name="_method" value="delete">
												<input type="hidden" name="_token" value="{{ csrf_token() }}"> 
												<a href="{{route('activities.view_content', $activity->id)}}" class="btn btn-xs btn-info">View</a>
			
												@if(Auth::user()->role_id == 4)
												<a href="{{route('activities.edit', $activity->id)}}" class="btn btn-xs btn-warning">Edit</a>
												<input type="submit" class="btn btn-xs" onclick="return confirm('Are you sure?')" value="delete">
												@endif
											</form>
										</td>
										
									</tr>
									@endif
									@endforeach
								@endif

							</tbody>
						</table>
					</div>
					<!-- /.panel-body -->
				</div>
				<!-- /.panel -->
			</div>
			<div class="col-lg-6">
				<div class="panel panel-default">
					<div class="panel-heading">
						Organizations Per Institute
					</div>
					<!-- /.panel-heading -->
					<div class="panel-body">
						<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
						<script type="text/javascript">
						google.charts.load('current', {'packages':['corechart']});
						google.charts.setOnLoadCallback(drawChart);
												
						function drawChart() {

							var data = google.visualization.arrayToDataTable([
							['Task', 'Organizations per Institute'],
							['IAS', {{$count_ias_orgs}}],
							['IBE', {{$count_ibe_orgs}}],
							['ICS', {{$count_ics_orgs}}],
							['IHM', {{$count_ihm_orgs}}],
							['ITE', {{$count_ite_orgs}}]
							]);

							var options = {
								'width': 600,
            					'height': 300,
								pieHole: 0.4,
							};

							var chart = new google.visualization.PieChart(document.getElementById('piechart'));

							chart.draw(data, options);
						}
						</script>

							<div id="piechart" style="overflow:hidden"></div>

					</div>
					<!-- /.panel-body -->
				</div>
				<!-- /.panel -->
			</div>



		@elseif(Auth::user()->role_id == 4)
			<div class="col-lg-6">
				<!-- START PROJECTS BLOCK -->
						<div class="panel panel-default">
							<div class="panel-heading">
								<div class="panel-title-box">
									<h3>Balance</h3>
								</div>      
							</div>
							<div class="panel-body panel-body-table">
								
								<div class="table-responsive">
									<table class="table table-bordered table-striped">
										<thead>
											<tr>
												<th width="40%">Semester</th>
												<th width="30%">Budget Remaining</th>
												<th width="30%">Usage</th>
											</tr>
										</thead>
										<tbody>
											@if($budget_first != NULL)
											<tr>
											<?php 
											$percent_1 = ($budget_first->remaining/$budget_first->budget)*100;
											$usage_1 = 100 - $percent_1;
											?>
											
												<td><strong>1st Semester:</strong></td>
												<td>
													<span class="label @if($usage_1 >= 60 && $usage_1 < 100)label-danger
															@elseif($usage_1 >= 30 && $usage_1 < 60)label-warning
															@else label-success
															@endif">
															₱ {{number_format($budget_first->remaining)}}
													</span>
												</td>
												<td>
														<?php
														if($usage_1<100)
														{ ?>
														<div class="progress progress-striped active">
														<div class="progress-bar @if($usage_1 >= 60 && $usage_1 < 100)progress-bar-danger
															@elseif($usage_1 >= 30 && $usage_1 < 60)progress-bar-warning
															@else progress-bar-success
															@endif" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: {{$usage_1}}%;">{{$usage_1}}%</div>
														</div>
														<?php } else { ?>
														<span class="label label-danger">No more Budget!</span>	
														<?php } ?>
												</td>
											</tr>
											@else
											<tr>
												<td><strong>1st Semester:</strong></td>
												<td>
													<span class="label label-success">
															Nan
													</span>
												</td>
												<td>
														<div class="progress progress-small progress-striped active">
														<div class="progress-bar " role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
														</div>
												</td>
											</tr>
											@endif


											@if($budget_second != NULL)
											<tr>
											<?php 
											$percen_2 = ($budget_second->remaining/$budget_second->budget)*100;
											$usage_2 = 100 - $percen_2;
											?>
												<td><strong>2nd Semester:</strong></td>
												<td>
													<span class="label @if($usage_2 >= 60 && $usage_2 < 100)progress-bar-danger
															@elseif($usage_2 >= 30 && $usage_2 < 60)progress-bar-warning
															@else progress-bar-success
															@endif">
													@if($budget_second != NULL)
														₱ {{number_format($budget_second->remaining)}}
													@else
														NaN
													@endif
													</span>
												</td>
												<td>
												<?php
														if($usage_2<100)
														{ ?>
														<div class="progress progress-striped active">
														<div class="progress-bar @if($usage_2 >= 60 && $usage_2 < 100)progress-bar-danger
															@elseif($usage_2 >= 30 && $usage_2 < 60)progress-bar-warning
															@else progress-bar-success
															@endif" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: {{$usage_2}}%;">{{$usage_2}}%</div>
														</div>
														<?php } else { ?>
														<span class="label label-danger">No more Budget!</span>	
														<?php } ?>
												</td>
											</tr>
											@else
											<tr>
												<td><strong>2nd Semester:</strong></td>
												<td>
													<span class="label label-success">
															Nan
													</span>
												</td>
												<td>
														<div class="progress progress-small progress-striped active">
														<div class="progress-bar " role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
														</div>
												</td>
											</tr>
											@endif
										</tbody>
									</table>
								</div>
								
							</div>
					</div>
						<!-- END PROJECTS BLOCK -->
			</div>
			<div class="col-lg-6">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Our Activities</h3>
					</div>
					<!-- /.panel-heading -->
					<div class="panel-body">
					<table width="100%" class="table table-striped table-bordered table-hover datatable">
						<thead>
							<tr>
								<th>#</th>
								<th>Activity Title</th>
								<th>Nature of Activity</th>
								<th>Status</th>
								<th>
									Action
								</th>
							</tr>
						</thead>
						<tbody>
								<?php $i=1; ?>
								@foreach($activity as $activity)
										<tr>
											<td>{{ $i++ }}</td>
											<td>{{ $activity->title }}</td>
											<td>{{ $activity->nature }}</td>
											<td>@if($activity->approval == 1)
													Approved
												@elseif($activity->approval == 0)
													Disapproved
												@else
													Pending
												@endif
											</td>
											<td>
													<a href="{{route('activities.view_content', $activity->id)}}" class="btn btn-xs btn-info">View</a>
											</td>
											
										</tr>
								@endforeach
		
						</tbody>
						</table>
					</div>
					<!-- /.panel-body -->
				</div>
				<!-- /.panel -->
			</div>
			
		@endif
				


	</div>
	
</div>


 
@endsection