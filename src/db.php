<?php
namespace Php\Db;

// Query Builder of Laravel

class DB
{
    private $tableName;
    public $connection;
    private $sql;


    /**
     * @param $server
     * @param $db_user
     * @param $db_pass
     * @param $db_name
     */
    // Constructor to automatically establish the connection to the database (One of Magic Functions )
    public function __construct($server, $db_user, $db_pass, $db_name)
    {
        $this->connection = mysqli_connect($server, $db_user, $db_pass, $db_name);
        if (!$this->connection) {
            die("Connection failed: " . mysqli_connect_error());
        }
    }
    // Sets the table name

    /**
     * @param string $tableName
     * @return object|$this
     */
    public function table(string $tableName): object
    {
        $this->tableName = $tableName;
        return $this;
    }

    /**
     * @return int
     */
    // Executes the SQL query
    public function execute(): int
    {
        echo "Executing query: " . $this->sql . "<br>";
        mysqli_query($this->connection, $this->sql);
        return mysqli_affected_rows($this->connection);
    }

    // Selects items from the table

    /**
     * @param string $items
     * @return object|$this
     */

    public function select(string $items = "*"): object
    {
        $this->sql = "SELECT $items FROM $this->tableName";
        return $this;
    }

    // Condition

    /**
     * @param string $columns
     * @param string $operator
     * @param string $value
     * @return object|$this
     */
    function where(string $columns, string $operator, string $value): object
    {
        $value = mysqli_real_escape_string($this->connection, $value);
        $this->sql .= " WHERE `$columns` $operator  '$value'";
        return $this;

    }

    /**
     * @param string $columns
     * @param string $operator
     * @param string $value
     * @return object|$this
     */
    function andWhere(string $columns, string $operator, string $value): object
    {
        $value = mysqli_real_escape_string($this->connection, $value);
        $this->sql .= "  AND  `$columns` $operator  '$value'";
        return $this;

    }

    /***
     * @param string $columns
     * @param string $operator
     * @param string $value
     * @return object|$this
     */
    function orWhere(string $columns, string $operator, string $value): object
    {
        $value = mysqli_real_escape_string($this->connection, $value);
        $this->sql .= "  OR  `$columns` $operator  '$value'";
        return $this;

    }
    // Update items

    /***
     * @param array $data
     * @return object|$this
     */
    public function update(array $data): object
    {
        $rows = '';
        foreach ($data as $key => $value) {
            $rows .= "`$key`= '$value' ,";

        }

        $rows = rtrim($rows, ',');
        $this->sql = "UPDATE   `$this->tableName` SET  $rows ";
        return $this;
    }
    // Insert Items

    /***
     * @param array $data
     * @return object|$this\
     */
    public function insert(array $data): object
    {
        $columns = '';
        $values = '';

        foreach ($data as $key => $value) {
            $columns .= "`$key`,";
            $values .= "'$value',";
        }

        $columns = rtrim($columns, ',');
        $values = rtrim($values, ',');

        $this->sql = "INSERT INTO `$this->tableName` ($columns) VALUES ($values)";

        return $this;
    }
    // Return all data from select

    /***
     * @return array
     */
    public function all(): array
    {
        $query = mysqli_query($this->connection, $this->sql);
        if ($query) {
            return mysqli_fetch_all($query, MYSQLI_ASSOC);
        } else {
            echo "Error: " . mysqli_error($this->connection) . "<br>";
            return [];
        }

    }

    /**
     * @return array
     */
    public function first(): array
    {
        $query = mysqli_query($this->connection, $this->sql);
        if ($query) {
            return mysqli_fetch_assoc($query);
        } else {
            echo "Error: " . mysqli_error($this->connection) . "<br>";
            return [];
        }

    }

    /**
     * @return object|$this
     */
    public function delete(): object
    {
        $this->sql = "DELETE FROM `$this->tableName` ";
        return $this;
    }
// Magic Method To close Connection after object Finish its work
    public function __destruct()
    {
        mysqli_close($this->connection);
    }
}


// Usage
// $db = new DB('server', 'DB-USER', 'DB-PASS', 'DB-Name');


// // Select data from a table  with  where
// echo "<pre>";
// $result = $db->table('users')
//     ->select()
//     ->where('id', '=', '90')
//     -> orWhere('username' , '=' , 'user')
//     ->first();

// print_r($result);


// // Select data from a table
//     echo "<pre>";
// print_r($db->table('users')
//     ->select()
//     ->first());


// Insert
// $result = $db->table('test')
//     ->insert([
//         'name' => 'donia alhosin mohamed',
//     ])
//     ->execute();

// if ($result) {
//     echo "Insert successful!";
// } else {
//     echo "Insert failed.";
// }


// Delete Row
// echo "<pre>";
// $result = $db->table('users')
//     ->delete()
//     ->where('id', '=', 7)
//     -> execute();


// print_r($result)


// Update a table with a condition
//$result = $db->table("users")
//    ->update([
//        'username' => "donia2000"
//    ])
//    ->where("username", "=", 'donia')
//    ->execute();
//print_r($result);





?>