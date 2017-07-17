<?php
require __DIR__ . '/inc/head.php';
?>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-3">
				<div class="panel panel-default preview">
					<img src="/App/templates/img/clients/<?= $client->image ?>" alt="" class="img-responsive">
				</div>
			</div>
			<div class="col-md-9">
				<h2>Заказчик: <?= $client->name ?></h2>
				<form  class="form-horizontal" role="form" method="POST" action="<?= $_SERVER[REQUEST_URI]; ?>" id="editClient" enctype="multipart/form-data">

					<div class="clearfix">
						<div class="control-group pull-left">
							<label class="control-label" for="name">имя:</label>
							<input type="text" id="name" name="name" class="form-control" value="<?= $client->name ?>">
						</div>
						<div class="control-group pull-right">
							<label class="control-label" for="picture">картинка: <small>не обязательна</small></label>
							<input type="file" id="picture" name="picture" class="form-control">
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="phone">телефон:</label>
						<input type="text" id="phone" name="phone" class="form-control"  value="<?= $client->phone ?>">
					</div>
					<div class="control-group">
						<label class="control-label" for="email">e-mail:</label>
						<input type="text" id="email" name="email" class="form-control"  value="<?= $client->email ?>">
					</div>
					<div class="control-group">
						<label class="control-label" for="address">адрес:</label>
						<input type="text" id="address" name="address" class="form-control"  value="<?= $client->address ?>">
					</div>
					<div class="control-group">
						<label class="control-label" for="description">примечание:</label>
						<textarea class="form-control" rows="3" id="description" name="description"><?= $client->description ?></textarea>
					</div>
					<div class="checkbox">
							<label>
								<input type="checkbox" name="actual" value="1"
								<?php if ($client->actual == 1) : ?>
								 checked
								<?php endif; ?>
								 > активный
							</label>
					</div>
					<div class="control-group top-indent">
						<a href="<?= $_SERVER["HTTP_REFERER"] ?>" class="btn btn-success"><span class="glyphicon glyphicon-chevron-left"></span> Назад</a>
						<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ok"></span> Отредактировать данные</button>
					</div>

				</form>
			</div>
		</div>
	</div>
	<script src="/App/templates/js/jquery.min.js"></script>
	<script src="/App/templates/js/bootstrap.min.js"></script>
	<script src="/App/templates/js/jquery-ui.min.js"></script>
	<script src="/App/templates/js/jquery.validate.min.js"></script>
	<script>
		$("#editClient").validate({
			rules: {
				name: {
					required: true
				}
			},
			messages: {
				name: {
					required: "Это поле обязательно для заполнения"
				}
			}
		});
	</script>
</body>