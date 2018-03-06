@extends('layouts.master')

@section('content')

<!-- START BREADCRUMB -->
<ul class="breadcrumb push-down-0">
	<li><a href="#">Organizations</a></li>
</ul>
<!-- END BREADCRUMB -->    

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

	<div class="row">

		<div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Summary</h3>
                </div>
                <div class="panel-body">
					@if(Auth::user()->role_id == 1)
						<p>
							<button type="button" class="btn btn-success btn-block btn-rounded" data-toggle="modal" data-target="#myModal">Add Organization</button>
						</p>
					@endif
                    <ul class="list-group border-bottom">
                        <li class="list-group-item">College Wide<span class="badge badge-info">{{$count_cw}}</span></li>
                        <li class="list-group-item">Cultural<span class="badge badge-info">{{$count_co}}</span></li>
						<li class="list-group-item">Student Councils<span class="badge badge-info">{{$count_sc}}</span></li>
						<li class="list-group-item">Publication<span class="badge badge-info">{{$count_eq}}</span></li>
						@foreach($institutes as $institute)
							<li class="list-group-item">{{ $institute->code }}
								<span class="badge badge-info">
									@if($institute->code == 'IAS')
										{{$count_ias}}
									@elseif($institute->code == 'IBE')
										{{$count_ibe}}
									@elseif($institute->code == 'ICS')
										{{$count_ics}}
									@elseif($institute->code == 'IHM')
										{{$count_ihm}}
									@elseif($institute->code == 'ITE')
										{{$count_ite}}
									@endif
								</span>
							</li>
						@endforeach
                    </ul>
					<hr>
					Total: <span class="badge badge-info pull-right">{{$count_total}}</span>          
					                      
                </div>
            </div>
         </div>

		<div class="col-md-9">
			<div class="panel panel-default">
				<!-- /.panel-heading -->
				<div class="panel-body">
					<h3 class="card-title">Organizations</h3>
					<h6 class="card-subtitle mb-2 text-muted">List</h6>
					<div class="table-responsive">
						<table width="100%" class="table table-striped table-bordered table-hover datatable">
							<thead>
								<tr>
									<th>#</th>
									<th>Organization Name</th>
									<th>Affiliation</th>
									<th>Organization Type</th>
									@if(Auth::user()->role_id == 1)
										<th>Option</th>
									@endif
								</tr>
							</thead>
							<tbody>
								<?php $i=1; ?>
								@foreach($organizations as $organization)
								<tr>
									<td>{{ $i++ }}</td>
									<td>{{ $organization->name }}</td>
									<td>
										@if($organization->institute_id != NULL)
											@foreach($ins as $institute)
												@if($institute->id == $organization->institute_id)
													{{$institute->code}}
												@endif
											@endforeach
										@else
											None
										@endif
									</td>
									<td>@if($organization->type == 'CW')  College Wide @elseif($organization->type == 'CO') Cultural @elseif($organization->type == 'IO') Institute Organization @elseif($organization->type == 'SPORTS') Sports @elseif($organization->type == 'SP') Student Publication @elseif($organization->type == 'ISC') Institute Student Council @else Supreme Student Council @endif</td>
									@if(Auth::user()->role_id == 1)
										<td>
											<form action="{{route('organizations.destroy', $organization->id)}}" method="POST">      
												<input type="hidden" name="_method" value="Delete">
												<input type="hidden" name="_token" value="{{ csrf_token() }}"> 
												@if(Auth::user()->role_id == 1)
													<div class="btn-group btn-group-sm">
														<button type="button" class="btn btn-warning btn-xs btn-rounded" data-toggle="modal" data-target="#myModal_2{{$organization->id}}" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></button> 
														<button type="submit" class="btn btn-xs btn-danger btn-rounded" onclick="return confirm('Are you sure?')" data-toggle="tooltip" data-placement="top" title="Delete" ><i class="fa fa-trash-o"></i></button>
													</div>
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
				</div>
				<!-- /.panel-body -->
			</div>
			<!-- /.panel -->
		</div>
	</div>

