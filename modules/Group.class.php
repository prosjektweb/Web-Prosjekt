<?php
class Group {
	/**
	 * The id of the group
	 *
	 * @var number
	 */
	var $id;
	
	/**
	 * The name of the group
	 *
	 * @var string
	 */
	var $name;
	
	/**
	 * Empty ctor
	 */
	function __construct() {
	}
	
	/**
	 * Get's the name of the group with the given id
	 *
	 * @param number $group_id        	
	 * @return string The name of the group or "none" if not found
	 */
	static function getGroupName($group_id) {
		try {
			$stmt = getDB ()->query ( "SELECT name FROM groups WHERE id='$group_id'" );
			return $stmt->fetch ()["name"];
		} catch ( Exception $ex ) {
			setSession ( "error", $ex->getMessage () );
		}
		return "none";
	}
	
	/**
	 * Get all the groups that satisfies the parameter condition or all if no parameter was specifieds
	 *
	 * @param string $where        	
	 * @return Group[] a list of the groups
	 */
	function getGroups($where = "") {
		try {
			$stmt = getDB ()->query ( "SELECT * FROM groups " . $where );
			$groups = array ();
			while ( ($group = $stmt->fetchObject ( "Group" )) ) {
				$groups [] = $group;
			}
			return $groups;
		} catch ( Exception $ex ) {
			setSession ( "error", $ex->getMessage () );
		}
	}
}