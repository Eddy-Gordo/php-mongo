<?php

interface Spec_Model_Collection_Interface extends Iterator, Countable, ArrayAccess
{
	public function append($model);

	public function prepend($model);

	public function populate($data);

	public function clear();

	public function asArray();
}