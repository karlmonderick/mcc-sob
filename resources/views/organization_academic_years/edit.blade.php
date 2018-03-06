@extends('layouts.master')

@section('content')

<!-- START BREADCRUMB -->
<ul class="breadcrumb push-down-0">
	<li><a href="javascript:history.back()">Organization</a></li>
	<li><a href="#">Not Accredited Organization</a></li>
</ul>
<!-- END BREADCRUMB -->      

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

	<div class="row">
		<div class="col-md-12">
        	<div class="panel panel-default">
				<!-- /.panel-heading -->
				<div class="panel-body">
					<h3 class="card-title">Not Accredited Organizations</h3>

					<hr>
					
                    <form action="{{route('organization_academic_years.update', $ay->id)}}" method="POST"> 
                    
                    	<input type="hidden" name="_method" value="put">
                    	<input type="hidden" name="_token" value="{{ csrf_token() }}"> 

						<input type="submit" class="btn btn-info btn-rounded btn-lg" onclick="return confirm('Are you sure?')" value="Accredit Organization">
						<input type="hidden" name="ay_id" value="{{$ay->id}}">

						<hr>

						<table width="100%" class="table table-striped table-bordered table-hover datatable panel-body mail">
							<thead>
								<tr>
									<th><label class="check mail-checkall">
										<input type="checkbox" class="icheckbox"/>
									</label>#</th>
									<th>Code</th>
									<th>Organization Name</th>
									<th>Organization Type</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$i=1;
								?>
								@foreach($organization_academic_year as $org_ay)
									<tr>
										<td class="mail-item mail-checkbox">                                   
										<div class="mail-checkbox">
											<input type="checkbox" name="accredit[]" value="{{$org_ay->id}}" id="{{$org_ay->id}}" class="icheckbox"/>
										</div>{{ $i++ }}</td>
										<td>{{ $org_ay->code }}</td>
										<td>{{ $org_ay->name }}</td>
										<td>
                                            @if($org_ay->type=='CW')
                                                College Wide
                                            @elseif($org_ay->type=='CO')
                                                Cultural
                                            @elseif($org_ay->type=='IO')
                                                Institute Organization
                                            @elseif($org_ay->type=='ISC')
                                                Institute Student Council
                                            @elseif($org_ay->type=='SSC')
                                                Supreme Student Council
                                            @elseif($org_ay->type=='SP')
                                                Student Publication
                                            @elseif($org_ay->type=='SPORTS')
                                                Sports
                                            @endif
                                        </td>
									</tr>
								@endforeach
								
							</tbody>
						</table>
						<!-- /.table-responsive -->
					</form>
				
				</div>
				<!-- /.panel-body -->
			</div>
			<!-- /.panel -->
		</div>
		<!-- /.col-lg-12 -->
	</div>
</div>     
@endsection


