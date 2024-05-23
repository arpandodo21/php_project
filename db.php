<?php 
// require_once (dirname(__FILE__) ."/routes/routes.php");
class database
{
    // use routes;
    private $host, $username, $password, $database, $conn;
    public $baseUrl = "http://localhost/php_project/";
    public $data;
    public function __construct($database = '', $host = 'localhost', $username = 'root', $password = '')
    {
        $this->host = $host;
        $this->database = $database;
        $this->username = $username;
        $this->password = $password;
        $this->conn = mysqli_connect($this->host, $this->username, $this->password, $this->database);
        session_start();
        // unset($_SESSION['user']);
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
    public function get_all_records($tableName = null, $fields = "*", $orderBy = 'id DESC')
    {
        if (is_array($fields)) {
            $fields = implode(",", $fields);
        }
        if ($tableName) {
            $query = 'SELECT ' . $fields . ' FROM ' . $tableName . ' ORDERBY ' . $orderBy;
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

    public function get_row_from_table($tableName = null, $fields = "*", $where = array(), $orderBy = 'id ASC')
    {
        $conditions = [];
        if (is_array($fields)) {
            $fields = implode(",", $fields);
        }
        if ($tableName && count($where) > 0) {
            $query = "SELECT `" . $fields . "` FROM `" . $tableName . "` WHERE ";
            foreach ($where as $key => $val) {
                $escapeKey = mysqli_real_escape_string($this->conn, $key);
                $escapeVal = mysqli_real_escape_string($this->conn, $val);
                $conditions[] = "`$escapeKey` = '$escapeVal'";
            }
            $conditions = implode(' AND ', $conditions);
            $query .= $conditions . " ORDER BY " . $orderBy;

            $this->data = mysqli_query($this->conn, $query);
            $this->data = (mysqli_num_rows($this->data) > 0) ? mysqli_fetch_assoc($this->data) : null;

            return $this->data;

        } else {
            echo '<h3>Please call the function "get_row_from_table" with proper arguments.</h3>';
        }
    }

    /*To authenticate user and make session
    parameters: @tableName, @data as array
    Author: Arpan Ghosh
     */

    public function checkUser($email, $password)
    {
        $useremail = $this->conn->real_escape_string($email);
        $userpass = $this->conn->real_escape_string($password);

        $query = "SELECT * FROM users WHERE email = '$useremail'";
        $result = mysqli_query($this->conn, $query);

        if ($result->num_rows > 0) {
            $this->data = $result->fetch_assoc();

            // Verify password (assuming passwords are hashed with password_hash())
            if (password_verify($userpass, $this->data['password'])) {
                // Set session variables
                $_SESSION['user'] = [
                    'user_id' => $this->data['id'],
                    'name' => $this->data['name'],
                    'email' => $this->data['email'],
                    'role' => $this->data['role'],
                    'is_active' => $this->data['is_active'],
                ];

                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /*To redirect user if not authenticated
    parameters: @url
    Author: Arpan Ghosh
     */

    public function redirect($url) {
        header('Location: '.$url);
        die();
    }

    /*To get user data if authenticated
    parameters: N.A
    Author: Arpan Ghosh
    */
    public function getUserFromSession() {
        if(isset($_SESSION['user']) && $_SESSION['user'] != '') {
            return $_SESSION['user'];
        }
    }

    public function __destruct()
    {
        mysqli_close($this->conn);
    }
}