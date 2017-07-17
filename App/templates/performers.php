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
				<h2>Исполнители</h2>
				<table class="table table-hover table-responsive">
					<thead>
						<tr>
							<th>исполнители</th>
							<th>телефон</th>
							<th>адрес</th>
							<th>примечание</th>
							<th>активн</th>
							<th>изменить</th>
						</tr>
					</thead>
					<tbody>
					<?php foreach ($performers as $performer) : ?>
						<tr>
							<td><?= $performer->name ?></td>
							<td><?= $performer->phone ?></td>
							<td><?= $performer->address ?></td>
							<td><?= $performer->description ?></td>
							<td><?php
							 if ($performer->actual == 1) {
							 	echo '<span class="glyphicon glyphicon-ok" style="color: green"></span>';
							 } else {
							 	echo '<span class="glyphicon glyphicon-remove" style="color: red"></span>';
							 }
							 ?></td>
							<td><a href="<?php echo $_SERVER['PHP_SELF'] . '?controller=performer&action=One&id=' . $performer->id ?>"><span class="glyphicon glyphicon-edit"></a></td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
		<div class="row new-performer">
			<div class="col-md-12">
				<button class="btn btn-success btn-lg" data-toggle="modal" data-target="#newPerformer"><span class="glyphicon glyphicon-pencil"></span> Добавить нового исполнителя</button>
			</div>
		</div>

		<div class="modal fade" id="newPerformer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="myModalLabel">
							Добавить нового исполнителя
						</h4>
						</div>

						<form  class="form-horizontal" role="form" method="POST" action="<?= $_SERVER[REQUEST_URI]; ?>" id="addPerformer" enctype="multipart/form-data">

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
									<label class="control-label" for="phone">телефоны:</label>
									<input type="text" id="phone" name="phone" class="form-control">
								</div>
								<div class="control-group">
									<label class="control-label" for="address">адрес:</label>
									<input type="text" id="address" name="address" class="form-control">
								</div>
								<div class="control-group">
									<label class="control-label" for="description">примечание:</label>
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
								<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ok"></span> Добавить исполнителя</button>
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
	$("#addPerformer").validate({
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