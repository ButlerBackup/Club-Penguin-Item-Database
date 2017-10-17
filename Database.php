<?php

if(!defined("DBCONF")){
	define("DBCONF", true);
	if (!defined("DB_FILE"))
	    define("DB_FILE", "config");
	include(DB_FILE . '.php');
}

define("DB_INCLUDED", true);

function dbprepare($data) {
    return dbEscape($data);
}

function dbrecover($data) {
    return $data;
}
$g_link = false;
function &getDB(){
	global $g_link;
	if( @$g_link && is_object($g_link))
		return $g_link;
	if(DB_HOST != "localhost" && DB_HOST != "127.0.0.1"){
		$g_link = mysqli_init();
		$g_link->real_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT, null, MYSQLI_CLIENT_COMPRESS);
	}
	else{
		$g_link = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
	}
	return $g_link;
}



function DBCommit(){
	$g_link = getDB();
	return $g_link->commit();
}

function getData($query, $m = "default"){
	error_reporting(E_ALL | E_STRICT);
	$mysqli = getDB();
	$result = $mysqli->query($query);
	if(!is_object($result)){
		return false;
	}
	$row = $result->fetch_assoc();
	if($m == "single"){
		if(is_object($result))
			$result->close();
		return $row;
	}
	$a = array($row);
	while($d2 = $result->fetch_assoc()){
		$a[] = $d2;
	}
	if(is_object($result))
		$result->close();
	return $a;
}

function setData($query){
	$mysqli = getDB();
	$result = $mysqli->query($query);
	$return =  ($result === false) ? false :true;
	if(is_object($result))
		$result->close();
	return $return;
}

function dbEscape($s, $link = NULL){
	$mysqli = getDB();
	return $mysqli->real_escape_string($s);
}

function finishDB(){
	global $g_link;
	if($g_link)
		@mysql_close($g_link);
	$g_link = false;
}

function millitime() {
  $microtime = microtime();
  $comps = explode(' ', $microtime);

  // Note: Using a string here to prevent loss of precision
  // in case of "overflow" (PHP converts it to a double)
  return sprintf('%d%03d', $comps[1], $comps[0] * 1000);
}

function updateStatus($id, $online){
	$query = "INSERT INTO stats VALUES($id," . dbEscape($online) . "," . ($time = time()) . ") ON duplicate KEY UPDATE population=" . dbEscape($online) . ", ts=$time";
	$res = setData($query);
}

?>
