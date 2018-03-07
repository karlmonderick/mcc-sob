@extends('layouts.master')

@section('content')
       
<!-- START BREADCRUMB -->
<ul class="breadcrumb push-down-0">
	<li><a href="#"> Funds {{ $ay->ay_from }} - {{ $ay->ay_to }}</a></li>
</ul>
<!-- END BREADCRUMB -->      

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<!-- /.panel-heading -->
				<div class="panel-body">
					<h3 class="card-title">Funds A.Y.  {{ $ay->ay_from }} - {{ $ay->ay_to }}</h3>
					<h6 class="card-subtitle mb-2 text-muted">List</h6>
					<p>
						<!-- @if(Auth::user()->role_id == 2)
							<form method="POST" action="{{route('funds.allocate_funds')}}">
								<input type="hidden" name="_method" value="post">
								<input type="hidden" name="_token" value="{{ csrf_token() }}"> 
								<input type="hidden" name="ay_id" value="{{$ay->id}}">
								<div class="col-sm-2">
									<select name="sem" id="" class="form-control">
										<option value="1">1st Semester</option>
										<option value="2">2nd Semester</option	>
									</select>
								</div>
								
								<button type="submit" class="btn btn-success">Allocate Funds</button>
							<form>
						@endif -->

						<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#1stSem">Allocate Budget for 1st Semester</button>
						<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#2ndSem">Allocate Budget for 2nd Semester</button>



					</p>
					<hr>
					<div class="col-md-6">
						<table width="100%" class="table table-striped table-bordered table-hover datatable">
							<thead>
								<tr>
									<th>#</th>
									<th>Funds Name</th>
									<th>Amount (₱)</th>
									<th>Semester</th>
								</tr>
							</thead>
							<tbody>
								<?php $i=1; ?>
								@foreach($funds as $funds)
								<tr>
									<td>{{ $i++ }}</td>
									<td>{{ $funds->name }}</td>
									<td><?php echo number_format($funds->amount) ?></td>
									<td>
										@if($funds->semester == 1) 
											1st
										@else 
											2nd 
										@endif
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
						<!-- /.table-responsive -->
					</div>
               
					<div class="col-md-6">
						<!-- START JUSTIFIED TABS -->
						<div class="panel panel-default tabs">
							<ul class="nav nav-tabs nav-justified">
								<li class="active"><a href="#tab-first" data-toggle="tab">First Semester</a></li>
								<li><a href="#tab-second" data-toggle="tab">Second Semester</a></li>
							</ul>
							<div class="panel-body tab-content">
								<div class="tab-pane active" id="tab-first">
									<table width="100%" class="table table-striped table-bordered table-hover datatable">
										<thead>
											<tr>
												<th>#</th>
												<th>Organization</th>
												<th>Allocated (₱)</th>
												<th>Source</th>
												@if($auth->role_id == 1)
													<th>Option</th>
												@endif
											</tr>
										</thead>
										<tbody>
											<?php $i=1; ?>
											@foreach($budget as $budgets)
											<tr>
												<td>{{ $i++ }}</td>
												<td>{{ $budgets->name }}</td>
												<td><?php echo number_format($budgets->budget) ?></td>
												<td>{{$budgets->fund_name}}</td>
												@if($auth->role_id == 1)
												<td>
													<form action="" method="POST">      
														<input type="hidden" name="_method" value="delete">
														<input type="hidden" name="_token" value="{{ csrf_token() }}"> 
														@if(Auth::user()->role_id == 1)
														<a href="{{route('budget.edit', $budgets->id)}}" class="btn btn-xs btn-warning">Update</a>
														<!--<input type="submit" class="btn btn-xs" onclick="return confirm('Are you sure?')" value="delete">-->
														@endif
													</form>
												</td>
												@endif
											</tr>
											@endforeach
										</tbody>
									</table>    
								</div>
								<div class="tab-pane" id="tab-second">
									<table width="100%" class="table table-striped table-bordered table-hover datatable">
										<thead>
											<tr>
												<th>#</th>
												<th>Organization</th>
												<th>Allocated (₱)</th>
												<th>Source</th>
												@if($auth->role_id == 1)
													<th>Option</th>
												@endif
											</tr>
										</thead>
										<tbody>
											<?php $i=1; ?>
											@foreach($budget2 as $budgets)
											<tr>
												<td>{{ $i++ }}</td>
												<td>{{ $budgets->name }}</td>
												<td><?php echo number_format($budgets->budget) ?></td>
												<td>{{$budgets->fund_name}}</td>
												@if($auth->role_id == 1)
												<td>
													<form action="" method="POST">      
														<input type="hidden" name="_method" value="delete">
														<input type="hidden" name="_token" value="{{ csrf_token() }}"> 
														@if(Auth::user()->role_id == 1)
														<a href="{{route('budget.edit', $budgets->id)}}" class="btn btn-xs btn-warning">Update</a>
														<!--<input type="submit" class="btn btn-xs" onclick="return confirm('Are you sure?')" value="delete">-->
														@endif
													</form>
												</td>
												@endif
											</tr>
											@endforeach
										</tbody>
									</table>    
								</div>                 
							</div>
						</div>    
					</div>

				</div>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>


