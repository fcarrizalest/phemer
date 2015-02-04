<?php

class Ticket extends \Illuminate\Database\Eloquent\Model
{


	protected $table = 'tickets';

	public function __construct(array $attributes = array())
	{

		$fillable = array( "ticketid" ,"uid","clientip" );
		$this->fillable( $fillable);
		parent::__construct($attributes);


	}

	public function users()
    {
        return $this->belongsToMany('User','users_roles','rid','uid');
    }
}
?>