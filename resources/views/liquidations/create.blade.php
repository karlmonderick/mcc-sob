 @extends('layouts.master')

@section('content')

<!-- START BREADCRUMB -->
<ul class="breadcrumb push-down-0">
<li><a href="#"> Liquidation</a></li>
<li><a href="#"> Create</a></li>
</ul>
<!-- END BREADCRUMB -->      

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
<div class="row">
<div class="col-md-12">
	<div class="panel panel-default">
			<!-- /.panel-heading -->
		<div class="panel-body">
			<h6 class="card-subtitle mb-2 text-muted">Liquidation</h6>
			
			<div class="articles-container">
				<div class="divider" style="margin-top: 1rem;"></div>
				<form action="{{route('liquidations.store')}}" method="post">
					{{ csrf_field()}}
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Official Receipt</label>
								<textarea class="form-control" name="receipt" required></textarea>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="position" class="col-md-4 control-label">Activity</label>
									<select name="act_id" class="form-control" required>
										<option>--SELECT--</option>
										@foreach($act as $act)
										<option value="{{$act->id}}">{{$act->title}}</option>
										@endforeach
									</select>
							</div>
						</div>
						
					
					</div>

					<hr>
				
					<div class="form-group" style="margin-left: 10px;">
						<input type="submit" class="btn btn-primary" value="Submit"> 
						<a href="{{ url('/home') }}" id="btn-add" class="btn btn-info" >Cancel</a>
					</div>
				</form>
			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.col-lg-12 -->
</div>
@endsection