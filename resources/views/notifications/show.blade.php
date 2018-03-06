@extends('layouts.master')

@section('content')
        
<!-- START BREADCRUMB -->
<ul class="breadcrumb push-down-0">
	<li>Notifcations</li>
	<li>A.Y {{$get_yr->ay_from}} - {{$get_yr->ay_to}}</li>
</ul>
<!-- END BREADCRUMB -->      

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
<div class="page-container">
            
                <!-- START CONTENT FRAME -->
                <div class="content-frame">
                    
                    <!-- START CONTENT FRAME TOP -->
                    <div class="content-frame-top">                        
                        <div class="page-title">                    
                            <h2><span class="fa fa-arrow-circle-o-left"></span>Notifications</h2>
                        </div>                                      
                        <div class="pull-right">
                            <button class="btn btn-default content-frame-left-toggle"><span class="fa fa-bars"></span></button>
                        </div>                        
                    </div>
                    <!-- END CONTENT FRAME TOP -->
                    
                    <!-- START CONTENT FRAME LEFT -->
                    <div class="content-frame-left">
                         <div class="panel panel-primary animated zoomIn xn-drop-left xn-panel-dragging">
                            <div class="panel-body">
                               <ul class="x-navigation">
                               	<li class="xn-openable">
                      			 <a href="#"><i class="fa fa-filter fa-fw"></i> <span class="xn-text">Filter by year</span><span class="fa arrow"></span></a>
                                 <ul class="nav nav-third-level">  
                            	 @foreach($acad_year as $ay)
				                <li class="nav-item">
				                   <a href="{{route('notifications.show', $ay->id)}}">{{ $ay->ay_from }}-{{ $ay->ay_to }}</a>          
				                </li>
				           		@endforeach
				           		</ul>
                        		 </li>
                               </ul>
                            </div>
                        </div>
                    </div>
                    <!-- END CONTENT FRAME LEFT -->
                    
                    <!-- START CONTENT FRAME BODY -->
        @if(Auth::user()->role_id == 4)
                    <div class="content-frame-body">
                         <div class="panel panel-primary animated zoomIn xn-drop-left xn-panel-dragging">
                            <div class="panel-body">
                            	@foreach($liquidation as $liquidation)
                            		@if($liquidation->approval == 1)
	                            		@if(Auth::user()->id == $liquidation->submitted_by_user_id)
	                           				<a class="list-group-item" href="{{route('liquidations.show', $liquidation->id)}}">
				                                    @if($liquidation->notify_officer == 0)<div class="list-group-status status-online"> @else <div class="list-group-status status-away">
				                                    @endif</div>
				                                    <img style="height: 45px; margin-right: 8px; margin-bottom: 4px;" src="/uploads/{{$sas->photo}}" class="pull-left" alt="profile picture"/><p>
				                                    <b> {{$sas->first_name}} {{$sas->middle_name}} {{$sas->last_name}} </b>   Approved your liquidation form.</p>
				                                    <small class="text-muted"><i class="fa fa-clock-o"></i> <?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($liquidation->updated_at))->diffForHumans() ?></small> 
			                                </a>
			                            @else
			                            	<a class="list-group-item" href="{{route('liquidations.show', $liquidation->id)}}">
				                                    @if($liquidation->notify_officer == 0)<div class="list-group-status status-online"> @else <div class="list-group-status status-away">
				                                    @endif</div>
				                                    <img style="height: 45px; margin-right: 8px; margin-bottom: 4px;" src="/uploads/{{$sas->photo}}" class="pull-left" alt="profile picture"/><p>
				                                    <b> {{$sas->first_name}} {{$sas->middle_name}} {{$sas->last_name}} </b>  Approved the liquidation form of your organization.</p>
				                                    <small class="text-muted"><i class="fa fa-clock-o"></i> <?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($liquidation->updated_at))->diffForHumans() ?></small> 
			                                </a>
			                            @endif
			                        @endif

			                        @if($liquidation->approval == 0)
	                            		@if(Auth::user()->id == $liquidation->submitted_by_user_id)
	                           				<a class="list-group-item" href="{{route('liquidations.show', $liquidation->id)}}">
				                                    @if($liquidation->notify_officer == 0)<div class="list-group-status status-online"> @else <div class="list-group-status status-away">
				                                    @endif</div>
				                                    <img style="height: 45px; margin-right: 8px; margin-bottom: 4px;" src="/uploads/{{$sas->photo}}" class="pull-left" alt="profile picture"/><p>
				                                    <b> {{$sas->first_name}} {{$sas->middle_name}} {{$sas->last_name}} </b>   Disapproved your liquidation form.</p>
				                                    <small class="text-muted"><i class="fa fa-clock-o"></i> <?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($liquidation->updated_at))->diffForHumans() ?></small> 
			                                </a>
			                            @else
			                            	<a class="list-group-item " href="{{route('liquidations.show', $liquidation->id)}}">
				                                    @if($liquidation->notify_officer == 0)<div class="list-group-status status-online"> @else <div class="list-group-status status-away">
				                                    @endif</div>
				                                    <img style="height: 45px; margin-right: 8px; margin-bottom: 4px;" src="/uploads/{{$sas->photo}}" class="pull-left" alt="profile picture"/><p>
				                                    <b> {{$sas->first_name}} {{$sas->middle_name}} {{$sas->last_name}} </b>  Disapproved the liquidation form of your organization.</p>
				                                    <small class="text-muted"><i class="fa fa-clock-o"></i> <?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($liquidation->updated_at))->diffForHumans() ?></small> 
			                                </a>
			                            @endif
			                        @endif

			                        @if($liquidation->reviewed_by_sas == 1)
	                            		@if(Auth::user()->id == $liquidation->submitted_by_user_id)
	                           				<a class="list-group-item " href="{{route('liquidations.show', $liquidation->id)}}">
				                                    @if($liquidation->notify_officers == 0)<div class="list-group-status status-online"> @else <div class="list-group-status status-away">
				                                    @endif</div>
				                                    <img style="height: 45px; margin-right: 8px; margin-bottom: 4px;" src="/uploads/{{$sas->photo}}" class="pull-left" alt="profile picture"/><p>
				                                    <b> {{$sas->first_name}} {{$sas->middle_name}} {{$sas->last_name}} </b>   Reviewed your liquidation form.</p>
				                                    <small class="text-muted"><i class="fa fa-clock-o"></i> <?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($liquidation->updated_at))->diffForHumans() ?></small> 
			                                </a>
			                            @else
			                            	<a class="list-group-item" href="{{route('liquidations.show', $liquidation->id)}}">
				                                    @if($liquidation->notify_officers == 0)<div class="list-group-status status-online"> @else <div class="list-group-status status-away">
				                                    @endif</div>
				                                    <img style="height: 45px; margin-right: 8px; margin-bottom: 4px;" src="/uploads/{{$sas->photo}}" class="pull-left" alt="profile picture"/><p>
				                                    <b> {{$sas->first_name}} {{$sas->middle_name}} {{$sas->last_name}} </b>  Reviewed the liquidation form of your organization.</p>
				                                    <small class="text-muted"><i class="fa fa-clock-o"></i> <?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($liquidation->updated_at))->diffForHumans() ?></small> 
			                                </a>
			                            @endif
			                        @endif

			                        @if($liquidation->reviewed_by_osca == 1)
	                            		@if(Auth::user()->id == $liquidation->submitted_by_user_id)
	                           				<a class="list-group-item" href="{{route('liquidations.show', $liquidation->id)}}">
				                                    @if($liquidation->notify_officers == 0)<div class="list-group-status status-online"> @else <div class="list-group-status status-away">
				                                    @endif</div>
				                                    <img style="height: 45px; margin-right: 8px; margin-bottom: 4px;" src="/uploads/{{$osca->photo}}" class="pull-left" alt="profile picture"/><p>
				                                    <b> {{$osca->first_name}} {{$osca->middle_name}} {{$osca->last_name}} </b>   Reviewed your liquidation form.</p>
				                                    <small class="text-muted"><i class="fa fa-clock-o"></i> <?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($liquidation->updated_at))->diffForHumans() ?></small> 
			                                </a>
			                            @else
			                            	<a class="list-group-item" href="{{route('liquidations.show', $liquidation->id)}}">
				                                    @if($liquidation->notify_officers == 0)<div class="list-group-status status-online"> @else <div class="list-group-status status-away">
				                                    @endif</div>
				                                    <img style="height: 45px; margin-right: 8px; margin-bottom: 4px;" src="/uploads/{{$osca->photo}}" class="pull-left" alt="profile picture"/><p>
				                                    <b> {{$osca->first_name}} {{$osca->middle_name}} {{$osca->last_name}} </b>  Reviewed the liquidation form of your organization.</p>
				                                    <small class="text-muted"><i class="fa fa-clock-o"></i> <?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($liquidation->updated_at))->diffForHumans() ?></small> 
			                                </a>
			                            @endif
			                        @endif
                           		@endforeach
                            	@foreach($cash_requests as $cash_requests)
                            	@if($cash_requests->released == 1)
                           				<a class="list-group-item" href="{{route('activities.view_content', $cash_requests->act_id)}}">
			                                    @if($cash_requests->notify_officer == 0)<div class="list-group-status status-online"> @else <div class="list-group-status status-away">
			                                    @endif</div>
			                                    <img style="height: 45px; margin-right: 8px; margin-bottom: 4px;" src="/uploads/{{$igp->photo}}" class="pull-left" alt="profile picture"/><p>
			                                    <b> {{$igp->first_name}} {{$igp->middle_name}} {{$igp->last_name}} </b>   Released your budget request.</p>
			                                    <small class="text-muted"><i class="fa fa-clock-o"></i> <?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($cash_requests->updated_at))->diffForHumans() ?></small> 
		                                </a>
		                        @endif
                           		@endforeach

                            	@foreach($activity as $activity)
	                            	@if($activity->review_id == 1)
	                            		@if(Auth::user()->id == $activity->requestedBy)
		                                   <a class="list-group-item " href="{{route('activities.view_content', $activity->id)}}">
		                                        @if($activity->notify2 == 0)<div class="list-group-status status-online"> @else <div class="list-group-status status-away">
		                                        @endif</div>
		                                        <img style="height: 45px; margin-right: 8px; margin-bottom: 4px;" src="/uploads/{{$osca->photo}}" class="pull-left" alt="profile picture"/><p>
		                                         <b>{{$osca->first_name}} {{$osca->middle_name}} {{$osca->last_name}} </b>Reviewed your request. </p>
		                                        <small class="text-muted"><i class="fa fa-clock-o"></i> <?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($activity->updated_at))->diffForHumans() ?></small> 
		                                    </a> 
		                                    
		                                   
		                                @else
		                                    <a class="list-group-item " href="{{route('activities.view_content', $activity->id)}}">
			                                    @if($activity->notify2 == 0)<div class="list-group-status status-online"> @else <div class="list-group-status status-away">
			                                    @endif</div>
			                                    <img style="height: 45px;margin-right: 8px; margin-bottom: 4px;" src="/uploads/{{$osca->photo}}" class="pull-left" alt="profile picture"/><p>
			                                    <b>{{$osca->first_name}} {{$osca->middle_name}} {{$osca->last_name}} </b>Reviewed the request of your organization. </p>
			                                    <small class="text-muted"><i class="fa fa-clock-o"></i> <?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($activity->updated_at))->diffForHumans() ?></small> 
		                                    </a>
		                           		@endif
		                           	@endif

		                           	@if($activity->approval == 1)
		                           		@if(Auth::user()->id == $activity->requestedBy)
		                                   <a class="list-group-item " href="{{route('activities.view_content', $activity->id)}}">
		                                        @if($activity->notify2 == 0)<div class="list-group-status status-online"> @else <div class="list-group-status status-away">
		                                        @endif</div>
		                                        <img style="height: 45px; margin-right: 8px; margin-bottom: 4px;" src="/uploads/{{$sas->photo}}" class="pull-left" alt="profile picture"/><p>
		                                         <b>{{$sas->first_name}} {{$sas->middle_name}} {{$sas->last_name}} </b>Approved your request. </p>
		                                        <small class="text-muted"><i class="fa fa-clock-o"></i> <?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($activity->updated_at))->diffForHumans() ?></small> 
		                                    </a> 
		                                    
		                                   
		                                @else
		                                    <a class="list-group-item " href="{{route('activities.view_content', $activity->id)}}">
			                                    @if($activity->notify2 == 0)<div class="list-group-status status-online"> @else <div class="list-group-status status-away">
			                                    @endif</div>
			                                    <img style="height: 45px; margin-right: 8px; margin-bottom: 4px;" src="/uploads/{{$sas->photo}}" class="pull-left" alt="profile picture"/><p>
			                                    <b> {{$sas->first_name}} {{$sas->middle_name}} {{$sas->last_name}}</b>Approved the request of your organization. </p>
			                                    <small class="text-muted"><i class="fa fa-clock-o"></i> <?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($activity->updated_at))->diffForHumans() ?></small> 
		                                    </a>
		                           		@endif
		                           	@endif

		                           	@if($activity->approval == 0)
		                           		@if(Auth::user()->id == $activity->requestedBy)
		                                   <a class="list-group-item " href="{{route('activities.view_content', $activity->id)}}">
		                                        @if($activity->notify2 == 0)<div class="list-group-status status-online"> @else <div class="list-group-status status-away">
		                                        @endif</div>
		                                        <img style="height: 45px; margin-right: 8px; margin-bottom: 4px;" src="/uploads/{{$sas->photo}}" class="pull-left" alt="profile picture"/><p>
		                                         <b>{{$sas->first_name}} {{$sas->middle_name}} {{$sas->last_name}} </b>Disapproved your request. </p>
		                                        <small class="text-muted"><i class="fa fa-clock-o"></i> <?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($activity->updated_at))->diffForHumans() ?></small> 
		                                    </a> 
		                                    
		                                   
		                                @else
		                                    <a class="list-group-item " href="{{route('activities.view_content', $activity->id)}}">
			                                    @if($activity->notify2 == 0)<div class="list-group-status status-online"> @else <div class="list-group-status status-away">
			                                    @endif</div>
			                                    <img style="height: 45px; margin-right: 8px; margin-bottom: 4px;" src="/uploads/{{$sas->photo}}" class="pull-left" alt="profile picture"/><p>
			                                    <b>{{$sas->first_name}} {{$sas->middle_name}} {{$sas->last_name}} </b>Disapproved the request of your organization. </p>
			                                    <small class="text-muted"><i class="fa fa-clock-o"></i> <?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($activity->updated_at))->diffForHumans() ?></small> 
		                                    </a>
		                           		@endif
		                           	@endif
                           		@endforeach

                            </div>
                     </div>
                    </div>
        @endif

        @if(Auth::user()->role_id == 3)
                    <div class="content-frame-body">
                         <div class="panel panel-primary animated zoomIn xn-drop-left xn-panel-dragging">
                            <div class="panel-body">
                            	@foreach($organizationsss as $get_orga3)
                                        <a class="list-group-item ">
                                         <div class="list-group-status status-away"></div>
                                        <img style="height: 45px; margin-right: 8px; margin-bottom: 4px;" src="/uploads/{{$osca->photo}}" class="pull-left" alt="profile picture"/><p>  <b>{{$osca->first_name}} {{$osca->last_name}} </b> Accredited  <b> {{$get_orga3->name}}</b>. </p>
                                            <small class="text-muted"><i class="fa fa-clock-o"></i><?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($get_orga3->updated_at))->diffForHumans() ?></small></a> 
                        		@endforeach 
                            	@foreach($liquidation_listss as $liquidation_lists)
                            	@if(count($liquidation_lists->id) >= 1)
                           				<a class="list-group-item" href="{{route('liquidations.show', $liquidation_lists->id)}}">
                           					@if($liquidation_lists->notify_sas == 0 || $liquidation_lists->approval == 2 || $liquidation_lists->reviewed_sas == 0)
		                                    <div class="list-group-status status-online"> @else <div class="list-group-status status-away">
		                                    @endif </div>
			                                <img style="height: 45px; margin-right: 8px; margin-bottom: 4px;" src="/assets/images/MccLogo.png" class="pull-left" alt="profile picture"/><p>New liquidation submitted from <b>{{$liquidation_lists->name}}</b> </p>
			                                <small class="text-muted"><i class="fa fa-clock-o"></i> <?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($liquidation_lists->created_at))->diffForHumans() ?></small>
		                                </a>
		                        @endif
		                    @endforeach

		                    @foreach($activitiess as $acts)
                            @if(count($acts->id) >= 1)
                                <a class="list-group-item" href="{{route('activities.show', $acts->id)}}">
                           			@if($acts->notify3 == 0)
		                                <div class="list-group-status status-online"> @else <div class="list-group-status status-away">
		                            @endif
		                                </div>
		                               <img style="height: 45px; margin-right: 8px; margin-bottom: 4px;" src="/assets/images/MccLogo.png" class="pull-left" alt="profile picture"/><p>You have new budget request from <b>{{ $acts->name }}</b> </p>
		                                <small class="text-muted"><i class="fa fa-clock-o"></i> <?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($acts->created_at))->diffForHumans() ?></small>
		                        </a>
                            @endif
                        @endforeach
                            </div>
                     </div>
                </div>
        @endif


        @if(Auth::user()->role_id == 1)
                    <div class="content-frame-body">
                         <div class="panel panel-primary animated zoomIn xn-drop-left xn-panel-dragging">
                            <div class="panel-body">
                            @foreach($liquidation_listss as $liquidation_lists)
                            	@if(count($liquidation_lists->id) >= 1)
                           				<a class="list-group-item" href="{{route('liquidations.show', $liquidation_lists->id)}}">
                           					@if($liquidation_lists->notify_osca == 0 || $liquidation_lists->reviewed_osca == 0)
		                                    <div class="list-group-status status-online"> @else <div class="list-group-status status-away">
		                                    @endif </div>
			                                <img style="height: 45px; margin-right: 8px; margin-bottom: 4px;" src="/assets/images/MccLogo.png" class="pull-left" alt="profile picture"/><p>New liquidation submitted from <b>{{$liquidation_lists->name}}</b> </p>
			                                <small class="text-muted"><i class="fa fa-clock-o"></i> <?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($liquidation_lists->created_at))->diffForHumans() ?></small>
		                                </a>
		                        @endif
		                    @endforeach

		                    @foreach($activitiess as $acts)
                            @if(count($acts->id) >= 1)
                                <a class="list-group-item" href="{{route('liquidations.show', $acts->id)}}">
                           			@if($acts->notify3 == 0)
		                                <div class="list-group-status status-online"> @else <div class="list-group-status status-away">
		                            @endif
		                                </div>
		                               <img style="height: 45px; margin-right: 8px; margin-bottom: 4px;" src="/assets/images/MccLogo.png" class="pull-left" alt="profile picture"/><p>New budget request from <b>{{ $acts->name }}</b> </p>
		                                <small class="text-muted"><i class="fa fa-clock-o"></i> <?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($acts->created_at))->diffForHumans() ?></small>
		                        </a>
                            @endif
                        @endforeach
                            </div>
                     </div>
                </div>
        @endif

        @if(Auth::user()->role_id == 2)
                    <div class="content-frame-body">
                         <div class="panel panel-primary animated zoomIn xn-drop-left xn-panel-dragging">
                            <div class="panel-body">
                            @foreach($cashhs as $cash)
                                 <a class="list-group-item " >
                                  <div class="list-group-status status-away">
                                    </div>
                                   <img style="height: 45px; margin-right: 8px; margin-bottom: 4px;" src="/assets/images/MccLogo.png" class="pull-left" alt="profile picture"/><p>you have new budget request from <b>{{ $cash->name }}</b>.
                                    </p>
                                    <small class="text-muted"><i class="fa fa-clock-o"></i><?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($cash->created_at))->diffForHumans() ?></small> 
                                </a>
                       		@endforeach

                        @foreach($activitiesss as $acts)
                            @if($acts->approval == 1)
                                 <a class="list-group-item" href="{{route('activities.view_content', $acts->id)}}">
                                    <div class="list-group-status status-away">
                                    </div>
                                   <img style="height: 45px; margin-right: 8px; margin-bottom: 4px;" src="/uploads/{{$sas->photo}}" class="pull-left" alt="profile picture"/><p><b>{{$sas->first_name}} {{$sas->middle_name}} {{$sas->last_name}} </b>Approved a budget request from <b>{{ $acts->name }}</b>.
                                    </p>
                                    <small class="text-muted"><i class="fa fa-clock-o"></i><?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($acts->created_at))->diffForHumans() ?></small> 
                                </a>
                            @endif

                            
                            @if($acts->approval == 0)
                                 <a class="list-group-item" href="{{route('activities.view_content', $acts->id)}}">
                                    <div class="list-group-status status-away">
                                    </div>
                                    <img style="height: 45px; margin-right: 8px; margin-bottom: 4px;" src="/uploads/{{$sas->photo}}" class="pull-left" alt="profile picture"/><p><b> {{$sas->first_name}} {{$sas->middle_name}} {{$sas->last_name}} </b>disapproved a budget request from <b>{{ $acts->name }}</b>.
                                    </p>
                                    <small class="text-muted"><i class="fa fa-clock-o"></i><?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($acts->created_at))->diffForHumans() ?></small> 
                                </a>
                            @endif
                        @endforeach
                        @foreach($organizationsss as $get_orga2)
                                        <a class="list-group-item">
                                        	<div class="list-group-status status-away">
                                        </div>
                                        <img style="height: 45px; margin-right: 8px; margin-bottom: 4px;" src="/uploads/{{$osca->photo}}" class="pull-left" alt="profile picture"/><p>  <b>{{$osca->first_name}} {{$osca->last_name}} </b> Accredited  <b> {{$get_orga2->name}}</b>. </p>
                                            <small class="text-muted"><i class="fa fa-clock-o"></i><?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($get_orga2->updated_at))->diffForHumans() ?></small></a> 
                        @endforeach 

                        @foreach($get_reviewed_acts as $get_reviewed_acts)
                                        <a class="list-group-item">
                                        <div class="list-group-status status-away">
                                        </div>
                                        <img style="height: 45px; margin-right: 8px; margin-bottom: 4px;" src="/uploads/{{$osca->photo}}" class="pull-left" alt="profile picture"/><p>  <b>{{$osca->first_name}} {{$osca->middle_name}} {{$osca->last_name}} </b> reviewed a budget request from  <b> {{$get_reviewed_acts->name}}</b>. </p>
                                            <small class="text-muted"><i class="fa fa-clock-o"></i><?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($get_reviewed_acts->act_updated_at))->diffForHumans() ?></small></a> 
        				@endforeach
                            </div>
                     </div>
                </div>
        @endif
                    <!-- END CONTENT FRAME BODY -->
                </div>
                <!-- END CONTENT FRAME -->
                
</div>
</div>
@endsection