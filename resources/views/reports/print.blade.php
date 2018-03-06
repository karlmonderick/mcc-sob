<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Print</title>
</head>
  <style type="text/css">
            dummydeclaration { padding-left: 4em; } /* Firefox ignores first declaration for some reason */

            tab1 { padding-left: 4em; }
            tab2 { padding-left: 8em; }
            tab3 { padding-left: 12em; }
            tab4 { padding-left: 16em; }
            tab5 { padding-left: 20em; }
            tab6 { padding-left: 24em; }
            tab7 { padding-left: 28em; }
            tab8 { padding-left: 32em; }
            tab9 { padding-left: 36em; }
            tab10 { padding-left: 40em; }
            tab11 { padding-left: 44em; }
            tab12 { padding-left: 48em; }
            tab13 { padding-left: 52em; }
            tab14 { padding-left: 56em; }
            tab15 { padding-left: 60em; }
            tab16 { padding-left: 64em; }

           body {
            margin-left: 25px; 
            }
            img
            {
                width: 100px;
                height: 90px;
            }

        </style>
<body onload="window.print()">
    @if(Auth::user()->role_id == 2)
    <!-- FUnds 1st Sem -->
    @if($ids == 1) 
        <table align="center" style="margin-right: 98px;" width="81%">
            <tr>
                <td align="left" rowspan="2"><img src="/assets/images/MccLogo.png" alt="profile picture"/></td>
                <td colspan="2" align="left" style="margin-right: 30px;">
                <p style="letter-spacing: 0.1px; font-family: georgia; font-size: 24px; line-height: 0px;"><b>MABALACAT CITY COLLEGE</b></p>
                <p style="margin-left: 61px; line-height: 0px">Dolores, Mabalacat City, Pampanga</p>
                
                </td>
            </tr>
        </table>
        <br>  
        <p><b>1st Semester - Funds</b> <small class="text-muted">A.Y {{$acad_yr_id->ay_from}}-{{$acad_yr_id->ay_to}}</small></p>                    
                <table width="100%">
                    <thead>
                        <tr>
                            <th align="left">#</th>
                            <th align="left">Name</th>
                            <th align="left">Amount (₱)</th>
                            <th align="left">Remaining amount (₱)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1; ?>
                        @foreach($fund_1 as $fund_1)
                        </tr>
                            <td>{{ $i++ }}</td>
                            <td>{{$fund_1->name}}</td>
                            <td>{{number_format($fund_1->amount)}}</td>
                            <td>{{number_format($fund_1->remaining)}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <br>
                &nbsp;<b>Total Amount:</b> ₱ {{number_format($fund_sum_1)}}
                <br>
                &nbsp;<b>Total Remaining Amount:</b> ₱ {{number_format($fund_sum_rem_1)}} 
    <!-- End -->   
    <!-- Funds 2nd Sem -->
    @elseif($ids == 2)
        <table align="center" style="margin-right: 98px;" width="81%">
            <tr>
                <td align="left" rowspan="2"><img src="/assets/images/MccLogo.png" alt="profile picture"/></td>
                <td colspan="2" align="left" style="margin-right: 30px;">
                <p style="letter-spacing: 0.1px; font-family: georgia; font-size: 24px; line-height: 0px;"><b>MABALACAT CITY COLLEGE</b></p>
                <p style="margin-left: 61px; line-height: 0px">Dolores, Mabalacat City, Pampanga</p>
                </td>
            </tr>
        </table>
        <br>
        <p><b> 2nd Semester - Funds</b> <br><small class="text-muted">A.Y {{$acad_yr_id->ay_from}}-{{$acad_yr_id->ay_to}}</small></p>
                <table width="100%">
                    <thead>
                        <tr>
                            <th align="left">#</th>
                            <th align="left">Name</th>
                            <th align="left">Amount (₱)</th>
                            <th align="left">Remaining amount (₱)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1; ?>
                        @foreach($fund_2 as $fund_2)
                        </tr>
                            <td>{{ $i++ }}</td>
                            <td>{{$fund_2->name}}</td>
                            <td>{{number_format($fund_2->amount)}}</td>
                            <td>{{number_format($fund_2->remaining)}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <br>
                &nbsp;<b>Total Amount:</b> ₱ {{number_format($fund_sum_2)}}
                <br>
                &nbsp;<b>Total Remaining Amount:</b> ₱ {{number_format($fund_sum_rem_2)}} 
    <!-- End -->
    <!-- Allocated budget 1st sem -->
    @elseif($ids == 3)
      <table align="center" style="margin-right: 98px;" width="81%">
            <tr>
                <td align="left" rowspan="2"><img src="/assets/images/MccLogo.png" alt="profile picture"/></td>
                <td colspan="2" align="left" style="margin-right: 30px;">
                <p style="letter-spacing: 0.1px; font-family: georgia; font-size: 24px; line-height: 0px;"><b>MABALACAT CITY COLLEGE</b></p>
                <p style="margin-left: 61px; line-height: 0px">Dolores, Mabalacat City, Pampanga</p>
               
                </td>
            </tr>
        </table>
        <br>
        <p><b> 1st Semester - Budget Requests</b> <br><small class="text-muted">A.Y {{$acad_yr_id->ay_from}}-{{$acad_yr_id->ay_to}}</small></p>
                <table width="100%">
                    <thead>
                        <tr>
                            <th align="left">#</th>
                            <th align="left">Organization</th>
                            <th align="left">Amount (₱)</th>
                            <th align="left">Remaining amount (₱)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1; ?>
                        @foreach($all_budget_1 as $all_budget_1)
                        </tr>
                            <td>{{ $i++ }}</td>
                            <td>{{$all_budget_1->name}}</td>
                            <td>{{number_format($all_budget_1->budget)}}</td>
                            <td>{{number_format($all_budget_1->remaining)}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <br>
                &nbsp;<b>Total Amount:</b> ₱ {{number_format($all_budget_sum_1)}}
                <br>
                &nbsp;<b>Total Remaining Amount:</b> ₱ {{number_format($all_budget_sum_rem_1)}}
    <!-- Allocated budget 2nd sem -->
    @elseif($ids == 4)
        <table align="center" style="margin-right: 98px;" width="81%">
            <tr>
                <td align="left" rowspan="2"><img src="/assets/images/MccLogo.png" alt="profile picture"/></td>
                <td colspan="2" align="left" style="margin-right: 30px;">
                <p style="letter-spacing: 0.1px; font-family: georgia; font-size: 24px; line-height: 0px;"><b>MABALACAT CITY COLLEGE</b></p>
                <p style="margin-left: 61px; line-height: 0px">Dolores, Mabalacat City, Pampanga</p>
               
                </td>
            </tr>
        </table>
        <br>
        <p><b>  2nd Semester - Budget Requests</b> <br><small class="text-muted">A.Y {{$acad_yr_id->ay_from}}-{{$acad_yr_id->ay_to}}</small></p> 
                <table width="100%">
                    <thead>
                        <tr>
                            <th align="left">#</th>
                            <th align="left">Organization</th>
                            <th align="left">Amount (₱)</th>
                            <th align="left">Remaining amount (₱)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1; ?>
                        @foreach($all_budget_2 as $all_budget_2)
                        </tr>
                            <td>{{ $i++ }}</td>
                            <td>{{$all_budget_2->name}}</td>
                            <td>{{number_format($all_budget_2->budget)}}</td>
                            <td>{{number_format($all_budget_2->remaining)}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <br>
                &nbsp;<b>Total Amount:</b> ₱ {{number_format($all_budget_sum_2)}}
                <br>
                &nbsp;<b>Total Remaining Amount:</b> ₱ {{number_format($all_budget_sum_rem_2)}}

    <!-- activity budget requests 1st sem -->
    @elseif($ids == 5)
        <table align="center" style="margin-right: 98px;" width="81%">
            <tr>
                <td align="left" rowspan="2"><img src="/assets/images/MccLogo.png" alt="profile picture"/></td>
                <td colspan="2" align="left" style="margin-right: 30px;">
                <p style="letter-spacing: 0.1px; font-family: georgia; font-size: 24px; line-height: 0px;"><b>MABALACAT CITY COLLEGE</b></p>
                <p style="margin-left: 61px; line-height: 0px">Dolores, Mabalacat City, Pampanga</p>
                
                </td>
            </tr>
        </table>
        <br>
        <p><b> 1st Semester - Activity Budget Requests</b> <br><small class="text-muted">A.Y {{$acad_yr_id->ay_from}}-{{$acad_yr_id->ay_to}}</small></p>
                <table width="100%">
                    <thead>
                        <tr>
                            <th align="left">#</th>
                            <th align="left">Date</th>
                            <th align="left">Activity</th>
                            <th align="left">Organization</th>
                            <th align="left">Amount (₱)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1; ?>
                        @foreach($activity_1 as $activity_1)
                        </tr>
                            <td>{{ $i++ }}</td>
                            <td>{{$activity_1->date}}</td>
                            <td>{{$activity_1->title}}</td>
                            <td>{{$activity_1->name}}</td>
                            <td>{{number_format($activity_1->buggetTotal)}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <br>
                &nbsp;<b>Total Amount:</b> ₱ {{number_format($activity_sum_1)}}

    <!-- activity budget requests 2nd sem -->
    @elseif($ids == 6)
        <table align="center" style="margin-right: 98px;" width="81%">
            <tr>
                <td align="left" rowspan="2"><img src="/assets/images/MccLogo.png" alt="profile picture"/></td>
                <td colspan="2" align="left" style="margin-right: 30px;">
                <p style="letter-spacing: 0.1px; font-family: georgia; font-size: 24px; line-height: 0px;"><b>MABALACAT CITY COLLEGE</b></p>
                <p style="margin-left: 61px; line-height: 0px">Dolores, Mabalacat City, Pampanga</p>
              
                </td>
            </tr>
        </table>
        <p><b> 2nd Semester - Activity Budget Requests</b> <br><small class="text-muted">A.Y {{$acad_yr_id->ay_from}}-{{$acad_yr_id->ay_to}}</small></p>
                <table width="100%">
                    <thead>
                        <tr>
                            <th align="left">#</th>
                            <th align="left">Date</th>
                            <th align="left">Activity</th>
                            <th align="left">Organization</th>
                            <th align="left">Amount (₱)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1; ?>
                        @foreach($activity_2 as $activity_2)
                        </tr>
                            <td>{{ $i++ }}</td>
                            <td>{{$activity_2->date}}</td>
                            <td>{{$activity_2->title}}</td>
                            <td>{{$activity_2->name}}</td>
                            <td>{{number_format($activity_2->buggetTotal)}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <br>
                &nbsp;<b>Total Amount:</b> ₱ {{number_format($activity_sum_2)}}

    <!-- cashouts 1st sem -->
    @elseif($ids == 7)
        <table align="center" style="margin-right: 98px;" width="81%">
            <tr>
                <td align="left" rowspan="2"><img src="/assets/images/MccLogo.png" alt="profile picture"/></td>
                <td colspan="2" align="left" style="margin-right: 30px;">
                <p style="letter-spacing: 0.1px; font-family: georgia; font-size: 24px; line-height: 0px;"><b>MABALACAT CITY COLLEGE</b></p>
                <p style="margin-left: 61px; line-height: 0px">Dolores, Mabalacat City, Pampanga</p>
                 </td>
            </tr>
        </table>
        <p><b> 1st Semester - Cash-Outs</b> <br><small class="text-muted">A.Y {{$acad_yr_id->ay_from}}-{{$acad_yr_id->ay_to}}</small></p>
                <table width="100%">
                    <thead>
                        <tr>
                            <th align="left">#</th>
                            <th align="left">Released</th>
                            <th align="left">Activity name</th>
                            <th align="left">Organization</th>
                            <th align="left">Amount (₱)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1; ?>
                        @foreach($cash_req_1 as $cash_req_1)
                        </tr>
                            <td>{{ $i++ }}</td>
                             <td>{{$cash_req_1->updated_at}}</td>
                            <td>{{$cash_req_1->title}}</td>
                            <td>{{$cash_req_1->name}}</td>
                            <td>{{number_format($cash_req_1->cash_amount)}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <br>
                &nbsp;<b>Total Amount:</b> ₱ {{number_format($cash_req_sum_1)}}

    <!-- cashouts 2nd sem -->
    @elseif($ids == 8)
        <table align="center" style="margin-right: 98px;" width="81%">
            <tr>
                <td align="left" rowspan="2"><img src="/assets/images/MccLogo.png" alt="profile picture"/></td>
                <td colspan="2" align="left" style="margin-right: 30px;">
                <p style="letter-spacing: 0.1px; font-family: georgia; font-size: 24px; line-height: 0px;"><b>MABALACAT CITY COLLEGE</b></p>
                <p style="margin-left: 61px; line-height: 0px">Dolores, Mabalacat City, Pampanga</p>
                </td>
            </tr>
        </table>
        <p><b>2nd Semester - Cash-Outs</b> <br><small class="text-muted">A.Y {{$acad_yr_id->ay_from}}-{{$acad_yr_id->ay_to}}</small></p>
                <table width="100%">
                    <thead>
                        <tr>
                            <th align="left">#</th>
                            <th align="left">Activity name</th>
                            <th align="left">Organization</th>
                            <th align="left">Amount (₱)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1; ?>
                        @foreach($cash_req_2 as $cash_req_2)
                        </tr>
                            <td>{{ $i++ }}</td>
                            <td>{{$cash_req_2->title}}</td>
                            <td>{{$cash_req_2->name}}</td>
                            <td>{{number_format($cash_req_2->cash_amount)}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <br>
                &nbsp;<b>Total Amount:</b> ₱ {{number_format($cash_req_sum_2)}}

    <!--  Liquidation 1st sem -->
    @elseif($ids == 9)
        <table align="center" style="margin-right: 98px;" width="81%">
            <tr>
                <td align="left" rowspan="2"><img src="/assets/images/MccLogo.png" alt="profile picture"/></td>
                <td colspan="2" align="left" style="margin-right: 30px;">
                <p style="letter-spacing: 0.1px; font-family: georgia; font-size: 24px; line-height: 0px;"><b>MABALACAT CITY COLLEGE</b></p>
                <p style="margin-left: 61px; line-height: 0px">Dolores, Mabalacat City, Pampanga</p>
                
                </td>
            </tr>
        </table>
        <p><b> 1st Semester - Liquidation</b> <br><small class="text-muted">A.Y {{$acad_yr_id->ay_from}}-{{$acad_yr_id->ay_to}}</small></p>
                <table width="100%">
                    <thead>
                        <tr>
                            <th align="left">#</th>
                            <th align="left">Organization</th>
                            <th align="left">Activity</th>
                            <th align="left">Official receipts</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1; ?>
                       @foreach($liquidation as $liquidation)
                        </tr>
                            <td>{{ $i++ }}</td>
                            <td>{{$liquidation->name}}</td>
                            <td>{{$liquidation->title}}</td>
                            <td>{{$liquidation->official_reciepts}}</td> 
                        </tr>
                        @endforeach
                    </tbody>
                </table>
    <!-- liquidation 2nd sem -->
    @elseif($ids == 10)
        <table align="center" style="margin-right: 98px;" width="81%">
            <tr>
                <td align="left" rowspan="2"><img src="/assets/images/MccLogo.png" alt="profile picture"/></td>
                <td colspan="2" align="left" style="margin-right: 30px;">
                <p style="letter-spacing: 0.1px; font-family: georgia; font-size: 24px; line-height: 0px;"><b>MABALACAT CITY COLLEGE</b></p>
                <p style="margin-left: 61px; line-height: 0px">Dolores, Mabalacat City, Pampanga</p>
               
                </td>
            </tr>
        </table>
        <p><b>2nd Semester - Liquidation</b> <br><small class="text-muted">A.Y {{$acad_yr_id->ay_from}}-{{$acad_yr_id->ay_to}}</small></p>
                <table width="100%">
                    <thead>
                        <tr>
                            <th align="left">#</th>
                            <th align="left">Organization</th>
                            <th align="left">Activity</th>
                            <th align="left">Official receipts</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1; ?>
                       @foreach($liquidation_2 as $liquidation_2)
                        </tr>
                            <td>{{ $i++ }}</td>
                            <td>{{$liquidation_2->name}}</td>
                            <td>{{$liquidation_2->title}}</td>
                            <td>{{$liquidation_2->official_reciepts}}</td> 
                        </tr>
                        @endforeach
                    </tbody>
                </table>
   
    @elseif($ids == 11)
        <table align="center" style="margin-right: 98px;" width="81%">
            <tr>
                <td align="left" rowspan="2"><img src="/assets/images/MccLogo.png" alt="profile picture"/></td>
                <td colspan="2" align="left" style="margin-right: 30px;">
                <p style="letter-spacing: 0.1px; font-family: georgia; font-size: 24px; line-height: 0px;"><b>MABALACAT CITY COLLEGE</b></p>
                <p style="margin-left: 61px; line-height: 0px">Dolores, Mabalacat City, Pampanga</p>
               
                </td>
            </tr>
        </table>
        <p><b>1st Semester - Liquidation</b> <br><small class="text-muted">A.Y </small></p>
                <table width="100%">
                    <thead>
                        <tr>
                            <th align="left">#</th>
                            <th align="left">Date</th>
                            <th align="left">Official receipts</th>
                            <th align="left">Items</th>
                            <th align="left">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1; ?>
                       @foreach($liquidation_1 as $liquidation_2)
                        </tr>
                            <td>{{ $i++ }}</td>
                            <td>{{$liquidation_2->created_at}}</td>
                            <td>{{$liquidation_2->item}}</td>
                            <td>{{$liquidation_2->amount}}</td>
                            <td>{{$liquidation_2->official_reciepts}}</td> 
                        </tr>
                        @endforeach
                    </tbody>
                </table>
   @elseif($ids == 12)
        <table align="center" style="margin-right: 98px;" width="81%">
            <tr>
                <td align="left" rowspan="2"><img src="/assets/images/MccLogo.png" alt="profile picture"/></td>
                <td colspan="2" align="left" style="margin-right: 30px;">
                <p style="letter-spacing: 0.1px; font-family: georgia; font-size: 24px; line-height: 0px;"><b>MABALACAT CITY COLLEGE</b></p>
                <p style="margin-left: 61px; line-height: 0px">Dolores, Mabalacat City, Pampanga</p>
               
                </td>
            </tr>
        </table>
        <p><b>2nd Semester - Liquidation</b> <br><small class="text-muted">A.Y </small></p>
                <table width="100%">
                    <thead>
                        <tr>
                            <th align="left">#</th>
                            <th align="left">Organization</th>
                            <th align="left">Activity</th>
                            <th align="left">Official receipts</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1; ?>
                       @foreach($liquidation_2 as $liquidation_2)
                        </tr>
                            <td>{{ $i++ }}</td>
                            <td>{{$liquidation_2->item}}</td>
                            <td>{{$liquidation_2->amount}}</td>
                            <td>{{$liquidation_2->official_reciepts}}</td> 
                        </tr>
                        @endforeach
                    </tbody>
                </table>
   @endif  
@endif

@if(Auth::user()->role_id == 4)
    <!--  Acitivities 1st sem -->
    @if($ids == 1)
        <table align="center" style="margin-right: 98px;" width="81%">
            <tr>
                <td align="left" rowspan="2"><img src="/assets/images/MccLogo.png" alt="profile picture"/></td>
                <td colspan="2" align="left" style="margin-right: 30px;">
                <p style="letter-spacing: 0.1px; font-family: georgia; font-size: 24px; line-height: 0px;"><b>MABALACAT CITY COLLEGE</b></p>
                <p style="margin-left: 61px; line-height: 0px">Dolores, Mabalacat City, Pampanga</p>
                
                </td>
            </tr>
        </table>
        <p><b> 1st Semester - Acitivities</b> <br><small class="text-muted">A.Y {{$acad_yr_id->ay_from}}-{{$acad_yr_id->ay_to}}</small></p>
                <table width="100%">
                    <thead>
                        <tr>
                            <th align="left">#</th>
                            <th align="left">Name</th>
                            <th align="left">Nature</th>
                            <th align="left">Venue</th>
                            <th align="left">Cost</th>
                            <th align="left">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1; ?>
                       @foreach($accomplished_activity as $activity)
                        </tr>
                            <td>{{ $i++ }}</td>
                            <td>{{$activity->title}}</td>
                            <td>{{$activity->nature}}</td>
                            <td>{{$activity->venue}}</td>
                            <td>{{number_format($activity->buggetTotal)}}</td>  
                            <td>{{$activity->date}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <br>
                &nbsp;<b>Total Cost:</b> ₱ {{number_format($sum_accomplished_activity)}}
    <!-- activities 2nd sem -->
    @elseif($ids == 2)
        <table align="center" style="margin-right: 98px;" width="81%">
            <tr>
                <td align="left" rowspan="2"><img src="/assets/images/MccLogo.png" alt="profile picture"/></td>
                <td colspan="2" align="left" style="margin-right: 30px;">
                <p style="letter-spacing: 0.1px; font-family: georgia; font-size: 24px; line-height: 0px;"><b>MABALACAT CITY COLLEGE</b></p>
                <p style="margin-left: 61px; line-height: 0px">Dolores, Mabalacat City, Pampanga</p>
               
                </td>
            </tr>
        </table>
        <p><b>2nd Semester - Acitivities</b> <br><small class="text-muted">A.Y {{$acad_yr_id->ay_from}}-{{$acad_yr_id->ay_to}}</small></p>
                <table width="100%">
                    <thead>
                        <tr>
                            <th align="left">#</th>
                            <th align="left">Name</th>
                            <th align="left">Nature</th>
                            <th align="left">Venue</th>
                            <th align="left">Cost</th>
                            <th align="left">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1; ?>
                       @foreach($accomplished_activity_2 as $accomplished_activity_2)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{$accomplished_activity_2->title}}</td>
                            <td>{{$accomplished_activity_2->nature}}</td>
                            <td>{{$accomplished_activity_2->venue}}</td>
                            <td>{{number_format($accomplished_activity_2->buggetTotal)}}</td>   
                            <td>{{$accomplished_activity_2->date}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
    @elseif($ids == 3)
        <table align="center" style="margin-right: 98px;" width="81%">
            <tr>
                <td align="left" rowspan="2"><img src="/assets/images/MccLogo.png" alt="profile picture"/></td>
                <td colspan="2" align="left" style="margin-right: 30px;">
                <p style="letter-spacing: 0.1px; font-family: georgia; font-size: 24px; line-height: 0px;"><b>MABALACAT CITY COLLEGE</b></p>
                <p style="margin-left: 61px; line-height: 0px">Dolores, Mabalacat City, Pampanga</p>
               
                </td>
            </tr>
        </table>
        <p><b>Liquidation</b> <br><small class="text-muted">A.Y </small></p>
                <table width="100%">
                    <thead>
                        <tr>
                            <th align="left">#</th>
                            <th align="left">Date</th>
                            <th align="left">Official Reciept</th>
                            <th align="left">Item</th>
                            <th align="left">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1; ?>
                       @foreach($officer_liquidation as $officer_liquidation)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{$officer_liquidation->created_at}}</td>
                            <td>{{$officer_liquidation->official_reciepts}}</td>
                            <td>{{$officer_liquidation->item}}</td>
                            <td><?php echo number_format($officer_liquidation->amount) ?></td>
                            
                            
                        </tr>
                        @endforeach
                    </tbody>
                </table>
           <h3>Total : ₱<?php echo number_format($liquidation_sum) ?>
    @endif
@endif
</body>
</html>