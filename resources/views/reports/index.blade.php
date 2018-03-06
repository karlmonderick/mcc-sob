@extends('layouts.master')

@section('content')
<!-- START BREADCRUMB -->
<ul class="breadcrumb push-down-0">
	<li><a href="#"> Reports</a></li>
</ul>
<!-- END BREADCRUMB -->      

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
	<div class="row">
		<div class="col-md-12">
			
			<div class="panel panel-default">
				<!-- /.panel-heading -->
				<br><br>

					
@if(Auth::user()->role_id == 2)
<!-- START JUSTIFIED TABS -->
						<ul class="nav nav-tabs nav-justified">
							<li class="active"><a href="#tab1" data-toggle="tab">Funds</a></li>
							<li><a href="#tab2" data-toggle="tab">Allocated Budget</a></li>
							<li><a href="#tab3" data-toggle="tab">Activity Budgets Request</a></li>
							<li><a href="#tab4" data-toggle="tab">Cash-outs</a></li>
							<li><a href="#tab5" data-toggle="tab">Liquidation</a></li>
						</ul>
						<div class="panel-body tab-content">

								<!-- funds -->
							<div class="tab-pane active" id="tab1">
								<br><br><br>
								<div class="panel panel-default tabs">
									<ul class="nav nav-tabs nav-justified">
										<li class="active"><a href="#tab10" data-toggle="tab">First Semester</a></li>
										<li><a href="#tab11" data-toggle="tab">Second Semester</a></li>
									</ul>
									<div class="panel-body tab-content">
										<div class="tab-pane active" id="tab10">
											@if($count_fund_1 != 0)
											<form target="_blank" action="{{route('reports.print', 1)}}">
												{{csrf_field()}}
												<input type="hidden" name="ay_id" value="{{$ay_id}}">
												<input type="submit" class="btn btn-sm btn-success pull-right" value="Generate report" style="margin-bottom:5px"/>
											</form>
											@else
											<form action="{{route('reports.print', 1)}}">
												{{csrf_field()}}
												<input type="hidden" name="ay_id" value="{{$ay_id}}">
												<input type="submit" class="btn btn-sm btn-success pull-right" value="Generate report" style="margin-bottom:5px"/>
											</form>
											@endif
											<table width="100%" class="table table-striped table-bordered table-hover datatable">
												<thead>
													<tr>
														<th>#</th>
														<th>Name</th>
														<th>Amount (₱)</th>
														<th>Remaining (₱)</th>
													</tr>
												</thead>
												<tbody>
													<?php $i=1; ?>
													@foreach($fund_1 as $fund_1)
													<tr>
														<td>{{ $i++ }}</td>
														<td>{{$fund_1->name}}</td>
														<td>{{number_format($fund_1->amount)}}</td>
														<td>{{number_format($fund_1->remaining)}}@if($fund_1->amount>$fund_1->remaining) <code><i class="fa fa-long-arrow-down"></i></code> @endif</td>
													</tr>
													@endforeach
												</tbody>
											</table>
										</div>
										<div class="tab-pane" id="tab11">
											@if($count_fund_2 != 0)
											<form target="_blank" action="{{route('reports.print', 2)}}">
												{{csrf_field()}}
												<input type="hidden" name="ay_id" value="{{$ay_id}}">
												<input type="submit" class="btn btn-sm btn-success pull-right" value="Generate report" style="margin-bottom:5px"/>
											</form>
											@else
											<form action="{{route('reports.print', 2)}}">
												{{csrf_field()}}
												<input type="hidden" name="ay_id" value="{{$ay_id}}">
												<input type="submit" class="btn btn-sm btn-success pull-right" value="Generate report" style="margin-bottom:5px"/>
											</form>
											@endif
											<table width="100%" class="table table-striped table-bordered table-hover datatable">
												<thead>
													<tr>
														<th>#</th>
														<th>Name</th>
														<th>Amount (₱)</th>
														<th>Remaining (₱)</th>
													</tr>
												</thead>
												<tbody>
													<?php $i=1; ?>
													@foreach($fund_2 as $fund_2)
													<tr>
														<td>{{ $i++ }}</td>
														<td>{{$fund_2->name}}</td>
														<td>{{number_format($fund_2->amount)}}</td>
														<td>{{number_format($fund_2->remaining)}} @if($fund_2->amount>$fund_2->remaining) <i class="fa fa-long-arrow-down"> @endif</i></td>
													</tr>
													@endforeach
												</tbody>
											</table>
										</div> 
									</div>
								</div>
							</div>
								<!-- end funds -->

								<!-- allocated budget -->
							<div class="tab-pane" id="tab2">
								<br><br><br>
								<div class="panel panel-default tabs">
									<ul class="nav nav-tabs nav-justified">
										<li class="active"><a href="#tab12" data-toggle="tab">First Semester</a></li>
										<li><a href="#tab13" data-toggle="tab">Second Semester</a></li>
									</ul>
									<div class="panel-body tab-content">
										<div class="tab-pane active" id="tab12">
											@if($count_all_budget_1 != 0)
											<form target="_blank" action="{{route('reports.print', 3)}}">
												{{csrf_field()}}
												<input type="hidden" name="ay_id" value="{{$ay_id}}">
												<input type="submit" class="btn btn-sm btn-success pull-right" value="Generate report" style="margin-bottom:5px"/>
											</form>
											@else
											<form action="{{route('reports.print', 3)}}">
												{{csrf_field()}}
												<input type="hidden" name="ay_id" value="{{$ay_id}}">
												<input type="submit" class="btn btn-sm btn-success pull-right" value="Generate report" style="margin-bottom:5px"/>
											</form>
											@endif
											<table width="100%" class="table table-striped table-bordered table-hover datatable">
												<thead>
													<tr>
														<th>#</th>
														<th>Organization</th>
														<th>Amount (₱)</th>
														<th>Date</th>
													</tr>
												</thead>
												<tbody>
													<?php $i=1; ?>
													@foreach($all_budget_1 as $all_budget_1)
													<tr>
														<td>{{$i++}}</td>
														<td>{{$all_budget_1->name}}</td>
														<td>{{number_format($all_budget_1->budget)}}</td>
														<td><?php echo \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $all_budget_1->budget_date)->format('M-d-Y'); ?></td>
													</tr>
													@endforeach
												</tbody>
											</table>
										</div>
										<div class="tab-pane" id="tab13">
											@if($count_all_budget_2 != 0)
											<form target="_blank" action="{{route('reports.print', 4)}}">
												{{csrf_field()}}
												<input type="hidden" name="ay_id" value="{{$ay_id}}">
												<input type="submit" class="btn btn-sm btn-success pull-right" value="Generate report" style="margin-bottom:5px"/>
											</form>
											@else
											<form action="{{route('reports.print', 4)}}">
												{{csrf_field()}}
												<input type="hidden" name="ay_id" value="{{$ay_id}}">
												<input type="submit" class="btn btn-sm btn-success pull-right" value="Generate report" style="margin-bottom:5px"/>
											</form>
											@endif
											<table width="100%" class="table table-striped table-bordered table-hover datatable">
												<thead>
													<tr>
														<th>#</th>
														<th>Organization</th>
														<th>Amount (₱)</th>
														<th>Date</th>
													</tr>
												</thead>
												<tbody>
													<?php $i=1; ?>
													@foreach($all_budget_2 as $all_budget_2)
													<tr>
														<td>{{$i++}}</td>
														<td>{{$all_budget_2->name}}</td>
														<td>{{number_format($all_budget_2->budget)}}</td>
														<td><?php echo \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $all_budget_2->budget_date)->format('M-d-Y'); ?></td>
													</tr>
													@endforeach
												</tbody>
											</table>
										</div> 
									</div>
								</div>
							</div> 
								<!-- end allocated budget -->

								<!-- activity budget request -->
							<div class="tab-pane" id="tab3">
								<br><br><br>
								<div class="panel panel-default tabs">
									<ul class="nav nav-tabs nav-justified">
										<li class="active"><a href="#tab14" data-toggle="tab">First Semester</a></li>
										<li><a href="#tab15" data-toggle="tab">Second Semester</a></li>
									</ul>
									<div class="panel-body tab-content">
										<div class="tab-pane active" id="tab14">
											@if($count_activity_1 != 0)
											<form target="_blank" action="{{route('reports.print', 5)}}">
												{{csrf_field()}}
												<input type="hidden" name="ay_id" value="{{$ay_id}}">
												<input type="submit" class="btn btn-sm btn-success pull-right" value="Generate report" style="margin-bottom:5px"/>
											</form>
											@else
											<form action="{{route('reports.print', 5)}}">
												{{csrf_field()}}
												<input type="hidden" name="ay_id" value="{{$ay_id}}">
												<input type="submit" class="btn btn-sm btn-success pull-right" value="Generate report" style="margin-bottom:5px"/>
											</form>
											@endif
											<table width="100%" class="table table-striped table-bordered table-hover datatable">
												<thead>
													<tr>
														<th>#</th>
														<th>Activity Name</th>
														<th>Organization</th>
														<th>Amount (₱)</th>
														<th>Date</th>
														<th>Liquidation</th>
														
													</tr>
												</thead>
												<tbody>
													<?php $i=1; ?>
													@foreach($activity_1 as $activity)
													<tr>
														<td>{{ $i++ }}</td>
														<td>{{$activity->title}}</td>
														<td>{{$activity->name}}</td>
														<td>{{number_format($activity->buggetTotal)}}</td>
														<td><?php echo \Carbon\Carbon::createFromFormat('Y-m-d', $activity->date)->format('M-d-Y'); ?></td>
														<td><form action="{{route('reports.print', 11)}}">
															{{csrf_field()}}
															<input type="hidden" name="activity_id" value="{{$activity->id}}">
															<input type="submit" class="btn btn-sm btn-success btn-block" value="Print" />
															</form>
														</td>
													</tr>
													@endforeach
												</tbody>
											</table>
										</div>
										<div class="tab-pane" id="tab15">
											@if($count_activity_2 != 0)
											<form target="_blank" action="{{route('reports.print', 6)}}">
												{{csrf_field()}}
												<input type="hidden" name="ay_id" value="{{$ay_id}}">
												<input type="submit" class="btn btn-sm btn-success pull-right" value="Generate report" style="margin-bottom:5px"/>
											</form>
											@else
											<form action="{{route('reports.print', 6)}}">
												{{csrf_field()}}
												<input type="hidden" name="ay_id" value="{{$ay_id}}">
												<input type="submit" class="btn btn-sm btn-success pull-right" value="Generate report" style="margin-bottom:5px"/>
											</form>
											@endif
											<table width="100%" class="table table-striped table-bordered table-hover datatable">
												<thead>
													<tr>
														<th>#</th>
														<th>Activity Name</th>
														<th>Organization</th>
														<th>Cash-amount (₱)</th>
														<th>Date</th>
														<th>Liquidation</th>
													</tr>
												</thead>
												<tbody>
													<?php $i=1; ?>
													@foreach($activity_2 as $activity)
													<tr>
														<td>{{ $i++ }}</td>
														<td>{{$activity->title}}</td>
														<td>{{$activity->name}}</td>
														<td>{{number_format($activity->buggetTotal)}}</td>
														<td><?php echo \Carbon\Carbon::createFromFormat('Y-m-d', $activity->date)->format('M-d-Y'); ?></td>
														<td>
														<form action="{{route('reports.print', 3)}}">
															{{csrf_field()}}
															<input type="hidden" name="activity_id" value="{{$activity->id}}">
															<input type="submit" class="btn btn-sm btn-success btn-block" value="Print" />
														</form>
														</td>
													</tr>
													@endforeach
												</tbody>
											</table>
										</div> 
									</div>
								</div>		
							</div>    
								<!-- end activity budget request -->

								<!-- cash outs -->
							<div class="tab-pane" id="tab4">
								<br><br><br>
								<div class="panel panel-default tabs">
									<ul class="nav nav-tabs nav-justified">
										<li class="active"><a href="#tab16" data-toggle="tab">First Semester</a></li>
										<li><a href="#tab17" data-toggle="tab">Second Semester</a></li>
									</ul>
									<div class="panel-body tab-content">
										<div class="tab-pane active" id="tab16">
											@if($count_cash_req_1 != 0)
											<form target="_blank" action="{{route('reports.print', 7)}}">
												{{csrf_field()}}
												<input type="hidden" name="ay_id" value="{{$ay_id}}">
												<input type="submit" class="btn btn-sm btn-success pull-right" value="Generate report" style="margin-bottom:5px"/>
											</form>
											@else
											<form action="{{route('reports.print', 7)}}">
												{{csrf_field()}}
												<input type="hidden" name="ay_id" value="{{$ay_id}}">
												<input type="submit" class="btn btn-sm btn-success pull-right" value="Generate report" style="margin-bottom:5px"/>
											</form>
											@endif
											<table width="100%" class="table table-striped table-bordered table-hover datatable">
												<thead>
													<tr>
														<th>#</th>
														<th>Activity Name</th>
														<th>Organization</th>
														<th>Cash-amount (₱)</th>
														<th>Date</th>
													</tr>
												</thead>
												<tbody>
													<?php $i=1; ?>
													@foreach($cash_req_1 as $cash_req_1)
													<tr>
														<td>{{ $i++ }}</td>
														<td>{{$cash_req_1->title}}</td>
														<td>{{$cash_req_1->name}}</td>
														<td>{{number_format($cash_req_1->cash_amount)}}</td>
														<td><?php echo \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $cash_req_1->created_at)->format('M-d-Y'); ?></td>
													</tr>
													@endforeach
												</tbody>
											</table>
										</div>
										<div class="tab-pane" id="tab17">
											@if($count_cash_req_2 != 0)
											<form target="_blank" action="{{route('reports.print', 8)}}">
												{{csrf_field()}}
												<input type="hidden" name="ay_id" value="{{$ay_id}}">
												<input type="submit" class="btn btn-sm btn-success pull-right" value="Generate report" style="margin-bottom:5px"/>
											</form>
											@else
											<form action="{{route('reports.print', 8)}}">
												{{csrf_field()}}
												<input type="hidden" name="ay_id" value="{{$ay_id}}">
												<input type="submit" class="btn btn-sm btn-success pull-right" value="Generate report" style="margin-bottom:5px"/>
											</form>
											@endif
											<table width="100%" class="table table-striped table-bordered table-hover datatable">
												<thead>
													<tr>
														<th>#</th>
														<th>Activity Name</th>
														<th>Organization</th>
														<th>Cash-amount (₱)</th>
														<th>Date</th>
													</tr>
												</thead>
												<tbody>
													<?php $i=1; ?>
													@foreach($cash_req_2 as $cash_req_2)
													<tr>
														<td>{{ $i++ }}</td>
														<td>{{$cash_req_2->title}}</td>
														<td>{{$cash_req_2->name}}</td>
														<td>{{number_format($cash_req_2->cash_amount)}}</td>
														<td><?php echo \Carbon\Carbon::createFromFormat('Y-m-d', $cash_req_2->date)->format('M-d-Y'); ?></td>
													</tr>
													@endforeach
												</tbody>
											</table>
										</div> 
									</div>
								</div>		
							</div>
								<!-- end cash outs -->

								<!-- liquidation -->
							<div class="tab-pane" id="tab5">
								<br><br><br>
								<div class="panel panel-default tabs">
									<ul class="nav nav-tabs nav-justified">
										<li class="active"><a href="#tab18" data-toggle="tab">First Semester</a></li>
										<li><a href="#tab19" data-toggle="tab">Second Semester</a></li>
									</ul>
									<div class="panel-body tab-content">
										<div class="tab-pane active" id="tab18">
											<table width="100%" class="table table-striped table-bordered table-hover datatable">
												<thead>
													<tr>
														<th>#</th>
														<th>Organization</th>
														<th>Activity Name</th>
														<th>Official Receipts</th>
														<th>Date</th>
													</tr>
												</thead>
												<tbody>
													<?php $i=1; ?>
													@foreach($liquidation as $liquidation)
													<tr>
														<td>{{ $i++ }}</td>
														<td>{{$liquidation->name}}</td>
														<td>{{$liquidation->title}}</td>
														<td>{{$liquidation->official_reciepts}}</td>
														<td><?php echo \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $liquidation->created_at)->format('M-d-Y'); ?></td>	
													</tr>
													@endforeach
												</tbody>
											</table>
										</div>
										<div class="tab-pane" id="tab19">
											@if($count_liquidation_2 != 0)
											<form target="_blank" action="{{route('reports.print', 10)}}">
												{{csrf_field()}}
												<input type="hidden" name="ay_id" value="{{$ay_id}}">
												<input type="submit" class="btn btn-sm btn-success pull-right" value="Generate report" style="margin-bottom:5px"/>
											</form>
											@else
											<form  action="{{route('reports.print', 10)}}">
												{{csrf_field()}}
												<input type="hidden" name="ay_id" value="{{$ay_id}}">
												<input type="submit" class="btn btn-sm btn-success pull-right" value="Generate report" style="margin-bottom:5px"/>
											</form>
											@endif
											<table width="100%" class="table table-striped table-bordered table-hover datatable">
												<thead>
													<tr>
														<th>#</th>
														<th>Organization</th>
														<th>Activity Name</th>
														<th>Official Receipts</th>
														<th>Date</th>
													</tr>
												</thead>
												<tbody>
													<?php $i=1; ?>
													@foreach($liquidation_2 as $liquidation_2)
													<tr>
														<td>{{ $i++ }}</td>
														<td>{{$liquidation_2->name}}</td>
														<td>{{$liquidation_2->title}}</td>
														<td>{{$liquidation_2->official_reciepts}}</td>
														<td><?php echo \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $liquidation_2->created_at)->format('M-d-Y'); ?></td>	
													</tr>
													@endforeach
												</tbody>
											</table>
										</div> 
									</div>
								</div>		
							</div>
								<!-- end liquidation -->  
						</div>                    
					           
