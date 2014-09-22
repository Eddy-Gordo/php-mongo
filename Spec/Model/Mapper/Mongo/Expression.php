<?php

class Spec_Model_Mapper_Mongo_Expression
{
	public $expr;

	public function __construct ($expr = null)
	{
		if ($expr !== NULL)
		{
			$this->set_expr($expr);
		}
	}

	public function set_expr ($expr)
	{
		$this->expr = $expr;
	}


	public function get_expr ()
	{
		return $this->expr;
	}
}