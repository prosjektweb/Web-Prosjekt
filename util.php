<?php
global $links;

/**
 * Set the body parameter to smarty
 *
 * @param unknown $body        	
 */
function setBody($body) {
	global $smarty;
	$smarty->assign ( "body", $body );
}

/**
 * Set the page parameter to smarty
 *
 * @param unknown $page        	
 */
function setPage($page) {
	global $smarty;
	$smarty->assign ( "page", $page );
}

/**
 * dbg
 *
 * @param unknown $var        	
 */
function dbg($var) {
	echo $var . "<br />";
}

/**
 * Helper function to filter emails
 *
 * @source http://php.net/manual/en/function.filter-var.php
 *
 * @param unknown $email        	
 * @param string $strict        	
 * @return boolean
 */
function validate_email($email, $strict = true) {
	$dot_string = $strict ? '(?:[A-Za-z0-9!#$%&*+=?^_`{|}~\'\\/-]|(?<!\\.|\\A)\\.(?!\\.|@))' : '(?:[A-Za-z0-9!#$%&*+=?^_`{|}~\'\\/.-])';
	$quoted_string = '(?:\\\\\\\\|\\\\"|\\\\?[A-Za-z0-9!#$%&*+=?^_`{|}~()<>[\\]:;@,. \'\\/-])';
	$ipv4_part = '(?:[0-9]|[1-9][0-9]|1[0-9][0-9]|2[0-4][0-9]|25[0-5])';
	$ipv6_part = '(?:[A-fa-f0-9]{1,4})';
	$fqdn_part = '(?:[A-Za-z](?:[A-Za-z0-9-]{0,61}?[A-Za-z0-9])?)';
	$ipv4 = "(?:(?:{$ipv4_part}\\.){3}{$ipv4_part})";
	$ipv6 = '(?:' . "(?:(?:{$ipv6_part}:){7}(?:{$ipv6_part}|:))" . '|' . "(?:(?:{$ipv6_part}:){6}(?::{$ipv6_part}|:{$ipv4}|:))" . '|' . "(?:(?:{$ipv6_part}:){5}(?:(?::{$ipv6_part}){1,2}|:{$ipv4}|:))" . '|' . "(?:(?:{$ipv6_part}:){4}(?:(?::{$ipv6_part}){1,3}|(?::{$ipv6_part})?:{$ipv4}|:))" . '|' . "(?:(?:{$ipv6_part}:){3}(?:(?::{$ipv6_part}){1,4}|(?::{$ipv6_part}){0,2}:{$ipv4}|:))" . '|' . "(?:(?:{$ipv6_part}:){2}(?:(?::{$ipv6_part}){1,5}|(?::{$ipv6_part}){0,3}:{$ipv4}|:))" . '|' . "(?:(?:{$ipv6_part}:){1}(?:(?::{$ipv6_part}){1,6}|(?::{$ipv6_part}){0,4}:{$ipv4}|:))" . '|' . "(?::(?:(?::{$ipv6_part}){1,7}|(?::{$ipv6_part}){0,5}:{$ipv4}|:))" . ')';
	$fqdn = "(?:(?:{$fqdn_part}\\.)+?{$fqdn_part})";
	$local = "({$dot_string}++|(\"){$quoted_string}++\")";
	$domain = "({$fqdn}|\\[{$ipv4}]|\\[{$ipv6}]|\\[{$fqdn}])";
	$pattern = "/\\A{$local}@{$domain}\\z/";
	return preg_match ( $pattern, $email, $matches ) && (! empty ( $matches [2] ) && ! isset ( $matches [1] [66] ) && ! isset ( $matches [0] [256] ) || ! isset ( $matches [1] [64] ) && ! isset ( $matches [0] [254] ));
}

/**
 * Textarea filter
 *
 * @param unknown $in        	
 */
function textarea_filter($str) {
	$allowed_tags = array (
			"code",
			"p",
			"b",
			"em",
			"li",
			"ul",
			"div",
			"br",
			"br/",
			"br /",
			"blockquote",
			"strike",
			"u",
			"ol" 
	);
	// Search through input and replace stuff
	$str = htmlspecialchars_decode ( $str );
	
	// TODO: Unsafe, we don't properly filter the data
	// $str = allow_only($str, $allowed_tags);
	return $str;
}

/**
 * Filter the given string for anything but alphanumerics.
 *
 * @param unknown $str        	
 * @return mixed
 */
