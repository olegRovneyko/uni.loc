<?php
namespace App\Controllers;

use App\View;

class Client
{
	protected $view;

	public function __construct() {
		$this->view = new View();
	}

	public function action($action) {
		$methodName = 'action' . $action;
		return $this->$methodName();
	}

	protected function actionIndex() {

		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			$this->view->clients = \App\Models\Client::findAll();
			$this->view->display(__DIR__ . '/../templates/clients.php');
		} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if (isset($_POST['name'])) {
				$client = new \App\Models\Client();
				$client->name = $_POST['name'];
				$client->phone = $_POST['phone'] ? : 'не указан';
				$client->email = $_POST['email'] ? : 'не указан';
				$client->address = $_POST['address'] ? : 'не указан';
				$client->description = $_POST['description'] ? : 'не указано';
				$client->actual = $_POST['actual'] ? : 0;
				$filename = 'noimage.png';

				if (isset($_FILES['picture'])) {
					if (0 == $_FILES['picture']['error']) {
						$name = $_FILES['picture']['name'];
						$tmp_name = $_FILES['picture']['tmp_name'];
						$extension = pathinfo($name)['extension'];
						$filename = time() . '.' . $extension;
						if ($extension == 'jpg' || $extension == 'png') {
							move_uploaded_file($_FILES['picture']['tmp_name'], __DIR__ . '/../../img/clients/' . $filename);

							$image = new \App\SimpleImage();
							$image->load(__DIR__ . '/../../img/clients/' . $filename);
							$image->resizeToWidth(500);
							$image->save(__DIR__ . '/../../img/clients/' . $filename);

						}
					}
				}
				$client->image = $filename;

				$client->save();
			}
			header('Location: ' . $_SERVER['REQUEST_URI']);
			exit;
		}
	}

	protected function actionOne() {
		$id = $_GET['id'];
		$this->view->client = \App\Models\Client::findById($id);
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			$this->view->display(__DIR__ . '/../templates/client.php');
		}
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if (isset($_POST['name'])) {

				$filename = $this->view->client->image;
				if (isset($_FILES['picture'])) {
					if (0 == $_FILES['picture']['error']) {
						$name = $_FILES['picture']['name'];
						$tmp_name = $_FILES['picture']['tmp_name'];
						$extension = pathinfo($name)['extension'];
						if ($filename == 'noimage.png') {
							$filename = time() . '.' . $extension;
						}
						if ($extension == 'jpg' || $extension == 'png') {
							move_uploaded_file($_FILES['picture']['tmp_name'], __DIR__ . '/../../img/clients/' . $filename);

							if ($filename !== 'noimage.png') {
								$image = new \App\SimpleImage();
								$image->load(__DIR__ . '/../../img/clients/' . $filename);
								$image->resizeToWidth(500);
								$image->save(__DIR__ . '/../../img/clients/' . $filename);
							}
						}
					}
				}

				$this->view->client->name = $_POST['name'];
				$this->view->client->phone = $_POST['phone'] ? : 'не указан';;
				$this->view->client->email = $_POST['email'] ? : 'не указан';;
				$this->view->client->address = $_POST['address'] ? : 'не указан';;
				$this->view->client->description = $_POST['description'] ? : 'не указано';;
				$this->view->client->actual = $_POST['actual'] ? : 0;
				$this->view->client->image = $filename;
				$this->view->client->save();
				header('Location: /index.php?controller=client');
				exit;
			}
		}
	}
}