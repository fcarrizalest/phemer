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
            People
            <small>Control panel</small>
          </h1>
          
@stop

@section('content')
   

    @foreach($users as $user)
    <li>{{ $user->username }}</li>
	
	@endforeach
    
@stop