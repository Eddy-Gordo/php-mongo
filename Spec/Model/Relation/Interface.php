<?php
interface Spec_Model_Relation_Interface
{
	/**
	 * @return Spec_Model_Interface
	 */
	public function get_foreign_object();

	/**
	 * @return boolean
	 */
	public function isset_foreign_object();

	/**
	 *
	 * @param Spec_Model_Interface $object
	 */
	public function set_foreign_object($object);

	/**
	 * @return Spec_Model_Interface
	 */
	public function get_local_object();

	/**
	 *
	 * @param Spec_Model $object
	 */
	public function set_local_object(Spec_Model $object);

	/**
	 * @return string
	 */
	public function get_relation_name();

	/**
	 *
	 * @param string $name
	 */
	public function set_relation_name($name);

	/**
	 *
	 * @param  array $requestParams
	 * @return Spec_Model_Interface
	 */
	public function match($requestParams);

	/**
	 *
	 * @param Spec_Model_Collection $collection
	 * @param boolean $refresh
	 */
	public function set_foreign_objects_to_collection(Spec_Model_Collection $collection, $refresh = false);
}