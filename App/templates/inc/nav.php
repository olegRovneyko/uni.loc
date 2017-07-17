<nav role="navigation" class="navbar navbar-default navbar-fixed-bottom">
			<div class="container">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
					<button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a href="#" class="navbar-brand">
					 <img src="/App/templates/img/logo.png" alt="" height="40" style="padding: 0 15px 0 0; margin: -10px 0">
					</a>
				</div>
				<div id="navbarCollapse" class="collapse navbar-collapse">
					<ul class="nav navbar-nav">
						<?php
						if ($_GET['controller'] == 'client') {
							$a = $b = '';
							$c = ' class="active"';
						} elseif ($_GET['controller'] == 'performer') {
							$a = $c = '';
							$b = ' class="active"';
						} else {
							$b = $c = '';
							$a = ' class="active"';
						}
						?>
						<li<?= $a ?>><a href="index.php">Заказы</a></li>
						<li<?= $b ?>><a href="<?php echo 'index.php?controller=performer' ?>">Исполнители</a></li>
						<li<?= $c ?>><a href="<?php echo 'index.php?controller=client' ?>">Заказчики</a></li>
					</ul>
<!-- 					<ul class="nav navbar-nav navbar-right">
	<li><a href="#">Войти</a></li>
</ul> -->
				</div>
			</div>
		</nav>