
        
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
				
					<div class="articles-container">
						<div class="divider" style="margin-top: 1rem;"></div>
							<form action="{{route('funds.update', $fund->id)}}" method="post">
							<input type="hidden" name="_method" value="PATCH">
							{{ csrf_field()}}
							<div class="form-group{{ ($errors->has('name')) ? $errors->first('name') : '' }}">
								Fund Name:
								<select name="name" id="name" class="form-control" required>
									<option value="{{$fund->name}}" selected>{{$fund->name}}</option>
									<option value="Academic Funds">Academic Funds</option>
									<option value="Cultural Activity Funds">Cultural Activity Funds</option>
									<option value="Student Activity Funds">Student Activity Funds</option>
									<option value="Student Council Funds">Student Council Funds</option>
									<option value="Publication Funds">Publication Funds</option>
									<option value="Sports Funds">Sports Funds</option>
								</select>
								{!! $errors->first('name', '<p class="help-block">:message</p>') !!}
								Amount:
								<input type="number" name="amount" class="form-control" placeholder="Enter Amount" value="{{$fund->amount}}" required>
								Semester:
								<select name="semester" class="form-control">
									<option value="1"
									@if ($fund->semester=='1') selected
									@endif
									>1st</option>
									<option value="2"
									@if ($fund->semester=='2') selected
									@endif
									>2nd</option>
								</select>
							</div>
							<div class="form-group">
								<input type="submit" class="btn btn-primary btn-xs" value="Submit"> <a href="{{ route('funds.show', $ay->id) }}" id="btn-add" class="btn btn-info btn-xs" >Cancel</a>
							</div>
						</form>
						
					</div>
				</div>
				<!-- /.panel-body -->
			</div>
			<!-- /.panel -->
		</div>
		<!-- /.col-lg-12 -->
	</div>
</div>
        
@endsection
        
