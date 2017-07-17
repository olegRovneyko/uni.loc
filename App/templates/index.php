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

					<div class="panel panel-default top-indent">
						<form class="form-inline panel-body" role="form" method="GET" action="" id="filter" style="padding: 5px">

							<div class="form-group">
									<div class="input-group">
										<div id="radioBtn" class="btn-group">
											<?php
											if (isset($_GET['sequence']) && $_GET['sequence'] == 'down') {
												$a = ' notActive';
												$b = ' active';
											} else {
												$a = ' active';
												$b = ' notActive';
											}
											?>
											<a class="btn btn-primary btn-sm<?= $a ?>" data-toggle="sequence" data-title="up">
												<span class="glyphicon glyphicon-arrow-up"></span>
											</a>
											<a class="btn btn-primary btn-sm<?= $b ?>" data-toggle="sequence" data-title="down">
												<span class="glyphicon glyphicon-arrow-down"></span>
											</a>
										</div>
										<input type="hidden" name="sequence" id="sequence" value="up">
									</div>
							</div>
							&nbsp;

							<div class="form-group">
								<label class="control-label" for="performer">исполнитель:</label>
								<select name="performer_id" id="performer" class="form-control">
									<option value="0">все</option>
									<?php
										foreach ($performers as $performer) {
											if ($performer->actual != 1) {
												continue;
											}
											echo '<option value="' . $performer->id . '"';
											if ($_GET['performer_id'] == $performer->id) {
												echo ' selected';
											}
											echo '>' . $performer->name . '</option>';
										}
									?>
								</select>
							</div>
							&nbsp;
							<div class="form-group">
								<label class="client" for="client">заказчик:</label>
								<select name="client_id" id="client" class="form-control">
									<option value="0">все</option>
									<?php
										foreach ($clients as $client) {
											if ($client->actual != 1) {
												continue;
											}
											echo '<option value="' . $client->id . '"';
											if ($_GET['client_id'] == $client->id) {
												echo ' selected';
											}
											echo '>' . $client->name . '</option>';
										}
									?>
								</select>
							</div>
							&nbsp;
							<div class="form-group">
								<label class="control-label" for="startDate">от:</label>
								<?php
									if (!empty($_GET['startDate'])) {
										$value = $_GET['startDate'];
									} else {
										$date = getdate();
										$mon = ($date['mon'] > 9) ? $date['mon'] : ('0' . $date['mon']);
										$value = '01.' . $mon . '.' . $date['year'];
									}
								?>
								<input type="text" id="startDate" name="startDate" class="form-control" value ="<?= $value ?>">
							</div>
							&nbsp;
							<div class="form-group">
								<label class="control-label" for="endDate">до:</label>
								<?php
									if (!empty($_GET['endDate'])) {
										$value = $_GET['endDate'];
									} else {
										$date = getdate();
										$day = ($date['mday'] > 9) ? $date['mday'] : ('0' . $date['mday']);
										$mon = ($date['mon'] > 9) ? $date['mon'] : ('0' . $date['mon']);
										$value = $day . '.' . $mon . '.' . $date['year'];
									}
								?>
								<input type="text" id="endDate" name="endDate" class="form-control" value ="<?= $value ?>">
							</div>
							&nbsp;
							<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-refresh"></span> Отобразить</button>
						</form>
					</div>

					<div class="panel-group" id="accordion">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="panel-title">
									<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">Оплата труда</a>
								</h4>
							</div>
							<div id="collapseOne" class="panel-collapse collapse in">
								<table class="table table-hover table-responsive" id="orders">
									<thead>
										<tr>
											<th><input type="checkbox" checked id="ischecked"></th>
											<th width="30%">описание заказа</th>
											<th>дата</th>
											<th>исполнитель</th>
											<th width="15%">заказчик</th>
											<th>цветн.</th>
											<th>форма</th>
											<th>тираж</th>
											<th>коэф.</th>
											<th>часы</th>
											<th>оплата</th>
											<th>изменить</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($orders as $order) { ?>
										<tr data-image="<?= $order->image ?>">
											<td><input type="checkbox" class="order-checkbox" checked></td>
											<td><a href="<?php echo $_SERVER['PHP_SELF'] . '?action=one&id=' . $order->id ?>"><?= $order->description ?></a></td>
											<td>
												<?php
													echo date('d.m.Y', $order->date);
												?>
											</td>
											<td><?= $order->performer ?></td>
											<td><?= $order->client ?></td>
											<td><?php
											if (0 == $order->colors) {
												echo '<span class="glyphicon glyphicon-remove" style="color: red"></span>';
											} else {
												echo $order->colors;
											}
											?></td>
											<td><?php
											 if ($order->form == 1) {
											 	echo '<span class="glyphicon glyphicon-ok" style="color: green"></span>';
											 } else {
											 	echo '<span class="glyphicon glyphicon-remove" style="color: red"></span>';
											 }
											 ?></td>
											<td><?php
											if ($order->quantity == 0) {
												echo '<span class="glyphicon glyphicon-remove" style="color: red"></span>';
											} else {
												echo $order->quantity;
											}
											?></td>
											<td><?= $order->pratio ?></td>
											<td><?php
											 if (0 == $order->hours ) {
											 	echo '<span class="glyphicon glyphicon-remove" style="color: red"></span>';
											 } else {
											 	echo $order->hours;
											 }
											 ?></td>
											<td><?= $order->pprice ?></td>
											<td>
												<a href="<?php echo $_SERVER['PHP_SELF'] . '?action=one&id=' . $order->id ?>"><span class="glyphicon glyphicon-edit">
												</a>
											</td>
										</tr>
										<?php } ?>
									</tbody>
									<tfoot>
										<tr>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td>Итого:</td>
											<td></td>
											<td></td>
										</tr>
									</tfoot>
								</table>
							</div>
						</div>

						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="panel-title">
									<a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">Стоимость заказа</a>
								</h4>
							</div>
							<div id="collapseTwo" class="panel-collapse collapse">
								<table class="table table-hover table-responsive" id="orders2">
									<thead>
										<tr>
											<th><input type="checkbox" checked id="ischecked"></th>
											<th width="30%">описание заказа</th>
											<th>дата</th>
											<th>исполнитель</th>
											<th width="15%">заказчик</th>
											<th>тираж</th>
											<th>за ед.</th>
											<th>оплата</th>
											<th>сумма</th>
											<th>изменить</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($orders as $order) {
											if ($order->quantity == 0) continue; ?>
										<tr data-image="<?= $order->image ?>">
											<td><input type="checkbox" class="order-checkbox" checked></td>
											<td><a href="<?php echo $_SERVER['PHP_SELF'] . '?action=one&id=' . $order->id ?>"><?= $order->description ?></a></td>
											<td>
												<?php
													echo date('d.m.Y', $order->date);
												?>
											</td>
											<td><?= $order->performer ?></td>
											<td><?= $order->client ?></td>
											<td><?= $order->quantity ?></td>
											<td><?= $order->cratio ?></td>
											<td><?php
												if ($order->paid == 1) {
											 	echo '<span class="glyphicon glyphicon-ok" style="color: green"></span>';
											 } else {
											 	echo '<span class="glyphicon glyphicon-remove" style="color: red"></span>';
											 }
											 ?></td>
											<td><?= $order->cprice ?></td>
											<td>
												<a href="<?php echo $_SERVER['PHP_SELF'] . '?action=one&id=' . $order->id ?>"><span class="glyphicon glyphicon-edit">
												</a>
											</td>
										</tr>
										<?php } ?>
									</tbody>
									<tfoot>
										<tr>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td>Итого:</td>
											<td></td>
											<td></td>
										</tr>
									</tfoot>
								</table>
							</div>
						</div>
					</div>

			</div>
		</div>

		<div class="row new-order">
			<div class="col-md-12">
				<button class="btn btn-success btn-lg" data-toggle="modal" data-target="#newOrder"><span class="glyphicon glyphicon-pencil"></span> Оформить новый заказ</button>
			</div>
		</div>

		<div class="modal fade" id="newOrder" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="myModalLabel">
							Оформить новый заказ
						</h4>
						</div>

						<form  class="form-horizontal" role="form" method="POST" action="<?= $_SERVER[PHP_SELF]; ?>" id="addOrder" enctype="multipart/form-data">

							<div class="modal-body">
								<div class="control-group">
									<label class="control-label" for="description">описание заказа:</label>
									<textarea class="form-control" rows="3" id="description" name="description"></textarea>
								</div>
								<div class="clearfix">
									<div class="control-group pull-left">
										<label class="control-label" for="orderDate">дата:</label>
										<input type="text" id="orderDate" name="orderDate" class="form-control">
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
											} ?>
											<option value="<?= $client->id ?>"><?= $client->name ?></option>
											<?php } ?>
										</select>
									</div>
									<div class="control-group pull-right">
										<label class="control-label" for="cratio">цена за единицу: </label>
										<input type="text" id="cratio" name="cratio" class="form-control" value="0.00">
									</div>
								</div>
								<div class="clearfix">
									<div class="checkbox pull-left" style="padding-top: 10px">
										<label>
											<input type="checkbox" name="paid" value="1"> оплачено
										</label>
									</div>
								</div>
								<hr>
								<div class="clearfix">
									<div class="control-group pull-left">
										<label class="control-label" for="performer">исполнитель:</label>
										<select name="performer_id" id="performer" class="form-control">
											<?php foreach ($performers as $performer) { ?>
											<?php if ($performer->actual != 1) {
												continue;
											} ?>
											<option value="<?= $performer->id ?>"><?= $performer->name ?></option>
											<?php } ?>
										</select>
									</div>
									<div class="control-group pull-right">
										<label class="control-label" for="pratio">коєф. для исполнителя: </label>
										<input type="text" id="pratio" name="pratio" class="form-control" value="1.0">
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
												<input type="text" id="colors" name="colors" class="form-control" value="1">
											</div>
											<div class="control-group pull-right">
												<label class="control-label" for="quantity">тираж:</label>
												<input type="text" id="quantity" name="quantity" class="form-control" value="0">
											</div>
										</div>
										<div class="clearfix">
											<div class="checkbox pull-left" style="padding-top: 10px">
												<label>
													<input type="checkbox" name="formPlus" value="1"
													 checked > изготовление формы
												</label>
											</div>
										</div>
									</div>
									<div class="tab-pane" id="hourly">
										<div class="clearfix">
											<div class="control-group pull-left">
												<label class="control-label" for="hours">часы:</label>
												<input type="text" id="hours" name="hours" class="form-control" value="0">
											</div>
										</div>
									</div>
								</div>
							</div>


							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
								<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ok"></span> Оформить заказ</button>
							</div>

						</form>
					</div><!-- /.modal-content -->
				</div><!-- /.modal-dialog -->
			</div><!-- /.modal -->
		</div>

		<!-- Кнопка вверх -->
		<div id="scrollup">
			<img alt="Прокрутить вверх" src="/App/templates/img/up.png" width="40" height="40">
		</div>
		<script src="/App/templates/js/jquery.min.js"></script>
		<script src="/App/templates/js/bootstrap.min.js"></script>
		<script src="/App/templates/js/jquery-ui.min.js"></script>
		<script src="/App/templates/js/jquery.validate.min.js"></script>

		<script>

