<?php
// require_once (dirname(__FILE__) ."/routes/routes.php");
class database
{
    // use routes;
    private $host, $username, $password, $database;
    public $conn;
    public $baseUrl = "http://localhost/php_project/";
    public $data;
    public $pages = [
        'links' => [
            'dashboard.php' => 'Dashboard',
            'products.php' => 'Products',
            'crm-creds.php' => 'CRM Credentials',
            'provider.php' => 'Provider',
            'provider-path.php' => 'Provider Paths',
            'roles.php' => 'User Role'
        ],
        'icons' => [
            'dashboard.php' => 'fa-tachometer-alt',
            'products.php' => 'fa-product-hunt',
            'crm-creds.php' => 'fa-user-secret',
            'provider.php' => 'fa-handshake',
            'provider-path.php' => 'fa-route',
            'roles.php' => 'fa-user-shield',
        ],

    ];
    public function __construct($database = '', $host = 'localhost', $username = 'root', $password = '')
    {
        $this->host = $host;
        $this->database = $database;
        $this->username = $username;
        $this->password = $password;
        $this->data = '';
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);
        session_start();
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
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
        $this->data = [];
        if (is_array($fields)) {
            $fields = implode(",", $fields);
        }
        if ($tableName) {
            $query = 'SELECT ' . $fields . ' FROM ' . $tableName . ' ORDER BY ' . $orderBy;
            $result = mysqli_query($this->conn, $query);

            if (mysqli_num_rows($result) > 0) {
                if ($fields != '*') {
                    while ($row = mysqli_fetch_assoc($result)) {
                        foreach ($row as $field => $value) {
                            $this->data[$field][] = $value;
                        }
                    }
                } else {
                    while ($row = $result->fetch_assoc()) {
                        $this->data[] = $row;
                    }
                }
            }
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

    public function add_data_to_table($tableName = null, $inputData = [], $debug = false)
    {
        $fields = implode(", ", array_keys($inputData[0]));
        $placeholders = implode(", ", array_fill(0, count($inputData[0]), '?'));

        $sql = "INSERT INTO $tableName ($fields) VALUES ($placeholders)";
        if ($debug) {
            // Print the SQL query for debugging
            echo "SQL Query: " . $sql . "\n";
        }
        $stmt = $this->conn->prepare($sql);
        if ($stmt === false) {
            die("Error preparing statement: " . $this->conn->error);
        }

        foreach ($inputData as $data) {
            if ($debug) {
                // Print the data being inserted for debugging
                echo "Data: " . json_encode($data) . "\n";
            }
            $stmt->bind_param(str_repeat('s', count($data)), ...array_values($data));

            if (!$debug) {
                // Only execute the statement if not in debug mode
                $stmt->execute();
            }
        }

        if (!$debug) {
            $stmt->close();
        }


    }

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

    public function redirect($url)
    {
        header('Location: ' . $url);
        die();
    }

    /*To get user data if authenticated
    parameters: N.A
    Author: Arpan Ghosh
    */
    public function getUserFromSession()
    {
        if (isset($_SESSION['user']) && $_SESSION['user'] != '') {
            return $_SESSION['user'];
        }
    }

    /*To create new user 
    parameters: N.A
    Author: Arpan Ghosh
    */

    public function createUser($input = array(), $tableName = 'users')
    {
        if (count($input) > 0) {
            $this->data['fullname'] = filter_var($input['name'], FILTER_SANITIZE_STRING);
            $this->data['email'] = filter_var($input['email'], FILTER_SANITIZE_EMAIL);
            $this->data['password'] = filter_var($input['password'], FILTER_SANITIZE_STRING);
            if ($this->data['fullname'] && $this->data['email'] && $this->data['password']) {
                $query = "SELECT * FROM users WHERE email = '" . $this->data['email'] . "'";
                $result = mysqli_query($this->conn, $query);
                if (mysqli_num_rows($result) > 0) {
                    return array('status' => false, 'message' => 'User is already registered!');
                } else {
                    $this->data['hashPassword'] = password_hash($this->data['password'], PASSWORD_DEFAULT);
                    $query = "INSERT INTO `$tableName` (`name`, `email`, `password`, `password_original`) VALUES ('" . $this->data['fullname'] . "','" . $this->data['email'] . "','" . $this->data['hashPassword'] . "','" . $this->data['password'] . "')";

                    $res = $this->conn->query($query);
                    if ($res) {
                        return array("status" => true, "message" => "Registered successfully!");
                    } else {
                        return array("status" => false, "message" => "Not registered successfully!");
                    }
                }
            }
        }
    }

    /* To get User Id roles priviledges
     */
    public function getUserWiseRoles()
    {

    }

    public function getRoleWisePrivileges($roleId)
    {
        $this->data= [];
        if ($roleId) {
            $query = "SELECT r.id AS roleId, GROUP_CONCAT( p.id SEPARATOR ', ' ) AS PRIVILEGES_ID FROM roles r JOIN role_privileges rp ON r.id = rp.role_id JOIN PRIVILEGES p ON rp.privilege_id = p.id WHERE r.id=$roleId GROUP BY r.id, r.name";

            $result = $this->conn->query($query);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $this->data = explode(', ', $row['PRIVILEGES_ID']);
                    // $this->data[] = $row;
                }
            }
            return $this->data;
        }
    }

    public function updateRoleWisePrivileges($roleId, $privileges)
    {
        if ($roleId) {
            $query = "DELETE from role_privileges WHERE id $roleId";
            $result = $this->conn->query($query);

            if ($privileges) {
                $stmt = $this->conn->prepare("INSERT INTO role_privileges (role_id, privilege_id) VALUES (?, ?)");
                foreach ($privileges as $privilegeId) {
                    $stmt->bind_param("ii", $roleId, $privilegeId);
                    $stmt->execute();
                }
                $stmt->close();

                return true;
            }
        }
    }

    public function __destruct()
    {
        mysqli_close($this->conn);
    }
}