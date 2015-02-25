@extends('master')

@section('header')

@stop

@section('left-side')


@stop

@section('sidebar')
    

    <p>This is appended to the master sidebar.</p>
@stop


@section('content-header')
	
	<h1>
            Profile
            <small>Control panel</small>
          </h1>
          
@stop

@section('content')

<ul class="user-panel">
<li class="user-header">
                    <img src="{{{$INETROOT}}}/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image" />
                    <p>
                      {{{$username}}} - Web Developer
                      <small>Member since Nov. 2012</small>
                    </p>
                  </li>
                  <!-- Menu Body -->
                 

                  <!-- Menu Footer-->
                  <li class="user-footer">
                    
                  </li>
</ul>
@stop