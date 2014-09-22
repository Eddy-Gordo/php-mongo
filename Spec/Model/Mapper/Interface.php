<?php

interface Spec_Model_Mapper_Interface
{
	public function create(Spec_Model_Interface $model);

	public function update(Spec_Model_Interface $model, $safe = FALSE, $upsert = FALSE);

	public function delete(Spec_Model_Interface $model, $safe = TRUE);

	public function fetchOne(array $cond = null, array $sort = null);

    public function fetchObject(array $cond = null, array $sort = null);

	/**
	 * @param array $cond
	 * @param array $sort
	 * @param null  $count
	 * @param null  $offset
	 * @param null  $hint
	 *
	 * @return Spec_Model_Collection
	 */
	public function fetchAll(array $cond = null, array $sort = null, $count = null, $offset = null, $hint = NULL);

	public function getCount(array $cond = null);
}