<div class="navbar-default sidebar" role="navigation">
	<div class="sidebar-nav navbar-collapse">
		<ul class="nav" id="side-menu">
			<?php $this->load->view('template/br_menu_busca'); ?>
			<li>
				<a href="home"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
			</li>
			<li>
				<a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Charts<span class="fa arrow"></span></a>
				<ul class="nav nav-second-level">
					<li>
						<a href="flot">Flot Charts</a>
					</li>
					<li>
						<a href="morris">Morris.js Charts</a>
					</li>
				</ul>
			</li>
			<li>
				<a href="tables"><i class="fa fa-table fa-fw"></i> Tables</a>
			</li>
			<li>
				<a href="forms"><i class="fa fa-edit fa-fw"></i> Forms</a>
			</li>
			<li>
				<a href="#"><i class="fa fa-wrench fa-fw"></i> UI Elements<span class="fa arrow"></span></a>
				<ul class="nav nav-second-level">
					<li>
						<a href="panels_wells">Panels and Wells</a>
					</li>
					<li>
						<a href="buttons">Buttons</a>
					</li>
					<li>
						<a href="notifications">Notifications</a>
					</li>
					<li>
						<a href="typography">Typography</a>
					</li>
					<li>
						<a href="icons"> Icons</a>
					</li>
					<li>
						<a href="grid">Grid</a>
					</li>
				</ul>
			</li>
			<li>
				<a href="#"><i class="fa fa-sitemap fa-fw"></i> Multi-Level Dropdown<span class="fa arrow"></span></a>
				<ul class="nav nav-second-level">
					<li>
						<a href="#">Second Level Item</a>
					</li>
					<li>
						<a href="#">Second Level Item</a>
					</li>
					<li>
						<a href="#">Third Level <span class="fa arrow"></span></a>
						<ul class="nav nav-third-level">
							<li>
								<a href="#">Third Level Item</a>
							</li>
							<li>
								<a href="#">Third Level Item</a>
							</li>
							<li>
								<a href="#">Third Level Item</a>
							</li>
							<li>
								<a href="#">Third Level Item</a>
							</li>
						</ul>
					</li>
				</ul>
				<!-- /.nav-second-level -->
			</li>
		</ul>
	</div>
	<!-- /.sidebar-collapse -->
</div>