function str_filter_only_alpha($str) {
	// Regex is hard :<
	// Must learn this properly some day!
	// Starts and ends with the same delimiter / in this case, # is also commonly used
	// This no sense make! Stupid PERL no one likes perl.
	// Oh and the [] thingy is called a character class
	// The ^ as a first option there means !
	// The + means that one or more occurances is valid
	// The i means case insensitive, that's creative!
	return preg_replace ( "/[^a-z0-9_]+/i", "", $str );
}

/**
 * Searched the given string for the given string ignoring case sensitivity
 *
 * @param unknown $str        	
 * @param unknown $like        	
 * @return boolean
 */
function str_contains_ignorecase($str, $like) {
	return str_contains ( strtolower ( $str ), strtolower ( $like ) );
}

/**
 * Searched the given string for the given string
 *
 * @param unknown $str        	
 * @param unknown $like        	
 * @return boolean
 */
function str_contains($str, $like) {
	$found = false;
	$likePos = 0;
	for($i = 0; $i < strlen ( $str ); $i ++) {
		if ($str [$i] == $like [$likePos]) {
			$likePos = $likePos + 1;
		} else {
			$likePos = 0;
		}
		if ($likePos == strlen ( $like )) {
			$found = true;
			break;
		}
	}
	return $found;
}

/**
 * Check if the given array has the given key
 *
 * @param unknown $array        	
 * @param unknown $key        	
 * @return boolean
 */
function array_has_key($array, $key) {
	$keys = array_keys ( $array );
	for($i = 0; $i < sizeof ( $keys ); $i ++) {
		if ($keys [$i] == $key) {
			return true;
		}
	}
	return false;
}

/**
 *
 * @param unknown $name        	
 * @param unknown $page        	
 * @param unknown $file        	
 * @param string $vars        	
 */
function addLink($name, $page, $file, $vars = null) {
	global $links;
	$links [$name] = makeLink ( $page, $file, $vars );
}

/**
 *
 * @param unknown $page        	
 * @param unknown $file        	
 * @param string $vars        	
 * @return string
 */
function makeLink($page, $file, $vars = null) {
	include ("config.php");
	if ($_SETTINGS ['mod_rewrite']) {
		$str = $ROOT_DIR . "/" . $page . "/" . $file . "/";
		for($i = 0; $i < sizeof ( $vars ); $i ++) {
			$str .= $vars [i] . "/";
		}
		return $str;
	} else {
		$str = $ROOT_DIR . "/index.php?page=" . $page . "&file=" . $file;
		for($i = 0; $i < sizeof ( $vars ); $i ++) {
			$str .= "&arg$i=" . $vars [$i];
		}
		return $str;
	}
}

/**
 * Check if we have the given argument
 *
 * @param unknown $index        	
 * @return type
 */
function hasArg($index) {
	return hasSession ( "arg" . $index );
}

/**
 * Get the given argument
 *
 * @param type $index        	
 * @return type
 */
function getArg($index) {
	if (! is_numeric ( $index ))
		return null;
	return session ( "arg" . $index );
}

/**
 *
 * @param type $url        	
 */
function headerRedirect($url) {
	header ( "Location: $url" );
	die ();
}

/**
 * Check if we are logged in
 *
 * @return boolean
 */
function isLoggedIn() {
	if (hasSession ( "userId" )) {
		return true;
	} else {
		return false;
	}
}

/**
 * Whether we are an admin or not
 *
 * @return type
 */
function isAdmin() {
	if (! isLoggedIn ()) {
		return false;
	}
	return session ( "group_id" ) == "1"; // hardcoded =D
}

/**
 * Get a localized string
 *
 * @param type $name        	
 * @return type
 */
function getString($name) {
	// Check strings
	include ("./assets/no.loc");
	// Do null check
	return $strings [$name];
}

/**
 * Get a link to a path, this can be handy if we want to implement mod_rewrite or something
 *
 * @param type $path        	
 */
function getLink($path) {
	$splits = split ( "/", $path );
	
	$cat = $splits [0];
	$page = $splits [1];
	
	return "?category=$cat&page=$page";
}

/**
 * Unset a session var
 *
 * @param type $sessName        	
 */
function unsetSession($sessName) {
	unset ( $_SESSION [$sessName] );
}

/**
 * Set a session var
 *
 * @param type $sessName        	
 * @param type $sessValue        	
 */
function setSession($sessName, $sessValue) {
	$_SESSION [$sessName] = $sessValue;
}

/**
 * Get a session var
 *
 * @param type $sessName        	
 * @return string
 */
function session($sessName) {
	if (hasSession ( $sessName )) {
		return $_SESSION [$sessName];
	} else {
		return "";
	}
}

/**
 * Check if the given array index exists
 *
 * @param type $sessName        	
 * @return type
 */
