<header>

	<!-- if user is Admin -->
	<?php include 'menu.php'; ?>

	<div class='container'>

		<!-- if page is index.php -->
		<?php include 'includes/widgets/slider.php'; ?>

		<?php 
			if (logged_in() === true){
				include 'includes/widgets/loggedin.php';
			}else{
				include 'includes/widgets/login.php'; 
			}
		?>

			
			
	</div>

</header> <!-- **********  END HEADER  *************8 -->