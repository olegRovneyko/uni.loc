<?php
	namespace App;

	class Db {
		use Singleton;
		protected $dbh;

		protected function __construct() {
			$this->dbh = new \PDO('sqlite:' . __DIR__ . '/../orders.db');
		}

		public function execute($sql, $params = []) {
			$sth = $this->dbh->prepare($sql);
			$res = $sth->execute($params);
			return $res;
		}

		public function query($sql, $class, $param = []) {
			$sth = $this->dbh->prepare($sql);
			$res = $sth->execute($param);
			if (false !== $res) {
				return $sth->fetchAll(\PDO::FETCH_CLASS, $class);
			}
			return [];
		}
	}