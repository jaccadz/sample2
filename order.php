<?php
//INITIALIZATION
	include 'core/init.php';
	include 'includes/overall/header.php';
?>

<?php
// SUCCESS NOTE
	if (isset($_GET['success_order']) && empty($_GET['success_order'])){
		echo "<div class='general-note' style='height:50px; padding-top: 40px;display:block; margin-bottom:9px; margin-top:-9px; margin-bottom: 0px;'>
				<p>Thank you " . $user_data['user_fname'] ."!  Your order is already taken place and will be deliver in any minute. <a href='index.php' style='text-decoration: underline; color:orange;'><u>Home</u></a></p>
			   </div>";	
	}else
	{
?>

<?php
//CART

	if (isset($_GET['toCart'])) {
		if (logged_in() === false){
			header('Location: register.php');
			exit();
		}else{
			
			$pid = $_GET['toCart'];
			$isFound = false;
			$i = 0;
			if(!isset($_SESSION['cart_array']) || count($_SESSION['cart_array']) < 1){

				$_SESSION['cart_array'] = array(0 => array('item_id' => $pid, 'qty' => 1));

			}else{

				foreach ($_SESSION['cart_array'] as $each_item) {
					$i++;
					while (list($key, $value) = each($each_item)) {
						if ($key == 'item_id' && $value == $pid) {
							
							array_splice($_SESSION['cart_array'], $i-1, 1, array(array('item_id' => $pid, 'qty' => $each_item['qty'] + 1)));
							$isFound = true;
						}
					}
				}

				if($isFound == false){
					array_push($_SESSION['cart_array'], array('item_id' => $pid, 'qty' => 11));
				}
			}

			header("Location: order.php#our");
		}
	}
?>

<?php
//EMPTY THE CART
	if(isset($_GET['cmd']) && $_GET['cmd'] == 'emptycart'){
		unset($_SESSION['cart_array']);
		header("Location: order.php#our");
	}
?>

<?php
//REMOVE AN ITEM IN THE CART
	if (isset($_GET['remove']) && $_GET['remove'] != '') {
		$remove_this = $_GET['remove'];
		if(count($_SESSION['cart_array']) <= 1){
			unset($_SESSION['cart_array']);
		}else{
			unset($_SESSION['cart_array'][$remove_this]);
			sort($_SESSION['cart_array']);
		}
		header("Location: order.php#our");
	}
?>

<?php
//ADJUST THE QUANTITY
	if(isset($_POST['adjust_this']) && $_POST['adjust_this'] != ''){
		$adjust_this = $_POST['adjust_this'];
		$qty_is =  $_POST['qty_is'];
		$i = 0;
		foreach ($_SESSION['cart_array'] as $each_item) {
			$i++;
			while (list($key, $value) = each($each_item)) {
				if ($key == 'item_id' && $value == $adjust_this) {
					array_splice($_SESSION['cart_array'], $i-1, 1, array(array('item_id' => $adjust_this, 'qty' => $qty_is)));
				}
			}
		}
		header("Location: order.php#our");
	}
?>

<?php
//OUTPUT THE CART DATA
	$output = '';
	$subtotal = 0;
	$tax = 12;
	$taxtotal = 0;
	$grandtotal = 0;
	if(!isset($_SESSION['cart_array']) || count($_SESSION['cart_array']) < 1){
		$output = "<tr><td colspan='6' style='font-weight:bold;color:red;text-align:center;padding: 30px;'>Your Cart is Empty. </td></tr>";
	}else{
		$i = 0;
		foreach ($_SESSION['cart_array'] as $each_item) {
			
			$item_id = $each_item['item_id'];
			$result = mysql_query("SELECT * FROM products WHERE prd_id = $item_id LIMIT 1");
			while ($row = mysql_fetch_array($result)) {
				$product_name = $row['prd_name'];
				$product_price = $row['prd_price'];
			}
			$pricetotal = $each_item['qty'] * $product_price;
			$subtotal += $pricetotal;
			$taxtotal = $subtotal * ($tax / 100);
			$grandtotal = $subtotal + $taxtotal;

			$output .= "<tr><td style='padding-top: 10px;padding-bottom: 10px;'><a href='order.php?remove=". $i."'>X</a></td>";
			$output .= "<td width='80px'>". $product_name ."</td>";
			$output .= "<td><form action='order.php' method='post'><select name='qty_is'>";
							
							for($j = 1; $j <= 20; $j++){
								if($j == $each_item['qty']){
									$output .= "<option value='". $j . "' selected>" . $j . "</option>";
								}else{
									$output .= "<option value='". $j . "'>" . $j . "</option>";
								}
							}

			$output .= "</select><input type='hidden' name='adjust_this' value='". $item_id ."'>";
			$output .= "<input type='submit' value='Update' style='font-size:10px;width:40px;padding:0px;margin-top:5px'></form></td>";
			$output .= "<td>". number_format($product_price, 2, '.', ' ') ."</td>";
			$output .= "<td>". number_format($pricetotal, 2, '.', ' ') ."</td></tr>";
			$i++;
		}
	}
?>

<?php
//SAVE ADDRESS
	if (isset($_POST['action']) && $_POST['action'] == 'Save Address'){
					
		$register_data = array(
		'add_person' 		=> $_POST['add_name1'],
		'add_houseNo' 		=> $_POST['add_door1'],
		'add_building' 		=> $_POST['add_build1'],
		'add_street' 		=> $_POST['add_street1'],
		'add_brgySubd' 		=> $_POST['add_brgy1'],
		'add_city' 			=> $_POST['add_city1'],				
		'user_id' 			=> $session_user_id
		);
		save_address($register_data);
	}

	if (isset($_POST['action']) && $_POST['action'] == '*Save Address'){
					
		$register_data = array(
		'add_person' 		=> $_POST['add_name2'],
		'add_houseNo' 		=> $_POST['add_door2'],
		'add_building' 		=> $_POST['add_build2'],
		'add_street' 		=> $_POST['add_street2'],
		'add_brgySubd' 		=> $_POST['add_brgy2'],
		'add_city' 			=> $_POST['add_city2'],				
		'user_id' 			=> $session_user_id
		);
		save_address($register_data);
	}

	if (isset($_POST['action']) && $_POST['action'] == 'Save Address' || isset($_POST['action']) && $_POST['action'] == '*Save Address'){
		echo "<div class='general-note'  style='display:block; margin-bottom:9px; margin-top:-9px;color:lightgreen'><p>
				  Address successfully saved. </p></div>";
	}
?>

<?php
//CHECK-OUT
	if(isset($_POST['action']) && $_POST['action'] == 'Check out'){
		if(!isset($_SESSION['cart_array']) || count($_SESSION['cart_array']) < 1){
			echo "<div class='general-note'  style='display:block; margin-bottom:9px; margin-top:-9px;'><p>
				  Transaction cannot be completed, as your cart is empty.</p></div>";
		}else{
			$i = 0;
			//$orderID = getOrderID();
			foreach ($_SESSION['cart_array'] as $each_item) {
				$subT = 0;
				$grandtotal = 0;
				$subtotal = 0;
				$pricetotal = 0;
				$taxtotal = 0;
				$item_id = $each_item['item_id'];
				$result = mysql_query("SELECT * FROM products WHERE prd_id = $item_id LIMIT 1");
				while ($row = mysql_fetch_array($result)) {
					$product_name = $row['prd_name'];
					$product_price = $row['prd_price'];
					$product_id = $row['prd_id'];
				}
				$pricetotal = $each_item['qty'] * $product_price;
				$subtotal += $pricetotal;
				$taxtotal = $subtotal * (12 / 100);
				$grandtotal = $subtotal + $taxtotal;

				$subT = $each_item['qty'] * $product_price;

				$register_data = array(
				'ordDet_qty' 			=> $each_item['qty'],
				'ordDet_subTotal' 		=> $subT,
				'prd_id' 				=> $product_id,
				'ord_id' 				=> getOrderID()			
				);
				save_items_order($register_data);
				$i++;
			}
			$dateTime = date('Y-m-d H:i:s');

			$orders = array(
				'ord_deliver_to' 		=> $_POST['del_add'],
				'ord_billing_to' 		=> $_POST['bill_add'],
				'ord_grandTotal' 		=> $grandtotal,
				'ord_datePlace' 		=> $dateTime,
				'user_id' 				=> $session_user_id				
			);
			place_order($orders);
			unset($_SESSION['cart_array']);
			header('Location: order.php?success_order');
			exit();
		}
	}
?>
<h1 class='section-title' id='our'>Order</h1>

<div class='container' id='menu-category'>
	<ul>
		<a href='order.php#our'><li>All</li></a>
		<?php
			$result = mysql_query("SELECT * FROM `categories`");

			while ($row = mysql_fetch_array($result)){
				echo "<a href='order.php?cat=" . $row['cat_id'] . "#our'><li>" . $row['cat_name'] . "</li></a>";					
	        }
 		?>
		<a href='order.php?cmd=emptycart'><li>Empty your cart</li></a>
	</ul>
	<div class='clearer'></div>
</div>

<div class ='container' id='inventory'>
<div class='two-col'>
	<div class="main" style='width:630px;'>

	 	<?php

	 	if(isset($_GET['cat'])){
	 		$cat_id = $_GET['cat'];
	 		$cat_id = mysql_real_escape_string($cat_id);
	 		$result = mysql_query("SELECT * FROM products WHERE prd_status != 'Unavailable' AND cat_id = $cat_id")  or die(mysql_error());
	 		echo "<h3>". mysql_result(mysql_query("SELECT `cat_name` FROM `categories` WHERE `cat_id` = $cat_id"), 0) . "</h3>";
	 	}else{
	 		$result = mysql_query("SELECT * FROM products WHERE prd_status != 'Unavailable'")  or die(mysql_error());
	 		echo "<h3>All Products</h3>";
	 	}
			While($row = mysql_fetch_array($result)){ ?>
		        <div class="view view-first">
		            <img src="<?php echo $row['prd_imgLoc']; ?>" />
		            <div class="mask">
			            <h2><?php echo $row['prd_name']; ?></h2>	
			            <p><?php echo $row['prd_desc']; ?></p>
			            <h2 id='lbl-price'>Php <?php echo $row['prd_price']; ?></h2>
			        	<a href="order.php?toCart=<?php echo $row['prd_id']; ?>" class="info">Add to cart</a>
			        </div>
                </div>
				<?php }
	    ?>	
                
    </div></div>
    
 
    <aside id='summary' class='two-col' style='padding-top: 30px; max-height:500px;'>
		<div class='clearer'></div>
		<h3>Order information</h3>
		<div id='steps'>
			<a id='li_tab1' onclick='tab("tab1")' class='active'>Cart</a>
			<a id='li_tab2' onclick='tab("tab2")'>Delivery</a>
			<a id='li_tab3' onclick='tab("tab3")'>Billing</a>
			<a id='li_tab4' onclick='tab("tab4")'>Check-out</a>
		</div>
		<div id='tab1' >
			<table id='summary'>
				<tr style='border-bottom: 1px solid #C86432;background: #fff; color:rgb(50,5,5);font-weight:bold'>
					<td> </td>
					<td width='80px'>Item</td>
					<td>Qty</td>
					<td>Price</td>
					<td>Amount</td>
					
				</tr>
				<?php echo $output; ?>
			</table>
			<h4 style='font-family:arial'>Subtotal : Php. <?php echo number_format($subtotal, 2, '.', ' '); ?></h4>
			<h4 style='font-family:arial'>Tax ( 12% ) : Php. <?php echo number_format($taxtotal, 2, '.', ' '); ?></h4>
			<h4 style='font-family:arial'>Grandtotal : Php. <?php echo number_format($grandtotal, 2, '.', ' '); ?></h4>
		</div>
		
		<div id='tab2' style='display:none'>
			<br><h5>Deliver to this Address</h5>
			<form action='order.php' method='POST' style='padding-left: 0px;'>
				<select name='delivery_add' onclick="setRDel(this.value)" style='width:230px;'>
					<?php

						$result = mysql_query("SELECT * FROM `address` WHERE `user_id` = $session_user_id");

						while ($row = mysql_fetch_array($result)){
							$address = $row['add_person']."  @  ".$row['add_houseNo']." ". $row['add_building'] . " " .$row['add_street']. " ". $row['add_brgySubd']. " ". $row['add_city'];
							echo "<option value='". $address ."'>" . $address ."</option>";						
		        		}

		        		if(mysql_affected_rows() == 0){
		        			echo "<option value='empty'>No saved address</option>";
		        		}
	 				?>
					<option value='empty' id='showform'>New Address</option>
				</select><br>
				<small style='font-size:11px;color:red'>Please kindly check the selected address.</small><br>
				<div id='address-form' style='display:none;margin-top:20px;'>
					<label>Fullname :</label><br>
					<input type='text' name='add_name1'><br>
					<label>Unit/House/Door No :</label><br>
					<input type='text' name='add_door1'><br>
					<label>Building name :</label><br>
					<input type='text' name='add_build1'><br>
					<label>Street :</label><br>
					<input type='text' name='add_street1'><br>
					<label>Barangay/Subdivision :</label><br>
					<input type='text' name='add_brgy1'><br>
					<label>City :</label><br>
						<select name='add_city1'>
							<option value='Davao City'>Davao City</option>
						</select>
					<br><br>
					<input type='submit' name='action' value='Save Address'><br><br>
				</div>
			
		</div>

		<div id='tab3' style='display:none'>
			<br>
			<h5>Payment through :&nbsp;&nbsp;&nbsp;
			
				<select name='pay_by' style='width:80px;'>
						<option value='cash' id='show-bill1'>Cash</option>
						<option value='paypal' id='show-bill2'>PayPal</option>
				</select></h5>
				<div id='bill1'>
						<h5>Payment to this Address</h5>
						
						<select name='billing_add' style='width:230px;' onclick='setRBill(this.value)'>
							<?php
								$address2 ='';
								$result = mysql_query("SELECT * FROM `address` WHERE `user_id` = $session_user_id");

								while ($row = mysql_fetch_array($result)){
									$address2 = $row['add_person']."  @  ".$row['add_houseNo']." ". $row['add_building'] . " " .$row['add_street']. " ". $row['add_brgySubd']. " ". $row['add_city'];
									echo "<option value='". $address2 ."'>" . $address2 ."</option>";						
				        		}

				        		if(mysql_affected_rows() == 0){
				        			echo "<option value='empty'>No saved address</option>";
				        		}
			 				?>
							<option value='empty' id='showform2'>New Addresss</option>
						</select><br>
				<small style='font-size:11px;color:red'>Please kindly check the selected address.</small><br>
						
						<div id='address-form2' style='display:none;margin-top:20px;'>
							<label>Fullname :</label><br>
							<input type='text' name='add_name2'><br>
							<label>Unit/House/Door No :</label><br>
							<input type='text' name='add_door2'><br>
							<label>Building name :</label><br>
							<input type='text' name='add_build2'><br>
							<label>Street :</label><br>
							<input type='text' name='add_street2'><br>
							<label>Barangay/Subdivision :</label><br>
							<input type='text' name='add_brgy2'><br>
							<label>City :</label><br>
								<select name='add_city2'>
									<option value='Davao City'>Davao City</option>
								</select>
							<br><br>
							<input type='submit' name='action' value='*Save Address'><br><br>
						</div>
				</div>
				<div id='bill2' style='display:none'>
					<h5>Pay with PayPal</h5>
					<div style='max-width:250px;border:1px solid #C86432;margin-left:10px;padding:10px;background:#fff;color:#320A0A;text-align:left'>
						<span style='color:red;font-weight:bold'><small>We only accept cash transaction as of the moment. <i>Feature is under repair.</i></small></span>
					</div>
				</div>
			</form>
		</div>

		<div id='tab4' style='display:none;font-family:arial'><br>
			<small style='font-size:12px;font-weight:bold;color:red'>*Please kindly check first all details below.</small><br>
			<h5>Cart Review</h5>
				<table id='summary'>
					<tr style='border-bottom: 1px solid #C86432;background: #fff; color:rgb(50,5,5);font-weight:bold'>
						<td> </td>
						<td width='80px'>Item</td>
						<td>Qty</td>
						<td>Price</td>
						<td>Amount</td>
						
					</tr>
					<?php echo $output; ?>
				</table>
			
			<h5>Billing</h5>
			Subtotal : Php. <?php echo number_format($subtotal, 2, '.', ' '); ?><br>
			Tax ( 12% ) : Php. <?php echo number_format($taxtotal, 2, '.', ' '); ?><br>
			Grandtotal : Php. <?php echo number_format($grandtotal, 2, '.', ' '); ?><br>
			<form action='order.php' method='POST'>
				<h5>To be paid by/at : </h5><br><br>
					<div style='margin-left:630px;position:relative'>
						<textarea id='reviewbilling' name='bill_add' style='height:50px;width:250px;border:1px solid #C86432;margin-left:10px;padding:3px;background:#fff;color:#320A0A;text-align:left'>Please select an address in billing module.</textarea>
					</div><br>
				<h5>To be deliver to : </h5><br><br>
					<div style='margin-left:630px;position:relative'>
						<textarea id='reviewdelivery' name='del_add' style='height:50px;width:250px;border:1px solid #C86432;margin-left:10px;padding:3px;background:#fff;color:#320A0A;text-align:left'>Please select an address in delivery module.</textarea>
					</div><br><br>

				<input type='submit' name='action' value='Check out'>
			</form>
		</div>
	</aside>
	
	<div class='clearer'></div>
	
</div>

<?php } 
	if (isset($_GET['success_order'])){
		include 'includes/widgets/a-links.php';
	}
	include 'includes/overall/footer.php'; 
