@extends('layouts.master')

@section('content')
<!-- START BREADCRUMB -->
<ul class="breadcrumb push-down-0">
	<li><a href="javascript:history.back(-1)"> Activities</a></li>
	<li><a href="#"> {{$act->title}}</a></li>
</ul>
<!-- END BREADCRUMB -->      


<!-- PAGE CONTENT WRAPPER -->
<div class="paged-content-wrap">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<!-- /.panel-heading -->
				<div class="panel-body">
                @if(Auth::user()->role_id == 4 && $act->comment == NULL)
					<h3 class="card-title">Activities</h3>			
				
					<h6 class="card-subtitle mb-2 text-muted">View</h6>
					
					@elseif(Auth::user()->role_id == 1 || Auth::user()->role_id == 2 || Auth::user()->role_id == 3 || Auth::user()->role_id == 5)
					<h3 class="card-title">Activities</h3>			
				
					<h6 class="card-subtitle mb-2 text-muted">View</h6>
					@endif
					@foreach($activity as $activity) 
					<div class="articles-container">
						<div class="divider" style="margin-top: 1rem;"></div>
							<h4>ACTIVITY INFORMATION</h4>
							<p> 
								
								Title of Activity: <strong>{{ $activity->title }}</strong>    
								<br> 
								Nature of Activity: <strong>{{ $activity->nature }}</strong>  
								<br> 
								Date: <strong>{{ $activity->date }}</strong>  
								<br> 
								Venue: <strong>{{ $activity->venue }}</strong>  
								<br> 
								Participants: <strong>{{ $activity->participants }}</strong>  
								<br> 
								Expected No. of Attendees: <strong>{{ $activity->expectedAttendees }}</strong>  
								<br>
								Organization: <strong>{{ $activity->name}}</strong>    
								
							</p>
							<h4>BUDGET</h4>
							<p>	
								Budget Description: <strong>
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
										
									</strong>  
								<br>
								Total: ₱ <strong>{{ number_format($activity->buggetTotal) }}</strong>  
								<br> 

							</p>
						</div>
						
						@if(Auth::user()->role_id == 4)
							@if($activity->approval == 1)
							<a class="btn btn-lg btn-default" href="{{ route('liquidations.view_content', $activity->id) }}"><em class="fa fa-book"></em>Liquidation</a>
							@endif
						@endif
						@if(Auth::user()->role_id == 3)
							<ul class="nav navbar-nav">
							<li>

						@foreach($ay as $ay)
							<form action="{{url('toggle-approve')}}" method="POST">
											{{ csrf_field() }}
										
										<input type="hidden" name="activityId" value="{{$activity->id}}">
										<input type="hidden" name="ay_id" value="{{$ay->id}}">
										@if($activity->approval == 2)
										<input type="submit" onclick="return confirm('Are you sure?')" class="btn btn-xs btn-info" value="Approve">&nbsp;&nbsp;
										@endif

							</form>
						
							</li>
							<li>
							<form action="{{url('toggle-disapprove')}}" method="POST">
											{{ csrf_field() }}
										<input type="hidden" name="ay_id" value="{{$ay->id}}">
										<input type="hidden" name="activityId2" value="{{$activity->id}}">
										@if($activity->approval == 2)
										<input type="submit" onclick="return confirm('Are you sure?')" class="btn btn-xs btn-warning" value="Disapprove">
										@endif
							</form>
							@endforeach
							</li>
							</ul>
						@endif
						<br><hr>
						@if(Auth::user()->role_id == 1 || Auth::user()->role_id == 4 || Auth::user()->role_id == 3)
						<div class="content-frame">
					 <div class="content-frame-top">                      
                       <h3 class="push-down-20">Reviews</h3>
                                    <ul class="media-list">
                                    	 @foreach($notify as $notif)
                                        <li class="media">
                                            <a class="pull-left" href="#">
                                                <img class="media-object img-text" src="/uploads/{{$notif->photo}}" alt="avatar"  width="64">
                                            </a>
                                            <div class="media-body">
                                                <h4 class="media-heading">{{$notif->first_name}} 
                                                	{{$notif->last_name}}
                                                </h4>
                                                <p>{{ $notif->comment }}</p>
                                                <small class="text-muted"><font color="black"><i class="fa fa-clock-o"></i>  <?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($notif->created_at))->diffForHumans() ?></font></small>
                                            </div>
                                        </li>
                        @endforeach                                          
                                       
                                    </ul>      
                     </div>
                    <?php
                     	$user_id = Auth::user()->role_id;
                    ?>
                    @if(Auth::user()->role_id == 1 OR Auth::user()->role_id == 3)
                    	<form action="{{url('toggle-notify')}}" method="POST">
							{{ csrf_field() }}
                            <div class="panel-body panel-body-search">
                                <div class="input-group">
                                   	<textarea class="form-control" required  placeholder="..." name="comment"></textarea>
                                    <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                                    <input type="hidden" name="activity_id" value="{{$activity->id}}">
                                    <input type="hidden" name="review_id" value="1">
                                    <div class="input-group-btn">
                                        <input type="submit" class="btn btn-info btn-lg" style="margin-left: 3px; margin-bottom: 9px;" value="Send">
                                    </div>
                                </div>
                            </div>
					 	</form>
					 @endif
					</div>
                        </div>
						@endif
					@endforeach
					</div>
					<!-- /.panel-body -->
				</div>
				<!-- /.panel -->
			</div>
			<!-- /.col-lg-12 -->
		</div>
	</div>
</div>
        
        <!-- Modal -->
@endsection