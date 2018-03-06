@extends('layouts.master')

@section('content')

<!-- START BREADCRUMB -->
<ul class="breadcrumb push-down-0">
<li><a href="#"> Activities</a></li>
<li><a href="#"> Edit</a></li>
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
				<form action="{{route('activities.update', $activity->id)}}" method="post">
					<input type="hidden" name="_method" value="PATCH">
								{{ csrf_field()}}
					<div class="row">
						<div class="col-md-6">
							<h4>ACTIVITY INFORMATION</h4>

							<div class="form-group{{ ($errors->has('title')) ? $errors->first('title') : '' }}">
							<label>Title of Activity</label>
								<input type="text" name="title" class="form-control"  value="{{ $activity->title }}" pattern="^[A-Za-z-'-.-\d _]*[A-Za-z-'-.-\d][A-Za-z-'-.-\d _]*$">
								{!! $errors->first('title', '<p class="help-block">:message</p>') !!}
							</div>

							<div class="form-group{{ ($errors->has('nature')) ? $errors->first('nature') : '' }}">
								<div class="form-group">
									<label>Nature of Activity</label>
									<div class="radio">
										<label>
											<input type="radio" name="nature"  id="nature" value="Academic" @if($activity->nature == 'Academic') checked @endif> Academic
										</label>
									</div>
									<div class="radio">
										<label>
											<input type="radio" name="nature" id="nature" value="Non-Academic" @if($activity->nature == 'Non-Academic') checked @endif> Non-Academic
										</label>
									</div>
								</div>
								{!! $errors->first('nature', '<p class="help-block">:message</p>') !!}
							</div>
							
							<div class="form-group{{ ($errors->has('date')) ? $errors->first('date') : '' }} {{ ($errors->has('endDate')) ? $errors->first('endDate') : '' }}">
								<label>Date of Activity</label>
								<br>
								<div class="col-md-6">
									From:
									<input  type="text"  class="form-control datepicker" name="date" value="{{$activity->date}}" >
									{!! $errors->first('date', '<p class="help-block">:message</p>') !!}
								</div>
								<div class="col-md-6">
									To:
									<input type="text"  class="form-control datepicker" name="endDate" value="{{$activity->endDate}}" >
									{!! $errors->first('endDate', '<p class="help-block">:message</p>') !!}
								</div>
							</div>

							
							<div class="form-group{{ ($errors->has('venue')) ? $errors->first('venue') : '' }}">
								<label>Venue</label>
								<input type="text" name="venue" class="form-control"  value="{{$activity->venue}}" >
								{!! $errors->first('venue', '<p class="help-block">:message</p>') !!}
							</div>
								
							<div class="form-group{{ ($errors->has('participants')) ? $errors->first('participants') : '' }}">
								<label>Participants</label>
								<input type="Text" name="participants"  class="form-control" value="{{$activity->participants}}" >
								{!! $errors->first('participants', '<p class="help-block">:message</p>') !!}
							</div>
								
							<div class="form-group{{ ($errors->has('expectedAttendees')) ? $errors->first('expectedAttendees') : '' }}">
								<label>Expected no. of Attendees</label>
								<input type="number" name="expectedAttendees"  class="form-control" value="{{$activity->expectedAttendees}}" >
								{!! $errors->first('expectedAttendees', '<p class="help-block">:message</p>') !!}
							</div>

							<div class="form-group{{ ($errors->has('personInCharge')) ? $errors->first('personInCharge') : '' }}">
								<div class="content-frame">
									<div class="content-frame-top"> 
									<b>Person/s Incharge:</b>  <br>         
		                                <?php
									 $persons = json_decode($activity->personInCharge,true);
											//print "pre ";
											//print_r("Name: ".$persons->Description); 
											//print_r($persons->name);
											//print "/pre ";

										
										foreach ($persons as $person)
										{
											
						                    echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$person;
						                    echo '<br>';
											
										}
										?>
										<font color="red"><i><b>Note:</b> <span>Please retype person incharge below if you want to edit.</span></i></font>
                    				 </div>
               					</div>
								<table class="table">  
									<div>
									<tr>

										<td>Person In charge:<input type="text" name="personInCharge[1]" class="form-control" placeholder="Enter personInCharge" ></td>
										<td style="padding-top: 30px;"><button type="button" name="add2" id="add2" class="add_form_field1 btn btn-success btn-xs">Add</button></td> 
									</tr>
									</div>
								</table>
							</div>
							<div class="form-group">
								<table class="table"> 
									<div id="container2"> </div>
								</table>
							</div>
							
						</div>
						<div class="col-md-6">
							<h4>BUDGETARY REQUIREMENTS</h4>	 
							
							<div class="col-md-13 form-group{{ ($errors->has('budgetDescription')) ? $errors->first('budgetDescription') : '' }}">
								<div class="content-frame">
									<div class="content-frame-top">              
		                                 <?php

										$xb = 1;
										$budgetDescription = json_decode($activity->budgetDescription,true);

										echo '<table style="margin-left:110px;" width="60%">';
										echo '<thead>';
											echo '<tr>';

												echo '<th>';
												echo 'No.';
												echo '</th>';

												echo '<th>';
												echo 'Description';
												echo '</th>';

												echo '<th>';
												echo 'Price';
												echo '</th>';

												echo '<th>';
												echo 'Quantity';
												echo '</th>';

											echo '</tr>';
										echo '</thead>';
										echo '<tbody>';
	                                        echo '<tr>';
	                                        	echo '<td>';
		                                        foreach($budgetDescription['Description'] as $i => $v)
		                                        {
		                                            
		                                            echo $xb++.'.'.'<br/>';
		                                            
		                                        }
		                                        echo '</td>';

		                                        echo '<td>';
		                                        foreach($budgetDescription['Description'] as $i => $v)
		                                        {
		                                            
		                                            echo $v.'<br/>';
		                                            
		                                        }
		                                        echo '</td>';
		                                        echo '<td>';
		                                        foreach($budgetDescription['Cost'] as $c => $a)
		                                        {
		                                            
		                                            echo '₱' .number_format($a).'<br/>';
		                                            
		                                        }
		                                        echo '</td>';
		                                        echo '<td>';
		                                        foreach($budgetDescription['Quantity'] as $q => $b)
		                                        {
		                                            
		                                            echo $b.'<br/>';
		                                            
		                                        }
		                                        echo '</td>';
	                                        echo '</tr>';
	                                    echo '</tbody>';
                                        echo '</table>';
										//$aaa= $budgetDescription->Description;
										//print_r("Price: ".$budgetDescription->Description->Cost);
										//print_r("Quantity: ".$budgetDescription->Description->Quantity);

									?>
									<font color="red"><i><b>Note: </b><span>Please retype Budget Description if you want to edit.</span></i></font>
                    				 </div>
               					</div>
								<table class="table" id="dynamic_field">  
									<tr>
										<td>Description<input type='text'  name='budgetDescription[1]' class='budgetDescription form-control' placeholder='Enter Description' ></td>
										<td>Cost<input type="number" name="budgetCost[1]" onkeyup="calcCost()" class=" form-control" placeholder="Enter Cost" ></td>
										<td>Quantity<input type="number" name="budgetQuantity[1]"  onkeyup="calcCost()" class="budgetQuantity form-control" placeholder="Enter Qty."  ></td>
										<td>Value:<br><span onkeyup="calcCost()" class="sum"></span> </td>		
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
						</div>
					
					</div>
				<!--
					<hr>
					<h4>REQUISITIONER / SPONSOR / ORGANIZER</h4>	
					<div class="row">	
						<div class="col-md-6">
							<div class="form-group{{ ($errors->has('requestedBy')) ? $errors->first('requestedBy') : '' }}">
								Requested By:
								<input type="text" name="requestedBy" class="form-control" placeholder="Enter requestedBy" >
								
							</div>
						</div>	
						<div class="col-md-6">		
							<div class="form-group{{ ($errors->has('noted')) ? $errors->first('noted') : '' }}">
								Noted By:
								<input type="text" name="noted" class="form-control" placeholder="Enter noted" >
								
							</div>
						</div>										
					</div>
					-->

					<hr>	


						<input type="hidden" name="approval" value="2">

						<input type="hidden" name="user_id" value="{{$auth->id}}">
						<input type="hidden" name="year" value="{{$date->year}}">

						

					<div class="form-group">
						<input type="submit" class="btn btn-primary" value="Submit"> 
						<a onclick="history.back()" id="btn-add" class="btn btn-info" >Cancel</a>
					</div>
				</form>
			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.col-lg-12 -->
</div>
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0-rc1/jquery.min.js"></script> 
<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>-->
<script type="text/javascript" src="/js/plugins/daterangepicker/jquery.js"></script>

@include('activities.js')
@endsection