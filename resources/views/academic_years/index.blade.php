<ul class="nav nav-second-level">

        <!-- Add a new year - SAS DIRECTOR ONLY -->
        @if(Auth::user()->role_id == 3)
            <?php 
                $year = date('Y') + 1;
                $count_year = count($years->ay_to);
                $add_year = $years->ay_to + 1;
            ?>
            <li>
                <form action="{{route('academic_year.add_year')}}" method="POST">      
                    <input type="hidden" name="_method" value="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"> 
                    <input type="hidden" name="next_yr" value="{{$next_yr}}">
                    <button type="submit" class="btn btn-success btn-block" data-toggle="tooltip" data-placement="right" title="Add a A.Y. <?php if($count_year != 0){ echo $years->ay_to; echo '-'; echo $add_year; } else {echo date('Y'); echo '-'; echo $year;} ?> " onclick="return confirm('Are you sure you want to add A.Y. <?php if($count_year != 0){ echo $years->ay_to; echo '-'; echo $add_year; } else {echo date('Y'); echo '-'; echo $year;} ?>?')">
                        <small><i class="fa fa-plus"></i></small>
                        <i class="fa fa-calendar-o"></i>
                    </button>
                </form>
            </li>
        @endif

        @if($auth->role_id==1)    
            @foreach($acad_years as $ay)
                <li class="xn-openable">
                    <a href="#">{{ $ay->ay_from }}-{{ $ay->ay_to }}</a>
                    <ul class="nav nav-third-level">
                        <li class="nav-item"><a class="nav-link" href="{{ route('organization_academic_years.show', $ay->id) }}"><em class="fa fa-users"></em> Accredited Organization</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('activities.show', $ay->id) }}"><em class="fa fa-file-text"></em> Activities</a></li>                
                        <li class="nav-item"><a class="nav-link" href="{{ route('budget.show', $ay->id) }}"><em class="fa fa-money"></em> Organization Budget</a></li>
                    </ul>                                
                <!-- /.nav-third-level -->
                </li>
            @endforeach
        @elseif($auth->role_id==2)    
            @foreach($acad_years as $ay)
                <li class="xn-openable">
                    <a href="#">{{ $ay->ay_from }}-{{ $ay->ay_to }}<span class="fa arrow"></span></a>
                    <ul class="nav nav-third-level">
                        <li class="nav-item"><a class="nav-link" href="{{ route('enrolled_ay.show', $ay->id) }}"><em class="fa fa-building"></em> Enrollees</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('funds.show', $ay->id) }}"><em class="fa fa-bank"></em> Funds</a></li>

                        

                        <li class="nav-item"><a class="nav-link" href="{{ route('cash_request.show', $ay->id) }}"><em class="fa fa-money"></em> Cash Request</a></li>

                        <li class="nav-item"><a class="nav-link" href="{{ route('reports.show', $ay->id) }}"><em class="fa fa-book"></em>Reports</a></li>
                        
                    </ul>                                
                <!-- /.nav-third-level -->
                </li>
            @endforeach

        <!-- SAS DIRECTOR -->
        @elseif($auth->role_id==3)    
            @foreach($acad_years as $ay)
                <li class="xn-openable">
                    <a href="#">{{ $ay->ay_from }} - {{ $ay->ay_to }}</a>
                    <ul class="nav nav-third-level">
                        <li class="nav-item">
                            <form action="{{route('academic_years.destroy', $ay->id)}}" class="pull-left" method="POST">      
                                <input type="hidden" name="_method" value="delete">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="deleted_year" value="{{ $ay->ay_from }} - {{ $ay->ay_to }}">
                                <button type="submit" class="btn btn-danger btn-block" data-toggle="tooltip" data-placement="right" title="Delete this year." onclick="return confirm('Are you sure you want to delete?')"><em class="fa fa-trash-o"></em></button>
                            </form>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('organization_academic_years.show', $ay->id) }}"><em class="fa fa-users"></em> Accredited Organization</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('activities.show', $ay->id) }}"><em class="fa fa-file-text"></em> Activities</a></li>                
                        <li class="nav-item"><a class="nav-link" href="{{ route('budget.show', $ay->id) }}"><em class="fa fa-money"></em> Organization Budget</a></li>
                    </ul>                                
                <!-- /.nav-third-level -->
                </li>
            @endforeach
            
        <!-- STUDENT     -->
        @elseif($auth->role_id == 4) 
             @foreach($academic_yr as $ay)
                <li class="xn-openable">
                    <a href="#">{{ $ay->ay_from }}-{{ $ay->ay_to }}<span class="fa arrow"></span></a>
                    <ul class="nav nav-third-level">

                        <li class="nav-item"><a class="nav-link" href="{{ route('activities.show', $ay->id) }}"><em class="fa fa-file-text"></em> Activities</a></li>  

                        <li class="nav-item"><a class="nav-link" href="{{ route('reports.show', $ay->id) }}"><em class="fa fa-book"></em> Reports</a></li>
                    </ul>                                
                <!-- /.nav-third-level -->
                </li>
            @endforeach 

        @endif
</ul>
    
