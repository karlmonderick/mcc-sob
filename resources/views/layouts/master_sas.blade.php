<!-- SAS START -->
@if($auth->role_id == 3)
    <?php 
        $count_notificationss = $count_req3 + $count_liquidation_1;
        $count_notifications = $count_organizationssss + $count_notificationss;
    ?>
    <li class="xn-icon-button pull-right">
        <!-- <a href="#"><span class="glyphicon glyphicon-globe"></span></a> -->
        @if($count_notifications >= 1)
            <!-- <div class="informer informer-warning">{{$count_notifications}}</div> -->
        @endif

        <div class="panel panel-primary animated zoomIn xn-drop-left xn-panel-dragging">
            <div class="panel-heading">
                <h3 class="panel-title"><span class="fa fa-tasks"></span> Notifications</h3>                                
            </div>
    
            <div class="panel-body list-group list-group-contacts scroll" style="height: 400px;"> 
        
                
                    
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
<!-- SAS END -->