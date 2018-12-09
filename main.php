<?php
include_once "DBConn.php";
$obj = new DBConn();
if (isset($_REQUEST["action"])) {
    $action = $_REQUEST["action"];
    switch ($action) {
        case "Pridėti":
            $nr = $_REQUEST["nr"];
            $marke = $_REQUEST["marke"];
            $modelis = $_REQUEST["modelis"];
            $metai = $_REQUEST["metai"];
            $lGreitis = $_REQUEST["lGreitis"];
            $fGreitis = $_REQUEST["fGreitis"];
            $bauda = isset($_REQUEST["bauda"]) ? $_REQUEST["bauda"] : "0";
            $sumoketa = isset($_REQUEST["sumoketa"]) ? $_REQUEST["sumoketa"] : "0";
            if ($bauda == "") {
                $bauda = ($fGreitis - $lGreitis) * 2.3;
            }
            $obj->prideti($nr, $marke, $modelis, $metai, $lGreitis, $fGreitis, $bauda, $sumoketa);
            break;
        case "Trinti":
            $obj->delete($_REQUEST["id"]);
            break;
        case "Saugoti":
            $id = $_REQUEST["id"];
            $nr = $_REQUEST["nr"];
            $marke = $_REQUEST["marke"];
            $modelis = $_REQUEST["modelis"];
            $metai = $_REQUEST["metai"];
            $lGreitis = $_REQUEST["leistgreitis"];
            $fGreitis = $_REQUEST["fiksgreitis"];
            $bauda = isset($_REQUEST["bauda"]) ? $_REQUEST["bauda"] : "";
            $sumoketa = isset($_REQUEST["sumoketa"]) ? $_REQUEST["sumoketa"] : "0";
            $obj->save($id, $nr, $marke, $modelis, $metai, $lGreitis, $fGreitis, $bauda, $sumoketa);
            break;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>

    <?php
    include("styles.php");
    ?>

</head>
<body>
<hr width="100%"
<br>
<h1>Duomenų bazės informacija:</h1>
<table id="main">
    <tr>
        <td>ID</td>
        <td>Auto numeriai</td>
        <td>Auto markė</td>
        <td>Auto modelis</td>
        <td>Pagaminimo metai</td>
        <td>Leistinas greitis</td>
        <td>Fiksuotas greitis</td>
        <td>Bauda</td>
        <td>Sumokėta</td>
        <td>Veiksmai</td>

    </tr>
</table>
<?php
if (isset($_REQUEST["action"])) {
    $action = $_REQUEST["action"];
    switch ($action) {
        case "BD":
            $result = $obj->rikiuotiBD();
            $obj->printAnyTable($result);
            break;
        case "VG":
            $result = $obj->rikiuotiVG();
            $obj->printAnyTable($result);
            break;
        case "PM":
            $result = $obj->rikiuotiPM();
            $obj->printAnyTable($result);
            break;
        case "SUM":
            $result = $obj->rikiuotiSUM();
            $obj->printAnyTable($result);
            break;
        default:
            $result = $obj->getAutoInfo();
            $obj->printAnyTable($result);
    }
}
?>
<br>
<hr width="100%">
<br>

<h3>Duomenis rikiuoti pagal: </h3>
<form action="#" method="get">
    <input type="radio" name="action" value="BD">Baudos dydį</input>
    <input type="radio" name="action" value="VG">Viršytą greitį</input>
    <input type="radio" name="action" value="PM">Pagaminimo metus</input>
    <input type="radio" name="action" value="SUM">Ar bauda sumokėta</input>
    <br>

    <input type="submit" value="Rikiuoti">

</form>
<br>
<hr width="100%"
<br> <br>
<h3>Pridėti naują informaciją: </h3>
<form action="#" method="get">
    <input type="text" name="nr" class="info" placeholder="Auto numeriai">
    <input type="text" name="marke" class="info" placeholder="Auto markė">
    <input type="text" name="modelis" class="info" placeholder="Auto modelis">
    <input type="text" name="metai" class="info" placeholder="Pagaminimo metai">
    <input type="text" name="lGreitis" class="info" placeholder="Leistinas greitis">
    <input type="text" name="fGreitis" class="info" placeholder="Fiksuotas greitis">
    <input type="text" name="bauda" class="info" placeholder="Bauda">
    <input type="text" name="sumoketa" class="info" placeholder="Ar sumokėta">

    <br> <br>
    <input type="submit" name="action" value="Pridėti">
</form>

<br>
<hr width="100%"

</body>
</html>