<!-- END JUSTIFIED TABS -->
@endif

@if(Auth::user()->role_id == 4)

						<ul class="nav nav-tabs nav-justified">
							<li class="active"><a href="#tab1" data-toggle="tab">Activity Budget Request</a></li>
							
						</ul>
						<div class="panel-body tab-content">

								<!-- funds -->
							<div class="tab-pane active" id="tab1">
								<br><br><br>
								<div class="panel panel-default tabs">
									<ul class="nav nav-tabs nav-justified">
										<li class="active"><a href="#tab3" data-toggle="tab">First Semester</a></li>
										<li><a href="#tab4" data-toggle="tab">Second Semester</a></li>
									</ul>
									<div class="panel-body tab-content">
										<div class="tab-pane active" id="tab3">
											@if($count_accomplished_activity != 0)
											<form target="_blank" action="{{route('reports.print', 1)}}">
												{{csrf_field()}}
												<input type="hidden" name="ay_id" value="{{$ay_id}}">
												<input type="submit" class="btn btn-sm btn-success pull-right" value="Generate report" style="margin-bottom:5px"/>
											</form>
											@else
											<form action="{{route('reports.print', 1)}}">
												{{csrf_field()}}
												<input type="hidden" name="ay_id" value="{{$ay_id}}">
												<input type="submit" class="btn btn-sm btn-success pull-right" value="Generate report" style="margin-bottom:5px"/>
											</form>
											@endif
											<table width="100%" class="table table-striped table-bordered table-hover datatable">
												<thead>
													<tr>
														<th>#</th>
														<th>Name</th>
														<th>Nature</th>
														<th>Venue</th>
														<th>Cost (₱)</th>
														<th>Date</th>
														<th>Liquidation</th>
													</tr>
												</thead>
												<tbody>
													<?php $i=1; ?>
													@foreach($accomplished_activity as $activity)
													<tr>
														<td>{{ $i++ }}</td>
														<td>{{$activity->title}}</td>
														<td>{{$activity->nature}}</td>
														<td>{{$activity->venue}}</td>
														<td>{{number_format($activity->buggetTotal)}}</td>	
														<td><?php echo \Carbon\Carbon::createFromFormat('Y-m-d', $activity->date)->format('M-d-Y'); ?></td>
														<td>
														<form action="{{route('reports.print', 3)}}">
															{{csrf_field()}}
															<input type="hidden" name="activity_id" value="{{$activity->id}}">
															<input type="submit" class="btn btn-sm btn-success btn-block" value="Print" />
														</form>
														</td>
													</tr>
													@endforeach
												</tbody>
											</table>
										</div>
										<div class="tab-pane " id="tab4">
											@if($count_accomplished_activity_2 != 0)
											<form target="_blank" action="{{route('reports.print', 2)}}">
												{{csrf_field()}}
												<input type="hidden" name="ay_id" value="{{$ay_id}}">
												<input type="submit" class="btn btn-sm btn-success pull-right" value="Generate report" style="margin-bottom:5px"/>
											</form>
											@else
											<form action="{{route('reports.print', 2)}}">
												{{csrf_field()}}
												<input type="hidden" name="ay_id" value="{{$ay_id}}">
												<input type="submit" class="btn btn-sm btn-success pull-right" value="Generate report" style="margin-bottom:5px"/>
											</form>
											@endif
											<table width="100%" class="table table-striped table-bordered table-hover datatable">
												<thead>
													<tr>
														<th>#</th>
														<th>Name</th>
														<th>Nature</th>
														<th>Venue</th>
														<th>Cost (₱)</th>
														<th>Date</th>
													</tr>
												</thead>
												<tbody>
													<?php $i=1; ?>
													@foreach($accomplished_activity_2 as $accomplished_activity_2)
													<tr>
														<td>{{ $i++ }}</td>
														<td>{{$accomplished_activity_2->title}}</td>
														<td>{{$accomplished_activity_2->nature}}</td>
														<td>{{$accomplished_activity_2->venue}}</td>
														<td>{{number_format($accomplished_activity_2->buggetTotal)}}</td>	
														<td><?php echo \Carbon\Carbon::createFromFormat('Y-m-d', $accomplished_activity_2->date)->format('M-d-Y'); ?></td>
													</tr>
													@endforeach
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>

							
@endif
				</div>
		</div>
	</div>
</div>
@endsection