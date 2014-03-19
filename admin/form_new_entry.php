<?php
include_once '../lib/db-settings.php';
include_once '../body/header.php';


$table = getParam('table');


if (isSave()) {

    $Unit = array(
        'unit' => "UnitId", //table name
        "$searchId" => "$employeeId",
        'Name' => "Name"
    );

    saveTable($Unit);
    echo "<script>location.replace('../unit/index.php');</script>";
}

//$field = "s"; // The field that contains the ENUM
//$result = mysql_query('show columns from ' . $table . ';');
//while ($tuple = mysql_fetch_assoc($result)) {
//    if ($tuple['Field'] == $field) {
//        $types = $tuple['Type'];
//        $beginStr = strpos($types, "(") + 1;
//        $endStr = strpos($types, ")");
//        $types = substr($types, $beginStr, $endStr - $beginStr);
//        $types = str_replace("'", "", $types);
//        $types = split(',', $types);
//        if ($sorted)
//            sort($types);
//        break;
//    }
//}
//print_r(enum_values('gander', "s"));
//function enum_values($table, $column_name) {
//    echo $sql = "
//        SELECT COLUMN_TYPE 
//        FROM INFORMATION_SCHEMA.COLUMNS
//        WHERE TABLE_NAME = '" . mysql_real_escape_string($table_name) . "' 
//            AND COLUMN_NAME = '" . mysql_real_escape_string($column_name) . "'
//    ";
//    $result = query($sql) or die(mysql_error());
//    $row = $result->fetch_array();
//    $enum_list = explode(",", str_replace("'", "", substr("enum('d','a')", 5, (strlen("enum('d','a')") - 6))));
//    return $enum_list;
//}

$tableList = rs2array("SHOW TABLES");

