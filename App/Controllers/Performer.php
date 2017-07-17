<?php
namespace App\Controllers;

use App\View;

class Performer
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
			$this->view->performers = \App\Models\Performer::findAll();
      $this->view->display(__DIR__ . '/../templates/performers.php');
		} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if (isset($_POST['name'])) {
				$performer = new \App\Models\Performer();
				$performer->name = $_POST['name'];
				$performer->phone = $_POST['phone'] ? : 'не указан';
				$performer->address = $_POST['address'] ? : 'не указан';
				$performer->description = $_POST['description'] ? : 'не указано';
				$performer->actual = $_POST['actual'] ? : 0;
				$filename = 'noimage.png';

				if (isset($_FILES['picture'])) {
					if (0 == $_FILES['picture']['error']) {
						$name = $_FILES['picture']['name'];
						$tmp_name = $_FILES['picture']['tmp_name'];
						$extension = pathinfo($name)['extension'];
						$filename = time() . '.' . $extension;
						if ($extension == 'jpg' || $extension == 'png') {
							move_uploaded_file($_FILES['picture']['tmp_name'], __DIR__ . '/../../img/performers/' . $filename);

							$image = new \App\SimpleImage();
							$image->load(__DIR__ . '/../../img/performers/' . $filename);
							$image->resizeToWidth(500);
							$image->save(__DIR__ . '/../../img/performers/' . $filename);

						}
					}
				}
				$performer->image = $filename;

				$performer->save();
			}
			header('Location: ' . $_SERVER['REQUEST_URI']);
			exit;
		}
	}

	protected function actionOne() {
		$id = $_GET['id'];
		$this->view->performer = \App\Models\Performer::findById($id);
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			$this->view->display(__DIR__ . '/../templates/performer.php');
		}
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if (isset($_POST['name'])) {

				$filename = $this->view->performer->image;
				if (isset($_FILES['picture'])) {
					if (0 == $_FILES['picture']['error']) {
						$name = $_FILES['picture']['name'];
						$tmp_name = $_FILES['picture']['tmp_name'];
						$extension = pathinfo($name)['extension'];
						if ($filename == 'noimage.png') {
							$filename = time() . '.' . $extension;
						}
						if ($extension == 'jpg' || $extension == 'png') {
							move_uploaded_file($_FILES['picture']['tmp_name'], __DIR__ . '/../../img/performers/' . $filename);

							if ($filename !== 'noimage.png') {
								$image = new \App\SimpleImage();
								$image->load(__DIR__ . '/../../img/performers/' . $filename);
								$image->resizeToWidth(500);
								$image->save(__DIR__ . '/../../img/performers/' . $filename);
							}
						}
					}
				}
				$this->view->performer->name = $_POST['name'];
				$this->view->performer->phone = $_POST['phone'] ? : 'не указан';;
				$this->view->performer->address = $_POST['address'] ? : 'не указан';;
				$this->view->performer->description = $_POST['description'] ? : 'не указано';;
				$this->view->performer->actual = $_POST['actual'] ? : 0;
				$this->view->performer->image = $filename;

				$this->view->performer->save();

				header('Location: /index.php?controller=performer');
				exit;
			}
		}
	}
}