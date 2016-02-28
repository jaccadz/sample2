<?php
//INITIALIZATION
	include 'core/init.php';
	include 'includes/overall/header.php';
?>

<h1 class='section-title' id='our'>Our Menu</h1>
<div class='container' id='menu-category'>
	<ul>
		<a href='product_menu.php#our'><li>All</li></a>
		<?php
			$result = mysql_query("SELECT * FROM `categories`");

			while ($row = mysql_fetch_array($result)){
				echo "<a href='product_menu.php?cat=" . $row['cat_id'] . "#our'><li>" . $row['cat_name'] . "</li></a>";					
	        }
 		?>
		<a href='order.php'><li>ORDER NOW !</li></a>
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
			             <a href="order.php?toCart" class="info">Order now</a>
			        </div>

                </div> 	
				<?php }
	    ?>	
                
    </div>
	</div>
	<?php include 'includes/aside.php'; ?>
	<div class='clearer'></div>
</div>



<?php include 'includes/overall/footer.php'; ?>