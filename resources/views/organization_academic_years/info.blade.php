@extends('layouts.master')

@section('content')

<!-- START BREADCRUMB -->
<ul class="breadcrumb push-down-0">
	<li><a href="#">{{ $organization_academic_year->name }}  {{ $ay->ay_from }} - {{ $ay->ay_to }}</a>
</ul>
<!-- END BREADCRUMB -->                                             

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
    
    <div class="row">
        <div class="col-md-3">
            
            <div class="panel panel-default tabs">
                <div class="panel-body profile" style="background: url('/uploads/{{ $organization_academic_year->logo }}') center center no-repeat;">
                    <div class="profile-image">
                        <img src="/uploads/{{ $organization_academic_year->logo }}" alt="Logo"/>
                    </div>
                    <div class="profile-data">
                        <div class="profile-data-name">{{ $organization_academic_year->name }}</div>
                        <div class="profile-data-title" style="color: #FFF;">{{ $organization_academic_year->type }}</div>
                    </div>                                    
                </div>
                <div class="panel-body list-group border-bottom">
                    <a href="#" class="list-group-item active" ><span class="fa fa-money"></span> Budget: <span class="badge badge-success">{{number_format($budget->sum('remaining'))}}</span></a>
                    <a href="#activities" data-toggle="tab" class="list-group-item" ><span class="fa fa-bar-chart-o"></span> Activities</a>
                    <a href="#officers" data-toggle="tab" class="list-group-item"><span class="fa fa-users"></span> Officers <span class="badge badge-default">{{$officers->count()}}</span></a>                                
                    <a href="#reports" data-toggle="tab" class="list-group-item"><span class="fa fa-info"></span> Reports</a>
                    <a href="#settings" data-toggle="tab" class="list-group-item"><span class="fa fa-cog"></span> Settings</a>
                </div>
                <!-- <div class="panel-body">
                    <h4 class="text-title">Friends</h4>
                    <div class="row">
                        <div class="col-md-4 col-xs-4">
                            <a href="#" class="friend">
                                <img src="assets/images/users/user.jpg"/>
                                <span>Dmitry Ivaniuk</span>
                            </a>                                            
                        </div>
                        <div class="col-md-4 col-xs-4">                                            
                            <a href="#" class="friend">
                                <img src="assets/images/users/user2.jpg"/>
                                <span>John Doe</span>
                            </a>                                            
                        </div>
                        <div class="col-md-4 col-xs-4">                                            
                            <a href="#" class="friend">
                                <img src="assets/images/users/user4.jpg"/>
                                <span>Brad Pit</span>
                            </a>                                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-xs-4">                                            
                            <a href="#" class="friend">
                                <img src="assets/images/users/user5.jpg"/>
                                <span>John Travolta</span>
                            </a>                                            
                        </div>
                        <div class="col-md-4 col-xs-4">                                            
                            <a href="#" class="friend">
                                <img src="assets/images/users/user6.jpg"/>
                                <span>Darth Vader</span>
                            </a>                                            
                        </div>
                        <div class="col-md-4 col-xs-4">                                            
                            <a href="#" class="friend">
                                <img src="assets/images/users/user7.jpg"/>
                                <span>Samuel Leroy Jackson</span>
                            </a>                                            
                        </div>
                    </div>
                
                    <h4 class="text-title">Photos</h4>
                    <div class="gallery" id="links">                                                
                        <a href="assets/images/gallery/music-1.jpg" title="Music Image 1" class="gallery-item" data-gallery>
                            <div class="image">
                                <img src="assets/images/gallery/music-1.jpg" alt="Music Image 1"/>
                            </div>                                            
                        </a>
                        <a href="assets/images/gallery/music-2.jpg" title="Music Image 2" class="gallery-item" data-gallery>
                            <div class="image">
                                <img src="assets/images/gallery/music-2.jpg" alt="Music Image 2"/>
                            </div>                                            
                        </a>
                        <a href="assets/images/gallery/music-3.jpg" title="Music Image 3" class="gallery-item" data-gallery>
                            <div class="image">
                                <img src="assets/images/gallery/music-3.jpg" alt="Music Image 3"/>
                            </div>                                            
                        </a>
                        <a href="assets/images/gallery/nature-1.jpg" title="Nature Image 1" class="gallery-item" data-gallery>
                            <div class="image">
                                <img src="assets/images/gallery/nature-1.jpg" alt="Nature Image 1"/>
                            </div>                                            
                        </a>
                        <a href="assets/images/gallery/nature-2.jpg" title="Nature Image 2" class="gallery-item" data-gallery>
                            <div class="image">
                                <img src="assets/images/gallery/nature-2.jpg" alt="Nature Image 2"/>
                            </div>                                            
                        </a>
                        <a href="assets/images/gallery/nature-3.jpg" title="Nature Image 3" class="gallery-item" data-gallery>
                            <div class="image">
                                <img src="assets/images/gallery/nature-3.jpg" alt="Nature Image 3"/>
                            </div>                                            
                        </a>
                        <a href="assets/images/gallery/nature-4.jpg" title="Nature Image 4" class="gallery-item" data-gallery>
                            <div class="image">
                                <img src="assets/images/gallery/nature-4.jpg" alt="Nature Image 4"/>
                            </div>                                            
                        </a>
                        <a href="assets/images/gallery/nature-5.jpg" title="Nature Image 5" class="gallery-item" data-gallery>
                            <div class="image">
                                <img src="assets/images/gallery/nature-5.jpg" alt="Nature Image 5"/>
                            </div>                                            
                        </a>                                        
                    </div>
                </div> -->
            </div>                            
            
        </div>
        
        <div class="col-md-9">

            <!-- START VERTICAL TABS -->
            <div class="panel panel-default tabs">                                  
                <div class="panel-body tab-content">

                    <div class="tab-pane active" id="activities">
                        <h3>List of Activities</h3>
                        <hr>
                        @include('organization_academic_years.activity_list') 
                    </div>

                    <div class="tab-pane" id="officers">
                        <h3>List of Officers</h3>
                        <hr>
                        @include('officers.show')                    
                    </div>

                    <div class="tab-pane" id="reports">
                        <h3>Reports</h3>
                        <hr>
                    </div>

                    <div class="tab-pane" id="settings">
                        <h3>Organization Settings</h3>
                        <hr>
                        <div class="form-group">
                            <form action="{{ URL::to('upload_org_logo') }}" method="post" enctype="multipart/form-data">
                                <strong>Select image to upload</strong>
                                <input type="hidden" name="o_id" value="{{$organization_academic_year->organization_id}}">
                                <input type="file" name="file" id="file" required>
                                </br>
                                <button class="btn btn-lg btn-success btn-block" type="submit" name="submit"><i class="fa fa-cloud-upload"></i> Upload</button>
                                    
                                <input type="hidden" value="{{ csrf_token() }}" name="_token">
                            </form>
                        </div>
                    </div>  

                </div>
            </div>                        
            <!-- END VERTICAL TABS -->
                       
            
        </div>
        
    </div>

</div>
<!-- END PAGE CONTENT WRAPPER -->                     


        
@endsection