<?php class database
{
    private $host, $username, $password, $database,$conn;
    public $data;
    public function __construct($database = '', $host = 'localhost', $username = 'root', $password = '')
    {
        $this->host = $host;
        $this->database = $database;
        $this->username = $username;
        $this->password = $password;
        $this->conn = mysqli_connect($this->host, $this->username, $this->password, $this->database);
    }

    /*To make a new table in database
    parameters: @tablename, @fields array with datatypes(Length) and other criteria.
    Author: Arpan Ghosh
     */
    public function make_new_table($tableName = null, $fields_with_datatypes = [])
    {
        if ($tableName && count($fields_with_datatypes) > 0) {
            $query = 'CREATE TABLE ' . $tableName . ' (';

            if (is_array($fields_with_datatypes)) {
                if (count($fields_with_datatypes) === 1) {
                    foreach ($fields_with_datatypes as $field => $datatype) {
                        $query .= $field . " " . $datatype;
                    }

                    $query .= ")";
                    if (mysqli_query($this->conn, $query)) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    foreach ($fields_with_datatypes as $field => $datatype) {
                        if ($field == @end(array_keys($fields_with_datatypes)))
                            $query .= $field . " " . $datatype;
                        else
                            $query .= $field . " " . $datatype . ",";
                    }
                    $query .= ")";
                    if (mysqli_query($this->conn, $query)) {
                        return true;
                    } else {
                        return false;
                    }
                }
            }
        }
    }

    /*To make a new table in database
    parameters: @tablename, @orderBy.
    Author: Arpan Ghosh
     */
    public function get_all_records($tableName = null,$fields="*", $orderBy = 'id DESC')
    {
        if(is_array($fields)){
            $fields = implode(",",$fields);
        }
        if ($tableName) {
            $query = 'SELECT '.$fields.' FROM ' . $tableName . ' ORDERBY ' . $orderBy;
            $this->data = mysqli_query($this->conn, $query);
            $this->data = (mysqli_num_rows($this->data) > 0) ? mysqli_fetch_assoc($this->data) : null;
            mysqli_close($this->conn);
            return $this->data;
        }
    }

    /*To Drop any table
    parameters: @tableName
    Author: Arpan Ghosh
     */
    public function drop_table($tableName = null)
    {
        if ($tableName) {
            $this->conn = mysqli_connect($this->host, $this->username, $this->password, $this->database);
            $query = 'DROP TABLE ' . $tableName;
            $this->data = (mysqli_query($this->conn, $query)) ? true : false;
            mysqli_close($this->conn);
            return $this->data;
        }
    }

    /*To Add data to any table
    parameters: @tableName, @data as array
    Author: Arpan Ghosh
     */

    /*
    public function add_data_to_table($tableName = null, $inputData = [])
    {
        if ($tableName && count($inputData) > 0) {
            $this->conn = mysqli_connect($this->host, $this->username, $this->password, $this->database);
            $query = 'INSERT INTO ' . $tableName;
            $fields = '';
            $values = '';
            echo "<pre>";print_r($inputData);die;
            if (is_array($inputData)) {
                if (count($inputData) === 1) {
                    foreach ($inputData as $key => $val) {
                        $fields .= $key;
                        if(is_array($val)){
                            foreach($val as $v){
                                
                                if (count($val) > 1 && $v == @end($val)) {
                                    $values .= "('".$v . "')";
                                } else {
                                    $values .= "('".$v . "'),";
                                }
                            }
                        }else{
                            $values .= "('".$val . "')";
                        }
                    }
                    $query .= "(" . $fields . ") VALUES " . $values . "";
                    echo $query;exit;
                    if (mysqli_query($this->conn, $query)) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    foreach ($inputData as $key => $val) {
                        if ($key == @end(array_keys($inputData))) {
                            $fields .= $key;
                            if(is_array($val)){
                                foreach($val as $v){
                                    
                                    if (count($val) > 1 && $v == @end($val)) {
                                        $values .= "('".$v . "')";
                                    } else {
                                        $values .= "('".$v . "'),";
                                    }
                                }
                            }else{
                                $values .= $val . ")";
                            }
                        } else {
                            $fields .= $key . ",";
                            if(is_array($val)){
                                $i = 0;
                                foreach($val as $v){
                                    
                                    if (count($val) > 1 && $v == @end($val)) {
                                        $values .= "('".$key[$i] . "','".$key[$i]."')";
                                    } else {
                                        $values .= "('".$key[$i] . "','".$key[$i]."'),";
                                    }
                                    $i++;
                                }
                            }else{
                                $values .= $val . ")";
                            }
                        }
                    }
                    $query .= "(" . $fields . ") VALUES " . $values . "";

                    echo $query;exit;
                    if (mysqli_query($this->conn, $query)) {
                        return true;
                    } else {
                        return false;
                    }
                }
            }
            mysqli_close($this->conn);
        }
    }
    */
    
    /*To get single data from any table
    parameters: @tableName, @data as array
    Author: Arpan Ghosh
     */

    public function get_row_from_table($tableName=null,$fields="*",$where=array(),$orderBy='id ASC'){
        $conditions = [];
        if(is_array($fields)){
            $fields = implode(",",$fields);
        }
        if ($tableName && count($where) > 0){
            $query = "SELECT `".$fields."` FROM `".$tableName."` WHERE ";
            foreach($where as $key => $val){
                $escapeKey = mysqli_real_escape_string($this->conn,$key);
                $escapeVal = mysqli_real_escape_string($this->conn,$val);
                $conditions[] = "`$escapeKey` = '$escapeVal'";
            }
            $conditions = implode(' AND ',$conditions);
            $query .= $conditions ." ORDER BY ".$orderBy;

            $this->data = mysqli_query($this->conn, $query);
            $this->data = (mysqli_num_rows($this->data) > 0) ? mysqli_fetch_assoc($this->data) : null;
            
            return $this->data;

        }else{
            echo '<h3>Please call the function "get_row_from_table" with proper arguments.</h3>';
        }
    }

    public function __destruct(){
        mysqli_close($this->conn);
    }
}