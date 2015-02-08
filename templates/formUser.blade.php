@extends('master')

@section('header')

@stop

@section('content-header')
	
	<h1>
            People
            <small>Control panel</small>
          </h1>
          
@stop

@section('content')



<div class="row">
    <div class="col-xs-12">
    	<div class="box box-primary">
    		<div class="box-header">
                  <h3 class="box-title">New User</h3>
            </div>
            <div class="box-body">
            	<form action="{{{$LOCALURL_ROOT}}}{{{$INETROOT}}}/people" method="post" role="form">
            		<input type="hidden" name="{{{$csrf_key}}}" value ="{{{$csrf_token}}}" />
            		
            		<div class="form-group">
	            		<div class="input-group">
	                    	
	                    	<span class="input-group-addon">@</span>
	                      	<input type="text" name="username" class="form-control" placeholder="UserName">
	                    </div>
                	</div>

                    
                	<div class="form-group">
	                    <div class="input-group">
	                      <label> Password</label>
	                      <input type="password" name="password" class="form-control"  placeholder="Password">
	                    </div>
                	</div>

                	<div class="form-group">
	                    <div class="input-group">
	                    	
	                    	<span class="input-group-addon"><i class="fa fa-envelope"></i></span>
	                    	<input type="text" name="email" class="form-control" placeholder="Email">
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