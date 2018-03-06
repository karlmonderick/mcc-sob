@extends('layouts.master')

@section('content')
<!-- START BREADCRUMB -->
<ul class="breadcrumb push-down-0">
	<li><a href="#"> Liquidation</a></li>
	<li><a href="#"> View</a></li>
</ul>
<!-- END BREADCRUMB -->      


<!-- PAGE CONTENT WRAPPER -->
<div class="paged-content-wrap">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<!-- /.panel-heading -->
				<div class="panel-body">
					<h3 class="card-title">Liquidation</h3>			
				
					<h6 class="card-subtitle mb-2 text-muted">View</h6>
					<br>
					@foreach($liquidation as $liquidation) 
					<div class="form-group">
                    <div class="timeline-item timeline-item-right">      
                                    <div class="timeline-item-content">                                       
                                        <div class="timeline-body">                                                                                        
                                            <img src="/uploads/{{$liquidation->picture}}" width="200" class="img-text" align="left"/> 
                                            <p> 
								
								Official Receipt: <strong>{{ $liquidation->official_reciepts }}</strong>    
								<br> 
								Activity: <strong>{{ $liquidation->title }}</strong>  
								<br> 
								Submitted By: <strong>{{ $liquidation->first_name }} {{ $liquidation->middle_name }} {{ $liquidation->last_name }}</strong>  

							</p>
                                                   
                                           
                                        </div>        
                                    </div>                                    
                                </div>
                            </div>
						
						@if(Auth::user()->role_id == 3)
							<ul class="nav navbar-nav">
							<li>
							<div class="btn-group">
							<form action="{{url('toggle2-approve')}}" method="POST">
											{{ csrf_field() }}
										<input type="hidden" name="id" value="{{$liquidation->id}}">
										@if($liquidation->approval == 2)
										<input type="submit" onclick="return confirm('Are you sure?')" class="btn btn-xs btn-info" value="Approve">&nbsp;&nbsp;
										@endif

							</form>
						
							</li>
							<li>
							<form action="{{url('toggle2-disapprove')}}" method="POST">
											{{ csrf_field() }}
										<input type="hidden" name="id" value="{{$liquidation->id}}">
										@if($liquidation->approval == 2)
										<input type="submit" onclick="return confirm('Are you sure?')" class="btn btn-xs btn-warning" value="Disapprove">
										@endif
							</form>
							</div>
							</li>
							</ul>
						@endif
						<br><br>
						@if(Auth::user()->role_id == 1 || Auth::user()->role_id == 4 || Auth::user()->role_id == 3)
						<div class="content-frame">
					 <div class="content-frame-top">                      
                       <h3 class="push-down-20">Reviews</h3>
                                    <ul class="media-list">
                                    	@foreach($notify as $notif)
                                        <li class="media">
                                            <a class="pull-left" href="#">
                                                <img class="media-object img-text" src="/assets/images/users/no-image.jpg" alt="Dmitry Ivaniuk" width="64">
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
                     @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 3)
                    <form action="{{url('toggle2-notify')}}" method="POST">
							{{ csrf_field() }}
                            <div class="panel-body panel-body-search">
                                <div class="input-group">
                                   	<textarea class="form-control" required  placeholder="..." name="comment"></textarea>
                                    <input type="hidden" name="id" value="{{$liquidation->id}}">
                                    <div class="input-group-btn">
                                        <input type="submit" class="btn btn-info" style="margin-left: 3px; margin-bottom: 9px;" value="Send">
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