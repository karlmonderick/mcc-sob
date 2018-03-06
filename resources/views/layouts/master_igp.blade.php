<!-- IGP START -->
@if($auth->role_id == 2)
    <li class="xn-icon-button pull-right">
        <?php $tot = $new_cash_req_count + $get_org; ?>
        <a href="#"><span class="glyphicon glyphicon-globe"></span></a>
        
        @if($tot >= 1 )
            <div class="informer informer-warning">{{$tot}}</div>
        @endif
        
        <div class="panel panel-primary animated zoomIn xn-drop-left xn-panel-dragging">
            <div class="panel-heading">
                <h3 class="panel-title"><span class="fa fa-tasks"></span> Notifications</h3>
            </div>
            
            <div class="panel-body list-group list-group-contacts scroll" style="height: 400px;">  

            @foreach($cashsh as $cash)
                <a class="list-group-item @if($cash->notify_igp == 0) active @endif" >
                
                    @if($cash->notify_igp == 0 || $cash->released == 0)
                        <div class="list-group-status status-online"> @else <div class="list-group-status status-away">
                    @endif</div>

                    <img src="/assets/images/MccLogo.png" class="pull-left" alt="profile picture"/><p>you have new budget request from <b>{{ $cash->name }}</b>.</p>
                    <small class="text-muted"><i class="fa fa-clock-o"></i><?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($cash->created_at))->diffForHumans() ?></small> 
                </a>
            @endforeach

            @foreach($activiti as $acts)
                @if($acts->approval == 1)
                    <a class="list-group-item @if($acts->notify3 == 0) active @endif" href="{{route('activities.view_content', $acts->id)}}">
                        @if($acts->notify3 == 0)<div class="list-group-status status-online"> @else <div class="list-group-status status-away">
                        @endif</div>
                    <img src="/uploads/{{$sas->photo}}" class="pull-left" alt="profile picture"/><p><b>{{$sas->first_name}} {{$sas->middle_name}} {{$sas->last_name}} </b>Approved a budget request from <b>{{ $acts->name }}</b>.
                        </p>
                        <small class="text-muted"><i class="fa fa-clock-o"></i><?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($acts->created_at))->diffForHumans() ?></small> 
                    </a>
                @endif

                
                @if($acts->approval == 0)
                    <a class="list-group-item @if($acts->notify3 == 0) active @endif" href="{{route('activities.view_content', $acts->id)}}">
                        @if($acts->notify3 == 0)<div class="list-group-status status-online"> @else <div class="list-group-status status-away">
                        @endif</div>
                        <img src="/uploads/{{$sas->photo}}" class="pull-left" alt="profile picture"/><p><b> {{$sas->first_name}} {{$sas->middle_name}} {{$sas->last_name}} </b>disapproved a budget request from <b>{{ $acts->name }}</b>.
                        </p>
                        <small class="text-muted"><i class="fa fa-clock-o"></i><?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($acts->created_at))->diffForHumans() ?></small> 
                    </a>
                @endif
            @endforeach

            @foreach($get_total_org2 as $get_orga2)
                <a class="list-group-item @if($get_orga2->notify == 0) active @endif">

                @if($get_orga2->notify == 0)
                    <div class="list-group-status status-online"></div>
                @else 
                    <div class="list-group-status status-away"></div>
                @endif
                    
                
                <img src="/uploads/{{$osca->photo}}" class="pull-left" alt="profile picture"/><p>  <b>{{$osca->first_name}} {{$osca->last_name}} </b> Accredited  <b> {{$get_orga2->name}}</b>. </p>
                <small class="text-muted"><i class="fa fa-clock-o"></i><?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($get_orga2->updated_at))->diffForHumans() ?></small></a> 
            @endforeach 

            @foreach($get_reviewed_act as $get_reviewed_act)
                <a class="list-group-item @if($get_orga2->notify == 0) active @endif">
                @if($get_orga2->notify == 0)
                    <div class="list-group-status status-online"></div>
                @else 
                    <div class="list-group-status status-away"></div>
                @endif
                <img src="/uploads/{{$osca->photo}}" class="pull-left" alt="profile picture"/><p>  <b>{{$osca->first_name}} {{$osca->middle_name}} {{$osca->last_name}} </b> reviewed a budget request from  <b> {{$get_reviewed_act->name}}</b>. </p>
                <small class="text-muted"><i class="fa fa-clock-o"></i><?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($get_reviewed_act->act_updated_at))->diffForHumans() ?></small></a> 
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
<!-- IGP END -->