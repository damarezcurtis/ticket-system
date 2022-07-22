<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';
require 'config.php';
require 'connect.php';

class Send{
	public function __construct(){
		switch ($_GET['action']) {
			case "save":
				$this->sendProfile();
			break;
			case "edit":
				$this->editProfile();
			break;
			case "search":
				$this->search();
			break;
		}		
	}
	private function save(){
		$this->doMailContributor();
	}
	private function doMailMarketing($id){

		$msg='';
		$msg									.= "<style type='text/css'>th.mailclient { text-align:left; font-family:verdana; font-size:11px;background-color:#0c2a7c;color:white;padding-right:10px;padding-left:11px;} td { font-family:verdana; font-size:10px; background-color:#eee;padding-left:10px; padding-right:10px; }  .kop { font-size:13px; font-weight:bold;background-color:#ddd} .subkop { font-weight:bold; }</style>
";
		/*
		Beste collega, 

Jouw ticket met nummer $id is door de afdeling Marketing afgehandeld en gesloten.
Opmerkingen: <INSERT TICKET REMARKS>

We hopen je hiermee van dienst geweest te zijn, 

Met vriendelijke groet, 

Marketing
*/
		//$msg.= $_SESSION['url'];  
		
		if (isset($_SESSION['traveller'])) {
			$msg.=$_SESSION['traveller'];
		}
		
		$mail 								= 	new PHPMailer;
		$mail->CharSet 							=   	"UTF-8";
		$mail								->	setFrom(CONFIG::SENDER, 'VCK Travel');
		$mail								->	addAddress(CONFIG::SENDER, 'VCK Travel');
		
		if(isset($_SESSION['upload_image'])){
			$upload = $_SESSION['upload_image'];
		
			if(is_array($_FILES)) {
				$mail->AddAttachment($upload); 
			}
		}
		
		$mail								->	isHTML(true);
		$mail->Subject  						= 	"Nieuwe Marketing Ticket #$id van ".$_SESSION['naam'].' '.$_SESSION['travelSegment_prefDate'];
		$mail->Body     						= 	$msg;
		if(!$mail->send()) {
		  echo 'Message was not sent.';
		  echo 'Mailer error: ' . $mail->ErrorInfo;
		} else {
		  echo '<p>Thank you for your request. This request has been sent to the appropriate manager for approval before it will be sent to VCK Travel.</p>';
			$_SESSION['upload']			='';
		}
	}
	private function doMailContributor($id){
		
		$search = ["{id}"];
		$replace = [$id];
		$template	           					=   	file_get_contents('templates/emailclient.html', true);
		$msg               						=   	str_replace($search,$replace,$template);
	
		$mail 								= 	new PHPMailer;
		$mail->CharSet 							=   	"UTF-8";
		$mail								->	setFrom(CONFIG::SENDER, 'VCK Travel');
		$mail								->	addAddress($_SESSION['addTraveller_email_booker'], 'VCK Travel');
		
		$mail								->	isHTML(true);
		$mail->Subject  						= 	"Nieuwe Marketing Ticket #$id van ".$_SESSION['naam'].' '.$_SESSION['travelSegment_prefDate'];
		$mail->Body     						= 	$msg;
		if(!$mail->send()) {
		  echo 'Message was not sent.';
		  echo 'Mailer error: ' . $mail->ErrorInfo;
		} else {
		  echo '<p>Thank you for your request. This request has been sent to the appropriate manager for approval before it will be sent to VCK Travel.</p>';
			$_SESSION['upload']			='';
		}
		//$this->sendCC($msg);
	}
	private function doMailAfter($response,$email,$naam,$id,$subject){
		
		$search = ["{NAME}","{id}","{response}"];
		$replace = [$naam,$id,$response];
		$template	           					=   	file_get_contents('templates/emailclosed.html', true);
		$msg               						=   	str_replace($search,$replace,$template);
		
		
		$mail 								= 	new PHPMailer;
		$mail->CharSet 							=   	"UTF-8";
		$mail								->	setFrom(CONFIG::SENDER, 'VCK Travel');
		$mail								->	addAddress($email, 'VCK Travel');
		$mail								->	isHTML(true);
		$mail->Subject  						= 	"Marketing Ticket #$id $subject gesloten ";
		$mail->Body     						= 	$msg;
		if(!$mail->send()) {
		  echo 'Message was not sent.';
		  echo 'Mailer error: ' . $mail->ErrorInfo;
		} else {
		  echo '<p>Thank you for your request. This request has been sent to the appropriate manager for approval before it will be sent to VCK Travel.</p>';
			$_SESSION['upload']					='';
		}
		//$this->sendCC($msg);
	}
	private function cleanUpString($inputString){
		$invalid_characters = array("$", "%", "#", "<", ">", "|");
		$str 								= 	str_replace($invalid_characters, "", $inputString);
		return $str;
	}
	private function sendProfile(){
		
	if(isset($_POST['naam'])){
			$traveller	= '';
				
			if(isset($_POST['naam'])){
				$naam 						= 	$this->cleanUpString(htmlspecialchars($_POST['naam']));
				$_SESSION['naam']				= 	$this->cleanUpString(htmlspecialchars($_POST['naam']));
			}else{
				$naam 						= 	'';
			}
			if(isset($_POST['addTraveller_email_booker'])){
				$addTraveller_email_booker 			= 	$this->cleanUpString(htmlspecialchars($_POST['addTraveller_email_booker']));
				$_SESSION['addTraveller_email_booker']		= 	$this->cleanUpString(htmlspecialchars($_POST['addTraveller_email_booker']));
			}else{
				$addTraveller_email_booker 			= 	'';
			}
			if(isset($_POST['kantoor'])){
				$kantoor 					= 	$this->cleanUpString(htmlspecialchars($_POST['kantoor']));
			}else{
				$kantoor 					= 	'';
			}
			if(isset($_POST['ticket'])){
				$ticket 					=	 $this->cleanUpString(htmlspecialchars($_POST['ticket']));
			}else{
				$ticket 					= 	'';
			}
			if(isset($_POST['subject'])){
				$subject 					= 	$this->cleanUpString(htmlspecialchars($_POST['subject']));
			}else{
				$subject 					= 	'';
			}
			if(isset($_POST['prio'])){
				$prio 						= 	$this->cleanUpString(htmlspecialchars($_POST['prio']));
			}else{
				$prio 						= 	'';
			}
			if(isset($_POST['datum'])){
				
				$datum = date("Y-m-d", strtotime($_POST['datum']));
				$_SESSION['travelSegment_prefDate']		= 	$datum;
			}else{
				$datum 						= 	'';
			}
			require_once('connect.php');
			$operatingsystem					=	$_SERVER['HTTP_USER_AGENT'];
			$status							=	0;
			$connection 						= 	new Connect();
			$connection						->	start();
			$mysqli 						=	$connection->connection;
			$status							=	"open";
			$opmerking						=	"";
			$actie							=	'';
			$display						=	'block';
			mysqli_set_charset( $mysqli, 'utf8');
			
			$query							=	"INSERT INTO `marketingticket` (`id`, `naam`, `email`, `kantoor`, `prio`, `ticket`,`subject`, `datum`, `status`,`actie`, `opmerking`, `currentdate`, `display`) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?,?, ?,?,NULL,?);";
			if (!($stmt = $mysqli->prepare($query))) {
				echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
			}
			if(!$stmt->	bind_param("sssssssssss",$naam, $addTraveller_email_booker, $kantoor, $prio, $ticket, $subject, $datum, $status,$actie, $opmerking,$display))
			{
				echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
			}
			if (!$stmt->execute()) {
				echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
			}else{
				$stmt					->	store_result();
			
				$id= $mysqli->insert_id;
				$numrows 				= 	$stmt->num_rows;	
			}	
		$link 							= "<br /><br /><a href=\"https://ichannel/ticket-system/view.php?id=$id\">Open Ticket in de browser</a>";
			$traveller.="<table cellspacing='2' cellpadding='10'><tbody>
			<tr><td colspan='2' class='kop'>Aanvrager</td></tr>
			<tr><th class='mailclient'>Naam</th><td> $naam</td></tr>
			<tr><th class='mailclient'>E-mail</th><td> $addTraveller_email_booker</td></tr>
			<tr><th class='mailclient'>Kantoor</th>	<td>$kantoor </td></tr>
			
			<tr><th class='mailclient'>Ticket</th><td> $ticket</td></tr>
			<tr><th class='mailclient'>Onderwerp</th><td> $subject</td></tr>
			<tr><th class='mailclient'>Prioriteit</th>	<td>$prio </td></tr>
			
			<tr><th class='mailclient'>Deadline</th>		<td> $datum <br>
<br>$link
</td></tr>
			</tbody></table><br/><br/>";
			
			$_SESSION["traveller"] = $traveller;
			$this->doMailContributor($id);
			$this->doMailMarketing($id);
		}	
	}
	private function editProfile(){
		if(isset($_POST['opmerking'])){
			$response	= '';	

			if(isset($_POST['opmerking'])){
				$ticketresponse 					= 	$this->cleanUpString(htmlspecialchars($_POST['opmerking']));
			}else{
				$ticketresponse 					= 	'';
			}
			if(isset($_POST['actie'])){
				$actie 							= 	$this->cleanUpString(htmlspecialchars($_POST['actie']));
			}else{
				$actie 							= 	'';
			}
			if(isset($_POST['status'])){
				$status 						= 	$this->cleanUpString(htmlspecialchars($_POST['status']));
			}else{
				$status 						= 	'';
			}
			if(isset($_POST['prio'])){
				$prio 							= 	$this->cleanUpString(htmlspecialchars($_POST['prio']));
			}else{
				$prio 							= 	'';
			}
			if(isset($_POST['theid'])){
				$id 							= 	$_POST['theid'];
			}else{
				$id 							=	 0;
			}
			if(isset($_POST['subjects'])){
				$subject 						= 	$_POST['subjects'];
			}else{
				$subject 						= 	0;
			}
		
			require_once('connect.php');
			$operatingsystem						=	$_SERVER['HTTP_USER_AGENT'];
			$connection 							= 	new Connect();
			$connection							->	start();
			$mysqli 							=	$connection->connection;
			mysqli_set_charset( $mysqli, 'utf8');
			$query = "UPDATE marketingticket SET status=?, actie=?, opmerking=?, prio=? WHERE id=?";
		
			if (!($stmt = $mysqli->prepare($query))) {
				echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
			}
			if(!$stmt->	bind_param("ssssi",$status,$actie,$ticketresponse,$prio,$id))
			{
				echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
			}
			if (!$stmt->execute()) {
				echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
			}else{
				$stmt					->	store_result();
			
			}	
			$response.= $ticketresponse;
			
			$email = $_POST['email'];
			$naam = $_POST['naam'];
		
			if($status==='gesloten'){
				$this->doMailAfter($response,$email,$naam,$id,$subject);
			}
		}	
	}
	private function search(){
	
		$connection 				= 	new Connect();
		$connection				->	start();
		$mysqli 				=	$connection->connection;
        $param = "%{$_POST['search']}%";
       
        $query 						=	"SELECT `id`, `naam`, `email`, `kantoor`, `prio`, `ticket`,`subject`, `datum`, `status`,`actie`, `opmerking`, `currentdate` FROM `marketingticket` WHERE `subject` LIKE ? OR `ticket` LIKE ? OR `email` LIKE ? OR `kantoor` LIKE ?  OR `naam` LIKE ?  OR `datum` LIKE ?   OR `status` LIKE ?  OR `id` LIKE ? ORDER by `id`";
        $resultaat 					= 	$mysqli->query($query);
		if (!($stmt = $mysqli->prepare($query))) {
     		echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		}
		if(!$stmt->	bind_param("ssssssss",$param,$param,$param,$param,$param,$param,$param,$param))
        {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }
		if (!$stmt->execute()) {
			echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
		}else{
			$stmt						->	store_result();
			$numrows 					= 	$stmt->num_rows;
            
			if($numrows<1){
				
			}else{
                if (!$stmt->bind_result($id, $naam, $email, $kantoor, $prio, $ticket,$subject, $datum, $status,$actie, $opmerking, $currentdate)) {
                    echo "bind_result failed: (" . $stmt->errno . ") " . $stmt->error;
                }else{
                    
                    while ($stmt->fetch()) {
                      $cdate    = new DateTime($currentdate);
					 setlocale(LC_ALL, 'nld_nld');
					switch($prio){
						case "Rood":
							$color = "bg-danger";
							$prio = "Urgent <i class=\"fa-solid fa-radiation\"></i>";
							break;
						case "Oranje":
							$color = "bg-warning";
							$prio = "Medium <i class=\"fa-solid fa-hand\"></i>";
							break;
						case "Groen":
							$color = "bg-success";
							$prio = "Low <i class=\"fa-solid fa-minimize\"></i>";
							break;
					}
					
					if($status=="open"){
						
						$st = "<i class=\"text-danger fa-solid fa-lock-open\"></i>";
						$textcolor = 'text-black-50';
					}else{
						$st = "<i class=\"text-success fa-solid fa-clipboard-check\"></i>";
						$textcolor = 'text-black-50';
					}
					echo " <li class=\"list-group-item d-flex justify-content-between align-items-start\">
    <div class=\"ms-2 me-auto\">
      <div class=\"fw-bold $textcolor\">$naam <span class=\"badge bg-primary rounded-pill \">case #$id</span></div>
    <a href=\"?id=$id\" class='$textcolor'>$subject</a> $st 
    </div>
	<div class=\"ms-2 \" style='padding-right:10px;'>
    <span class=\"float-start\">".date("D j M Y", strtotime($currentdate))
."</span></div>
	<span class=\"badge $color rounded-pill \">$prio </span>
  </li>";
                    			}
               		 	}
			}
		}
      }
}
$send = new Send();
?>