<!-- Modal Sem:1 -->
<div id="1stSem" class="modal fade" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">1st Semester Allocation</h4>
			</div>
			<form method="POST" action="{{route('funds.allocate_funds')}}">
				<input type="hidden" name="_method" value="post">
				<input type="hidden" name="_token" value="{{ csrf_token() }}"> 
				<input type="hidden" name="ay_id" value="{{$ay->id}}">
				<input type="hidden" name="sem" value="1">
				<div class="modal-body">
					<table class="table table-bordered">
						<tr>
							<th>Funds</th>
							<th>Projection</th>
						</tr>
						@foreach($funds1sem as $sem1)
						<tr>
							<!-- pre-alocate funds -->
							

							<td>{{$sem1->name}} <br> <i>(₱<?php echo number_format($sem1->amount) ?>)</i></td>
							<td>				
								
								<table class="table table-bordered">
									<tr>
										<th>Organization</th>
										@if($sem1->name != 'Cultural' and $sem1->name != 'Publication' and $sem1->name != 'Sports')
										<th>Equal 
											<label class="switch switch-small">
												<input type="radio" name="{{$sem1->name}}-sem" checked value="1"/>
												<span></span>
											</label><br>
										</th>
										@else
											<th>  </th>
										@endif
										@if($sem1->name != 'Cultural' and $sem1->name != 'Publication' and $sem1->name != 'Sports')
											<th>By # of Students
												<label class="switch switch-small">
													<input type="radio" name="{{$sem1->name}}-sem" value="2"/>
													<span></span>
												</label>
											</th>
										@endif
									</tr>
									<?php
										if($sem1->name == 'Academic'){
											foreach($isc_orgs as $isc){
												echo '<tr>';
												echo '<td><p>'.$isc->name.'</p></td>';

												$acadequal =  $sem1->amount/count($isc_orgs);
												echo '<td><p>₱ '.number_format($acadequal).'</p></td>';

												foreach($institute_enrolled_1 as $ie1){
													if($isc->institute_id == $ie1->institute_id){
														if($ie1->no_of_students > 0 && $total_enrollee1 > 0){
															$percent = ($ie1->no_of_students / $total_enrollee1);
															$acadnum =  $sem1->amount*$percent;
														}else{
															$acadnum = 0;
														}	
														echo '<td><p>₱ '.number_format($acadnum).'</p></td>';
														echo '</tr>';
													}
												}
											}	
										}
										if($sem1->name == 'Cultural'){
											foreach($co_orgs as $co){
												echo '<tr>';
												echo '<td><p>'.$co->name.' '.count($co_orgs).'$</p></td>';

												$coequal =  $sem1->amount/count($co_orgs);
												echo '<td><p>₱ '.number_format($coequal).'</p></td>';
											}	
										}
										if($sem1->name == 'Student Council'){
											echo '<tr>';
											echo '<td> Supreme Student Council </td>';
											$sc =  ($sem1->amount/2);
											echo '<td><p>₱ '.number_format($sc).'</p></td>';
											echo '<td><p>₱ '.number_format($sc).'</p></td>';
											echo '<tr>';
											foreach($isc_orgs as $isc){
												echo '<tr>';
												echo '<td><p>'.$isc->name.'</p></td>';

												$scequal =  ($sem1->amount/2)/count($isc_orgs);
												echo '<td><p>₱ '.number_format($scequal).'</p></td>';

												foreach($institute_enrolled_1 as $ie1){
													if($isc->institute_id == $ie1->institute_id){
														$percent = ($ie1->no_of_students / $total_enrollee1);
														$scnum =  ($sem1->amount/2)*$percent;
														
														echo '<td><p>₱ '.number_format($scnum).'</p></td>';
														echo '</tr>';
													}
												}
											}	
										}
										if($sem1->name == 'Publication'){
											foreach($sp_orgs as $eq){
												echo '<tr>';
												echo '<td><p>'.$eq->name.'</p></td>';

												$eqequal =  $sem1->amount;
												echo '<td><p>₱ '.number_format($eqequal).'</p></td>';
											}	
										}
										if($sem1->name == 'Student Activity'){
											$orgs = count($io_orgs) + count($cw_orgs);
											foreach($io_orgs as $io){
												echo '<tr>';
												echo '<td><p>'.$io->name.'</p></td>';
												
												$saequal =  $sem1->amount/$orgs;
												echo '<td><p>₱ '.number_format($saequal).'</p></td>';

												foreach($institute_enrolled_1 as $ie1){
													if($io->institute_id == $ie1->institute_id){
														$percent = ($ie1->no_of_students / $total_enrollee1);
														if($io->institute_id == '2'){
															$sanum =  (($sem1->amount*.90)*$percent)/$count_ias_org;
															echo '<td><p>₱ '.number_format($sanum).'</p></td>';
														}
														elseif($io->institute_id == '3'){
															$sanum =  (($sem1->amount*.90)*$percent)/$count_ibe_org;
															echo '<td><p>₱ '.number_format($sanum).'</p></td>';
														}
														elseif($io->institute_id == '4'){
															$sanum =  (($sem1->amount*.90)*$percent)/$count_ics_org;
															echo '<td><p>₱ '.number_format($sanum).'</p></td>';
														}
														elseif($io->institute_id == '5'){
															$sanum =  (($sem1->amount*.90)*$percent)/$count_ihm_org;
															echo '<td><p>₱ '.number_format($sanum).'</p></td>';
														}
														elseif($io->institute_id == '6'){
															$sanum =  (($sem1->amount*.90)*$percent)/$count_ite_org;
															echo '<td><p>₱ '.number_format($sanum).'</p></td>';
														}
														else{
															echo '<td><p> N/A</p></td>';
														}
														echo '</tr>';
													}
												}
											}
											foreach($cw_orgs as $cw){
												echo '<tr>';
												echo '<td><p>'.$cw->name.'</p></td>';
												echo '<td><p>₱ '.number_format($saequal).'</p></td>';
												$sanum2 =  ($sem1->amount*.10)/count($cw_orgs);
												echo '<td><p>₱ '.number_format($sanum2).'</p></td>';
												echo '</tr>';
											}	
										}
										if($sem1->name == 'Sports'){
											foreach($sports_orgs as $sports){
												echo '<tr>';
												echo '<td><p>'.$sports->name.'</p></td>';

												$sportsequal =  $sem1->amount/count($sports_orgs);
												echo '<td><p>₱ '.number_format($sportsequal).'</p></td>';
											}	
										}
									?>
								</table>  
							</td>
						</tr>
						@endforeach
					</table>
					
					      

				</div>
				
   				
				<div class="modal-footer">
					<div class="form-group">
						<input type="submit" class="btn btn-primary" value="Submit">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>

			</form>
		</div>

	</div>