function hasSession($sessName) {
	return array_key_exists ( $sessName, $_SESSION );
}

/**
 *
 * @param type $var        	
 */
function hasGet($var) {
	if (array_key_exists ( $var, $_GET )) {
		return true;
	} else {
		return false;
	}
}

/**
 *
 * @param type $var        	
 */
function hasPost($var) {
	if (array_key_exists ( $var, $_POST )) {
		return true;
	} else {
		return false;
	}
}

/**
 * Simple html special chars filter for the $_GET input
 *
 * @param type $var        	
 * @return type
 */
function getFilter($var) {
	if (hasGet ( $var )) {
		return htmlspecialchars ( $_GET [$var] );
	} else {
		return "";
	}
}

/**
 *
 * @param type $var        	
 * @return string
 */
function postFilter($var) {
	if (hasPost ( $var )) {
		return htmlspecialchars ( $_POST [$var] );
	} else {
		return "";
	}
}

/**
 * Utility function, from: http://stackoverflow.com/questions/2915864/php-how-to-find-the-time-elapsed-since-a-date-time
 *
 * @param unknown $time_stamp        	
 * @return string
 */
function get_time_ago($time_stamp) {
	$time_difference = strtotime ( 'now' ) - $time_stamp;
	
	if ($time_difference >= 60 * 60 * 24 * 365.242199) {
		/*
		 * 60 seconds/minute * 60 minutes/hour * 24 hours/day * 365.242199 days/year
		 * This means that the time difference is 1 year or more
		 */
		return get_time_ago_string ( $time_stamp, 60 * 60 * 24 * 365.242199, 'year' );
	} elseif ($time_difference >= 60 * 60 * 24 * 30.4368499) {
		/*
		 * 60 seconds/minute * 60 minutes/hour * 24 hours/day * 30.4368499 days/month
		 * This means that the time difference is 1 month or more
		 */
		return get_time_ago_string ( $time_stamp, 60 * 60 * 24 * 30.4368499, 'month' );
	} elseif ($time_difference >= 60 * 60 * 24 * 7) {
		/*
		 * 60 seconds/minute * 60 minutes/hour * 24 hours/day * 7 days/week
		 * This means that the time difference is 1 week or more
		 */
		return get_time_ago_string ( $time_stamp, 60 * 60 * 24 * 7, 'week' );
	} elseif ($time_difference >= 60 * 60 * 24) {
		/*
		 * 60 seconds/minute * 60 minutes/hour * 24 hours/day
		 * This means that the time difference is 1 day or more
		 */
		return get_time_ago_string ( $time_stamp, 60 * 60 * 24, 'day' );
	} elseif ($time_difference >= 60 * 60) {
		/*
		 * 60 seconds/minute * 60 minutes/hour
		 * This means that the time difference is 1 hour or more
		 */
		return get_time_ago_string ( $time_stamp, 60 * 60, 'hour' );
	} else {
		/*
		 * 60 seconds/minute
		 * This means that the time difference is a matter of minutes
		 */
		return get_time_ago_string ( $time_stamp, 60, 'minute' );
	}
}

/**
 * Utility function, from http://stackoverflow.com/questions/2915864/php-how-to-find-the-time-elapsed-since-a-date-time
 *
 * @param unknown $time_stamp        	
 * @param unknown $divisor        	
 * @param unknown $time_unit        	
 * @return string
 */
function get_time_ago_string($time_stamp, $divisor, $time_unit) {
	$time_difference = strtotime ( "now" ) - $time_stamp;
	$time_units = floor ( $time_difference / $divisor );
	
	settype ( $time_units, 'string' );
	
	if ($time_units === '0') {
		return 'less than 1 ' . $time_unit . ' ago';
	} elseif ($time_units === '1') {
		return '1 ' . $time_unit . ' ago';
	} else {
		/*
		 * More than "1" $time_unit. This is the "plural" message.
		 */
		// TODO: This pluralizes the time unit, which is done by adding "s" at the end; this will not work for i18n!
		return $time_units . ' ' . $time_unit . 's ago';
	}
}

/**
 *
 * @param unknown $posts        	
 * @return multitype:unknown
 *
 * Sjekker om postverdien fra søkefelt finnes i tittel eller innohold av postene og retunrer at array med de postene.
 */
function search($posts) {
	$search = array ();
	
	for($i = 0; $i < sizeof ( $posts ); $i ++) {
		$post = $posts [$i];
		
		if (str_contains_ignorecase ( $post->getTitle (), postFilter ( "search" ) ) || str_contains_ignorecase ( $post->getContent (), postFilter ( "search" ) )) {
			$search [] = $post;
		}
	}
	
	return $search;
}
