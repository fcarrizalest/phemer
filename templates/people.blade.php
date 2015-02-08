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
    <div class="box-body">

        <a class="btn btn-default btn-flat"  href="./people/new"> New User </a>
        <table id="example2" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>UserName</th>
                    <th>Email</th>
                    <th>Active</th>
                    
                    <th>Actions </th>
                </tr>
            </thead>
            <tbody>
        @foreach($users as $user)
                <tr>
                    <td>{{ $user->username }}</td>
                    <td> {{$user->email}} </td>
                    <td> 

                        @if ($user->active  == 1 )
                         
                         <a href="{{{$LOCALURL_ROOT}}}{{{$INETROOT}}}/people/{{$user->id}}/edit" class="btn btn-default btn-flat"><i class="fa fa-check-circle-o"></i></a>
                        @endif

                        @if ($user->active  == 0 )
                           <a href="{{{$LOCALURL_ROOT}}}{{{$INETROOT}}}/people/{{$user->id}}/edit" class="btn btn-default btn-flat"><i class="fa fa-circle-o"></i></a>
                      
                        @endif
                    </td>
                   
                    <td> 
                        <div class="btn-group">
                          <a href="{{{$LOCALURL_ROOT}}}{{{$INETROOT}}}/people/{{$user->id}}/edit" class="btn btn-default btn-flat">Edit</a>
                            
                            <form class="btn btn-default btn-flat"  method="post" action="{{{$LOCALURL_ROOT}}}{{{$INETROOT}}}/people/{{$user->id}}"> 
                                <input type="hidden" name="{{{$csrf_key}}}" value ="{{{$csrf_token}}}" />
                                <input type="submit" value="delete" href="./people/{{$user->id}}/delete" />
                            </form>
                        
                        </div>

                    </td>
	           </tr>
	   @endforeach
            </tbody>
        </table>
    </div>
@stop