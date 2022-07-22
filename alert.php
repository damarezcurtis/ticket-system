<?php
session_start();
require_once '../connect.php';

class Alert{
	public function __construct(){
		
	}
	public function total_new(){
		$items 					= 	array();
		$connection 			= 	new Connect();
		$connection				->	start();
		$mysqli 				=	$connection->connection;
		$query 					=	"SELECT `id`, `naam`, `email`, `kantoor`, `prio`, `ticket`,`subject`, `datum`, `status`,`actie`, `opmerking`, `currentdate` FROM `marketingticket` WHERE `display`='block' ORDER BY currentdate DESC;";		//"$query 					=	SELECT `id`, `naam`, `email`, `kantoor`, `prio`, `ticket`, `datum`, `status`,`actie`, `opmerking`, `currentdate` FROM `marketingticket`  WHERE `status`='open';";
		mysqli_set_charset( $mysqli, 'utf8');
		$resultaat 				= 	$mysqli->query($query);
		$row_cnt = $resultaat->num_rows;
		if (!($stmt = $mysqli->prepare($query))) {
     		echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		}
		
        if (!$stmt->execute()) {
			echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            
		}
		echo $row_cnt-1; 
	}
	public function total_trash(){
		$items 					= 	array();
		$connection 			= 	new Connect();
		$connection				->	start();
		$mysqli 				=	$connection->connection;
		$query 					=	"SELECT `id`, `naam`, `email`, `kantoor`, `prio`, `ticket`,`subject`, `datum`, `status`,`actie`, `opmerking`, `currentdate` FROM `marketingticket` WHERE `display`='none' ORDER BY currentdate DESC;";		//"$query 					=	SELECT `id`, `naam`, `email`, `kantoor`, `prio`, `ticket`, `datum`, `status`,`actie`, `opmerking`, `currentdate` FROM `marketingticket`  WHERE `status`='open';";
		mysqli_set_charset( $mysqli, 'utf8');
		$resultaat 				= 	$mysqli->query($query);
		$row_cnt = $resultaat->num_rows;
		if (!($stmt = $mysqli->prepare($query))) {
     		echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		}
		
        if (!$stmt->execute()) {
			echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            
		}
		echo $row_cnt-1; 
	}
	
}

?>