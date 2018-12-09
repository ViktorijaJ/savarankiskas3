<?php
class DBConn
{
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $db = "kcs";
    private $conn;
    function __construct()
    {
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->db);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }
    public function printAnyTable($result)
    {
        if ($result->num_rows > 0) {
            echo "<table>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr><form action='#' method='get'>";
                foreach ($row as $key => $value) { //key - stulpelio pavadinimas, value - reiksme
                    echo "<td><input type='text' name='$key' value='$value'></td>";
                }
                echo "<td><input type='submit' name='action' value='Trinti'><input type='submit' name='action' value='Saugoti'></td></form></tr>";
            }
            echo "</table>";
        } else {
            echo "0 results";
        }
    }
    public function getAutoInfo()
    {
        $q = "SELECT * FROM `savarankiskas3`;";
        return $this->conn->query($q);
    }
    public function prideti($nr, $marke, $modelis, $metai, $lGreitis, $fGreitis, $bauda, $sumoketa)
    {
        $q = "INSERT INTO `savarankiskas3` ( `nr`, `marke`, `modelis`, `metai`, `leistgreitis`, `fiksgreitis`,`bauda`, `sumoketa`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($q);
        $stmt->bind_param("sssiiiis", $nr, $marke, $modelis, $metai, $lGreitis, $fGreitis, $bauda, $sumoketa);
        $stmt->execute();
    }
    public function delete($id)
    {
        $q = "DELETE FROM `savarankiskas3` WHERE `id` = ?";
        $stmt = $this->conn->prepare($q);
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
    public function save($id, $nr, $marke, $modelis, $metai, $lGreitis, $fGreitis, $bauda, $sumoketa)
    {
        $q = "UPDATE `savarankiskas3` SET `nr` = ?, `marke` = ?, `modelis` = ?, `metai` = ?, `leistgreitis` = ?, `fiksgreitis` =?, `bauda` = ?, `sumoketa` = ? WHERE `id` = ?;";
        $stmt = $this->conn->prepare($q);
        $stmt->bind_param("sssiiiisi", $nr, $marke, $modelis, $metai, $lGreitis, $fGreitis, $bauda, $sumoketa, $id);
        $stmt->execute();
    }
    public function rikiuotiBD()
    {
        $q = "SELECT * FROM `savarankiskas3` ORDER BY `savarankiskas3`.`bauda` ASC;";
        return $this->conn->query($q);
    }
    public function rikiuotiVG()
    {
        $q = "SELECT * FROM `savarankiskas3` ORDER BY `savarankiskas3`.`fiksgreitis` ASC;";
        $stmt = $this->conn->query($q);
        return $stmt;
    }
    public function rikiuotiPM()
    {
        $q = "SELECT * FROM `savarankiskas3` ORDER BY `savarankiskas3`.`metai` ASC;";
        return $this->conn->query($q);
    }
    public function rikiuotiSUM()
    {
        $q = "SELECT * FROM `savarankiskas3` ORDER BY `savarankiskas3`.`sumoketa` ASC;";
        return $this->conn->query($q);
    }
}