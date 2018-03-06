@extends('layouts.app')

@section('content')


<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Funds AY {{ $ay->ay_from }} - {{ $ay->ay_to }}</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				DataTables Advanced Tables
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<h3 class="card-title">Add New Fund</h3>
				
				<div class="articles-container">
					<div class="divider" style="margin-top: 1rem;"></div>
					<form action="{{route('funds.store')}}" method="post">
						{{ csrf_field()}}
						<div class="row">
							<div class="col-md-10">
								<div class="form-group{{ ($errors->has('name')) ? $errors->first('name') : '' }}">
									Fund Name:
									<input type="text" name="name" class="form-control" placeholder="Enter Fund Name" required>
									{!! $errors->first('name', '<p class="help-block">:message</p>') !!}
									Amount:
									<input type="number" name="amount" class="form-control" placeholder="Enter Amount" required>
									Semester:
									<select name="semester" class="form-control">
										<option value="">--Select--</option>
										<option value="1">1st</option>
										<option value="2">2nd</option>
									</select>
								</div>
							</div>
						</div>

						
						<input type="hidden" name="ay_id" value="{{$ay->id}}">
						<input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
						<div class="form-group">
							<input type="submit" class="btn btn-primary btn-xs" value="Submit"> <a href="{{ route('funds.index') }}" id="btn-add" class="btn btn-info btn-xs" >Cancel</a>
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

<script src="//code.jquery.com/jquery-1.11.1.min.js"></script> 
                        
<script>  
 $(document).ready(function(){  
      var i=2018;  
      $('#add').click(function(){  
           i++;  
           $('#dynamic_field').append("<option id='row"+i+"' value='"+i+"-"+(+i+1)+"'>"+i+"-"+(+i+1)+"</option>");  
      });  
      $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove();  
      });  
 });

 </script>

        
@endsection
        
