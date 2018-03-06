<!-- OSCA START -->
@if($auth->role_id == 1)
    <?php
    $count_appr = $count_approve2 + $count_disapprove2;
    $cr2 = $count_req2 + $count_appr + $count_liquidations_2;
    ?>
    <li class="xn-icon-button pull-right">
        <a href="#"><span class="glyphicon glyphicon-globe"></span></a>
        @if($cr2 >= 1)
        <div class="informer informer-warning">{{$cr2}}</div>
        @endif
        
        <div class="panel panel-primary animated zoomIn xn-drop-left xn-panel-dragging">
            <div class="panel-heading">
                <h3 class="panel-title"><span class="fa fa-tasks"></span> Notifications</h3>                                
                
            </div>
            <div class="panel-body list-group list-group-contacts scroll" style="height: 400px;"> 
            
        @foreach($activiti as $acts)
            @if($acts->approval == 1)
                <a class="list-group-item @if($acts->notify == 0) active @endif" href="{{route('activities.view_content', $acts->id)}}">
                    @if($acts->notify == 0)<div class="list-group-status status-online"> @else <div class="list-group-status status-away">
                    @endif</div>
                <img src="/uploads/{{$sas->photo}}" class="pull-left" alt="profile picture"/><p><b>{{$sas->first_name}} {{$sas->middle_name}} {{$sas->last_name}} </b>Approved a budget request from <b>{{ $acts->name }}</b>.
                    </p>
                    <small class="text-muted"><i class="fa fa-clock-o"></i><?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($acts->created_at))->diffForHumans() ?></small> 
                </a>
            @endif

            
            @if($acts->approval == 0)
                <a class="list-group-item @if($acts->notify == 0) active @endif" href="{{route('activities.view_content', $acts->id)}}">
                    @if($acts->notify == 0)<div class="list-group-status status-online"> @else <div class="list-group-status status-away">
                    @endif</div>
                    <img src="/uploads/{{$sas->photo}}" class="pull-left" alt="profile picture"/><p><b> {{$sas->first_name}} {{$sas->middle_name}} {{$sas->last_name}} </b>disapproved a budget request from <b>{{ $acts->name }}</b>.
                    </p>
                    <small class="text-muted"><i class="fa fa-clock-o"></i><?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($acts->created_at))->diffForHumans() ?></small> 
                </a>
            @endif

            @if(count($acts->id) >= 1)
                <a class="list-group-item @if($acts->notify == 0) active @endif" href="{{route('activities.view_content', $acts->id)}}">
                    @if($acts->notify == 0)<div class="list-group-status status-online"> </div> @endif @if($acts->notify == 1) <div class="list-group-status status-away"> </div>
                    @endif
                    <img src="/assets/images/MccLogo.png" class="pull-left" alt="profile picture"/><p>You have new budget request from <b>{{ $acts->name }}</b> </p>
                    <small class="text-muted"><i class="fa fa-clock-o"></i><?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($acts->created_at))->diffForHumans() ?></small> 
                </a> 

            @endif
        @endforeach 
        @foreach($liquidation_list_2 as $liquidation_list_2)
            @if(count($liquidation_list_2->id) >= 1)
                <a class="list-group-item @if($liquidation_list_2->notify_osca== 0 || $liquidation_list_2->reviewed_osca == 0) active @endif" href="{{route('liquidations.show', $liquidation_list_2->id)}}">
                    @if($liquidation_list_2->notify_osca == 0 || $liquidation_list_2->reviewed_osca == 0)
                    <div class="list-group-status status-online"> @else <div class="list-group-status status-away">
                    @endif
                    </div>
                    <img src="/assets/images/MccLogo.png" class="pull-left" alt="profile picture"/><p>New liquidation form submitted from <b>{{$liquidation_list_2->name}}</b> </p>
                    <small class="text-muted"><i class="fa fa-clock-o"></i><?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($liquidation_list_2->created_at))->diffForHumans() ?></small> 
                </a> 
            @endif 
            @endforeach
                    
            </div>  
            <div class="panel-footer text-center">
                <form action="{{url('toggle-notifications')}}" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="a_id" value="0">
                    <input type="submit" value="Show all notifications" class="btn btn-default">
                </form>
            </div> 
                                    
        </div>                        
    </li>
@endif
<!-- OSCA END -->