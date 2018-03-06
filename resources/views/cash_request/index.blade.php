@extends('layouts.master')

@section('content')
        
<!-- START BREADCRUMB -->
<ul class="breadcrumb push-down-0">
	<li><a href="#"> Cash Request {{ $ay->ay_from }} - {{ $ay->ay_to }}</a></li>
</ul>
<!-- END BREADCRUMB -->      

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
	
	@if(Auth::user()->role_id == 2)

	<div class="row">
		<div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">No. of Cash Request/s</h3>
                </div>
                <div class="panel-body">
                    <ul class="list-group border-bottom">
                       <li class="list-group-item">Not yet released<span class="badge badge-info">{{$count_not}}</span></li>
                        <li class="list-group-item">Released<span class="badge badge-success">{{$count_released}}</span></li>
                   </ul>                                
                </div>
            </div>
         </div>

         <div class="col-md-9">
			<div class="panel panel-default tabs">
				<ul class="nav nav-tabs nav-justified">
					<li class="active"><a href="#tab8" data-toggle="tab">Not yet released</a></li>
					<li><a href="#tab9" data-toggle="tab">Released</a></li>
				</ul>
				<div class="panel-body tab-content">
				<div class="tab-pane active" id="tab8">
					<table width="100%" class="table table-striped table-bordered table-hover datatable" >
					<thead>
						<tr>
							<th>#</th>
							<th>Organization</th>
							<th>Cash Amount (₱)</th>
							<th>
								Option
							</th>
							
						</tr>
					</thead>
					<tbody>
						<?php $i=1; ?>
						@foreach($ca_req as $ca_req)
						<tr>
							<td>{{ $i }}</td>
							<td>{{ $ca_req->name }}</td>
							<td><?php echo number_format($ca_req->cash_amount) ?></td>	
							<td>
								<a data-toggle="modal" data-target="#myModal{{$i++}}"  class="btn btn-xs btn-info">Release</a>
							</td>
						</tr>
						@endforeach
						</tbody>
					</table>
				</div>
					<!-- /.table-responsive -->
				<div class="tab-pane" id="tab9">
					<table width="100%" class="table table-striped table-bordered table-hover datatable" >
					<thead>
						<tr>
							<th>#</th>
							<th>Organization</th>
							<th>Cash Amount (₱)</th>
							
							
						</tr>
					</thead>
					<tbody>
						<?php $i=1; ?>
						@foreach($re_req as $re_req)
						<tr>
							<td>{{ $i++ }}</td>
							<td>{{ $re_req->name }}</td>
							<td><?php echo number_format($re_req->cash_amount) ?></td>
							
						</tr>
						@endforeach
					</tbody>
					</table>
				</div>
				</div>
				<!-- /.panel-body -->
			</div>
			<!-- /.panel -->
		</div>
	</div>
	
	@endif
</div>


<?php $j=1; ?>
@foreach($ca_req2 as $ca_req2)
	<!-- Modal -->
	<div id="myModal{{$j++}}" class="modal fade" role="dialog">
		<div class="modal-dialog modal-sm">

			<!-- Modal content-->
			<div class="modal-content">

				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Enter Verification Code</h4>
				</div>
				<form method="POST" action="{{route('cash_request.update', $ca_req2->id) }}">
					<input type="hidden" name="_method" value="PATCH">
							{{ csrf_field()}}
					<div class="modal-body">
						<input type="hidden" name="act_id" value="{{$ca_req2->activity_id}}">
						<input type="text" name="v_code" class="form-control" required>
						<input type="hidden" name="v_code_true" value="{{$ca_req2->verification_code}}">
						<input type="hidden" name="cash_id" value="{{$ca_req2->id}}">
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



