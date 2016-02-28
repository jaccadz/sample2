		<div class='container' id='main-nav'>
			<a title="Home Page" class="logo" href='index.php'></a>     
			<nav class='slide-line'>
				<a id='nav-active' class='active' href='index.php'>Home</a>
				<a id='nav-about' href="about.php">About</a>
				<a id='nav-menu' href="product_menu.php">Menu</a>
				<a id='nav-order' href="order.php">Order</a>
				<a id='nav-contact' href="contact.php">Contacts</a>
				

			
				<?php if (logged_in() === true){ 
					if ($user_data['user_type'] === 'Admin'){ ?>
					<div class='user-nav' id='admin-nav'>
						<ul id='menu'>
							<li>ADMIN
								<ul class='sub-menu'>
									<li><a href='inventory.php'>Inventory</a></li>
									<li><a href='order_list.php' >Orders</a></li>
								</ul>
							</li>
						</ul>
					</div><?php 
					}?>
					<div class='user-nav' style='display:block'>
				<?php 
				}else{ ?>
					<div class='user-nav' style='display:none'>
				<?php } ?>
				<ul id='menu'>
					<li><?php echo $user_data['user_fname'] . ' ^'; ?> 
						<ul class='sub-menu'>
							<li><a href='settings.php'>Account Settings</a></li>
							<li><a href='password.php'>Change password</a></li>
							<li><a href='logout.php' style='border-top: 1px solid #c86432; width:110px' >Logout</a></li>
						</ul>
					</li>
				</ul>
				</div>
			</nav>
		</div>