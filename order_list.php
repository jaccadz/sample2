<?php
//INITIALIZATION
	include 'core/init.php';
	include 'includes/overall/header.php';
?>

<?php
	if (isset($_GET['success_deliver']) && empty($_GET['deliver'])){
		echo "<div class='general-note' style='height:50px; padding-top: 40px;display:block; margin-bottom:9px; margin-top:-9px; margin-bottom: 0px;'>
				<p>Order is on delivery status.  &nbsp; <a href='order_list.php' style='text-decoration: underline; color:orange;'><u>Back</u></a></p>
			   </div>";	
	}
	else
	{
?>

<?php
	if(isset($_POST['action']) && $_POST['action'] == 'Deliver this order'){
		$id = $_POST['deliver_this_id'];
		mysql_query("UPDATE `orders` SET `ord_status` = 'On delivery' WHERE `ord_id` = $id");
		header("Location: order_list.php?success_deliver");
	}

?>

<?php
//DELETE A PRODUCT
	if(isset($_GET['rcv_order'])){
		echo "<div class='general-note' style='display:block; margin-bottom:9px; margin-top:-9px;'><p>";
		echo "Are you sure that order is already recieved by the customer? Please press, ";
		echo "<a href='order_list.php?rcv_this=". $_GET['rcv_order'] ."' style='color:lightgreen;padding-left:3px; text-decoration:underline'>Yes</a> | ";
		echo "<a href='order_list.php#our' style='color:red;padding-left:3px; text-decoration:underline'>No</a>";
		echo "</p></div>";
	}

	if(isset($_GET['rcv_this'])){
		$id = $_GET['rcv_this'];
		mysql_query("UPDATE `orders` SET `ord_status` = 'Received' WHERE `ord_id` = $id");
		echo "<div class='general-note' style='display:block; margin-bottom:9px; margin-top:-9px;'>
				<p>Order is already received by the client. Order information updated.</p>
			   </div>";	
	}
?>

<h1 class='section-title' id='our'>Orders</h1>


<div class ='container' id='inventory' style='width:905px; padding: 0 35px;'>
	<?php 
		if(isset($_GET['view_order']) && $_GET['view_order'] != ''){
			$id = $_GET['view_order'];
			echo "<div class='list-wrap' style='margin-top:30px;margin-bottom:-50px;width:500px;'>	
				<h2>Order No. ". $id ."</h2>

		   			<form action='order_list.php' method='POST'>
		   				<input type='hidden' name='deliver_this_id' value=". $id .">
		   				<input type='submit' name='action' value='Deliver this order'>
		   			</form><br>
		 
				<table class='head' style='margin-top:0px;width:500px;'>
			        <tr>
			            <td style='width:200px;'>Product</td>
			            <td style='width:60px;'>Unit Price</td>
			            <td style='width:60px;'>Quantity</td>
			            <td style='width:60px;'>Total</td>
			        </tr>
			    </table>
		    <div class='inner_table'>
		        <table id='data-list' style='width:500px;'>";
		        		$result = mysql_query("SELECT p.prd_name, od.ordDet_subTotal, od.ord_id, od.ordDet_qty ,p.prd_price
											   FROM order_details AS od , products AS p
											   WHERE od.prd_id = p.prd_id AND od.ord_id = $id")  or die(mysql_error());
		
						While($row = mysql_fetch_array($result)){
			            	echo "<tr>".
			            		"<td style='width:200px;'>". $row['prd_name'] . "</td>" .
								"<td style='width:60px;'>". $row['prd_price'] . "</td>" .
								"<td style='width:60px;'>". $row['ordDet_qty'] . "</td>" . 
								"<td style='width:60px;'>". $row['ordDet_subTotal'] . "</td></tr>";
						}
		   	echo "</table></div></div>";

		   	
		}
    ?>

	<div class="list-wrap">
		<h2>Order list</h2>
	    <table class="head" >
	        <tr>
	            <td style='width:70px;'>Order No.</td>
	            <td style='width:120px;'>Date / Time</td>
	            <td style='width:180px;'>Deliver to</td>
	            <td style='width:180px;'>Payment to/at</td>
	            <td style='width:95px;'>Total<small>(+12% Tx)</small></td>
	            <td style='width:40px;'>Action</td>
	            <td style='width:60px;'>Status</td>
	            <td style='width:55px;padding-right:15px'></td>
	        </tr>
	    </table>
	    <div class="inner_table">
	        <table id='data-list'>
	        	<?php

	        		$result = mysql_query("SELECT * FROM `orders` WHERE `ord_status` = 'On delivery' or `ord_status` = 'On placed'")  or die(mysql_error());
	
					While($row = mysql_fetch_array($result)){
		            	echo "<tr>".
			            	"<td style='width:70px;'>". $row['ord_id'] . "</td>" .
							"<td style='width:120px;'>". $row['ord_datePlace'] . "</td>" .
							"<td style='width:180px;'>". $row['ord_deliver_to'] . "</td>" . 
							"<td style='width:180px;'>". $row['ord_billing_to'] . "</td>" .
							"<td style='width:95px;font-weight:bold;color:orange'> Php. ". $row['ord_grandTotal'] . "</td>".
							"<td style='width:40px;'><a href='order_list.php?view_order=". $row['ord_id']."#our' style='color:lightgreen;padding-left:3px; text-decoration:underline'>View</a> </td>" .
							"<td style='width:60px;'>". $row['ord_status'] . "</td>" .
							"<td style='width:55px;padding-right:15px'><a href='order_list.php?rcv_order=". $row['ord_id']."' style='color:lightgreen;padding-left:3px; text-decoration:underline'>RCV</a> </td></tr>";
					}

	            ?>
	   	 	</table>
    	</div>
	</div>
	<div class='clearer'></div>
</div>
<?php } 
	if (isset($_GET['success_deliver']) ){
		include 'includes/widgets/a-links.php';
	}
	include 'includes/overall/footer.php'; 
//FOOTER
?>