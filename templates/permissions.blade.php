@extends('master')

@section('header')

@stop

@section('left-side')


@stop

@section('sidebar')
    

    <p>This is appended to the master sidebar.</p>
@stop



@section('header')

@stop

@section('left-side')


@stop

@section('sidebar')
    

    <p>This is appended to the master sidebar.</p>
@stop


@section('content-header')
    
    <h1>
            Permissions
            <small>Control panel</small>
          </h1>
          
@stop

@section('content')
<div class="box-body">


        
       <form action="{{{$INETROOT}}}/people/permissions" method="post" /> 
       <input type="hidden" name="{{{$csrf_key}}}" value ="{{{$csrf_token}}}" />
        <table id="example2" class="table table-bordered table-hover">

        		<thead>
        					<th>  per </th>

        					@foreach($roles as $rol)

        						<th> {{{$rol->name}}} </th>

        					@endforeach
        		</thead>
        		<tbody>

        			@foreach($namePerm as $name)
        				<tr>
        					<td> {{{$name}}} </td>
        					@foreach($roles as $rol)
        					<td> <input name="{{{$rol->name}}}[]" value="{{{$name}}}" type="checkbox"
        						@foreach( $rol->permission  as $perm )

        							@if ($perm->permission   == $name )
        							  
        							  checked="checked"
        							 	
        							@endif
        							

        						@endforeach

        						 /> </td>
        					@endforeach

        				</tr>
        			@endforeach

        		</tbody>
        </table>

        <input type="submit">
    </form>
</div>

	


@stop