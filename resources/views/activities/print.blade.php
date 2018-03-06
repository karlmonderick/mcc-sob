
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
        <?php $f_name = Auth::user()->first_name;
              $m_name = Auth::user()->middle_name;
              $l_name = Auth::user()->last_name;
        ?>
        
<body onload="window.print()" >
        <table align="center" style="margin-right: 80px;" width="81%">
            <tr>
                <td align="left" rowspan="2"><img src="/assets/images/MccLogo.png" alt="profile picture"/></td>
                <td colspan="2" align="left" style="margin-right: 30px;">
                <p style="letter-spacing: 0.1px; font-family: georgia; font-size: 24px; line-height: 0px;"><b>MABALACAT CITY COLLEGE</b></p>
                <p style="margin-left: 61px; line-height: 0px">Dolores, Mabalacat City, Pampanga</p>
                <p style="letter-spacing: 0.5px; font-family: Bernard MT Condensed; 10px; margin-left: 57.5px;">STUDENT ACTIVITY ENCASHMENT FORM</p>
                </td>
            </tr>
        </table>
        <br>

        <div class="text">
    @foreach($act as $act)
            Reference Number &nbsp;:&nbsp;<b> MCCSAEF<?php echo date('Y'); ?>-{{$act->id}}</b>
            <br>
            Encashment Code &nbsp;&nbsp;: &nbsp;<b>{{$act->verification_code}}</b>
        </div>
        <hr>
        <p align="center"><b>ACTIVITY INFORMATION</b></p>
        <div class="text">
            Title of the Activity &nbsp;&nbsp;&nbsp;&nbsp;: &nbsp;&nbsp;&nbsp;&nbsp;{{$act->title}}  <br>  
            Nature of Activity &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: &nbsp;&nbsp;&nbsp;&nbsp;{{$act->nature}}
            <br> 
            Participants &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: &nbsp;&nbsp;&nbsp;&nbsp;{{$act->participants}} 
            <br> 
            Venue of the Activity &nbsp; : &nbsp;&nbsp;&nbsp;&nbsp;{{$act->venue}} <br> 
            Expected Attendees &nbsp;&nbsp;&nbsp;&nbsp;: &nbsp;&nbsp;&nbsp;&nbsp;{{$act->expectedAttendees}} <br> 
            Person/s In-charge &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :<?php
                $persons = json_decode($act->personInCharge,true);
                    //print "pre ";
                    //print_r("Name: ".$persons->Description); 
                    //print_r($persons->name);
                    //print "/pre ";

                
                foreach ($persons as $person)
                {
                    
                    echo '<div class="row">';
                    echo '<div class="col-md-3">';
                    echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$person;
                    echo '</div>';
                    echo '</div>';
                    
                }
                ?> <br>
            <i>(Please attach activity objectives & rationale on a separate sheet of bond paper including the necessary supporting documents upon encashment) </i>
            <hr>

            <p align="center"><b>LOGISTICS</b></p>
            <b>Budgetary requirements:</b> 
            <br>
            <i><b>(List in detail) Use separate sheet if necessary</b></i>
            <br><br>
            <?php

                                        $xb = 1;
                                        $budgetDescription = json_decode($act->budgetDescription,true);

                                        echo '<table width="100%">';
                                        echo '<thead>';
                                            echo '<tr>';

                                                echo '<th align="left">';
                                                echo 'No.';
                                                echo '</th>';

                                                echo '<th align="left">';
                                                echo 'Description';
                                                echo '</th>';

                                                echo '<th align="left">';
                                                echo 'Price';
                                                echo '</th>';

                                                echo '<th align="left">';
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
                                                    
                                                    echo number_format($b).'<br/>';
                                                    
                                                }
                                                echo '</td>';
                                            echo '</tr>';
                                        echo '</tbody>';
                                        echo '</table>';
                                        //$aaa= $budgetDescription->Description;
                                        //print_r("Price: ".$budgetDescription->Description->Cost);
                                        //print_r("Quantity: ".$budgetDescription->Description->Quantity);

                                    ?>
            <br>
            <b>Total Budget </b>: ₱ {{number_format($act->buggetTotal)}}
            <br>
            <b>Source of Funding </b>: {{$act->f_name}}
    @endforeach
            <hr>
            <p><b>REQUISITIONER / SPONSOR / ORGANIZER</b></p>
            <b>Organization name : </b> {{$act->name}}<br><br>
            <b>Requested by: </b> 
            <br><br>
            <ins style="letter-spacing: 1px;"><b>{{$f_name}} {{$m_name}} {{$l_name}}</b></ins> 
            <br>
            <footer><i>Signature over Printed Name</i></footer>
            <br><br>
            <b>Released by: </b> 
            <br><br>
            <ins style="letter-spacing: 0.5px;"><b> {{$igp->first_name}} {{$igp->middle_name}} {{$igp->last_name}} </b></ins>
            <br>
            <footer><i>IGP Officer</i></footer>

        </div> 

</body>
</html>
 