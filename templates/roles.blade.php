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
            Roles
            <small>Control panel</small>
          </h1>
          
@stop

@section('content')
    <div class="box-body">


        
        
        <a class="btn btn-default btn-flat"  href="./roles/new"> New Rol </a>
        <table id="example2" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Actions </th>
                </tr>
            </thead>
            <tbody>
        @foreach($roles as $rol)
                <tr>
                    <td>{{ $rol->name }}</td>
                  

                    
                
                    <td> 
                        <div class="btn-group">
                          <a href="{{{$INETROOT}}}/people/roles/{{$rol->id}}/edit" class="btn btn-default btn-flat">Edit</a>
                            
                            <form class="btn btn-default btn-flat"  method="post" action="{{{$INETROOT}}}/people/roles/{{$rol->id}}/delete"> 
                                <input type="hidden" name="{{{$csrf_key}}}" value ="{{{$csrf_token}}}" />
                                <input type="submit" value="delete" href="./roles/{{$rol->id}}/delete" />
                            </form>
                        
                        </div>

                    </td>
	           </tr>
	   @endforeach
            </tbody>
        </table>
    </div>
@stop