/* ---------- русификация датапикера ---------- */
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
/* ---------- /русификация датапикера ---------- */

				$("#startDate").datepicker();
				$("#endDate").datepicker();
				$("#orderDate").datepicker();

				var date = new Date();
				var year = date.getFullYear();
				var month = date.getMonth() + 1;
				var day = date.getDate();
				month = (month <= 9) ? '0' + month : month;
				day = (day <= 9) ? '0' + day : day;
				var startDate = '01.' + month + '.' +  year;
				var endDate = day + '.' + month + '.' +  year;

				$("#orderDate").val(endDate); // установка даты заказа


/* ---------- всплывающее изображение-подсказка ---------- */
				var orderName = $('#orders tbody tr td:nth-child(2)');
				var orderName2 = $('#orders2 tbody tr td:nth-child(2)');
				orderName.hover(handlerIn, handlerOut);
				orderName2.hover(handlerIn, handlerOut);

				function handlerIn(e) {
					var cell = $(e.target);
					var image = cell.parent().data('image');
					if (image == 'noimage.png') {
						image = '/App/templates/img/orders/noimage.png';
					} else {
						image = '/App/templates/img/orders/thumbs/' + image;
					}

					cell.css('position', 'relative');
					var hint = $('<div class="hint" style="background-image:url(' + image + '); background-size: cover; background-position:center; background-repeat: no-repeat;"><div class="arrow-image"></div></div>');
					cell.append(hint);
					hint.css('display', 'block');
				}

				function handlerOut(e) {
					var cell = $(e.target);
					$('td .hint').remove();
					cell.find('div.hint').css('display', 'none');
				}