//FOOTER
?>


<script type="text/javascript">
//SOME JAVASCRIPTS

 function setRDel(value){
 	if(value === 'empty'){
 		value = 'Please select an address in delivery module.';
 	}
 	document.getElementById('reviewdelivery').innerHTML = value;
 }

 function setRBill(value){
 	if(value === 'empty'){
 		value = 'Please select an address in billing module.';
 	}
 	document.getElementById('reviewbilling').innerHTML = value;
 }



	function tab(tab) {
	document.getElementById('tab1').style.display = 'none';
	document.getElementById('tab2').style.display = 'none';
	document.getElementById('tab3').style.display = 'none';
	document.getElementById('tab4').style.display = 'none';
	document.getElementById('li_tab1').setAttribute('class', '');
	document.getElementById('li_tab2').setAttribute('class', '');
	document.getElementById('li_tab3').setAttribute('class', '');
	document.getElementById('li_tab4').setAttribute('class', '');
	document.getElementById(tab).style.display = 'block';
	document.getElementById('li_'+tab).setAttribute('class', 'active');
	}

	$("select").change(function(){
    if($("#showform").is(":selected")){
        $("#address-form").slideDown("slow");
    } else { $("#address-form").slideUp("slow"); }
 });

 $("select").change(function(){
    if($("#showform2").is(":selected")){
        $("#address-form2").slideDown("slow");
    } else { $("#address-form2").slideUp("slow"); } 
 });

 $("select").change(function(){
    if($("#show-bill1").is(":selected")){
        $("#bill1").slideDown("slow");
    } else { $("#bill1").slideUp("slow"); } 
 });

  $("select").change(function(){
    if($("#showform2").is(":selected")){
        $("#showAdd").slideUp("slow");
    } else { $("#showAdd").slideDown("slow"); } 
 });

    $("select").change(function(){
    if($("#showform").is(":selected")){
        $("#showAdd2").slideUp("slow");
    } else { $("#showAdd2").slideDown("slow"); } 
 });

 $("select").change(function(){
    if($("#show-bill2").is(":selected")){
        $("#bill2").slideDown("slow");
    } else { $("#bill2").slideUp("slow"); } 
 });
      

</script>	