<?php
	namespace App\Models;

	use App\Db;
	use App\Model;

	class Client extends Model {
		public $name;
		public $phone;
		public $email;
		public $address;
		public $description;
		public $actual;
		public $image;

		const TABLE = 'clients';
	}