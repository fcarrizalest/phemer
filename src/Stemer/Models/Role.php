<?php

class Role extends \Illuminate\Database\Eloquent\Model
{


	 protected $table = 'role';

	public function __construct(array $attributes = array())
	{

		$fillable = array( "name" );
		$this->fillable( $fillable);
		parent::__construct($attributes);


	}

	public function users()
    {
        return $this->belongsToMany('User','users_roles','rid','uid');
    }
}
?>