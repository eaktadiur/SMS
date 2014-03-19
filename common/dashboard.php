<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

require_once("admin/models/config.php");
if (!$loggedInUser->user_id){die();}



$leadId = $_GET['id'];



//Check if selected lead exists
/*if(!leadIdExists($leadId)){
	header("Location: leads.php"); die();
}*/
$leaddetails = fetchFranchisedetails($leadId); //Fetch lead details
require_once('header.php');
?>


<?php if ($leaddetails[0]['active'] == 0) { ?>
     	<script>
			$(document).ready(function(){
				// show popup when you click on the link
				$('.overlay-content').html($('.active-button').html());
				$('.overlay-bg').show(); //display your popup

				 
				 
				 
				});
		</script>
     <?php } ?>

            

<div class="row-fluid sortable">		
				<div class="box span12">
					
					<div class="box-content">
     <h1>Welcome to the Franchise Tools!</h1>
<p>Please make a selection from the menu on the left.</p>
     </div>
				</div><!--/span-->
			
			</div>	

				

    
    
    
<?php include('footer.php'); ?>