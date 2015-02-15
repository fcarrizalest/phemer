<?php

class Permission extends \Illuminate\Database\Eloquent\Model{
	protected $table = 'role_permission';
	public $timestamps = false;
	public function __construct(array $attributes = array())
	{

		$fillable = array( "permission", "rid" );

		$this->fillable( $fillable);
		parent::__construct($attributes);


	}




}
?>