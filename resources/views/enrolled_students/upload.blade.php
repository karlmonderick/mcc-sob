@extends('layouts.master')

@section('content')
<div class="row">
                        <div class="col-md-8">

                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <h3><span class="fa fa-mail-forward"></span> File Input</h3>
                                    <p>Add class <code>file</code> to file input to get Bootstrap FileInput plugin</p>                                    
                                    <form enctype="multipart/form-data" class="form-horizontal">                                        
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label>Default</label>
                                                <input type="file" multiple class="file" data-preview-file-type="any"/>
                                            </div>
                                            <div class="col-md-12">
                                                <label>Disabled</label>
                                                <input type="file" multiple readonly="true" class="file" data-preview-file-type="any"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label>Simple</label><br/>
                                                <input type="file" multiple id="file-simple"/>
                                            </div>                                            
                                        </div>
                                    </form>
                                </div>
                            </div>
                            
                        </div>
                        <div class="col-md-4">
                            
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <h3><span class="fa fa-sitemap"></span> File Tree</h3>
                                    <p>File Tree is a configurable, AJAX file browser plugin for jQuery.</p>
                                    <div id="filetree"></div>
                                </div>
                            </div>
                            
                        </div>
                    </div>




@endsection