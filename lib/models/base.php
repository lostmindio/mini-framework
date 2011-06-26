<?php

class ModelBase {
	
	private static $pdo;
	
	public function __construct($obj = array()) {
		$this->columns = array();
		foreach($obj as $k=>$v) {
			$this->$k = $v;
			$this->columns[] = $k;
		}
	}
	
	public function save() {
		if(in_array("updated_at", $this->columns)) {
			$this->updated_at = time();
		}
		$table_name = self::table_name();
		$sets = "";
		$params = array();
		foreach($this->columns as $col) {
			if($col == "id") continue;
			$params[] = $this->$col;
			if($sets != "") {
				$sets .= ", ";
			}
			$sets .= "$col = ? ";
		}
		$stmt = self::$pdo->prepare("UPDATE $table_name SET $sets WHERE id = ?");
		$params[] = $this->id;
		$stmt->execute($params);
	}
	
	public function __get($name) {
		$model_class = ucfirst(preg_replace_callback("/_(?<letter>[a-z])/", function($m) {
			return strtoupper($m['letter']);
		}, $name));
		if(isset($this->belongs_to) && in_array($name, $this->belongs_to)) {
			$name_id = "${name}_id";
			return $model_class::find($this->$name_id);
		}
		if(isset($this->has_many) && in_array($name, $this->has_many)) {
			$by_name_id = "by_" . self::table_name() . "_id";
			$a = $model_class::$by_name_id($this->id);
			return $a;
		}
		return NULL;
	}
	
	public static function get($param = NULL) {
		global $params;
		if($param == NULL) {
			$param = self::table_name() . "_id";
		}	
		expects(array($param => "int"));
		return self::find($params[$param]);
	}
	
	public static function find($id) {
		return self::find_by_id($id);
	}
	
	public static function delete($id) {
		$table = self::table_name();
		$stmt = self::$pdo->prepare("DELETE FROM $table WHERE id = ?");
		$stmt->execute(array($id));
	}
	
	public function destroy() {
		$table = self::table_name();
		$stmt = self::$pdo->prepare("DELETE FROM $table WHERE id = ?");
		$stmt->execute(array($this->id));
	}
	
	public static function all($order = NULL) {
		$model_class = get_called_class();
		$objects = array();
		$table = self::table_name();
		$stmt = self::$pdo->prepare("SELECT * FROM $table " . ($order ? "ORDER BY $order" : ""));
		$stmt->execute();
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$objects[] = new $model_class($row);
		}
		return $objects;
	}
	
	private static function table_name() {
		return strtolower(preg_replace("/([a-z])([A-Z])/", '${1}_${2}', get_called_class()));
	}
	
	public static function __callStatic($name, $arguments) {
		if(preg_match('/^find_by_(?<column>[a-z_]+)$/', $name, $matches)) {
			$model_class = get_called_class();
			$table = self::table_name();
			$stmt = self::$pdo->prepare("SELECT * FROM $table WHERE $matches[column] = ?");
			$stmt->execute(array($arguments[0]));
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				return new $model_class($row);
			}
			return NULL;
		}
		if(preg_match('/^by_(?<column>[a-z_]+)$/', $name, $matches)) {
			$model_class = get_called_class();
			$table = self::table_name();
			$stmt = self::$pdo->prepare("SELECT * FROM $table WHERE $matches[column] = ?");
			$stmt->execute(array($arguments[0]));
			$objects = array();
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$objects[] = new $model_class($row);
			}
			return $objects;
		}
	}
	
	public static function connect() {
		global $config;
		self::$pdo = new PDO($config["db"]["dsn"], $config["db"]["user"], $config["db"]["pass"]);
	}
}
if(isset($config["db"]["dsn"])) {
	ModelBase::connect();
}