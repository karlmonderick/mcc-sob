

			
			@if($auth->role_id == 1)
			<p>
				<button type="button" class="btn btn-success btn-sm btn-rounded" data-toggle="modal" data-target="#myModal"><i class="fa fa-user"></i>Add Officer</button>
			</p>
			@endif
			


                <div class="row">
                	@if(Auth::user()->role_id == 4)
						@foreach($users as $users)
							@foreach($officers as $officer)
								@if($officer->organization_ay_id == $users->organization_ay_id)
									<div class="col-md-3">
										<!-- CONTACT ITEM -->
										<div class="panel panel-default">
											<div class="panel-body profile">
												<div class="profile-image">
													<img src="/uploads/{{Auth::user()->photo}}" alt="profile picture"/>
												</div>
												<div class="profile-data">
													<div class="profile-data-name">{{ $officer->first_name }} {{ $officer->last_name }}</div>
													<div class="profile-data-title">{{ $officer->position }}</div>
												</div>
											</div>                                
											<div class="panel-body">                                    
												<div class="contact-info">
													<p><small>Contact No.</small><br/>{{ $officer->contact }}</p>
													<p><small>Student ID</small><br/>{{ $officer->es_id }}</p>
													<p><small>Email</small><br/>{{ $officer->email }}</p>                                   
												</div>
											</div>                                
										</div>
										<!-- END CONTACT ITEM -->
									</div>
								@endif
							@endforeach
						@endforeach 

					@else
                	@foreach($officers as $officer)
                        <div class="col-md-3">
                            <!-- CONTACT ITEM -->
                            <div class="panel panel-default">
                                <div class="panel-body profile">
                                    <div class="profile-image">
                                        <img src="/uploads/{{$officer->photo}}" alt="profile picture"/>
                                    </div>
                                    <div class="profile-data">
                                        <div class="profile-data-name">{{ $officer->first_name }} {{ $officer->last_name }}</div>
                                        <div class="profile-data-title">{{ $officer->position }}</div>
                                    </div>
                                </div>                                
                                <div class="panel-body">                                    
                                    <div class="contact-info">
                                        <p><small>Contact No.</small><br/>{{ $officer->contact }}</p>
                                        <p><small>Employee/Student ID</small><br/>{{ $officer->es_id }}</p>
                                        <p><small>Email</small><br/>{{ $officer->email }}</p>                                   
                                    </div>
                                </div>                                
                            </div>
                            <!-- END CONTACT ITEM -->
                        </div>
					@endforeach  
					@endif                   
				</div>
                <!-- /.table-responsive -->
            

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Officer Information</h4>
			</div>
			
			<form class="form-horizontal" method="POST" action="{{ route('officers.store_officers') }}">
			
				<div class="modal-body">
					
					{{ csrf_field() }}

					<div class="form-group">
						<label class="col-md-4 control-label">Search</label>
						<div class="col-md-6">                                                                                
							<select class="form-control select" name="student" data-live-search="true">
								@foreach($enrolled as $enrolled)
									<option value="{{$enrolled->id}}">{{ $enrolled->student_no }} - {{ $enrolled->firstname_middlename }} {{ $enrolled->surname }}</option>
								@endforeach
							</select>
						</div>
					</div>


					<div class="form-group{{ $errors->has('position') ? ' has-error' : '' }}">
						<label for="position" class="col-md-4 control-label">Position</label>

						<div class="col-md-6">
							<select name="position" id="position" class="form-control">
								<option value="President">President</option>
								<option value="Vice President">Vice President</option>
								<option value="Secretary">Secretary</option>
								<option value="Treasurer">Treasurer</option>
								<option value="Auditor">Auditor</option>
								<option value="PRO">PRO</option>
							</select>
						{!! $errors->first('position', '<p class="help-block">:message</p>') !!}
						</div>
					</div>
					
					<input type="hidden" name="role_id" value="4">
					<input type="hidden" name="organization_ay_id" value="{{$organization_academic_year->id}}">
					<input type="hidden" name="ay_id" value="{{$ay->id}}">
					
				
				</div>
			
				
				<div class="modal-footer">
					<div class="form-group">
						<div class="col-md-6 col-md-offset-4">
							<button type="submit" class="btn btn-primary">
								Add
							</button>
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						</div>
					</div>
				</div>

			</form>
		</div>

	</div>
</div>


<!-- Modal -->

