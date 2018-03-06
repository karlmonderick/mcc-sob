@extends('layouts.master')

@section('content')
<!-- START BREADCRUMB -->
<ul class="breadcrumb push-down-0">
	<li><a href="#"> Organization Budget</a></li>
</ul>
<!-- END BREADCRUMB -->      

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
	<div class="row">
		<div class="col-md-12">
			
			<div class="panel panel-default">
				<!-- /.panel-heading -->
				<div class="panel-body">
					@if(Auth::user()->role_id == 4)
						@foreach($officers2 as $offs)
							@foreach($budget2 as $budget2)
								@if($budget2->organization_id == $offs->organization_id)

								@if($budget2->remaining != 0)
								<h3 class="card-title">Organization Budget A.Y.  {{ $ay->ay_from }} - {{ $ay->ay_to }}</h3>
								@else
								<h3 class="card-title">Organization Budget Savings A.Y.  {{ $ay->ay_from }} - {{ $ay->ay_to }}</h3>
								@endif
								
								<h6 class="card-subtitle mb-2 text-muted">List</h6>

								@endif
							@endforeach
						@endforeach
					@else
						<h3 class="card-title">Organization Budgets A.Y.  {{ $ay->ay_from }} - {{ $ay->ay_to }}</h3>
						<h6 class="card-subtitle mb-2 text-muted">List</h6>
					@endif

					@if(Auth::user()->role_id == 4)
						@if($org_saving_num < $org_officer_num && $off_vote != $officer)
						<p>
						<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal2">Save budget as savings</button>
						</p>
						@else
						<p>
						<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal2">View voters</button>
						</p>
						@endif
					@endif
					@if(Auth::user()->role_id == 4)
					<table width="100%" class="table table-striped table-bordered table-hover datatable">
						<thead>
							<tr>
								<th>#</th>
								<th>Organization</th>
								<th>Semester</th>
								<th>Allocated</th>
								<th>Remaining</th>
								<th>Source</th>
							</tr>
						</thead>
						<tbody>
							
							<?php $i=1; ?>
							@foreach($officers as $off)
							@foreach($budget as $budget)
							@if($budget->organization_id == $off->organization_id)
							@if($budget->remaining != 0)
							<tr>
								
								<td>{{ $i++ }}</td>
								<td>{{ $budget->name}}</td>
								<td>@if($budget->semester == 1) 1st @else 2nd @endif </td>
								<td><?php echo number_format($budget->budget) ?></td>
								<td><?php echo number_format($budget->remaining) ?></td>
								<td>{{$budget->name}}</td>
								
							@else

							@foreach($officers as $off)
							@foreach($budget_savings as $budget_savings)
							@if($budget_savings->organization_ay_id == $off->organization_id)
								<td>{{ $i++ }}</td>
								<td>{{ $budget_savings->name}}</td>
								<td>@if($budget_savings->semester == 1) 1st @else 2nd @endif </td>
								<td>Php <?php echo number_format($budget_savings->savings) ?></td>
								<td>Php <?php echo number_format($budget_savings->remaining) ?></td>
								<td>{{$budget_savings->name}}</td>
								
								@endif
								@endforeach
								@endforeach
							</tr>
							@endif
							@endif
							@endforeach
							@endforeach
						</tbody>
					</table>
					@else
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
											<th>Organization</th>
											<th>Budget</th>
											<th>Source</th>
										</tr>
									</thead>
									<tbody>
										
										<?php $i=1; ?>
										@foreach($budget as $budget)
									</tr>
											<td>{{ $i++ }}</td>
											<td>{{ $budget->name}}</td>
											<td><?php echo number_format($budget->remaining) ?></td>
											<td>{{$budget->fund_name}}</td>
											
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
										@foreach($budget2 as $budget2)
										</tr>
											<td>{{ $i++ }}</td>
											<td>{{ $budget2->name}}</td>
											<td><?php echo number_format($budget2->remaining) ?></td>
											<td>{{$budget2->fund_name}}</td>
											
										</tr>
											@endforeach
									</tbody>
								</table>		
							</div>                      
						</div>
					</div>                                         
					<!-- END JUSTIFIED TABS -->

					@endif
					<!-- /.table-responsive -->
				</div>
				<!-- /.panel-body -->
			</div>
			<!-- /.panel -->
		</div>
		<!-- /.col-lg-12 -->
	</div>
</div>




<!-- Modal2 -->

@if(Auth::user()->role_id == 4)
<div id="myModal2" class="modal fade" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Voters</h4>
			</div>
			
			<form method="POST" action="{{route('budgets.get_budget')}}">
				{{ csrf_field()}}
				<div class="modal-body">
					<div class="form-group{{ ($errors->has('institute_id')) ? $errors->first('institute_id') : '' }}">
							
					</div>
					<div class="form-group{{ ($errors->has('no_of_students')) ? $errors->first('no_of_students') : '' }}">
									    
							<p><a href="javascript:void(0);" onclick="user();"><b>{{$org_saving_num}}/{{$org_officer_num}} </b></a>of your co-officers are willing to convert the remaining budget as savings. </p>
							<br>
							<div id="user" style="display: none">
							<table width="100%" class="table table-striped table-bordered table-hover">
							<thead>
							<tr>
								<th>#</th>
								<th>Name</th>
								<th>Position</th>
							</tr>
							</thead>
							<tbody>
							<?php $a=1; ?>
							@foreach($u_users as $u_use)
							<tr>
								<td><?php echo $a++; ?></td>
								<td>{{$u_use->first_name}} {{$u_use->middle_name}} {{$u_use->last_name}}</td>
								<td>{{$u_use->position}}</td>
							</tr>
							@endforeach
							</tbody>
							</table>
							</div>
					</div>
					@foreach($officers as $offs)
					@foreach($budget_id as $budget_id)
					@if($budget_id->organization_ay_id == $offs->organization_id)
					<input type="hidden" name="ay_id" value="{{$ay->id}}">
					<input type="hidden" name="budget_id" value="{{$budget_id->id}}">
					<input type="hidden" name="budget" value="{{$budget_id->remaining}}">
					<input type="hidden" name="sem" value="{{$budget_id->semester}}">
					<input type="hidden" name="organization_ay_id" value="{{$budget_id->organization_ay_id}}">
					<input type="hidden" name="user_id" value="{{$org_officer->user_id}}">
					<input type="hidden" name="org_saving_num" value="{{$org_saving_num}}">
					<input type="hidden" name="org_officer_num" value="{{$org_officer_num}}">
					@endif
					@endforeach
					@endforeach
				</div>
				<div class="modal-footer">
					<div class="form-group">
						@if($org_saving_num < $org_officer_num && $off_vote != $officer)
						<span>Do you want to convert it?</span>
						<input type="submit" class="btn btn-info" value="Yes">
						<button type="button" class="btn btn-default" data-dismiss="modal">no</button>
						@endif
					</div>
				</div>

			</form>
		</div>
	</div>
</div>

@endif

<script type="text/javascript">
        function user() {
        	//es_id
            document.getElementById("user").style.display = "block";
        }
    </script>
                
@endsection