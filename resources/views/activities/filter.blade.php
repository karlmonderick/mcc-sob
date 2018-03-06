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
		<div class="col-md-4">
			<div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">Filter by year</h4>
                </div>
                <form accept="{{ url('activities') }}" method="post">
               <div class="panel-body panel-body-search">
                <div class="input-group">
                	@foreach($acad_years as $acad)
                    <select name="ay_id"  class="form-control">
									<option value="">--Select--</option>
									<option value="{{$acad->id}}">{{$acad->ay_from}} - {{$acad->ay_to}}</option>
									<option value="2">ssds</option>
					</select>
					@endforeach
                    <div class="input-group-btn">
                        <input type="submit" class="btn btn-info" value="Filter">
                </div>
                </div>
                </div>
            </form>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Request/s</h3>
                </div>
                <div class="panel-body">
                    <ul class="list-group border-bottom">
                        
                        <li class="list-group-item">Not yet reviewed<span class="badge badge-info">{{$count_activity_not}}</span></li>
                        <li class="list-group-item">Reviewed request/s<span class="badge badge-success">{{$count_activity}}</span></li>
                    </ul>                                
                </div>
            </div>
         </div>

         <div class="col-md-8">
			<div class="panel panel-default">
				<!-- /.panel-heading -->
				<div class="panel-body">
					<h3 class="card-title">Not yet reviewed {{ $ay->ay_from }} - {{ $ay->ay_to }}</h3>
					<h6 class="card-subtitle mb-2 text-muted">List</h6>
					<table width="100%" class="table table-striped table-bordered table-hover datatable" >
					<thead>
						<tr>
							<th>#</th>
							@if($auth->role_id == 2)
							<th>Organization</th>
							@endif
							<th>Activity Title</th>
							<th>Nature of Activity</th>
							<th>Status</th>
							<th>
								Option
							</th>
							
						</tr>
					</thead>
					<tbody>
						@if(Auth::user()->role_id == 1)
						<?php $i=1; ?>
						@foreach($not_rev_activity as $activity)
						<tr>
							<td>{{ $i++ }}</td>
							<td>{{ $activity->title }}</td>
							<td>{{ $activity->nature }}</td>
							<td>@if($activity->approval == 1)
									Reviewed
									@elseif($activity->approval == 0)
									Declined
									@elseif($activity->approval == 2)
									Not yet review
								@endif</td>
							<td>
								<form action="{{route('activities.destroy', $activity->id)}}" method="POST">      
									<input type="hidden" name="_method" value="delete">
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									@if($activity->approval != 0) 
									<a href="{{route('activities.view_content', $activity->id)}}" class="btn btn-xs btn-info">View</a>
									@endif
									@if(Auth::user()->role_id == 4)
									<a href="{{route('activities.edit', $activity->id)}}" class="btn btn-xs btn-warning">Edit</a>
									<input type="submit" class="btn btn-xs" onclick="return confirm('Are you sure?')" value="Delete">
									@endif
								</form>
							</td>
						</tr>
						@endforeach
						@endif

						@if(Auth::user()->role_id == 3 )
						<?php $i=1; ?>
						@foreach($activity as $activity)
						<tr>
							<td>{{ $i++ }}</td>
							<td>{{ $activity->title }}</td>
							<td>{{ $activity->nature }}</td>
							<td>@if($activity->approval3 == 1)
									Approved
									@elseif($activity->approval3 == 0)
									Disapproved
									@elseif($activity->approval3 == 2)
									Pending
								@endif</td>
							<td>
								<form action="{{route('activities.destroy', $activity->id)}}" method="POST">      
									<input type="hidden" name="_method" value="delete">
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									@if($activity->review_id != 0) 
									<a href="{{route('activities.view_content', $activity->id)}}" class="btn btn-xs btn-info">View</a>
									@endif
									@if(Auth::user()->role_id == 4)
									<a href="{{route('activities.edit', $activity->id)}}" class="btn btn-xs btn-warning">Edit</a>
									<input type="submit" class="btn btn-xs" onclick="return confirm('Are you sure?')" value="Delete">
									@endif
								</form>
							</td>
						</tr>
						@endforeach
						@endif
					</tbody>
					</table>
					<!-- /.table-responsive -->
				</div>
				<!-- /.panel-body -->
			</div>
			<!-- /.panel -->
		</div>
	</div>
	@endif
	@if(Auth::user()->role_id == 1)
	<div class="row">
		<div class="col-md-4"></div>
	<div class="col-md-8">
			<div class="panel panel-default">
				<!-- /.panel-heading -->
				<div class="panel-body">
					<h3 class="card-title">Reviewed request/s {{ $ay->ay_from }} - {{ $ay->ay_to }}</h3>
					<h6 class="card-subtitle mb-2 text-muted">List</h6>
					<table width="100%" class="table table-striped table-bordered table-hover datatable" >
					<thead>
						<tr>
							<th>#</th>
							@if($auth->role_id == 2)
							<th>Organization</th>
							@endif
							<th>Activity Title</th>
							<th>Nature of Activity</th>
							<th>Status</th>
							<th>
								Option
							</th>
							
						</tr>
					</thead>
					<tbody>
						@if(Auth::user()->role_id == 1)
						<?php $i=1; ?>
						@foreach($rev_activity as $rev_activity)
						<tr>
							<td>{{ $i++ }}</td>
							<td>{{ $rev_activity->title }}</td>
							<td>{{ $rev_activity->nature }}</td>
							<td>@if($rev_activity->approval == 1)
									Reviewed
									@elseif($rev_activity->approval == 0)
									Declined
									@elseif($rev_activity->approval == 2)
									Not yet review
								@endif</td>
							<td>
								<form action="{{route('activities.destroy', $rev_activity->id)}}" method="POST">      
									<input type="hidden" name="_method" value="delete">
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									@if($rev_activity->approval != 0) 
									<a href="{{route('activities.view_content', $rev_activity->id)}}" class="btn btn-xs btn-info">View</a>
									@endif
									@if(Auth::user()->role_id == 4)
									<a href="{{route('activities.edit', $rev_activity->id)}}" class="btn btn-xs btn-warning">Edit</a>
									<input type="submit" class="btn btn-xs" onclick="return confirm('Are you sure?')" value="Delete">
									@endif
								</form>
							</td>
						</tr>
						@endforeach
						@endif

						@if(Auth::user()->role_id == 3 )
						<?php $i=1; ?>
						@foreach($activity as $activity)
						<tr>
							<td>{{ $i++ }}</td>
							<td>{{ $activity->title }}</td>
							<td>{{ $activity->nature }}</td>
							<td>@if($activity->approval3 == 1)
									Approved
									@elseif($activity->approval3 == 0)
									Disapproved
									@elseif($activity->approval3 == 2)
									Pending
								@endif</td>
							<td>
								<form action="{{route('activities.destroy', $activity->id)}}" method="POST">      
									<input type="hidden" name="_method" value="delete">
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									@if($activity->review_id != 0) 
									<a href="{{route('activities.view_content', $activity->id)}}" class="btn btn-xs btn-info">View</a>
									@endif
									@if(Auth::user()->role_id == 4)
									<a href="{{route('activities.edit', $activity->id)}}" class="btn btn-xs btn-warning">Edit</a>
									<input type="submit" class="btn btn-xs" onclick="return confirm('Are you sure?')" value="Delete">
									@endif
								</form>
							</td>
						</tr>
						@endforeach
						@endif
					</tbody>
					</table>
					<!-- /.table-responsive -->
				</div>
				<!-- /.panel-body -->
			</div>
			<!-- /.panel -->
	</div>
	</div>
	@endif
	@endsection