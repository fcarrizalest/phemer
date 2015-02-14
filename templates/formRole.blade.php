@extends('master')

@section('header')

@stop

@section('content-header')
	
	<h1>
            Roles
            <small>Control panel</small>
          </h1>
          
@stop

@section('content')



<div class="row">
    <div class="col-xs-12">
    	<div class="box box-primary">
    		<div class="box-header">
            @if ( isset(  $role ) )
              <h3 class="box-title">Edit Rol</h3>
            @else
              <h3 class="box-title">New Rol</h3>

            @endif

                  
            </div>
            <div class="box-body">

              @if ( isset(  $role ) )
                <form action="{{{$INETROOT}}}/people/roles/{{{$role->id}}}" method="post" role="form">
              
              @else
                <form action="{{{$INETROOT}}}/people/roles" method="post" role="form">
              
              @endif
            		<input type="hidden" name="{{{$csrf_key}}}" value ="{{{$csrf_token}}}" />
            		
            		<div class="form-group">
	            		<div class="input-group">
	                    	
	                    	<span class="input-group-addon">@</span>
                          @if ( isset(  $role ) )
	                      	<input type="text" value="{{{ $role->name or '' }}}" name="name" class="form-control" placeholder="Name">
	                       @else 
                              <input type="text"  name="name" class="form-control" placeholder="Name">
                       
                         @endif
                      </div>
                	</div>

                    
                	
                	



                  	<div class="form-group">
	                  	<div class="input-group">
	                  		<input type="submit" value="Save" name="Save" >
	                  	</div>
                  	</div>

            	</form>
            </div>
    	</div>
	</div>
</div>



@stop