@foreach($liquidation_list as $liquidation_lists)
                    @if(count($liquidation_lists->id) >= 1)
                        <a class="list-group-item @if($liquidation_lists->notify_sas == 0 || $liquidation_lists->approval == 2 || $liquidation_lists->reviewed_sas == 0) active @endif" href="{{route('liquidations.show', $liquidation_lists->id)}}">
                            @if($liquidation_lists->notify_sas == 0 || $liquidation_lists->approval == 2 || $liquidation_lists->reviewed_sas == 0)
                                <div class="list-group-status status-online">  </div>
                            @else 
                                <div class="list-group-status status-away"> </div>
                            @endif
                        
                            <img src="/assets/images/MccLogo.png" class="pull-left" alt="profile picture"/><p>New liquidation form submitted from <b>{{$liquidation_lists->name}}</b> </p>
                            <small class="text-muted"><i class="fa fa-clock-o"></i><?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($liquidation_lists->created_at))->diffForHumans() ?></small> 
                        </a> 
                    @endif  
                @endforeach

                @foreach($activiti as $acts)
                    @if(count($acts->id) >= 1)
                        <a class="list-group-item @if($acts->notify3 == 0) active @endif" href="{{route('activities.view_content', $acts->id)}}">
                            @if($acts->notify3 == 0)
                                <div class="list-group-status status-online"> </div>
                            @else 
                                <div class="list-group-status status-away"> </div>
                            @endif
                            <img src="/assets/images/MccLogo.png" class="pull-left" alt="profile picture"/><p>You have new budget request from <b>{{ $acts->name }}</b> </p>
                            <small class="text-muted"><i class="fa fa-clock-o"></i><?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($acts->created_at))->diffForHumans() ?></small> 
                        </a> 
                    @endif
                @endforeach 

                @foreach($get_total_org2 as $get_orga3)
                        <a class="list-group-item @if($get_orga3->notify_sas == 0) active @endif">
                            @if($get_orga3->notify_sas == 0)
                                <div class="list-group-status status-online"></div>
                            @else 
                                <div class="list-group-status status-away"></div>
                            @endif
                            <img src="/uploads/{{$osca->photo}}" class="pull-left" alt="profile picture"/>
                            <p>  
                                <b>{{$osca->first_name}} {{$osca->last_name}} </b> Accredited  <b> {{$get_orga3->name}}</b>. 
                            </p>
                            <small class="text-muted">
                                <i class="fa fa-clock-o"></i><?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($get_orga3->updated_at))->diffForHumans() ?>
                            </small>
                        </a>  
                @endforeach