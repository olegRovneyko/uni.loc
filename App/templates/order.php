<?php
	$num = (string)$order->id;
	$str = str_pad($num, 8, '0', STR_PAD_LEFT);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Заказ № <?= $str ?></title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/jquery-ui.min.css" rel="stylesheet">
	<link href="css/styles.css" rel="stylesheet">
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-3">
				<div class="panel panel-default preview">
					<img src="img/orders/<?= $order->image ?>" alt="" class="img-responsive">
				</div>
			</div>
			<div class="col-md-9" id="oneOrder">
				<h2>Заказ № <?= $str ?></h2>
				<form  class="form-horizontal" role="form" method="POST" action="<?= $_SERVER[REQUEST_URI]; ?>" id="editOrder" enctype="multipart/form-data">

								<div class="control-group">
									<label class="control-label" for="description">описание заказа:</label>
									<textarea class="form-control" rows="3" id="description" name="description"><?= $order->description; ?></textarea>
								</div>
								<div class="clearfix">
									<div class="control-group pull-left">
										<label class="control-label" for="orderDate">дата:</label>
										<input type="text" id="orderDate" name="orderDate" class="form-control" value="<?php echo date('d.m.Y' ,$order->date) ?>">
									</div>
									<div class="control-group pull-right">
										<label class="control-label" for="picture">картинка: <small>не обязательна</small></label>
										<input type="file" id="picture" name="picture" class="form-control">
									</div>
								</div>
								<div class="clearfix">
									<div class="control-group pull-left">
										<label class="client control-label" for="client">заказчик:</label>
										<select name="client_id" id="client" class="form-control">
											<?php foreach ($clients as $client) { ?>
											<?php if ($client->actual != 1) {
												continue;
											} ?>											<option value="<?= $client->id ?>"
											<?php if ($order->client_id == $client->id) echo ' selected'; ?>
											><?= $client->name ?></option>
											<?php } ?>
										</select>
									</div>
									<div class="control-group pull-right">
										<label class="control-label" for="cratio">цена за единицу: </label>
										<input type="text" id="cratio" name="cratio" class="form-control" value="<?= $order->cratio ?>">
									</div>
								</div>
								<div class="clearfix">
									<div class="checkbox pull-left" style="padding-top: 10px">
										<label>
											<input type="checkbox" name="paid" value="1"
											<?php if ($order->paid == 1) : ?>
												 checked
											<?php endif; ?>
											> оплачено
										</label>
									</div>
								</div>
								<hr>
								<div class="clearfix">
									<div class="control-group pull-left">
										<label class="control-label" for="performer">исполнитель:</label>
										<select name="performer_id" id="performer" class="form-control">
											<?php foreach ($performers as $performer) { ?>
											<option value="<?= $performer->id ?>"
											<?php if ($order->performer_id == $performer->id) echo ' selected'; ?>
											><?= $performer->name ?></option>
											<?php } ?>
										</select>
									</div>
									<div class="control-group pull-right">
										<label class="control-label" for="pratio">коєф. для исполнителя: </label>
										<input type="text" id="pratio" name="pratio" class="form-control" value="<?= $order->pratio ?>">
									</div>
								</div>

								<ul class="nav nav-tabs" style="margin-top: 10px">
									<li class="active"><a href="#piecework" data-toggle="tab">сдельная оплата</a></li>
									<li><a href="#hourly" data-toggle="tab">почасовая оплата</a></li>
								</ul>
								<div class="tab-content">
									<div class="tab-pane active" id="piecework">
										<div class="clearfix">
											<div class="control-group pull-left">
												<label class="control-label" for="colors">цветность:</label>
												<input type="text" id="colors" name="colors" class="form-control" value="<?= $order->colors ?>">
											</div>
											<div class="control-group pull-right">
												<label class="control-label" for="quantity">тираж:</label>
												<input type="text" id="quantity" name="quantity" class="form-control" value="<?= $order->quantity ?>">
											</div>
										</div>
										<div class="clearfix">
											<div class="checkbox pull-left"  style="padding-top: 10px">
												<label>
													<input type="checkbox" name="formPlus" value="1"
													<?php if ($order->form == 1) : ?>
														 checked
														<?php endif; ?>
													> изготовление формы
												</label>
											</div>
										</div>
									</div>
								<div class="tab-pane" id="hourly">
									<div class="clearfix">
										<div class="control-group pull-left">
											<label class="control-label" for="hours">часы:</label>
											<input type="text" id="hours" name="hours" class="form-control" value="<?= $order->hours ?>">
										</div>
									</div>
								</div>
							</div>

								<div class="control-group top-indent">
									<a href="<?= $_SERVER["HTTP_REFERER"] ?>" class="btn btn-success"><span class="glyphicon glyphicon-chevron-left"></span> Назад</a>
									<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ok"></span> Отредактировать заказ</button>
									<a href="/index.php?action=Delete&id=<?= $_GET['id'] ?>" class="btn btn-danger pull-right"><span class="glyphicon glyphicon-thumbs-down"></span> Удалить заказ</a>
								</div>
						</form>
					</div>
			</div>
		</div>
	</div>

	<script src="/App/templates/js/jquery.min.js"></script>
	<script src="/App/templates/js/bootstrap.min.js"></script>
	<script src="/App/templates/js/jquery-ui.min.js"></script>
	<script src="/App/templates/js/jquery.validate.min.js"></script>

	<script>
		$(function() {
			$.datepicker.regional['ru'] = {
				closeText: 'Закрыть',
				prevText: '&#x3c;Пред',
				nextText: 'След&#x3e;',
				currentText: 'Сегодня',
				monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь',
				'Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
				monthNamesShort: ['Янв','Фев','Мар','Апр','Май','Июн',
				'Июл','Авг','Сен','Окт','Ноя','Дек'],
				dayNames: ['воскресенье','понедельник','вторник','среда','четверг','пятница','суббота'],
				dayNamesShort: ['вск','пнд','втр','срд','чтв','птн','сбт'],
				dayNamesMin: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'],
				dateFormat: 'dd.mm.yy',
				firstDay: 1,
				isRTL: false
			};

			$.datepicker.setDefaults($.datepicker.regional['ru']);

			$("#orderDate").datepicker();
			$("a.btn.btn-danger.pull-right").on('click',
				function(e) {
					var answer = confirm('Вы уверены?');
					if (answer == false) {
						e.preventDefault();
					}
				}
			);
		});
	</script>
</body>
</html>