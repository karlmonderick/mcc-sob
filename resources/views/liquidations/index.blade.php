@extends('layouts.master')

@section('content')

<!-- START BREADCRUMB -->
<ul class="breadcrumb push-down-0">
	<li><a href="#">Liquidations</a></li>
</ul>
<!-- END BREADCRUMB --> 

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

	<div class="row">
		<div class="col-md-12">

			
			<div class="panel panel-default">
				<!-- /.panel-heading -->
				<div class="panel-body">
					<h3 class="card-title">Liquidation</h3>
					<h6 class="card-subtitle mb-2 text-muted">List</h6>
					<p>
				<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#myModal">Add Liquidation</button>
			</p><br>
					<table width="100%" class="table table-striped table-bordered table-hover datatable">
						<thead>
							<tr>
								<th>#</th>
								<th>Item</th>
								<th>Amount</th>
								<th>OR#</th>
								<th>Options</th>
								
							</tr>
						</thead>
						<tbody>
							<?php $i=1; ?>
							@foreach($liquidation as $liquidation)
							<tr>
								<td>{{ $i++ }}</td>
								<td>{{ $liquidation->item }}</td>
								<td><? echo number_format($liquidation->amount)?></td>
								<td>{{ $liquidation->official_reciepts }}</td>
								
									<td>
										
										
										<form action="{{route('liquidations.destroy', $liquidation->id)}}" method="POST">      
											<input type="hidden" name="_method" value="delete">
											<input type="hidden" name="_token" value="{{ csrf_token() }}">
											<div class="btn-group">
											<button type="button" class="btn btn-info btn-xs btn-sm btn-rounded" data-toggle="modal" data-target="#myModal_view{{$liquidation->id}}">View</button>
											@if(Auth::user()->role_id == 4)
											@if($liquidation->approval != 1)
											<button type="button" class="btn btn-warning btn-xs btn-sm btn-rounded" data-toggle="modal" data-target="#myModal_edit{{$liquidation->id}}">Edit</button>
											@endif
											@endif
											</div>
										</form>
										
									</td>
							</tr>

							@endforeach
						</tbody>
					</table>
					<!-- /.table-responsive -->
					
					<h3>Total: ₱<?php echo number_format($liquidation_sum) ?> </h3>
				</div>
				<!-- /.panel-body -->
			</div>
			<!-- /.panel -->
		</div>
	</div>

</div>
     



<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
	<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Liquidation Form </h4>
			</div>
			<form action="{{route('liquidations.store')}}" method="post" enctype="multipart/form-data">
				<div class="modal-body">
					{{ csrf_field()}}
							<div class="form-group">
								<label>Item <font color='red'>*</font></label>
									<input type="text" class="form-control" name="item" required>
							</div>
							<div class="form-group">
								<label>Amount<font color='red'>*</font></label>
									<input type="text" class="form-control" name="amount" required>
							</div>
							<input type="hidden" name="act_id" value="{{$act_id}}">
							<div class="form-group">
								<label>Official Receipt #<font color='red'>*</font></label>
								<input type="text" class="form-control" name="receipt" required>
							</div>
							
							<div class="form-group">
								<label>Photo <font color='red'>*</font></label>
							    <input type="file" name="file" id="file" required>
							</div>
					<hr>
					<div class="form-group" >
						<input type="submit" class="btn btn-primary" value="Submit"> 
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- Modal --> 

<!-- Modal edit-->
@foreach($liquidation_modal as $liquidation_modal)
<div id="myModal_edit{{$liquidation_modal->id}}" class="modal fade" role="dialog">
	<div class="modal-dialog">
	<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Liquidation Form</h4>
			</div>
			<div class="modal-body">
			<form action="{{route('liquidations.update', $liquidation_modal->id)}}" method="post">

				<input type="hidden" name="_method" value="PATCH">
								{{ csrf_field()}}
					<div class="row">
						<div class="form-group">
								<label>Item <font color='red'>*</font></label>
									<input type="text" class="form-control" name="item"  value="{{$liquidation_modal->item}}" required>
							</div>
							<div class="form-group">
								<label>Amount<font color='red'>*</font></label>
									<input type="number" class="form-control" value="{{$liquidation_modal->amount}}" name="amount" required>
							</div>
							<input type="hidden" name="act_id" value="{{$act_id}}">
							<div class="form-group">
								<label>Official Receipt #<font color='red'>*</font></label>
								<input type="text" class="form-control" name="receipt" value="{{ $liquidation_modal->or}}" required>
							</div>
							
						
					
					</div>
					

					<hr>
				
					<div class="form-group" style="margin-left: 10px;">
						<input type="submit" class="btn btn-primary" value="Submit"> 
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endforeach
<!-- Modal --> 


<!-- Modal view-->
@foreach($liquidation_modal_view as $liquidation_modal_view)
<div id="myModal_view{{$liquidation_modal_view->id}}" class="modal fade" role="dialog">
	<div class="modal-dialog">
	<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Liquidation Form</h4>
			</div>
			<div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
<div class="form-group">
                    <div class="timeline-item timeline-item-right">      
                                    <div class="timeline-item-content">                                       
                                        <div class="timeline-body">                                                                                        
                                            <img src="/uploads/{{$liquidation_modal_view->picture}}" width="200" class="img-text" align="left"/> 
                                            <p> 
								
								Item: <strong>{{ $liquidation_modal_view->item}}</strong>  
								<br>
								amount: <strong>{{ $liquidation_modal_view->amount}}</strong>  
								<br>
								Official Receipt #: <strong>{{ $liquidation_modal_view->official_reciepts }}</strong>    
								<br> 
								
								Submitted By: <strong>{{ $liquidation_modal_view->first_name }} {{ $liquidation_modal_view->middle_name }} {{ $liquidation_modal_view->last_name }}</strong>  

							</p>
                                                   
                                           
                                        </div>        
                                    </div>                                    
                                </div>
                            </div>
                        </div>
                    </div>
			<br><br>
			<hr>
				
					<div class="form-group" style="margin-left: 0px;">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
			</div>
		</div>
	</div>
</div>
@endforeach
<!-- Modal -->   
@endsection