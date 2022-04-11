<?php
session_start();
require_once '../connect.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../phpmailer/src/Exception.php';
require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';
class getTicket{
	private $numpages;
	public function __construct(){
		if(isset($_GET['id'])){
		
			$id = $_GET['id'];
			$this->get_ticket($id);
		}else{
			if (isset($_GET['page'])) {
				$pageno = $_GET['page'];
			} else {
				$pageno = 1;
			}
			$limit = 8;
			
			$this->get_total($limit);

			$eq = ($pageno-1)*$limit;
			$this->get_tickets($eq,$limit);
			$this->pagination_menu($limit,$pageno) ;
		}
	}
	private function get_total($limit){
		$items 					= 	array();
		$connection 			= 	new Connect();
		$connection				->	start();
		$mysqli 				=	$connection->connection;
		$query 					=	"SELECT `id`, `naam`, `email`, `kantoor`, `prio`, `ticket`,`subject`, `datum`, `status`,`actie`, `opmerking`, `currentdate` FROM `marketingticket`;";		//"$query 					=	SELECT `id`, `naam`, `email`, `kantoor`, `prio`, `ticket`, `datum`, `status`,`actie`, `opmerking`, `currentdate` FROM `marketingticket`  WHERE `status`='open';";
		mysqli_set_charset( $mysqli, 'utf8');
		$resultaat 				= 	$mysqli->query($query);
		$total_rows = $resultaat->num_rows;
		
		$total_pages = ceil ($total_rows / $limit); 
		$this->numpages = $total_pages;
		
		if (!($stmt = $mysqli->prepare($query))) {
     		echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		}
		
        if (!$stmt->execute()) {
		echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            
		}else{
            $stmt						->	store_result();
			$numrows 					= 	$stmt->num_rows;
            $stmt->close();
			
        }
	}
	private function pagination_menu($limit,$pageno){
		$items 					= 	array();
		$connection 			= 	new Connect();
		$connection				->	start();
		$mysqli 				=	$connection->connection;
		$query 					=	"SELECT `id`, `naam`, `email`, `kantoor`, `prio`, `ticket`,`subject`, `datum`, `status`,`actie`, `opmerking`, `currentdate` FROM `marketingticket`;";		//"$query 					=	SELECT `id`, `naam`, `email`, `kantoor`, `prio`, `ticket`, `datum`, `status`,`actie`, `opmerking`, `currentdate` FROM `marketingticket`  WHERE `status`='open';";
		mysqli_set_charset( $mysqli, 'utf8');
		$resultaat 				= 	$mysqli->query($query);
		$total_rows = $resultaat->num_rows;
		
		$total_pages = ceil ($total_rows / $limit); 
		$this->numpages = $total_pages;
		echo '<div class="container"><nav aria-label="Page navigation example">
  <ul class="pagination justify-content-center">';
		for($page_number = 1; $page_number<= $total_pages; $page_number++) {  
			if($pageno==$page_number){
				$c='active';
			}else{
				$c='';
			}
        	echo '<li class="page-item '.$c.'"><a  class="page-link" href = "view.php?page=' . $page_number . '">' . $page_number . ' </a></li>';  

    	}  
		echo '</ul>
</nav></div>';
		if (!($stmt = $mysqli->prepare($query))) {
     		echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		}
		
        if (!$stmt->execute()) {
			echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            
		}else{
            $stmt						->	store_result();
			$numrows 					= 	$stmt->num_rows;
            $stmt->close();
			
        }
	}
	private function get_tickets($offset,$no_of_records_per_page){
		echo "<ul class=\"list-group\">";
		$items 					= 	array();
		$connection 			= 	new Connect();
		$connection				->	start();
		$mysqli 				=	$connection->connection;
		$query 					=	"SELECT `id`, `naam`, `email`, `kantoor`, `prio`, `ticket`,`subject`, `datum`, `status`,`actie`, `opmerking`, `currentdate` FROM `marketingticket` ORDER BY currentdate DESC LIMIT $offset, $no_of_records_per_page;";		//"$query 					=	SELECT `id`, `naam`, `email`, `kantoor`, `prio`, `ticket`, `datum`, `status`,`actie`, `opmerking`, `currentdate` FROM `marketingticket`  WHERE `status`='open';";
		mysqli_set_charset( $mysqli, 'utf8');
		$resultaat 				= 	$mysqli->query($query);
		$row_cnt = $resultaat->num_rows;
		if (!($stmt = $mysqli->prepare($query))) {
     		echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		}	
        	if (!$stmt->execute()) {
			echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            
		}else{
           	 $stmt						->	store_result();
			$numrows 					= 	$stmt->num_rows;
			
			
			
            	if (!$stmt->bind_result($id, $naam, $email, $kantoor, $prio, $ticket, $subject, $datum, $status,$actie, $opmerking, $currentdate)) {
                	echo "bind_result failed: (" . $stmt->errno . ") " . $stmt->error;
           	 }else{
                	while ($stmt->fetch()) {
					//echo ($naam);
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
           		 $stmt->close();
			echo "</ul>";
        	}
	}
	private function get_ticket($id){

		$connection 				= 	new Connect();
		$connection				->	start();
		$mysqli 				=	$connection->connection;
		$query 					=	"SELECT `id`, `naam`, `email`, `kantoor`, `prio`, `ticket`,`subject`, `datum`, `status`,`actie`, `opmerking`, `currentdate` FROM `marketingticket`  WHERE `id`=?;";
		mysqli_set_charset( $mysqli, 'utf8');
		$resultaat 				= 	$mysqli->query($query);
		if (!($stmt = $mysqli->prepare($query))) {
     		echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		}
		if(!$stmt->	bind_param("i",$id))
		{
			echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
		}
        if (!$stmt->execute()) {
			echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            
		}else{
            $stmt						->	store_result();
		$numrows 					= 	$stmt->num_rows;
            if (!$stmt->bind_result($id, $naam, $email, $kantoor, $prio, $ticket,$subject, $datum, $status,$actie, $opmerking, $currentdate)) {
                echo "bind_result failed: (" . $stmt->errno . ") " . $stmt->error;
            }else{
                while ($stmt->fetch()) {
					//echo ($naam);
					$d =date('d-m-Y',strtotime($currentdate));					
					$datum =date('d-m-Y',strtotime($datum));
					
					switch($prio){
						case "Rood":
							$color = "bg-danger";
							$prio = "Urgent <i class=\"fa-solid fa-radiation\"></i>";
							$select2 = "<select class='form-control' name='prio'><option value='Rood' selected>Rood</option><option value='Oranje'>Oranje</option><option value='Groen'>Groen</option></select>";
							break;
						case "Oranje":
							$color = "bg-warning";
							$prio = "Medium <i class=\"fa-solid fa-hand\"></i>";
							$select2 = "<select class='form-control' name='prio'><option value='Rood' >Rood</option><option value='Oranje' selected>Oranje</option><option value='Groen'>Groen</option></select>";
							break;
						case "Groen":
							$color = "bg-success";
							$prio = "Low <i class=\"fa-solid fa-minimize\"></i>";
							$select2 = "<select class='form-control' name='prio'><option value='Rood' >Rood</option><option value='Oranje' >Oranje</option><option value='Groen' selected>Groen</option></select>";
							break;
					}
					switch($status){
						case "open":
							$select = "<select class='form-control' name='status'><option value='open' selected>open</option><option value='gesloten'>gesloten</option></select>";
							
							break;
						case "gesloten":
							$select = "<select class='form-control' name='status'><option value='open'>open</option><option value='gesloten' selected>gesloten</option></select>";
							break;
						default:
							$select = "<select class='form-control' name='status'><option value='open'>open</option><option value='gesloten'>gesloten</option></select>";
							break;
					}
					echo "
<div class=''>
<ul class=\"list-group \">
  <li class=\"list-group-item \">
    <div class=\"ms-2 me-auto\">
      <div class=\"fw-bold\">$subject <span class=\"badge $color rounded-pill \">$prio</span><a href='view.php' class=\"btn-close float-end\" aria-label=\"Close\"></a> </div>
      $ticket<br>
      <br>
      <small><strong>Deadline:</strong> $datum | <strong>Aanvrager: </strong>$naam |<strong> Afdeling</strong>:$kantoor |<strong> Datum ontvangen: </strong>$d</small> </div>
  </li>
  <li  class=\"list-group-item \">
    <form action=\"send.php?action=edit&id=$id\" method=\"post\" name=\"response\" enctype=\"multipart/form-data\">
      <table  width='100%' border='0' cellspacing='5' cellpadding='5'>
        <tbody>
          <tr>
            <td align='left' width='10%'><strong>Opmerking*:</strong></td>
            <td width='90%'><textarea  name='opmerking' required='required'  class='form-control' id='opmerking' placeholder='Opmerking'>$opmerking</textarea>
              <input type='hidden' name='theid' value=\"$id\"</td>
          </tr>
          <tr>
            <td align='left' width='10%'><strong>Ondernomen actie*:</strong></td>
            <td width='90%'><textarea  name='actie' required='required'  class='form-control' id='actie' placeholder='Ondernomen actie'>$actie</textarea></td>
          </tr>
          <tr>
            <td align='left' width='10%'><strong>Status*:</strong></td>
            <td width='90%'>$select</td>
          </tr>
          <tr>
            <td align='left' width='10%'><strong>Prioriteit*:</strong></td>
            <td width='90%'>$select2</td>
          </tr>
          <tr>
            <td align='left' width='10%'><input type='hidden' value=\"$email\" name='email'><input type='hidden' value=\"$naam\" name='naam'><input type='hidden' value=\"$ticket\" name='ticket'></td>
            <td width='90%'><br>

<button class='btn btn-primary' type='submit' style='background:rgb(199,209,83); color:rgb(38,74,151);' id='savebtn'>Opslaan </button></td>
          </tr>
        </tbody>
      </table>
    </form>
  </li>
  <li class=\"list-group-item bedankt\">
    
  </li>
</ul>
</div>
";
                }
            } 
            
            $stmt->close();
        }
	}
	private function cleanUpString($inputString){
		$invalid_characters = array("$", "%", "#", "<", ">", "|");
		$str 				= str_replace($invalid_characters, "", $inputString);
		return $str;
	}
}
$ticket = new getTicket();
?>