function genderList() {
    return $genderList = array(
        'type' => 'checkbox',
        '1' => 'Male',
        '2' => 'Female'
    );
}
?>
<div class="row-fluid sortable">		
    <div class="box span12 hidden-print">
        <div class="box-header well" data-original-title>
            <h3>
                <a href="#">Home</a> <span class="divider">/</span>
                <a href="#">Form Generate</a>
            </h3>
        </div>
        <div class="box-content">
            <form action="" autocomplete="off" method="POST">
                <?php
                comboBox('table', $tableList, $table, TRUE);
                ?>
                <button type="submit" name="Submit">Show</button>
            </form>
            <hr>
            <?php if ($table) { ?>
                <form action="" autocomplete="off" method="POST">
                    <div class="span12">
                        <div class="span6">

                            <?php
                            $sqlSchema = "SELECT  
                            c.COLUMN_NAME, c.ORDINAL_POSITION, IS_NULLABLE, DATA_TYPE,
                            CHARACTER_MAXIMUM_LENGTH, COLUMN_TYPE, COLUMN_KEY, COLUMN_COMMENT,
                            kcu.REFERENCED_TABLE_NAME, kcu.REFERENCED_COLUMN_NAME, tc.CONSTRAINT_TYPE


                            FROM information_schema.`COLUMNS` c
                            LEFT JOIN information_schema.KEY_COLUMN_USAGE kcu ON kcu.TABLE_SCHEMA=c.TABLE_SCHEMA AND kcu.TABLE_NAME=c.TABLE_NAME AND kcu.COLUMN_NAME=c.COLUMN_NAME
                            LEFT JOIN information_schema.TABLE_CONSTRAINTS tc ON tc.CONSTRAINT_NAME=kcu.CONSTRAINT_NAME AND tc.CONSTRAINT_SCHEMA=c.TABLE_SCHEMA AND tc.CONSTRAINT_NAME=kcu.CONSTRAINT_NAME AND tc.TABLE_NAME=c.TABLE_NAME

                            WHERE c.TABLE_SCHEMA='$db_name' AND c.TABLE_NAME='$table'";

                            $Result = query($sqlSchema);

                            $totalField = mysqli_num_rows($Result);
                            $totalField = $totalField - 4;
                            if ($Result) {
                                while ($row = $Result->fetch_row()) {

                                    //ORDINAL_POSITION even
                                    if ($row[1] % 2 == 0 && $row[1] <= $totalField) {
                                        ?>

                                        <div class="form-group">
                                            <label for="<?php echo $row[0]; ?>" class="col-sm-2 control-label"><?php echo $row[0]; ?></label>
                                            <div class="col-sm-10">
                                                <?php
                                                if ($row[3] == 'varchar') {
                                                    if ($row[4] == 3) {
                                                        $required = $row[2] == 'YES' ? '' : 'required';
                                                        echo "<input type='checkbox' name='$row[0]' $required class='' id='$row[0]'/>";
                                                    } else {
                                                        $required = $row[2] == 'YES' ? '' : 'required';
                                                        echo "<input type='text' name='$row[0]' $required class='form-input' id='$row[0]'/>";
                                                    }
                                                } elseif ($row[3] == 'int') {
                                                    if ($row[10] == 'FOREIGN KEY') {

                                                        $a = $row[8];
                                                        //echo $b = '$' . $a . 'List';
                                                        $sql = "SELECT $row[9], Name FROM $row[8]";
                                                        //$sql = "SELECT DESIGNATION_ID, DESIGNATION_NAME FROM designation";
                                                        $data = rs2array($sql);

                                                        comboBox($row[0], $data, '', TRUE, 'form-input');
                                                    } else {
                                                        $required = $row[2] == 'YES' ? '' : 'required';
                                                        echo "<input type='text' name='$row[0]' $required class='form-input' id='$row[0]'/>";
                                                    }
                                                } elseif ($row[3] == 'set') {
                                                    // if column type is set
                                                    echo "<pre>";
                                                    $arr = str_replace('set', 'array', $row[5]);
                                                    $loop = eval("return $arr;");
                                                    foreach ($loop as $key => $value) {
                                                        echo "$value <input type='checkbox' name='$value' $required class='form-input' id='$value'/>";
                                                    }
                                                    //print_r($loop);
                                                    //$arr = str_replace('set', 'array', $row[5]);
                                                    //$loop = eval("return $row[7];");
                                                    //print_r($loop);
                                                    echo "</pre>";
                                                }
                                                ?>
                                            </div>
                                        </div>


                                        <?php
                                    }
                                }
                            }
                            $Result->close();
//dbLink()->next_result();
                            ?>
                        </div>


                        <div class="span6">

                            <?php
                            $Result = query($sqlSchema);
                            if ($Result) {
                                while ($row = $Result->fetch_row()) {

                                    //ORDINAL_POSITION even
                                    if ($row[1] % 2 == 1 && $row[1] <= $totalField && $row[1] > 1) {
                                        ?>

                                        <div class="form-group">
                                            <label for="<?php echo $row[0]; ?>" class="col-sm-2 control-label"><?php echo $row[0]; ?></label>
                                            <div class="col-sm-10">
                                                <?php
                                                if ($row[3] == 'varchar') {
                                                    $required = $row[2] == 'YES' ? '' : 'required';
                                                    echo "<input type='text' name='$row[0]' $required class='form-input' id='$row[0]'/>";
                                                } elseif ($row[3] == 'int') {
                                                    if ($row[10] == 'FOREIGN KEY') {
                                                        $a = $row[8];
                                                        //echo $b = '$' . $a . 'List';
                                                        $sql = "SELECT $row[9], Name FROM $row[8]";
                                                        $data = rs2array($sql);

                                                        comboBox($row[0], $data, '', TRUE, 'form-input');
                                                    } else {
                                                        $required = $row[2] == 'YES' ? '' : 'required';
                                                        echo "<input type='text' name='$row[0]' $required class='form-input' id='$row[0]'/>";
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>


                                        <?php
                                    }
                                }
                            }
                            $Result->close();
                            ?>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group">
                        <button type="submit" name="save" class="btn btn-primary">
                            <i class="icon icon-save"></i> Save Employee
                        </button>
                        <button type="button" class="btn btn-primary" onclick="goBack();">
                            <i class="icon-white icon-arrow-left"></i> 
                            Go Back
                        </button>
                        <a href="index.php" class="btn btn-primary">Employee List</a>
                    </div> 
                </form>
            <?php } ?>
        </div>
    </div><!--/span-->       
</div>

<?php
include("../body/footer.php");
?>