</div>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
	<div class="modal-dialog modal-sm">

		<!-- Modal content-->
		<div class="modal-content">

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Organization Information</h4>
			</div>
			
			<form method="POST" action="{{route('organizations.store')}}">
			
				<div class="modal-body">
					{{ csrf_field()}}
					<div class="form-group">
						<label>Organization Name:</label>
						<input type="text" name="name" class="form-control" pattern="^[A-Za-z-'-. _]*[A-Za-z-'-.][A-Za-z-'-. _]*$" placeholder="Enter Organization name" required>
						{!! $errors->first('name', '<p class="help-block">:message</p>') !!}
					</div>
					<div class="form-group">
						<label>Organization Code:</label>
						<input type="text" name="code" class="form-control" pattern="^[A-Za-z-'-. _]*[A-Za-z-'-.][A-Za-z-'-. _]*$" placeholder="Enter Organization code" required>
						{!! $errors->first('code', '<p class="help-block">:message</p>') !!}
					</div>
					<input type="hidden" name="officers" value="">
					<div class="form-group">
						<label>Institute</label>
						<select class="form-control" name="institute_id">
							<option value="">None</option>
							@foreach($ins as $institute)
								<option value="{{ $institute->id }}">{{ $institute->name }}</option>
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
							<option value="SPORTS">Spors</option>
						</select>
					</div>
				</div>
				
				<div class="modal-footer">
					<div class="form-group">
						<input type="submit" class="btn btn-success" value="Add">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>

			</form>
		</div>

	</div>
</div>

<!-- Modal -->
@foreach($organizations as $organization_modal)
<div id="myModal_2{{$organization_modal->id}}" class="modal fade" role="dialog">
	<div class="modal-dialog">
	<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Liquidation Form</h4>
			</div>
				<div class="modal-body">
					
					<form action="{{route('organizations.update', $organization_modal->id)}}" method="post">
								<input type="hidden" name="_method" value="PATCH">
								{{ csrf_field()}}
								<div class="form-group">
									<label>Organization Name:</label>
									<input type="text" name="name" class="form-control" placeholder="Enter Organization name" value="{{ $organization_modal->name }}" required>
								</div>
								<div class="form-group">
									<label>Organization Code:</label>
									<input type="text" name="code" class="form-control" placeholder="Enter Organization code" value="{{ $organization_modal->code }}" required>
								</div>
								<div class="form-group">	
									<label>Institute:</label>
									<select class="form-control" name="institute_id">
										<option value="">None</option>
										@foreach($ins as $institute)
											<option value="{{ $institute->id }}"
											@if($organization_modal->institute_id==$institute->id) selected
											@endif
											>{{ $institute->name }}</option>
										@endforeach
										
									</select>
								</div>
								<div class="form-group">
									<label>Type</label>
									<select class="form-control" name="type">
										<option value="CW" @if($organization_modal->type=="CW") selected @endif>College Wide</option>
										<option value="CO" @if($organization_modal->type=="CO") selected @endif>Cultural</option>
										<option value="IO" @if($organization_modal->type=="IO") selected @endif>Institute Organization</option>
										<option value="SP" @if($organization_modal->type=="SP") selected @endif>Student Publication</option>
										<option value="ISC" @if($organization_modal->type=="ISC") selected @endif>Institute Student Council</option>
										<option value="SSC" @if($organization_modal->type=="SSC") selected @endif>Supreme Student Council</option>
										<option value="SPORTS" @if($organization_modal->type=="SPORTS") selected @endif>Sports</option>
									</select>
								</div>
								<div class="form-group">
									<input type="submit" class="btn btn-success" value="Save">
									<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
									<!-- <a onclick="history.back()" id="btn-add" class="btn btn-info" >Cancel</a>-->
								</div>
							</form>

				</div>
		</div>
	</div>
</div>
@endforeach
<!-- Modal --> 
        
@endsection