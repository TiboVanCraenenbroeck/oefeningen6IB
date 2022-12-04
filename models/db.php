<?php
class DB
{
    private $servername = "mysql_db";
    private $username = "root";
    private $password = "root";
    private $dbName = "test";
    private $conn = null;

    function create_connection()
    {
        $this->conn = mysqli_connect($this->servername, $this->username, $this->password, $this->dbName);
        if (!$this->conn)
        {
            die("Connection failed: " . mysqli_connect_error());
        }
    }
    function close_connection()
    {
        mysqli_close($this->conn);
    }
    function select_data($sql, $datatypes, ...$parameters)
    {
        $resultaat = [];
        $this -> create_connection();

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param($datatypes, ...$parameters);
        $stmt->execute();
        $resultaat_db = $stmt->get_result();
        while($rij = $resultaat_db->fetch_assoc())
        {
            $resultaat[] = $rij;
        }
        $stmt->close();
        $this-> close_connection();
        return $resultaat;
    }
    function rij_toevoegen_bewerken_verwijderen($sql, $datatypes, ...$parameters)
    {
        $isGelukt = False;

        $this -> create_connection();
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param($datatypes, ...$parameters);
        $stmt->execute();
        if($stmt->affected_rows > 0)
        {
            $isGelukt = True;
        }
        $stmt->close();
        $this-> close_connection();
        return $isGelukt;
    }
}

?>