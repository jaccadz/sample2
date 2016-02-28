<?php
//INITIALIZATION
	include 'core/init.php';
	include 'includes/overall/header.php';
?>

<?php
// SUCCESS NOTE
	if (isset($_GET['success_add']) && empty($_GET['success_add'])){
		echo "<div class='general-note' style='height:50px; padding-top: 40px;display:block; margin-bottom:9px; margin-top:-9px; margin-bottom: 0px;'>
				<p>New product record was added in the inventory. Please check it &nbsp; <a href='inventory.php' style='text-decoration: underline; color:orange;'><u>out.</u></a></p>
			   </div>";	
	}else if (isset($_GET['success_delete']) && empty($_GET['success_delete'])){
		echo "<div class='general-note' style='height:50px; padding-top: 40px;display:block; margin-bottom:9px; margin-top:-9px; margin-bottom: 0px;'>
				<p>Selected product was deleted in the inventory. Please check it &nbsp; <a href='inventory.php' style='text-decoration: underline; color:orange;'><u>out.</u></a></p>
			   </div>";	
	}else
	{
?>

<?php
//ERROR TRAPPINGS FOR ADDING A PRODUCT
	if  (isset($_POST['action']) && $_POST['action'] == 'Add this product'){
		if(empty($errors) === true){
			if(product_exists($_POST['pr_name']) === true){
				$errors[] = 'Product name is alread used. Please try another one.';
			}
		}
	}
?>

<?php
//ADDING A PRODUCT
	if (isset($_POST['action']) && $_POST['action'] == 'Add this product'){

		if(isset($_FILES['pr_img']) === true){
			if(empty($_FILES['pr_img']['name']) === true){
				$file_path = 'resources/uploads/default.jpg';
			}else{
				$allowed = array('jpg', 'jpeg', 'gif', 'png');

				$file_name = $_FILES['pr_img']['name'];
				$file_extn = strtolower(end(explode('.', $file_name)));
				$file_temp = $_FILES['pr_img']['tmp_name'];

				if(in_array($file_extn, $allowed) === true){
					$file_path = 'resources/uploads/' . substr(md5(time()), 0, 10) . '.' . $file_extn;
					move_uploaded_file($file_temp, $file_path);
				}else{
					$errors[] = 'Incorrect image file type. Only allowed jpg, jpeg, png and gif images.';
				}
			}
		}

		if(empty($errors) === true){
			$register_data = array(
			'prd_name' 		=> $_POST['pr_name'],
			'prd_price' 	=> $_POST['pr_price'],
			'prd_desc' 		=> $_POST['pr_desc'],
			'cat_id' 		=> $_POST['c_id'],
			'prd_imgLoc' 	=> $file_path
			);
			add_product($register_data);
			header('Location: inventory.php?success_add');
			exit();
		}
	}
?>

<?php
//DELETE A PRODUCT
	if(isset($_GET['delete_product'])){
		echo "<div class='general-note' style='display:block; margin-bottom:9px; margin-top:-9px;'><p>";
		echo "Do you really want to delete <b>". $_GET['delete_product'] ."</b> ? Please press, ";
		echo "<a href='inventory.php?yesdelete_product=". $_GET['delete_product'] ."' style='color:red;padding-left:3px; text-decoration:underline'>Yes</a> | ";
		echo "<a href='inventory.php' style='color:lightgreen;padding-left:3px; text-decoration:underline'>No</a>";
		echo "</p></div>";
	}

	if(isset($_GET['yesdelete_product'])){
		del_product($_GET['yesdelete_product']);
		header('Location: inventory.php?success_delete');
		exit();
	}
?>

<?php
//OUTPUT ERRORS
	if(empty($errors) === false){ ?>
		<div class='general-note' style='display:block; margin-bottom:9px; margin-top:-9px; border-color:red; color:lightred'><p> 
			<?php echo output_errors($errors);?>
		</p></div><?php
	}
?>



<h1 class='section-title'>Inventory</h1>


<div class ='container' id='inventory' style='width:905px; padding: 0 35px;'>
	<h3>Add Product</h3>

	<div class='data-container'>

		<img src="resources/uploads/default.jpg" id='prev-img' alt='Product Photo Here'>	
		<form action='' method='POST' enctype='multipart/form-data'>
			<label>Product name : </label>
			<input type='text' name='pr_name' required><br>
			<label>Price : </label>
			<input type='text' name='pr_price' onkeypress="return isNumberKey(event)" required/><br>
			<label>Category : </label>
			<select name='c_id'>
				<?php
					$result = mysql_query("SELECT * FROM `categories`");

					while ($row = mysql_fetch_array($result)){
						echo "<option value='". $row['cat_id'] ."'>" . $row['cat_name']."</option>";						
	        		}
 				?>
			</select>
			<input type='button' style='width:45px;' value='+' title='Add Category' onclick="">
			<br>
			<label>Photo : </label>
			<input type='file' name='pr_img' id='img-file' onclick='index.php'>
			<label id='lbl-desc'>Description : </label>
			<textarea name='pr_desc'></textarea>
			<input id='button' type='submit' value='Add this product' name='action'>
		</form>
		<div class='clearer'></div>
	</div><br>


	<h3 id='our'>Product List</h3>
	<div id='list-menu'>
		<ul>
			<form action='' method='POST'>
				<input type='submit' name='action' value='View all'>
				<input style='margin-left: 80px;' id='search' type='text' name='search' placeholder='Search Keyword'>
				<input type='submit' name='action' value='Search'>
				<!- SORTING SELECT TYPE ->
			</form>
		</ul>
	</div>
	<div class="list-wrap">
	    <table class="head">
	        <tr>
	            <td style='width:150px;'>Photo</td>
	            <td>Name</td>
	            <td style='width:70px;'>Price</td>
	            <td>Description</td>
	            <td style='width:90px;'>Category</td>
	            <td style='width:60px;'>Status</td>
	            <td style='width:100px;'>Action</td>
	        </tr>
	    </table>
	    <div class="inner_table">
	        <table id='data-list'>
	        	<?php

	        		if (isset($_POST['action']) && $_POST['action'] == 'Search'){
	        			$keyword = $_POST['search'];

						$result = mysql_query("SELECT 		p.prd_id, p.prd_name, p.prd_price, p.prd_desc,p.prd_imgLoc,p.prd_status,c.cat_name,c.cat_status,p.cat_id
										   FROM 		categories AS c ,products AS p
										   WHERE 		c.cat_id = p.cat_id AND p.prd_status != 'Unavailable' AND (p.prd_name LIKE '%$keyword%' || c.cat_name LIKE '%$keyword%')
										   ORDER BY 	p.prd_id DESC")  or die(mysql_error());
					}else{
						$result = mysql_query("SELECT 		p.prd_id, p.prd_name, p.prd_price, p.prd_desc,p.prd_imgLoc,p.prd_status,c.cat_name,c.cat_status,p.cat_id
										   FROM 		categories AS c ,products AS p
										   WHERE 		c.cat_id = p.cat_id AND p.prd_status != 'Unavailable'
										   ORDER BY 	p.prd_id DESC")  or die(mysql_error());
					}

					While($row = mysql_fetch_array($result)){
		            			
						if($row['prd_status'] === 'Available'){
			            	echo "<tr>".
			            		 "<td style='width:150px; height:120px;'><img src=' ". $row['prd_imgLoc'] . "'></td>" .
								 "<td>". $row['prd_name'] . "</td>" .
								 "<td style='width:70px;'> Php. ". $row['prd_price'] . "</td>" . 
								 "<td>". $row['prd_desc'] . "</td>" .
								 "<td style='width:90px;'>". $row['cat_name'] . "</td>" .
							     "<td style='width:60px;'>". $row['prd_status'] . "</td>" . 
							     "<td style='width:100px;'>
									<a href='inventory.php?delete_product=". $row['prd_name']."' style='color:red;padding-left:3px; text-decoration:underline'>Delete</a> | 
									<a href='inventory_edit.php?update_id=". $row['prd_id']."' style='color:green;padding-left:3px; text-decoration:underline'>Edit</a>
								  </td>" . 
								  "</tr>";
						}
					}

	            ?>
	   	 	</table>
    	</div>
	</div>
	<div class='clearer'></div>
</div>



<?php } 
	if (isset($_GET['success_add']) || isset($_GET['success_delete'])){
		include 'includes/widgets/a-links.php';
	}
	include 'includes/overall/footer.php'; 
//FOOTER
?>


<script type="text/javascript">
//SOME JAVASCRIPT
	function isNumberKey(evt){
	    var charCode = (evt.which) ? evt.which : event.keyCode
	    if (charCode > 31 && (charCode != 46 &&(charCode < 48 || charCode > 57)))
	        return false;
	    return true;
	}

	function readURL(input) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();

	        reader.onload = function (e) {
	            $('#prev-img').attr('src', e.target.result);
	        }

	        reader.readAsDataURL(input.files[0]);
	    }
	}

	$("#img-file").change(function(){
    readURL(this);	
	});


</script>