 @extends('layouts.master')

@section('content')

<!-- START BREADCRUMB -->
<ul class="breadcrumb push-down-0">
<li><a href="#"> Liquidation</a></li>
<li><a href="#"> Edit</a></li>
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
				@foreach($act as $act)
				<form action="{{route('liquidations.update', $act->id)}}" method="post">
				<input type="hidden" name="_method" value="PATCH">
								{{ csrf_field()}}
					<div class="row">
						
						<div class="col-md-6">
							<div class="form-group">
								<label>Official Receipt</label>
								<textarea class="form-control" name="receipt" value="{{$act->official_reciepts}}" required> </textarea>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="position" class="col-md-4 control-label">Activity</label>
									<select name="act_id" class="form-control" required>
										<option>--SELECT--</option>
										@foreach($activity as $activity)
										<option value="{{$activity->id}}" @if($activity->id == $act->acitivity_id) selected @endif>{{$activity->title}}</option>
										@endforeach
									
									</select>
							</div>
						</div>
						
					
					</div>
					

					<hr>
				
					<div class="form-group" style="margin-left: 10px;">
						<input type="submit" class="btn btn-primary" value="Submit"> 
						<a href="{{ route('liquidations.index') }}" id="btn-add" class="btn btn-info" >Cancel</a>
					</div>
				</form>
				@endforeach
			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.col-lg-12 -->
</div>
@endsection