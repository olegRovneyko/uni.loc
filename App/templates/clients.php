<?php
require __DIR__ . '/inc/head.php';
?>
<body>
	<?php
	require 'inc/nav.php';
	?>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h2>Заказчики</h2>
				<table class="table table-hover table-responsive">
					<thead>
						<tr>
							<th>заказчик</th>
							<th>телефон</th>
							<th>e-mail</th>
							<th>адрес</th>
							<th>примечание</th>
							<th>активн</th>
							<th>изменить</th>
						</tr>
					</thead>
					<tbody>
					<?php foreach ($clients as $client) : ?>
						<tr>
							<td><?= $client->name ?></td>
							<td><?= $client->phone ?></td>
							<td><?= $client->email ?></td>
							<td><?= $client->address ?></td>
							<td><?= $client->description ?></td>
							<td><?php
							 if ($client->actual == 1) {
							 	echo '<span class="glyphicon glyphicon-ok" style="color: green"></span>';
							 } else {
							 	echo '<span class="glyphicon glyphicon-remove" style="color: red"></span>';
							 }
							 ?></td>
							<td><a href="<?php echo $_SERVER['PHP_SELF'] . '?controller=client&action=One&id=' . $client->id ?>"><span class="glyphicon glyphicon-edit"></a></td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>

		<div class="row new-client">
			<div class="col-md-12">
				<button class="btn btn-success btn-lg" data-toggle="modal" data-target="#newClient"><span class="glyphicon glyphicon-pencil"></span> Добавить нового заказчика</button>
			</div>
		</div>

		<div class="modal fade" id="newClient" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="myModalLabel">
							Добавить нового заказчика
						</h4>
						</div>

						<form  class="form-horizontal" role="form" method="POST" action="<?= $_SERVER[REQUEST_URI]; ?>" id="addClient"  enctype="multipart/form-data">

							<div class="modal-body">
								<div class="clearfix">
									<div class="control-group pull-left">
										<label class="control-label" for="name">имя:</label>
										<input type="text" id="name" name="name" class="form-control">
									</div>
									<div class="control-group pull-right">
										<label class="control-label" for="picture">картинка: <small>не обязательна</small></label>
										<input type="file" id="picture" name="picture" class="form-control">
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="phone">телефоны: <small>не обязательно</small></label>
									<input type="text" id="phone" name="phone" class="form-control">
								</div>
								<div class="control-group">
									<label class="control-label" for="email">e-mail: <small>не обязательно</small></label>
									<input type="text" id="email" name="email" class="form-control">
								</div>
								<div class="control-group">
									<label class="control-label" for="address">адрес: <small>не обязательно</small></label>
									<input type="text" id="address" name="address" class="form-control">
								</div>
								<div class="control-group">
									<label class="control-label" for="description">примечание: <small>не обязательно</small></label>
									<textarea class="form-control" rows="3" id="description" name="description"></textarea>
								</div>
								<div class="checkbox">
										<label>
											<input type="checkbox" name="actual" value="1" checked> активный
										</label>
								</div>

							</div>

							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
								<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ok"></span> Добавить заказчика</button>
							</div>

						</form>
					</div><!-- /.modal-content -->
				</div><!-- /.modal-dialog -->
			</div><!-- /.modal -->

	</div>
		<script src="/App/templates/js/jquery.min.js"></script>
		<script src="/App/templates/js/bootstrap.min.js"></script>
		<script src="/App/templates/js/jquery-ui.min.js"></script>
		<script src="/App/templates/js/jquery.validate.min.js"></script>
		<script>
		$("#addClient").validate({
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
</html>
