
    <!-- Page Wrapper -->
	 <style>
			/* Custom Sidebar Styling */
			.custom-sidebar {
				background: linear-gradient(180deg, #2c3e50, #3498db);
			}

			.custom-sidebar .sidebar-brand-text {
				font-family: 'Poppins', sans-serif;
				font-size: 1rem;
				font-weight: bold;
				text-align: center;
			}

			.custom-sidebar .nav-link {
				font-family: 'Poppins', sans-serif;
				font-weight: 500;
				font-size: 0.95rem;
				color: #ecf0f1;
			}

			.custom-sidebar .nav-link:hover {
				background-color: rgba(255, 255, 255, 0.1);
				color: #ffffff;
				transition: 0.3s;
			}

			.custom-sidebar .nav-item.active .nav-link {
				background-color: rgba(255, 255, 255, 0.2);
				border-left: 4px solid #f1c40f;
				color: #f1c40f;
			}

			.custom-sidebar .collapse.bg-gradient-dark {
				background: linear-gradient(180deg, #34495e, #2c3e50);
			}

			.custom-sidebar .sidebar-divider {
				border-color: rgba(255, 255, 255, 0.15);
			}

			.sidebar-brand-icon i {
				font-size: 1.5rem;
				color: #f1c40f;
			}
	</style>

    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav sidebar sidebar-dark accordion custom-sidebar" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
                <div class="sidebar-brand-icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <div class="sidebar-brand-text mx-3">SD 11 <br> Fena Fafan</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider">

			<!-- QUERY MENU -->
			<?php
			$role_id = $this->session->userdata('role_id');
			$queryMenu = "SELECT `user_menu`.`id`, `menu` 
			FROM `user_menu` JOIN `user_access_menu` 
			ON `user_menu`.`id` = `user_access_menu`.`menu_id` 
			WHERE `user_access_menu`.`role_id` = $role_id 
			ORDER BY `user_access_menu`.`menu_id` ASC";

			$menu = $this->db->query($queryMenu)->result_array();
			?>
			
			<!-- LOOPING MENU -->
			<?php foreach ($menu as $m) : ?>
				<li class="nav-item">
					<strong><a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#submenu<?= $m['id']; ?>" aria-expanded="true" aria-controls="submenu">
						<span>
							<?= $m['menu']; ?>
						</span>
					</a></strong>
					<div id="submenu<?= $m['id']; ?>" class="collapse bg-gradient-dark" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
						<ul class="nav row">
							<!-- SIAPKAN SUB-MENU SESUAI MENU -->
							<?php
							$menuId = $m['id'];
							$querySubMenu = "SELECT * 
							FROM `user_sub_menu` JOIN `user_menu` 
							ON `user_sub_menu`.`menu_id` = `user_menu`.`id` 
							WHERE `user_sub_menu`.`menu_id` = $menuId 
							AND `user_sub_menu`.`is_active` = 1";
							$subMenu = $this->db->query($querySubMenu)->result_array();
							?>
							<?php foreach ($subMenu as $sm) : ?>
								<?php if ($title == $sm['title']) : ?>
									<li class="nav-item active">
									<?php else : ?>
									<li class="nav-item">
									<?php endif; ?>
									<strong><a class="nav-link pb-0" href="<?= base_url($sm['url']); ?>">
										<i class="<?= $sm['icon']; ?> text-light"></i>
										<span><?= $sm['title']; ?></span>
									</a></strong>
									</li>
								<?php endforeach; ?>
						</ul>
					</div>
				</li>
				 <hr class="sidebar-divider">
			<?php endforeach; ?>

            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('auth/logout'); ?>">
                    <strong><span>LOGOUT</span></a></strong>
            </li>

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->
