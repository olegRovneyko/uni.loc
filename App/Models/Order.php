<?php
	namespace App\Models;

	use App\Db;
	use App\Model;

	class Order extends Model {
		const TABLE = 'orders';

		public $description;
		public $date;
		public $performer_id;
		public $client_id;
		public $colors;
		public $quantity;
		public $pratio;
		public $pprice;
		public $cratio;
		public $cprice;
		public $form;
		public $hours;
		public $image;
		public $paid;

		public function __get($prop) {
			switch ($prop) {
				case 'performer':
					return Performer::findById($this->performer_id)->name;
					break;
				case 'client':
					return Client::findById($this->client_id)->name;
					break;
				default:
					return null;
			}
		}

		public function __isset($prop) {
			switch ($prop) {
				case 'performer':
					return !empty($this->performer_id);
					break;
				case 'client':
					return !empty($this->client_id);
					break;
				default:
					return false;
			}
		}
	}