</div>

<!-- Modal Sem:2 -->
<div id="2ndSem" class="modal fade" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">2nd Semester Allocation</h4>
			</div>
			<form method="POST" action="{{route('funds.allocate_funds')}}">
				<input type="hidden" name="_method" value="post">
				<input type="hidden" name="_token" value="{{ csrf_token() }}"> 
				<input type="hidden" name="ay_id" value="{{$ay->id}}">
				<input type="hidden" name="sem" value="2">
				<div class="modal-body">
					<table class="table table-bordered">
						<tr>
							<th>Funds</th>
							<th>Projection</th>
						</tr>
						@foreach($funds2sem as $sem2)
						<tr>
							<!-- pre-alocate funds -->
							

							<td>{{$sem2->name}} <br> <i>(₱<?php echo number_format($sem2->amount) ?>)</i></td>
							<td>				
								
								<table class="table table-bordered">
									<tr>
										<th>Organization</th>
										@if($sem2->name != 'Cultural' and $sem2->name != 'Publication' and $sem2->name != 'Sports')
										<th>Equal 
											<label class="switch switch-small">
												<input type="radio" name="{{$sem2->name}}-sem" checked value="1"/>
												<span></span>
											</label><br>
										</th>
										@else
											<th>  </th>
										@endif
										@if($sem2->name != 'Cultural' and $sem2->name != 'Publication' and $sem2->name != 'Sports')
											<th>By # of Students
												<label class="switch switch-small">
													<input type="radio" name="{{$sem2->name}}-sem" value="2"/>
													<span></span>
												</label>
											</th>
										@endif
									</tr>
									<?php
										if($sem2->name == 'Academic'){
											foreach($isc_orgs as $isc){
												echo '<tr>';
												echo '<td><p>'.$isc->name.'</p></td>';

												$acadequal =  $sem2->amount/count($isc_orgs);
												echo '<td><p>₱ '.number_format($acadequal).'</p></td>';

												foreach($institute_enrolled_2 as $ie1){
													if($isc->institute_id == $ie1->institute_id){
														$percent = ($ie1->no_of_students / $total_enrollee2);
														$acadnum =  $sem2->amount*$percent;
														
														echo '<td><p>₱ '.number_format($acadnum).'</p></td>';
														echo '</tr>';
													}
												}
											}	
										}
										if($sem2->name == 'Cultural'){
											foreach($co_orgs as $co){
												echo '<tr>';
												echo '<td><p>'.$co->name.' '.count($co_orgs).'$</p></td>';

												$coequal =  $sem2->amount/count($co_orgs);
												echo '<td><p>₱ '.number_format($coequal).'</p></td>';
											}	
										}
										if($sem2->name == 'Student Council'){
											echo '<tr>';
											echo '<td> Supreme Student Council </td>';
											$sc =  ($sem2->amount/2);
											echo '<td><p>₱ '.number_format($sc).'</p></td>';
											echo '<td><p>₱ '.number_format($sc).'</p></td>';
											echo '<tr>';
											foreach($isc_orgs as $isc){
												echo '<tr>';
												echo '<td><p>'.$isc->name.'</p></td>';

												$scequal =  ($sem2->amount/2)/count($isc_orgs);
												echo '<td><p>₱ '.number_format($scequal).'</p></td>';

												foreach($institute_enrolled_2 as $ie1){
													if($isc->institute_id == $ie1->institute_id){
														$percent = ($ie1->no_of_students / $total_enrollee2);
														$scnum =  ($sem2->amount/2)*$percent;
														
														echo '<td><p>₱ '.number_format($scnum).'</p></td>';
														echo '</tr>';
													}
												}
											}	
										}
										if($sem2->name == 'Publication'){
											foreach($sp_orgs as $eq){
												echo '<tr>';
												echo '<td><p>'.$eq->name.'</p></td>';

												$eqequal =  $sem2->amount;
												echo '<td><p>₱ '.number_format($eqequal).'</p></td>';
											}	
										}
										if($sem2->name == 'Student Activity'){
											$orgs = count($io_orgs) + count($cw_orgs);
											foreach($io_orgs as $io){
												echo '<tr>';
												echo '<td><p>'.$io->name.'</p></td>';
												
												$saequal =  $sem2->amount/$orgs;
												echo '<td><p>₱ '.number_format($saequal).'</p></td>';

												foreach($institute_enrolled_2 as $ie1){
													if($io->institute_id == $ie1->institute_id){
														$percent = ($ie1->no_of_students / $total_enrollee2);
														if($io->institute_id == '2'){
															$sanum =  (($sem1->amount*.90)*$percent)/$count_ias_org;
															echo '<td><p>₱ '.number_format($sanum).'</p></td>';
														}
														elseif($io->institute_id == '3'){
															$sanum =  (($sem1->amount*.90)*$percent)/$count_ibe_org;
															echo '<td><p>₱ '.number_format($sanum).'</p></td>';
														}
														elseif($io->institute_id == '4'){
															$sanum =  (($sem1->amount*.90)*$percent)/$count_ics_org;
															echo '<td><p>₱ '.number_format($sanum).'</p></td>';
														}
														elseif($io->institute_id == '5'){
															$sanum =  (($sem1->amount*.90)*$percent)/$count_ihm_org;
															echo '<td><p>₱ '.number_format($sanum).'</p></td>';
														}
														elseif($io->institute_id == '6'){
															$sanum =  (($sem1->amount*.90)*$percent)/$count_ite_org;
															echo '<td><p>₱ '.number_format($sanum).'</p></td>';
														}
														else{
															echo '<td><p> N/A</p></td>';
														}
														echo '</tr>';
													}
												}
											}
											foreach($cw_orgs as $cw){
												echo '<tr>';
												echo '<td><p>'.$cw->name.'</p></td>';
												echo '<td><p>₱ '.number_format($saequal).'</p></td>';
												$sanum2 =  ($sem2->amount*.10)/count($cw_orgs);
												echo '<td><p>₱ '.number_format($sanum2).'</p></td>';
												echo '</tr>';
											}	
										}
										if($sem2->name == 'Sports'){
											foreach($sports_orgs as $sports){
												echo '<tr>';
												echo '<td><p>'.$sports->name.'</p></td>';

												$sportsequal =  $sem2->amount/count($sports_orgs);
												echo '<td><p>₱ '.number_format($sportsequal).'</p></td>';
											}	
										}
									?>
								</table>  
							</td>
						</tr>
						@endforeach
					</table>
					
					      

				</div>
				
   				
				<div class="modal-footer">
					<div class="form-group">
						<input type="submit" class="btn btn-primary" value="Submit">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>

			</form>
		</div>

	</div>
</div>
        

@endsection