/* ---------- /всплывающее изображение-подсказка ---------- */

				$('tfoot tr').css({'color': 'green', 'font-weight': 'bold'});
				$('#orders tbody tr td:nth-child(4)').css({'background-color': '#fefed7'});
				$('#orders2 tbody tr td:nth-child(5)').css({'background-color': '#fefed7'});

				function recount(context) {
					var sum = 0;
					$('tbody tr td:nth-child(1)', context).each(
						function(index, el) {
							var checkbox = $(el).find('input[type="checkbox"]');
							if (checkbox.is(':checked')) {
								sum += +($(el).parent().children('td:nth-last-child(2)').css('background', '#fefed7').html());
								sum = Math.ceil(sum * 100) / 100;
							}
						}
					);
					$('tfoot tr:last-child() td:nth-last-child(2)', context).html(sum);
				} // функция пересчета
				recount('#orders');
				recount('#orders2');

/* ---------- чекбоксы полей ---------- */
				function toggleAll(context) {
					var headCheckbox = $('#ischecked', context);
					headCheckbox.on('click', function() {
						if ($(this).is(':checked')) {
							$('input.order-checkbox').prop('checked', true);
							changeSum(context);
						} else {
							$('input.order-checkbox').prop('checked', false);
							changeSum(context);
						}
					});
				}
				toggleAll('#orders');
				toggleAll('#orders2');
