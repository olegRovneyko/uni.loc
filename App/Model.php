<?php
namespace App;

abstract class Model {
	const TABLE = '';

	public $id;

	public static function findAll() {
		$db = Db::instance();
		return $db->query(
				'SELECT * FROM ' . static::TABLE,
				static::class
			);
	}

	public static function findByCondition($condition, $data) {
		$db = Db::instance();
		return $db->query(
				'SELECT * FROM ' . static::TABLE . ' ' . $condition,
				static::class,
				$data
			);
	}

	public static function findById($id) {
		$db = Db::instance();
		$res = $db->query(
				'SELECT * FROM ' . static::TABLE . ' WHERE id = :id',
				static::class,
				[':id' => $id]
			)[0];
		if (null === $res)
			return false;
		return $res;
	}

	public function isNew()
	{
		return empty($this->id);
	}

	public function save()
	{
		if ($this->isNew()) {
			$this->insert();
		} else {
			$this->update();
		}
	}

	public function insert()
	{
		$columns = [];
		$values = [];
		foreach ($this as $k => $v) {
			if ('id' == $k) {
				continue;
			}
			$columns[] = $k;
			$values[':'.$k] = $v;
		}

		$sql = '
INSERT INTO ' . static::TABLE . '
(' . implode(',', $columns) . ')
VALUES
(' . implode(',', array_keys($values)) . ')
		';
		$db = Db::instance();
		$db->execute($sql, $values);
	}

	public function update()
	{
		$sets = [];
		$values = [];
		foreach ($this as $k => $v) {
			if ('id' == $k) {
				continue;
			}
			$sets[] = $k . ' = :' . $k;
			$values[':'.$k] = $v;
		}

		$sql = 'UPDATE ' . static::TABLE . ' SET ' . implode(', ', $sets) . ' WHERE id = ' . $this->id;
		$db = Db::instance();
		$db->execute($sql, $values);
	}

	public function delete()
	{
		if ($this->isNew()) {
			return;
		}
		$sql = 'DELETE FROM ' . static::TABLE . ' WHERE id = ' . $this->id;
		$db = Db::instance();
		$db->execute($sql);
	}

}