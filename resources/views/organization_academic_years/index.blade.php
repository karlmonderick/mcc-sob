@extends('layouts.master')

@section('content')

<!-- START BREADCRUMB -->
<ul class="breadcrumb push-down-0">
	<li><a href="#">Accredited Organization {{ $ay->ay_from }} - {{ $ay->ay_to }}</a>
</ul>
<!-- END BREADCRUMB -->   



<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
	<div class="row">
        @if($auth->role_id == 3)
            <div class="col-md-3">
                <div class="panel panel-default">
                    
                    <div class="panel-heading">
                        <h3 class="panel-title">Options:</h3>
                    </div>
                    
                    <div class="panel-body">      
                        @if(Auth::user()->role_id == 3)
                                @if(Auth::user()->role_id == 3)
                                    <form action="{{route('organization_academic_years.refresh_list', $ay->id)}}" method="POST">      
                                        <input type="hidden" name="_method" value="post">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <button type="submit" class="btn btn-success btn-block"> <i class="fa fa-add"></i> Accredit Organizations</button>
                                    </form>
                                @endif
                        @endif
                        
                        <!-- <a href="{{ route('organization_academic_years.edit', $ay->id) }}" id="btn-add" class="btn btn-success btn-block " >Accredit an Organization</a> -->
                                        
                    </div>
                </div>
            </div>
        @endif       


        <div 
            @if($auth->role_id==1) 
                class="col-md-12" 
            @else 
                class="col-md-9" 
            @endif>
         	
             <div class="panel panel-default tabs">
				
                <ul class="nav nav-tabs nav-justified">
					<li class="active"><a href="#acdtd" data-toggle="tab">Accredited</a></li>
					<li><a href="#ntacdtd" data-toggle="tab">Not Accredited</a></li>
				</ul>

				<div class="panel-body tab-content">
                    <div class="tab-pane active" id="acdtd">
                        <div class="table-responsive">
                            <table width="100%" class="table table-striped table-bordered datatable" >
                                <thead>
                                    <tr>
                                        <th> #</th>
                                        <th>Organization Name</th>
                                        <th>Organization Type</th>
                                        @if($auth->role_id == 1 || $auth->role_id == 3  )
                                            <th>
                                                Information
                                            </th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach($organization_academic_year as $org_ay)
                                        @if($org_ay->accredited==1)
                                        <tr>
                                            <td>{{ $i++ }}</td>
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
                                            @if($auth->role_id == 1 || $auth->role_id == 3)
                                                <td>
                                                    <a href="{{ url('organization_academic_years/info/'.$org_ay->id) }}" class="btn btn-xs btn-info"> <i class="fa fa-eye"></i> Open</a>
                                                </td>
                                            @endif
                                        </tr>
                                        @endif
                                    
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="tab-pane" id="ntacdtd">
                        <table width="100%" class="table table-striped table-bordered table-hover datatable" >
                            <thead>
                                <tr>
                                    <th> #</th>
                                    <th>Organization Name</th>
                                    <th>Organization Type</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach($organization_academic_year as $org_ay)
                                    @if($org_ay->accredited==0)
                                    <tr>
                                        <td>{{ $i++ }}</td>
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
                                    @endif
                                
                                @endforeach
                            </tbody>
                        </table>
                    </div>
				</div>
				<!-- /.panel-body -->

			</div>
			<!-- /.panel -->
		</div>
        
    </div>
</div>


        
@endsection