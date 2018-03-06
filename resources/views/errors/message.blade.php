<!-- <script>
@if(Session::has('success'))
    noty({
        type: 'success',
        layout: 'bottomLeft',
        text: '{{ Session::get('success') }}',
        timeout: 3000
    });
@endif      
@if(Session::has('information'))
    noty({
        type: 'information',
        layout: 'bottomLeft',
        text: '{{ Session::get('information') }}',
        timeout: 3000
    });
@endif    
@if(Session::has('error'))
    noty({
        type: 'error',
        layout: 'bottomLeft',
        text: '{{ Session::get('error') }}',
        timeout: 3000
    });
@endif    
@if(Session::has('warning'))
    noty({
        type: 'warning',
        layout: 'bottomLeft',
        text: '{{ Session::get('warning') }}',
        timeout: 3000
    });
@endif  

</script> -->


@if (Session::has('alert-success'))
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <i class="fa fa-check-square"></i> {{ Session::get('alert-success') }}
    </div>
@elseif (Session::has('alert-info'))
    <div class="alert alert-info">
        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <i class="fa fa-info-circle"></i> {{ Session::get('alert-info') }}
    </div>
@elseif (Session::has('alert-danger'))
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <i class="fa fa-info-circle"></i> {{ Session::get('alert-danger') }}
    </div>    
@endif