<?php

class User extends \Illuminate\Database\Eloquent\Model
{



	public function __construct(array $attributes = array())
	{

		$fillable = array( "username", "password", "email", 'active');
		$this->fillable( $fillable);
		parent::__construct($attributes);


	}

	public function roles()
    {
        return $this->belongsToMany('Role','users_roles','uid','rid');
    }
}
?>