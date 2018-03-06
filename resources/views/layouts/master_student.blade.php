<!-- STUDENT START -->
@if($auth->role_id == 4)
    <?php
    $count_approve = $count_approve1 + $count_disapprove1;
    $count_ad_liq = $count_a_liquidation + $count_d_liquidation;
    $count_reviews = $count_sas_liquidation + $count_ad_liq;
    $count_osca = $count_osca_liquidation + $count_reviews;
    $gettotal = $count_osca + $count_approve;
    $cr_cas = $count_req + $gettotal;
    $cr_ca = $cr_cas + $c_cash_requests_released;
    ?>

    <li class="xn-icon-button pull-right">
        <a href="#"><span class="glyphicon glyphicon-globe"></span></a>

        @if($cr_ca >= 1)
            <div class="informer informer-warning">{{$cr_ca}}</div>
        @endif

        <div class="panel panel-primary animated zoomIn xn-drop-left xn-panel-dragging">
            <div class="panel-heading">
                <h3 class="panel-title"><span class="fa fa-tasks"></span> Notifications</h3>                                
            </div>
    
            <div class="panel-body list-group list-group-contacts scroll" style="height: 400px;"> 
                @foreach($liquidationss_app as $liquidationss_app)
                    @if($liquidationss_app->approval == 1)
                        @if(Auth::user()->id == $liquidationss_app->submitted_by_user_id)
                            <a class="list-group-item @if($liquidationss_app->notify_officer == 0) active @endif " href="{{route('liquidations.show', $liquidationss_app->acitivity_id)}}" >
                                @if($liquidationss_app->notify_officer == 0)<div class="list-group-status status-online"> </div>
                                @else <div class="list-group-status status-away"></div>
                                @endif
                                <img src="/uploads/{{$sas->photo}}" class="pull-left" alt="profile picture"/><p>
                                <b> {{$sas->first_name}} {{$sas->middle_name}} {{$sas->last_name}} </b>   Approved your liquidation form.</p>
                                <small class="text-muted"><i class="fa fa-clock-o"></i> <?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($liquidationss_app->updated_at))->diffForHumans() ?></small> 
                            </a>
                        @else
                            <a class="list-group-item" href="{{route('liquidations.show', $liquidationss_app->acitivity_id)}}">
                                @if($liquidationss_app->notify_officer == 0)<div class="list-group-status status-online"> </div>
                                @else <div class="list-group-status status-away"></div>
                                @endif
                                <img src="/uploads/{{$sas->photo}}" class="pull-left" alt="profile picture"/><p>
                                <b> {{$sas->first_name}} {{$sas->middle_name}} {{$sas->last_name}} </b>  Approved the liquidation form of your organization.</p>
                                <small class="text-muted"><i class="fa fa-clock-o"></i> <?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($liquidationss_app->updated_at))->diffForHumans() ?></small> 
                            </a>
                        @endif
                    @endif

                    @if($liquidationss_app->approval == 0)
                        @if(Auth::user()->id == $liquidationss_app->submitted_by_user_id)
                            <a class="list-group-item" href="{{route('liquidations.show', $liquidationss_app->id)}}">
                                    @if($liquidationss_app->notify_officer == 0)<div class="list-group-status status-online"> 
                                    @else <div class="list-group-status status-away">
                                    @endif</div>
                                    <img src="/uploads/{{$sas->photo}}" class="pull-left" alt="profile picture"/><p>
                                    <b> {{$sas->first_name}} {{$sas->middle_name}} {{$sas->last_name}} </b>   Disapproved your liquidation form.</p>
                                    <small class="text-muted"><i class="fa fa-clock-o"></i> <?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($liquidationss_app->updated_at))->diffForHumans() ?></small> 
                            </a>
                        @else
                            <a class="list-group-item " href="{{route('liquidations.show', $liquidationss_app->id)}}">
                                    @if($liquidationss_app->notify_officer == 0)<div class="list-group-status status-online"> @else <div class="list-group-status status-away">
                                    @endif</div>
                                    <img src="/uploads/{{$sas->photo}}" class="pull-left" alt="profile picture"/><p>
                                    <b> {{$sas->first_name}} {{$sas->middle_name}} {{$sas->last_name}} </b>  Disapproved the liquidation form of your organization.</p>
                                    <small class="text-muted"><i class="fa fa-clock-o"></i> <?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($liquidationss_app->updated_at))->diffForHumans() ?></small> 
                            </a>
                        @endif
                    @endif

                @endforeach

                @foreach($l_liquidation as $l_liquidation)
            

                    @if($l_liquidation->reviewed_by_sas == 1)
                        @if(Auth::user()->id == $l_liquidation->submitted_by_user_id)
                            <a class="list-group-item @if($l_liquidation->notify_officers == 0) active @endif" href="{{route('liquidations.show', $l_liquidation->acitivity_id)}}">
                                    @if($l_liquidation->notify_officers == 0)<div class="list-group-status status-online"> @else <div class="list-group-status status-away">
                                    @endif</div>
                                    <img src="/uploads/{{$sas->photo}}" class="pull-left" alt="profile picture"/><p>
                                    <b> {{$sas->first_name}} {{$sas->middle_name}} {{$sas->last_name}} </b>   Reviewed your liquidation form</p>
                                    <small class="text-muted"><i class="fa fa-clock-o"></i> <?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($l_liquidation->updated_at))->diffForHumans() ?></small> 
                            </a>
                        @else
                            <a class="list-group-item @if($l_liquidation->notify_officers == 0) active @endif" href="{{route('liquidations.show', $l_liquidation->acitivity_id)}}">
                                    @if($l_liquidation->notify_officers == 0)<div class="list-group-status status-online"> @else <div class="list-group-status status-away">
                                    @endif</div>
                                    <img src="/uploads/{{$sas->photo}}" class="pull-left" alt="profile picture"/><p>
                                    <b> {{$sas->first_name}} {{$sas->middle_name}} {{$sas->last_name}} </b>  Reviewed the liquidation form of your organization.</p>
                                    <small class="text-muted"><i class="fa fa-clock-o"></i> <?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($l_liquidation->updated_at))->diffForHumans() ?></small> 
                            </a>
                        @endif
                    @endif

                    @if($l_liquidation->reviewed_by_osca == 1)
                        @if(Auth::user()->id == $l_liquidation->submitted_by_user_id)
                            <a class="list-group-item" href="{{route('liquidations.show', $l_liquidation->id)}}">
                                    @if($l_liquidation->notify_officers == 0)<div class="list-group-status status-online"> @else <div class="list-group-status status-away">
                                    @endif</div>
                                    <img src="/uploads/{{$osca->photo}}" class="pull-left" alt="profile picture"/><p>
                                    <b> {{$osca->first_name}} {{$osca->middle_name}} {{$osca->last_name}} </b>   Reviewed your liquidation form.</p>
                                    <small class="text-muted"><i class="fa fa-clock-o"></i> <?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($l_liquidation->updated_at))->diffForHumans() ?></small> 
                            </a>
                        @else
                            <a class="list-group-item" href="{{route('liquidations.show', $l_liquidation->id)}}">
                                    @if($l_liquidation->notify_officers == 0)<div class="list-group-status status-online"> @else <div class="list-group-status status-away">
                                    @endif</div>
                                    <img src="/uploads/{{$osca->photo}}" class="pull-left" alt="profile picture"/><p>
                                    <b> {{$osca->first_name}} {{$osca->middle_name}} {{$osca->last_name}} </b>  Reviewed the liquidation form of your organization.</p>
                                    <small class="text-muted"><i class="fa fa-clock-o"></i> <?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($l_liquidation->updated_at))->diffForHumans() ?></small> 
                            </a>
                        @endif
                    @endif
                @endforeach

                @foreach($c_cash_requests as $cash_requests)
                    @if($cash_requests->released == 1)
                        <a class="list-group-item @if($cash_requests->notify_officer == 0) active @endif"  href="{{route('activities.view_content', $cash_requests->act_id)}}">
                                @if($cash_requests->notify_officer == 0)<div class="list-group-status status-online"> @else <div class="list-group-status status-away">
                                @endif</div>
                                <img src="/uploads/{{$igp->photo}}" class="pull-left" alt="profile picture"/><p>
                                <b> {{$igp->first_name}} {{$igp->middle_name}} {{$igp->last_name}} </b>   Released your budget request.</p>
                                <small class="text-muted"><i class="fa fa-clock-o"></i> <?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($cash_requests->updated_at))->diffForHumans() ?></small> 
                        </a>
                    @endif
                @endforeach

                @foreach($getact as $act)
                    @if(Auth::user()->id == $act->requestedBy)
                        @if($act->review_id == 1)
                            <a class="list-group-item @if($act->notify2 == 0) active @endif" href="{{route('activities.view_content', $act->id)}}">
                                @if($act->notify2 == 0)<div class="list-group-status status-online"> 
                                @else <div class="list-group-status status-away">
                                @endif</div>
                                <img src="/uploads/{{$osca->photo}}" class="pull-left" alt="profile picture"/><p>
                                <b>{{$osca->first_name}} {{$osca->middle_name}} {{$osca->last_name}} </b>Reviewed your request. </p>
                                <small class="text-muted"><i class="fa fa-clock-o"></i><?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($act->updated_at))->diffForHumans() ?></small> 
                            </a> 
                        @endif

                        @if($act->approval == 1)
                            <a class="list-group-item @if($act->notify2 == 0) active @endif" href="{{route('activities.view_content', $act->id)}}">
                                @if($act->notify2 == 0)<div class="list-group-status status-online"> @else <div class="list-group-status status-away"> 
                                @endif</div>
                                <img src="/uploads/{{$sas->photo}}" class="pull-left" alt="profile picture"/><p><b> {{$sas->first_name}} {{$sas->middle_name}} {{$sas->last_name}} </b>Approved your request.
                                </p>
                                <small class="text-muted"><i class="fa fa-clock-o"></i><?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($act->updated_at))->diffForHumans() ?></small> 
                            </a>
                        @endif

                        @if($act->approval == 0)
                            <a class="list-group-item @if($act->notify2 == 0) active @endif" href="{{route('activities.view_content', $act->id)}}">
                                @if($act->notify2 == 0)<div class="list-group-status status-online"> @else <div class="list-group-status status-away"> @endif</div>
                                <img src="/uploads/{{$sas->photo}}" class="pull-left" alt="profile picture"/><p><b> {{$sas->first_name}} {{$sas->middle_name}} {{$sas->last_name}} </b>Disapproved your request.
                                </p>
                                <small class="text-muted"><i class="fa fa-clock-o"></i><?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($act->updated_at))->diffForHumans() ?></small> 
                            </a>
                        @endif 

                    @else

                        @if($act->review_id == 1)
                                <a class="list-group-item @if($act->notify2 == 0) active @endif" href="{{route('activities.view_content', $act->id)}}">
                                    @if($act->notify2 == 0)<div class="list-group-status status-online"> 
                                    @else <div class="list-group-status status-away">
                                    @endif</div>
                                    <img src="/uploads/{{$osca->photo}}" class="pull-left" alt="profile picture"/><p>
                                    <b>{{$osca->first_name}} {{$osca->middle_name}} {{$osca->last_name}} </b>Reviewed the request of your organization. </p>
                                    <small class="text-muted"><i class="fa fa-clock-o"></i><?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($act->updated_at))->diffForHumans() ?></small> 
                                </a> 
                        @endif

                        @if($act->approval == 1)
                            <a class="list-group-item @if($act->notify2 == 0) active @endif" href="{{route('activities.view_content', $act->id)}}">
                                @if($act->notify2 == 0)<div class="list-group-status status-online"> @else <div class="list-group-status status-away">
                                @endif</div>
                                <img src="/uploads/{{$sas->photo}}" class="pull-left" alt="profile picture"/><p><b>{{$sas->first_name}} {{$sas->middle_name}} {{$sas->last_name}} </b>Approved the request of your organization.
                                </p>
                            <small class="text-muted"><i class="fa fa-clock-o"></i><?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($act->updated_at))->diffForHumans() ?></small> 
                            </a>
                        @endif

                        @if($act->approval == 0)
                            <a class="list-group-item @if($act->notify2 == 0) active @endif" href="{{route('activities.view_content', $act->id)}}">
                                @if($act->notify2 == 0)<div class="list-group-status status-online"> @else <div class="list-group-status status-away">
                                @endif</div>
                                <img src="/uploads/{{$sas->photo}}" class="pull-left" alt="profile picture"/><b><p> {{$sas->first_name}} {{$sas->middle_name}} {{$sas->last_name}} </b>Disapproved the request of your organization.
                                </p>
                                <small class="text-muted"><i class="fa fa-clock-o"></i><?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($act->updated_at))->diffForHumans() ?></small> 
                            </a>
                        @endif 
                    @endif
                @endforeach   
            </div> 
            <?php
                $count_approve5 = $count_approve5 + $count_disapprove5;
                $cr_ca5 = $count_req5 + $count_approve5;
            ?>   
            <div class="panel-footer text-center">
                @if($cr_ca5 >= 1)
                    <form action="{{url('toggle-notifications')}}" method="post">
                    {{ csrf_field() }}
                        <input type="hidden" name="a_id" value="0">
                        <input type="submit" value="Show all notifications" class="btn btn-default">
                    </form>
                @endif
            </div>                      
        </div>                        
    </li>
@endif
<!-- STUDENT END -->