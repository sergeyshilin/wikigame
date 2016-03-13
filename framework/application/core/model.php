<?php
include_once("mysql_config.php");
class Model extends mysqli{
	public function get_data(){

	}
	public function ConnectDB(){
		parent::__construct(SQLADDR, SQLUSER, SQLPWD, SQLDB);
		$this->query("SET NAMES utf8");
	}
    public function escape($string) {
        return $this->escape_string($string);
        // return $string;
    }

    public function run($query) {
        $this->query($query);
        return true;
    }

    public function delete($query) {
        return $this->query($query);
        // if ($result === TRUE)
        //     return true;
        // return false;
    }

    public function insert($query) {
        $this->query($query);
        $result = $this->query("SELECT LAST_INSERT_ID() AS LID");
        if ($result->num_rows > 0) {
            $item = $result->fetch_array(MYSQLI_ASSOC);
            return $item['LID'] != 0 ? $item['LID'] : NULL;
        }
        return NULL;
    }

    public function update($query) {
        $$this->query($query);
        if ($this->affected_rows > 0)
            return true;
        return false;
    }

    public function getFirst($query) {
        if ($result = $this->query($query)) {
            if ($result->num_rows > 0) {
                return $result->fetch_array(MYSQLI_ASSOC);
            }
        }
        return NULL;
    }

    public function getAssoc($query) {
        $list = [];
        if ($result = $this->query($query)) {
            while ($row = $result->fetch_assoc()) {
                array_push($list, $row);
            }
            $result->free();
        }
        return $list;
    }
    public function exec($query){
        $result = $this->query($query);

        if (!$result) {
            echo mysqli_error($this);
            die("Stopped at Model->exec()");
        }

        return $result->fetch_object();
    }
    public function toArray($query){
        $result = $this->query($query);

        if(!$result){
            echo mysqli_error($this);
            die("Stopped at Model-> query()");
        }
        return $result->fetch_array();
    }
}