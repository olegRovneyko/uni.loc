<?php
	namespace App\Models;

	use App\Db;
	use App\Model;

	class Performer extends Model {
		public $name;
		public $phone;
		public $address;
		public $description;
		public $actual;
		public $image;

		const TABLE = 'performers';
	}