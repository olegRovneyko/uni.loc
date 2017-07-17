<?php
namespace App\Controllers;

use App\View;

class Order {

	protected $view;

	public function __construct() {
		$this->view = new View();
	}

	public function action($action) {
		$methodName = 'action' . $action;
		return $this->$methodName($i);
	}

	protected function actionIndex() {

		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			$mon = getdate()['mon'];
			$startDate = mktime(0, 0, 0, $mon, 1);
			$endDate = time();

			if (!empty($_GET['startDate'])) {
				$startDate = $_GET['startDate'];
				$arr = explode('.', $startDate);
				$startDate = mktime(0, 0, 0, $arr[1], $arr[0], $arr[2]);
			}
			if (!empty($_GET['endDate'])) {
				$endDate = $_GET['endDate'];
				$arr = explode('.', $endDate);
				$endDate = mktime(0, 0, 0, $arr[1], $arr[0], $arr[2]);
			}

			$data = [];
			$data[':startdate'] = $startDate;
			$data[':enddate'] = $endDate;
			$condition = 'WHERE (date BETWEEN :startdate AND :enddate)';

			if (!empty($_GET['performer_id'])) {
				$performer_id = (int)$_GET['performer_id'];
				$data[':performer_id'] = $performer_id;
				$condition .= ' AND performer_id = :performer_id';
			}

			if (!empty($_GET['client_id'])) {
				$client_id = (int)$_GET['client_id'];
				$data[':client_id'] = $client_id;
				$condition .= ' AND client_id = :client_id';
			}

			if ($_GET['sequence'] == 'down') {
				$condition .= ' ORDER BY date';
			} else {
				$condition .= ' ORDER BY date DESC';
			}


			$this->view->orders = \App\Models\Order::findByCondition($condition, $data);
			$this->view->clients = \App\Models\Client::findAll();
			$this->view->performers = \App\Models\Performer::findAll();

			$this->view->display(__DIR__ . '/../templates/index.php');
		} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {

			if (isset($_POST['description']) and isset($_POST['quantity']) and isset($_POST['colors'])) {
				$description = trim(strip_tags($_POST['description']));
				$quantity = (int)$_POST['quantity'];
				$colors = (int)$_POST['colors'];
				$form = (int)$_POST['formPlus'] ? : 0;
				$paid = (int)$_POST['paid'] ? : 0;
				$pratio = (float)$_POST['pratio'];
				$cratio = (float)$_POST['cratio'];
				$hours = (int)$_POST['hours'];

				$date = trim(strip_tags($_POST['orderDate']));
				$date = explode('.', $date);
				$timestamp = mktime(0, 0, 0, $date[1], $date[0], $date[2]);

				$filename = 'noimage.png';
				$client_id = (int)$_POST['client_id'];
				$performer_id = (int)$_POST['performer_id'];

				if (isset($_FILES['picture'])) {
					if (0 == $_FILES['picture']['error']) {
						$name = $_FILES['picture']['name'];
						$tmp_name = $_FILES['picture']['tmp_name'];
						$extension = pathinfo($name)['extension'];
						$filename = time() . '.' . $extension;
						if ($extension == 'jpg' || $extension == 'png') {
							move_uploaded_file($_FILES['picture']['tmp_name'], __DIR__ . '/../../img/orders/' . $filename);

							$image = new \App\SimpleImage();
							$image->load(__DIR__ . '/../../img/orders/' . $filename);
							$image->resizeToWidth(250);
							$image->save(__DIR__ . '/../../img/orders/thumbs/' . $filename);
							$image2 = new \App\SimpleImage();
							$image2->load(__DIR__ . '/../../img/orders/' . $filename);
							$image2->resizeToWidth(500);
							$image2->save(__DIR__ . '/../../img/orders/' . $filename);

						}
					}
				}

				$order = new \App\Models\Order();

				$order->description = $description;
				$order->date = $timestamp;
				$order->performer_id = $performer_id;
				$order->client_id = $client_id;
				$order->colors = $colors;
				$order->quantity = $quantity;
				$order->pratio = $pratio;
				$order->cratio = $cratio;
				$order->form = $form;
				$order->paid = $paid;
				$order->hours = $hours;
				if (0 == $hours) {
					$order->pprice = ($colors > 1) ? (0.2 * $colors) * $pratio * $quantity : (0.3 * $colors) * $pratio * $quantity;
					if ($form == 1) {
						$order->pprice += $colors * 30;
					}
				} else {
					$order->pprice = $hours * 25 * $pratio;
					$order->colors = 0;
					$order->quantity = 0;
					$order->form = 0;
				}

				$order->cprice = ($quantity * $cratio);
				$order->image = $filename;
				$order->save();
			}

			header('Location: ' . $_SERVER['REQUEST_URI']);
			exit;
		}
	}

	protected function actionOne() {
		$id = $_GET['id'];
		$this->view->clients = \App\Models\Client::findAll();
		$this->view->performers = \App\Models\Performer::findAll();
		$this->view->order = \App\Models\Order::findById($id);
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			$this->view->display(__DIR__ . '/../templates/order.php');
		}

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$filename = $this->view->order->image;
			if (isset($_FILES['picture'])) {
				if (0 == $_FILES['picture']['error']) {
					$name = $_FILES['picture']['name'];
					$tmp_name = $_FILES['picture']['tmp_name'];
					$extension = pathinfo($name)['extension'];
					if ($filename == 'noimage.png') {
						$filename = time() . '.' . $extension;
					}
					if ($extension == 'jpg' || $extension == 'png') {
						move_uploaded_file($_FILES['picture']['tmp_name'], __DIR__ . '/../../img/orders/' . $filename);

						if ($filename !== 'noimage.png') {
							$image = new \App\SimpleImage();
							$image->load(__DIR__ . '/../../img/orders/' . $filename);
							$image->resizeToWidth(250);
							$image->save(__DIR__ . '/../../img/orders/thumbs/' . $filename);
							$image2 = new \App\SimpleImage();
							$image2->load(__DIR__ . '/../../img/orders/' . $filename);
							$image2->resizeToWidth(500);
							$image2->save(__DIR__ . '/../../img/orders/' . $filename);
						}
					}
				}
			}
			$description = $_POST['description'];
			$date = trim(strip_tags($_POST['orderDate']));
			$date = explode('.', $date);
			$timestamp = mktime(0, 0, 0, $date[1], $date[0], $date[2]);
			$performer_id = $_POST['performer_id'];
			$client_id = $_POST['client_id'];
			$colors = (int)$_POST['colors'];
			$form = $_POST['formPlus'] ? : 0;
			$paid = $_POST['paid'] ? : 0;
			$hours = (int)$_POST['hours'];
			$quantity = (int)$_POST['quantity'];
			$pratio = (float)$_POST['pratio'];
			$cratio = (float)$_POST['cratio'];
			if (0 == $hours) {
				$pprice = ($colors > 1) ? (0.2 * $colors) * $pratio * $quantity : (0.3 * $colors) * $pratio * $quantity;
				if ($form == 1) {
					$pprice += $colors * 30;
				}
			} else {
				$pprice = $hours * 25 * $pratio;
				$colors = 0;
				$form = 0;
			}
			$cprice = $cratio * $quantity;


			$this->view->order->description = $description;
			$this->view->order->date = $timestamp;
			$this->view->order->performer_id = $performer_id;
			$this->view->order->client_id = $client_id;
			$this->view->order->colors = $colors;
			$this->view->order->form = $form;
			$this->view->order->pratio = $pratio;
			$this->view->order->cratio = $cratio;
			$this->view->order->quantity = $quantity;
			$this->view->order->pprice = $pprice;
			$this->view->order->cprice = $cprice;
			$this->view->order->hours = $hours;
			$this->view->order->paid = $paid;
			$this->view->order->image = $filename;
			$this->view->order->save();
			header('Location: \index.php');
			exit;
		}
	}

	protected function actionDelete() {
		$id = $_GET['id'];
		$this->view->order = \App\Models\Order::findById($id);
		$filename = $this->view->order->image;
		$this->view->order->delete();
		if ($filename !== 'noimage.png') {
			unlink(__DIR__ . '/../../img/orders/' . $filename);
			unlink(__DIR__ . '/../../img/orders/thumbs/' . $filename);
		}

		header('Location: \index.php');
		exit;
	}
}
