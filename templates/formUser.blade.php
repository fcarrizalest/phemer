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
            @if ( isset(  $user ) )
              <h3 class="box-title">Edit User</h3>
            @else
              <h3 class="box-title">New User</h3>

            @endif

                  
            </div>
            <div class="box-body">

              @if ( isset(  $user ) )
                <form action="{{{$INETROOT}}}/people/{{{$user->id}}}" method="post" role="form">
              
              @else
                <form action="{{{$INETROOT}}}/people" method="post" role="form">
              
              @endif
            		<input type="hidden" name="{{{$csrf_key}}}" value ="{{{$csrf_token}}}" />
            		
            		<div class="form-group">
	            		<div class="input-group">
	                    	
	                    	<span class="input-group-addon">@</span>
                          @if ( isset(  $user ) )
	                      	<input type="text" value="{{{ $user->username or '' }}}" name="username" class="form-control" placeholder="UserName">
	                       @else 
                              <input type="text"  name="username" class="form-control" placeholder="UserName">
                       
                         @endif
                      </div>
                	</div>

                    
                	<div class="form-group">
	                    <div class="input-group">
	                      <label> Password</label>
                        
                          <input type="password"  name="password" class="form-control"  placeholder="Password">
                         
                      </div>
                	</div>

                	<div class="form-group">
	                    <div class="input-group">
	                    	
	                    	<span class="input-group-addon"><i class="fa fa-envelope"></i></span>
	                    	 @if ( isset(  $user ) )
                        <input type="text" name="email" value="{{{ $user->email or '' }}}" class="form-control" placeholder="Email">
	                  	  @else
                        <input type="text" name="email"  class="form-control" placeholder="Email">
                        
                        @endif
                      </div>
                  	</div>


                    <div class="form-group">
                      <div class="input-group">


                        @if( isset( $roles ) )
                             @foreach($roles as $rol)

                                  @if( in_array( $rol->name , $useroles ) )
                                  <input type="checkbox" checked="checked" name="role[]"  value="{{{$rol->id}}}"/> {{{$rol->name}}}  <br>
                                  @else
                                  <input type="checkbox"  name="role[]"  value="{{{$rol->id}}}"/> {{{$rol->name}}}  <br>
                                  
                                  @endif
                             @endforeach
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