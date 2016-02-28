<?php 
	include 'core/init.php';
	include 'includes/overall/header.php'; 
?>


<h1 class='section-title'>Profile</h1>
<div class ='container' id='profile'>
	<div class='two-col' id='content'>
		<div class='clearer'></div>
		<h3>Transaction History</h3>
		<div class="list-wrap">
		    <table class="head">
		        <tr>
		        	<td style='width:35px;'>View</td>
		            <td style='width:70px;'>Trans. ID</td>
		            <td>Date / Time</td>
		            <td style='width:100px;'>Grand Total</td>
		            <td>Deliver to</td>
		            <td>Paid by</td>
		        </tr>
		    </table>
		    <div class="inner_table">
		        <table>
			        	<tr>
			        		<td style='width:35px;'><a href='#' class="toggler" data-prod-cat="1" title='View Orders'><small>View orders</small></a></td>
			        		<td style='width:70px;'>001</td>
			        		<td>Dec-21-2013 | 24:00</td>
			        		<td style='width:100px;'>Php 1999.50</td>
			        		<td>Santiago, Jayson @ 11-A Bermijo Apt.</td>
			        		<td>Santiago, Jayson @ 11-A Bermijo Apt.</td>
			        	</tr>
			        		
			        	<tr class="cat1" style="display:none">
			        		<td></td>
							<td>Product name</td>
							<td>Quantity</td>
							<td>Subtotal</td>
			        		<td></td>
			        		<td></td>
			        	</tr>

			        	<tr>
			        		<td><a href='#' class="toggler" data-prod-cat="2" title='View Orders'><small>View orders</small></a></td>
			        		<td>001</td>
			        		<td>Dec-21-2013 | 24:00</td>
			        		<td>Php 1999.50</td>
			        		<td>Santiago, Jayson @ 11-A Bermijo Apt.</td>
			        		<td>Santiago, Jayson @ 11-A Bermijo Apt.</td>
			        	</tr>

			        	<tr class='cat2' style='display:none'>
			        		<td></td>
							<td>Product name</td>
							<td>Quantity</td>
							<td>Subtotal</td>
			        		<td></td>
			        		<td></td>
			        	</tr>
		   	 	</table>

	    	</div>
		</div>	

	</div>

	<aside class='two-col'>
		<h2>HELLO , &nbsp; <?php echo $user_data['user_fname']; ?> !</h2>
		<section>
			<h5>Personal Information</h5>
			<div>
				<label>Fullname : </label>
				<span><?php echo $user_data['user_lname'] . ', ' . $user_data['user_fname']; ?></span><br>
				<label>Fullname : </label>
				<span><?php echo $user_data['user_lname'] . ', ' . $user_data['user_fname']; ?></span><br>
				<label>Fullname : </label>
				<span><?php echo $user_data['user_lname'] . ', ' . $user_data['user_fname']; ?></span><br>
			</div>
		</section>
		<section>
			<h5>Contact Information</h5>
			Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et al.
		</section>
		<section>
			<h5>Current Delivery Information</h5>
			Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et al.
		</section>
		<section>
			<h5>Current Billing Information</h5>
			Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et al.
		</section>
		
		<div class='clearer'></div>
	</aside>

</div>




<?php 
	include 'includes/overall/footer.php'; 
?>

<script type="text/javascript">
	$(document).ready(function(){
	    $(".toggler").click(function(e){
	        e.preventDefault();
	        $('.cat'+$(this).attr('data-prod-cat')).toggle();
	    });
	});
</script>