/* ---------- /чекбоксы полей ---------- */

				function changeSum(context) {
					$('.order-checkbox', context).each(function() {
						if ($(this).is(':checked')) {
							$(this).closest('tr').css('color', '');
						} else {
							$(this).closest('tr').css('color', '#ccc');
						}
						recount(context);
					});
				} // пересчет суммы

				$('.order-checkbox', '#orders').on('click', function() { changeSum('#orders'); });
				$('.order-checkbox', '#orders2').on('click', function() { changeSum('#orders2'); });

/* ---------- сортировка полей ---------- */
			$('#radioBtn a').on('click', function() {
				var sel = $(this).data('title');
				var tog = $(this).data('toggle');
				$('#'+tog).prop('value', sel);

				$('a[data-toggle="'+tog+'"]').not('[data-title="'+sel+'"]').removeClass('active').addClass('notActive');
				$('a[data-toggle="'+tog+'"][data-title="'+sel+'"]').removeClass('notActive').addClass('active');
			});
/* ---------- /сортировка полей ---------- */

/* ---------- кнопка вверх ---------- */
			jQuery( document ).ready(function() {
				jQuery('#scrollup img').mouseover( function(){
					jQuery( this ).animate({opacity: 0.65},100);
				}).mouseout( function(){
					jQuery( this ).animate({opacity: 1},100);
				}).click( function(){
					window.scroll(0 ,0);
					return false;
				});

				jQuery(window).scroll(function(){
					if ( jQuery(document).scrollTop() > 0 ) {
						jQuery('#scrollup').fadeIn('fast');
					} else {
						jQuery('#scrollup').fadeOut('fast');
					}
				});
			});
/* ---------- /кнопка вверх ---------- */

/* ---------- валидация формы ---------- */
			$("#addOrder").validate({
					rules: {
						colors: {
							required: true,
							digits: true,
						},

						quantity: {
							required: true,
							digits: true,
						},

						description: {
							required: true
						}
					},
					messages: {
						colors: {
							required: "Это поле обязательно для заполнения",
							digits: "Должно быть число",
						},

						quantity: {
							required: "Это поле обязательно для заполнения",
							digits: "Должно быть число",
						},

						description: {
							required: "Это поле обязательно для заполнения"
						}
					}
				});
/* ---------- /валидация формы ---------- */
		</script>
	</body>
</html>