 @extends('layouts.master')

@section('content')

<!-- START BREADCRUMB -->
<ul class="breadcrumb push-down-0">
<li><a href="#"> Activities</a></li>
<li><a href="#"> Create</a></li>
</ul>
<!-- END BREADCRUMB -->  
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<!-- /.panel-heading -->
			<div class="panel-body">
				<h3 class="card-title">SAS FORM </h3>
				<h6 class="card-subtitle mb-2 text-muted">Activities</h6>
			
			<div class="articles-container">
				<div class="divider" style="margin-top: 1rem;"></div>
				<form action="{{route('activities.store')}}" method="post">
					{{ csrf_field()}}
					<div class="row">
						<div class="col-md-6">
							<h4>ACTIVITY INFORMATION</h4>

							<div class="form-group{{ ($errors->has('title')) ? $errors->first('title') : '' }}">
							<label>Title of Activity <font color="red">*</font></label>
								<input type="text" name="title" class="form-control" placeholder="e.g. Activity 101" pattern="^[A-Za-z-'-.-\d _]*[A-Za-z-'-.-\d][A-Za-z-'-.-\d _]*$" value="{{ old('title')}}" required>
								{!! $errors->first('title', '<p class="help-block">:message</p>') !!}
							</div>

							<div class="form-group{{ ($errors->has('nature')) ? $errors->first('nature') : '' }}">
								<div class="form-group">
									<label>Nature of Activity <font color="red">*</font></label>
									<div class="radio">
										<label>
											<input type="radio" name="nature" id="nature" value="Academic" checked> Academic
										</label>
									</div>
									<div class="radio">
										<label>
											<input type="radio" name="nature" id="nature" value="Non-Academic"> Non-Academic
										</label>
									</div>
								</div>
								{!! $errors->first('nature', '<p class="help-block">:message</p>') !!}
							</div>
							
							<div class="form-group{{ ($errors->has('date')) ? $errors->first('date') : '' }} {{ ($errors->has('endDate')) ? $errors->first('endDate') : '' }}">
								<label>Date of Activity <font color="red">*</font></label>
								<br>
								<div class="col-md-6">
									From:
									<input type="text"  value="{{ old('date')}}" class="form-control datepicker" name="date" placeholder="Enter date" min="<?php echo date('Y'.'-'.'m'.'-'.'d'); ?>" required>
									{!! $errors->first('date', '<p class="help-block">:message</p>') !!}
								</div>
								<div class="col-md-6">
									To:
									<input type="text"  value="{{ old('endDate')}}" class="form-control datepicker" name="endDate"placeholder="Enter date" required>
									{!! $errors->first('endDate', '<p class="help-block">:message</p>') !!}
								</div>
							</div>

							
							<div class="form-group{{ ($errors->has('venue')) ? $errors->first('venue') : '' }}">
								<label>Venue <font color="red">*</font></label>
								<input type="text" name="venue" value="{{ old('venue')}}" class="form-control" pattern="^[A-Za-z-'-.-\d _]*[A-Za-z-'-.-\d][A-Za-z-'-.-\d _]*$" placeholder="Enter Venue" required>
								{!! $errors->first('venue', '<p class="help-block">:message</p>') !!}
							</div>
								
							<div class="form-group{{ ($errors->has('participants')) ? $errors->first('participants') : '' }}">
								<label>Participants<font color="red">*</font></label>
								<input type="Text" value="{{ old('participants')}}" name="participants" class="form-control" placeholder="Expected participants" required>
								{!! $errors->first('participants', '<p class="help-block">:message</p>') !!}
							</div>
								
							<div class="form-group{{ ($errors->has('expectedAttendees')) ? $errors->first('expectedAttendees') : '' }}">
								<label>Expected No. of Attendees <font color="red">*</font></label>
								<input type="number" value="{{ old('expectedAttendees')}}" name="expectedAttendees" class="form-control" placeholder="Number of Attendees" required>
								{!! $errors->first('expectedAttendees', '<p class="help-block">:message</p>') !!}
							</div>
							
							<div class="form-group">
								<table class="table"> 
									<div id="container2"> </div>
								</table>
							</div>
							<!--<div class="form-group{{ ($errors->has('personInCharge1')) ? $errors->first('personInCharge1') : '' }}">
								<label>Person in Charge:</label>
								<input type="text" name="personInCharge1" class="form-control" placeholder="Enter Name" >
								{!! $errors->first('personInCharge1', '<p class="help-block">:message</p>') !!}  
							</div>-->
						</div>
						<div class="col-md-6">
							<h4>BUDGETARY REQUIREMENTS </h4>	 
							
							<div class="col-md-13 form-group{{ ($errors->has('budgetDescription')) ? $errors->first('budgetDescription') : '' }}">
								<table class="table" id="dynamic_field">  
									<tr>
										<td>Description <font color="red">*</font><input type='text' pattern="^[A-Za-z _]*[A-Za-z][A-Za-z _]*$" name='budgetDescription[1]' class='budgetDescription form-control' placeholder='Enter Description' required></td>
										<td>Cost<font color="red">*</font><input type="number" name="budgetCost[1]" pattern='\d*' onkeyup="calcCost()" class=" form-control" placeholder="Enter Cost" required></td>
										<td>Quantity<font color="red">*</font><input type="number" name="budgetQuantity[1]" pattern='\d*' onkeyup="calcCost()" class="budgetQuantity form-control" placeholder="Enter Qty." required ></td>
										<td>Value: <br><span onkeyup="calcCost()" class="sum"></span> </td>		
										<!--<td>Sum : <i class="sum"></i></td>-->	
										<input type="hidden" name="b_id" value="1">															 
										<td style="padding-top: 30px;"><button type="button" onkeyup="calcCost()" id="add" class="btn btn-success btn-xs">Add</button></td>  
									</tr>
									<tbody>
										<tr>
											<td colspan="3" align="right">Total: &#8369;</td>
											<td><input  type="text" class="form-control" name="buggetTotal" onkeyup="calcCost()" id="total_sum" readonly></td>
										</tr>
									</tbody> 
								</table>
							</div>
							
							<div class="form-group{{ ($errors->has('sourceOfFund')) ? $errors->first('sourceOfFund') : '' }}">
							</div>

							<div id="div2"></div>

							
							
						</div>
					
					</div>


					<hr>	
 
					

					<input type="hidden" name="approval" value="2">
					<input type="hidden" name="approval2" value="0">
					<input type="hidden" name="approval3" value="2">
					<input type="hidden" name="current_date" value="<?php echo date('Y'.'-'.'m'.'-'.'d'); ?>">

					<input type="hidden" name="user_id" value="{{$auth->id}}">
					<input type="hidden" name="year" value="{{$date->year}}">

						

					<div class="form-group" style="margin-left: 10px;">
						<input type="submit" class="btn btn-primary" value="Submit"> <a onclick="history.back()" id="btn-add" class="btn btn-info" >Cancel</a>
					</div>
				</form>
			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.col-lg-12 -->
</div>
<!--
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0-rc1/jquery.min.js"></script> 
<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>-->
<script type="text/javascript" src="/js/plugins/daterangepicker/jquery.js"></script>
@include('activities.js')
@endsection