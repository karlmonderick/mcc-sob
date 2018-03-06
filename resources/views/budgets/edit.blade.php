
        
@extends('layouts.master')

@section('content')


@foreach($budgets as $budget)

<!-- START BREADCRUMB -->
<ul class="breadcrumb push-down-0">
	<li><a href="{{ URL::previous() }}"> Budget</a></li>
	<li><a href="#"> {{ $budget->name }}</a></li>
</ul>
<!-- END BREADCRUMB -->      

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<!-- /.panel-heading -->
				<div class="panel-body">
					<h3 class="card-title">{{ $budget->name }}</h3>
					<div class="articles-container">
						<div class="divider" style="margin-top: 1rem;"></div>
						<form action="{{route('budget.update', $budget->id)}}" method="post">
							<input type="hidden" name="_method" value="PATCH">
							{{ csrf_field()}}
							<div class="form-group{{ ($errors->has('budget')) ? $errors->first('budget') : '' }}">
								Budget:
								<input type="number" name="budget" class="form-control" placeholder="Enter budget Name"  value="{{$budget->budget}}" required>
							</div>
							<div class="form-group">
								<input type="submit" class="btn btn-primary btn-xs" value="Submit"> 
								<a onclick="history.back()" id="btn-add" class="btn btn-info" >Cancel</a>
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
@endforeach
        
@endsection
        
