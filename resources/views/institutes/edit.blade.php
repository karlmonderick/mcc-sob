@extends('layouts.master')

@section('content')
<!-- START BREADCRUMB -->
<ul class="breadcrumb push-down-0">
	<li><a href="javascript:history.back()">Institutes</a></li>
	<li><a href="#">Edit</a></li>
</ul>
<!-- END BREADCRUMB -->     

 
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

	<div class="row">
		<div class="col-md-12">

			<div class="panel panel-default">
				<!-- /.panel-heading -->
				<div class="panel-body">
					
					<div class="card-block">
						<h3 class="card-title">Institutes</h3>
						
						<h6 class="card-subtitle mb-2 text-muted">Edit</h6>
						
						
						<div class="articles-container">
							<div class="divider" style="margin-top: 1rem;"></div>
							@foreach($institute as $ins)
							<form action="{{route('institutes.update', $ins->id)}}" method="post">
								<input type="hidden" name="_method" value="PATCH">
								{{ csrf_field()}}
								Institute Name
								<div class="form-group{{ ($errors->has('name')) ? $errors->first('name') : '' }}">
									<input type="text" name="name" pattern="^[A-Za-z-'-. _]*[A-Za-z-'-.][A-Za-z-'-. _]*$" class="form-control" placeholder="Enter Institute name" value="{{ $ins->name }}"required>
									{!! $errors->first('name', '<p class="help-block">:message</p>') !!}
									<br>
									Institute Code:
									<input type="text" name="code" pattern="^[A-Za-z _]*[A-Za-z][A-Za-z _]*$" class="form-control" value="{{ $ins->code }}" required>
									{!! $errors->first('code', '<p class="help-block">:message</p>') !!}
									
									{!! $errors->first('enrollee', '<p class="help-block">:message</p>') !!}
									<input type="hidden" name="ins_id" value="{{ $ins->id }}">
								</div>
								@foreach($acad_years as $ay)
				  				 <input type="hidden" name="ay_id" value="{{$ay->id}}"> 
				   				 @endforeach
								<div class="form-group">
									<input type="submit" class="btn btn-primary btn-xs" value="Submit"> 
									<a href="{{ route('institutes.index') }}" id="btn-add" class="btn btn-info btn-xs" >Cancel</a>
								</div>
							</form>
							@endforeach
							
						</div>
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