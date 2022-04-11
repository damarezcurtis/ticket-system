<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

class Send{
	public function __construct(){
		switch ($_GET['action']) {
			case "save":
				$this->sendProfile();
			break;
			case "edit":
				$this->editProfile();
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
		
		$mail 											= 	new PHPMailer;
		$mail->CharSet 									=   "UTF-8";
		$mail											->	setFrom('noreply@vcktravel.nl', 'VCK Travel');
		$mail											->	addAddress('damarez.rickets@vcktravel.nl', 'VCK Travel');
		//$mail											->	addAddress($_SESSION['addTraveller_email_booker'], 'VCK Travel');
		
		if(isset($_SESSION['upload'])){
			$upload = $_SESSION['upload'];
		
			if(is_array($_FILES)) {
				$mail->AddAttachment($upload); 
			}
		}
		
		$mail											->	isHTML(true);
		$mail->Subject  								= 	"Nieuwe Marketing Ticket #$id van ".$_SESSION['naam'].' '.$_SESSION['travelSegment_prefDate'];
		$mail->Body     								= 	$msg;
		if(!$mail->send()) {
		  echo 'Message was not sent.';
		  echo 'Mailer error: ' . $mail->ErrorInfo;
		} else {
		  echo '<p>Thank you for your request. This request has been sent to the appropriate manager for approval before it will be sent to VCK Travel.</p>';
			$_SESSION['upload']			='';
		}
		//$this->sendCC($msg);
	}
	private function doMailContributor($id){
		
	
		$msg='';
		$msg									.= "<style type='text/css'>th.mailclient { text-align:left; font-family:verdana; font-size:11px;background-color:#0c2a7c;color:white;padding-right:10px;padding-left:11px;} td { font-family:verdana; font-size:11px; background-color:#ffffff;padding-left:10px; padding-right:10px; }  .kop { font-size:13px; font-weight:bold;background-color:#ddd} .subkop { font-weight:bold; }</style>
		<table width=\"100%\" border=\"0\" cellspacing=\"5\" cellpadding=\"5\">
  <tbody>
    <tr>
      <td>Beste collega, <br>
<br>


Bedankt voor het indienen van een ticket voor Marketing.<br>

We hebben je ticket in goede orde ontvangen, en houden je op de hoogte van de status van je ticket.<br>
<br>

<u>Jouw ticket-nummer is: $id</u><br>
<br>


<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
  <tr>
    <td><p><a name=\"_MailAutoSig\">Met vriendelijke groet / Kind regards,</a><br>
        <br>
      <em>Marketing</em></p></td>
  </tr>
</table>
<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
  <tr>
    <td rowspan=\"2\" valign=\"top\"><p> <img width=\"70\" height=\"70\" src=\"https://ichannel/ticket-system/images/mail_clip_image002.png\"></p></td>
    <td><p><strong>VCK Travel &nbsp;B.V.</strong></p></td>
  </tr>
  <tr>
    <td nowrap valign=\"top\"><table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
      <tr>
        <td></td>
      </tr>
    </table>
      <p> </p>
      <table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
        <tr>
          <td><p> <strong><img width=\"13\" height=\"11\" src=\"https://ichannel/ticket-system/images/mail_clip_image003.png\"></strong><strong> </strong></p></td>
          <td><p>&nbsp;+31 88 120 1981 </p></td>
        </tr>
        <tr>
          <td><p> <img width=\"13\" height=\"11\" src=\"https://ichannel/ticket-system/images/mail_clip_image004.png\"></p></td>
          <td><p>&nbsp; <a href=\"https://www.vcktravel.nl\">www.vcktravel.nl</a></p></td>
        </tr>
      </table></td>
    <td nowrap valign=\"top\"></td>
  </tr>
</table>
</td>
    </tr>
  </tbody>
</table>
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
		

		$mail 											= 	new PHPMailer;
		$mail->CharSet 									=   "UTF-8";
		$mail											->	setFrom('noreply@vcktravel.nl', 'VCK Travel');
		//$mail											->	addAddress('damarez.rickets@vcktravel.nl', 'VCK Travel');
		$mail											->	addAddress($_SESSION['addTraveller_email_booker'], 'VCK Travel');
		
		if(isset($_SESSION['upload'])){
			$upload = $_SESSION['upload'];
		
			if(is_array($_FILES)) {
				$mail->AddAttachment($upload); 
			}
		}

		$mail											->	isHTML(true);
		$mail->Subject  								= 	"Nieuwe Marketing Ticket #$id van ".$_SESSION['naam'].' '.$_SESSION['travelSegment_prefDate'];
		$mail->Body     								= 	$msg;
		if(!$mail->send()) {
		  echo 'Message was not sent.';
		  echo 'Mailer error: ' . $mail->ErrorInfo;
		} else {
		  echo '<p>Thank you for your request. This request has been sent to the appropriate manager for approval before it will be sent to VCK Travel.</p>';
			$_SESSION['upload']			='';
		}
		//$this->sendCC($msg);
	}
	private function doMailAfter($RESPONSE,$email,$naam,$id){
		
	
		$msg='';
		$msg									.= "<style type='text/css'>th.mailclient { text-align:left; font-family:verdana; font-size:11px;background-color:#0c2a7c;color:white;padding-right:10px;padding-left:11px;} td { font-family:verdana; font-size:11px; background-color:#ffffff;padding-left:10px; padding-right:10px; }  .kop { font-size:13px; font-weight:bold;background-color:#ddd} .subkop { font-weight:bold; }</style>
		<table width=\"500px\" border=\"0\" cellspacing=\"5\" cellpadding=\"5\">
  <tbody>
    <tr>
      <td>Beste $naam, <br>
<br>
Jouw ticket met nummer $id is door de afdeling Marketing afgehandeld en gesloten.<br><br>


<u>Opmerkingen</u>:<br><br>



<em>$RESPONSE</em><br><br>


We hopen je hiermee van dienst geweest te zijn,<br><br>


<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
  <tr>
    <td><p>Met vriendelijke groet / Kind regards,<br>
        <br>
      <em>Marketing</em></p></td>
  </tr>
</table>
<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
  <tr>
    <td rowspan=\"2\" valign=\"top\"><p> <img width=\"70\" height=\"70\" src=\"https://ichannel/ticket-system/images/mail_clip_image002.png\"></p></td>
    <td><p><strong>VCK Travel &nbsp;B.V.</strong></p></td>
  </tr>
  <tr>
    <td nowrap valign=\"top\"><table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
      <tr>
        <td></td>
      </tr>
    </table>
      <p> </p>
      <table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
        <tr>
          <td><p> <strong><img width=\"13\" height=\"11\" src=\"https://ichannel/ticket-system/images/mail_clip_image003.png\"></strong><strong> </strong></p></td>
          <td><p>&nbsp;+31 88 120 1981 </p></td>
        </tr>
        <tr>
          <td><p> <img width=\"13\" height=\"11\" src=\"https://ichannel/ticket-system/images/mail_clip_image004.png\"></p></td>
          <td><p>&nbsp; <a href=\"https://www.vcktravel.nl\">www.vcktravel.nl</a></p></td>
        </tr>
      </table></td>
    <td nowrap valign=\"top\"></td>
  </tr>
</table>
</td>
    </tr>
  </tbody>
</table>
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
		

		$mail 											= 	new PHPMailer;
		$mail->CharSet 									=   "UTF-8";
		$mail											->	setFrom('noreply@vcktravel.nl', 'VCK Travel');
		//$mail											->	addAddress('damarez.rickets@vcktravel.nl', 'VCK Travel');
		$mail											->	addAddress($email, 'VCK Travel');
		$mail											->	isHTML(true);
		$mail->Subject  								= 	"Marketing Ticket #$id gesloten ";
		$mail->Body     								= 	$msg;
		if(!$mail->send()) {
		  echo 'Message was not sent.';
		  echo 'Mailer error: ' . $mail->ErrorInfo;
		} else {
		  echo '<p>Thank you for your request. This request has been sent to the appropriate manager for approval before it will be sent to VCK Travel.</p>';
			$_SESSION['upload']			='';
		}
		//$this->sendCC($msg);
	}
	private function cleanUpString($inputString){
		$invalid_characters = array("$", "%", "#", "<", ">", "|");
		$str 				= str_replace($invalid_characters, "", $inputString);
		return $str;
	}
	private function sendProfile(){
	
	
	if(isset($_POST['naam'])){
			$traveller	= '';
				
			if(isset($_POST['naam'])){
				$naam 					= $this->cleanUpString(htmlspecialchars($_POST['naam']));
				$_SESSION['naam']		= $this->cleanUpString(htmlspecialchars($_POST['naam']));
			}else{
				$naam 					= '';
			}
			if(isset($_POST['addTraveller_email_booker'])){
				$addTraveller_email_booker 					= $this->cleanUpString(htmlspecialchars($_POST['addTraveller_email_booker']));
				$_SESSION['addTraveller_email_booker']		= $this->cleanUpString(htmlspecialchars($_POST['addTraveller_email_booker']));
			}else{
				$addTraveller_email_booker 					= '';
			}
			if(isset($_POST['kantoor'])){
				$kantoor 					= $this->cleanUpString(htmlspecialchars($_POST['kantoor']));
			}else{
				$kantoor 					= '';
			}
			if(isset($_POST['ticket'])){
				$ticket 					= $this->cleanUpString(htmlspecialchars($_POST['ticket']));
			}else{
				$ticket 					= '';
			}
			if(isset($_POST['subject'])){
				$subject 					= $this->cleanUpString(htmlspecialchars($_POST['subject']));
			}else{
				$subject 					= '';
			}
			if(isset($_POST['prio'])){
				$prio 					= $this->cleanUpString(htmlspecialchars($_POST['prio']));
			}else{
				$prio 					= '';
			}
			if(isset($_POST['datum'])){
				
				$datum = date("Y-m-d", strtotime($_POST['datum']));
				$_SESSION['travelSegment_prefDate']	= $datum;
			}else{
				$datum 					= '';
			}
			require_once('connect.php');
			$operatingsystem			=	$_SERVER['HTTP_USER_AGENT'];
			$status						=	0;
			$connection 				= 	new Connect();
			$connection					->	start();
			$mysqli 					=	$connection->connection;
			$status						=	"open";
			$opmerking					=	"";
			$actie						=	'';
			mysqli_set_charset( $mysqli, 'utf8');
			//$_SESSION['subject'] dit gaan we na het roken toevoegen in de database. maken een veld onderwerp. en plaatsen deze in de tabel zodat we hem altijd kunnen terugvinden
			$query								="INSERT INTO `marketingticket` (`id`, `naam`, `email`, `kantoor`, `prio`, `ticket`,`subject`, `datum`, `status`,`actie`, `opmerking`, `currentdate`) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?,?, ?,?,NULL);";
			if (!($stmt = $mysqli->prepare($query))) {
				echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
			}
			if(!$stmt->	bind_param("ssssssssss",$naam, $addTraveller_email_booker, $kantoor, $prio, $ticket, $subject, $datum, $status,$actie, $opmerking))
			{
				echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
			}
			if (!$stmt->execute()) {
				echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
			}else{
				$stmt					->	store_result();
				//echo $mysqli->insert_id." Laatste id";

				$id= $mysqli->insert_id;
				$numrows 				= 	$stmt->num_rows;	
			}	
		$link = "<br /><br /><a href=\"https://ichannel/ticket-system/view.php?id=$id\">Open Ticket in de browser</a>";
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
				$ticketresponse 					= $this->cleanUpString(htmlspecialchars($_POST['opmerking']));
				
			}else{
				$ticketresponse 					= '';
			}
			if(isset($_POST['actie'])){
				$actie 					= $this->cleanUpString(htmlspecialchars($_POST['actie']));
			}else{
				$actie 					= '';
			}
			if(isset($_POST['status'])){
				$status 					= $this->cleanUpString(htmlspecialchars($_POST['status']));
			}else{
				$status 					= '';
			}
			if(isset($_POST['prio'])){
				$prio 					= $this->cleanUpString(htmlspecialchars($_POST['prio']));
			}else{
				$prio 					= '';
			}
			if(isset($_POST['theid'])){
				$id 					= $_POST['theid'];
			}else{
				$id 					= 0;
			}
		
			require_once('connect.php');
			$operatingsystem			=	$_SERVER['HTTP_USER_AGENT'];
		
			$connection 				= 	new Connect();
			$connection					->	start();
			$mysqli 					=	$connection->connection;
			
			mysqli_set_charset( $mysqli, 'utf8');
			//$_SESSION['subject'] dit gaan we na het roken toevoegen in de database. maken een veld onderwerp. en plaatsen deze in de tabel zodat we hem altijd kunnen terugvinden
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
			$response.="
 $ticketresponse 
";
			;
			$email = $_POST['email'];
			$naam = $_POST['naam'];
			//$_SESSION["traveller"] = $traveller;
			if($status==='gesloten'){
				$this->doMailAfter($response,$email,$naam,$id);
			}
			//$this->doMailMarketing($id);
		}
			
		
	}
}
$send = new Send();
?>