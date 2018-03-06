@extends('layouts.master')

@section('content')
<ul class="breadcrumb push-down-0">
	<li><a href="#">User</a></li>
	<li><a href="#">Settings</a></li>
</ul>
<div class="page-content-wrap">
<div class="row">
	<div class="col-md-12">
                            <!-- CONTACT ITEM -->
                            <div class="panel panel-default">
                                <div class="panel-body profile">
                                    <div class="profile-image">
                                        <img src="/uploads/{{Auth::user()->photo}}" alt="profile picture"/>
                                    </div>
                                    <div class="profile-data">
                                       <div class="profile-data-name">
                                       	{{$users->first_name}} {{$users->middle_name}} {{$users->last_name}}
                                       </div>
                                    </div>
                                </div>                                
                                <div class="panel-body">                                    
                                    <div class="contact-info">
                                    	 @if (count($errors) > 0)
					            <div class="alert alert-danger">
					                <strong>Whoops!</strong> There were some problems with your input.
					                <ul>
					                    @foreach ($errors->all() as $error)
					                        <li>{{ $error }}</li>
					                    @endforeach
					                </ul>
					            </div>
					        @endif
					       
					   		<div class="form-group">
								<form action="{{ URL::to('upload_image') }}" method="post" enctype="multipart/form-data">
								<strong>Select image to upload</strong>
							    <input type="hidden" name="u_id" value="{{$users->id}}">
							    <table>
							    	<tr>
									    <td><input type="file" name="file" id="file" required></td>
									    <td align="left"><button class="btn btn-sm btn-success" type="submit" name="submit"><i class="fa fa-cloud-upload"></i> Upload</button></td>
									</tr>
								</table>
								<input type="hidden" value="{{ csrf_token() }}" name="_token">
								</form>
							</div>
		                                   	<p>
			                                    	<strong>
			                                    	@if($users->role_id != 4)
			                                    
			                                    	Employee ID
			                                    	@else
			                                    	
			                                    	Student ID
			                                    	
			                                    	@endif
			                                    	
			                                    	</strong> : {{$users->es_id}} &nbsp; 
		                                    	</p>
						    <p><a href="javascript:void(0);" onclick="na();" class="btn btn-xs btn-warning"> <i class="fa fa-edit"></i> Edit </a> <strong>Name</strong>  : {{$users->first_name}} {{$users->middle_name}} {{$users->last_name}} &nbsp; </p>
						    <div id="na" style="display: none">
							    <form action="{{route('users.update', $users->id)}}" method="POST">
							    	<input type="hidden" name="_method" value="PATCH">
							    	<input type="hidden" name="id" value="$users->id">
									{{ csrf_field()}}
								    <div class="row">
								    	<div class="col-md-3">
								    		<label>First Name</label>
								       		 <input type="text" name="first_name" class="form-control" value="{{$users->first_name}}" required>
								   	</div>
								   	<div class="col-md-3">
								   		<label>Middle Name</label>
								        	<input type="text" name="middle_name" class="form-control" value="{{$users->middle_name}}" placeholder="Optional">
								   	</div>
								   	<div class="col-md-3">
								   		<label>Last Name</label>
								        	<input type="text" name="last_name" class="form-control" value="{{$users->last_name}}"required>
								   	</div>
								   	<div class="col-md-3" style="padding-top: 22px;">
								        	<input type="submit" class="btn btn-info" value="Save">
								  	</div>
								  </div>
							  </form>
							  </br>
						    </div>

 
									  

                                        	<p> <a href="javascript:void(0);" onclick="email();" class="btn btn-xs btn-warning"> <i class="fa fa-edit"></i> Edit </a> <strong>Email</strong> : {{$users->email}} </p>
									    <div id="email" style="display: none">
									    	<form action="{{route('users.update', $users->id)}}" method="POST">
										    	<input type="hidden" name="_method" value="PATCH">
										    	<input type="hidden" name="id" value="$users->id">
												{{ csrf_field()}}
										    	<div class="row">
											    	<div class="col-md-3">
											        	<input type="email" name="email" class="form-control" placeholder="New Email" required>
											   	</div>
										   		<div class="col-md-3">
											        	<input type="submit" class="btn btn-info" value="Save">
											  	</div>
										  	</div>
									  	</form>
									  	</br>
									    </div>

                                        <p><a href="javascript:void(0);" onclick="contact();" class="btn btn-xs btn-warning"> <i class="fa fa-edit"></i> Edit </a> <strong>Contact No.</strong> : {{$users->contact}} </p>
									    <div id="contact" style="display: none">
									    <form action="{{route('users.update', $users->id)}}" method="POST">
									    	<input type="hidden" name="_method" value="PATCH">
									    	<input type="hidden" name="id" value="$users->id">
											{{ csrf_field()}}
									    	<div class="row">
									    	<div class="col-md-3">
									        <input type="text" name="contact" pattern="\d*" class="form-control" placeholder="New Number" required>
									   		</div>
									   		<div class="col-md-3">
									        <input type="submit" class="btn btn-info" value="Save">
									  		</div>
									  		</div>
									  	</form>
									  	</br>
									    </div>
							</br>
                                        <p><a href="javascript:void(0);" onclick="pass();" class="btn btn-xs btn-danger"><i class="fa fa-exclamation-triangle"></i> Change Password</a></p>
									    <div id="pass" style="display: none">
									    <form action="{{route('users.update', $users->id)}}" method="POST">
									    	<input type="hidden" name="_method" value="PATCH">
									    	<input type="hidden" name="id" value="{{$users->id}}">
											{{ csrf_field()}}
									    	<div class="row">

									    	<div class="col-md-3">
									    		<label>Current Password</label>
									        <input type="password" name="current_pass" class="form-control" required>
									   		</div>
									   		
									    	<div class="col-md-3">
									    		<label>New Password</label>
									        <input type="password" name="password" id="password" class="form-control" required>
									        </div>

									        <div class="col-md-3">
									    		<label>Confirm Password</label>
									        <input type="password" id="confirm_password" name="c_password" class="form-control" required>
									        </div>
									   		<!--<label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>
				                            <div class="col-md-3">
				                             <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
				                            </div>-->	
									   		<div class="col-md-3" style="padding-top: 22px;">
									        <input type="submit" class="btn btn-info" value="Save">
									  		</div>
									  		</div>
									  	</form>
									    </div>                               
                                    </div>
                                </div>                                
                            </div>
                            <!-- END CONTACT ITEM -->
                        </div>
</div>
</div>

<script type="text/javascript">
        function es_id() {
        	//es_id
            document.getElementById("es_id").style.display = "block";
        }

        function email() {
        	//email
            document.getElementById("email").style.display = "block";
        }

        function contact() {
        	//contact
            document.getElementById("contact").style.display = "block";
        }

        function pass() {
        	//password
            document.getElementById("pass").style.display = "block";
        }

        function na() {
        	//password
            document.getElementById("na").style.display = "block";
        }
    </script>
@endsection

