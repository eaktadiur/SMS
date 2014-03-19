<?php
require_once '../lib/DbManager.php';

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

$tableList = rs2array("SHOW TABLES");

include '../body/header.php';
?>
<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Dashboard
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Student</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content box">

        <form action="" autocomplete="off" method="POST">
            <?php
            comboBox('table', $tableList, $table, TRUE);
            ?>
            <button type="submit" name="Submit">Show</button>
        </form>

        <?php if ($table) { ?>
            <div class="row-fluid">
                <div class="box box-success">
                    <div class="box-header">
                        <h3 class="box-title">Quick Example</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form action="" autocomplete="off" method="POST">

                        <div class="col-lg-12">
                            <div class="col-lg-6">

                                <?php
                                $Result = fromDraw($db_name, $table);

                                $totalField = mysqli_num_rows($Result);
                                $totalField = $totalField - 4;
                                if ($Result) {
                                    while ($row = $Result->fetch_row()) {

                                        //ORDINAL_POSITION even
                                        if ($row[1] % 2 == 0 && $row[1] <= $totalField) {
                                            ?>

                                            <div class="box-body">
                                                <div class="form-group">
                                                    <label for="<?php echo $row[0]; ?>"><?php echo $row[0]; ?></label>
                                                    <?php
                                                    if ($row[3] == 'varchar') {
                                                        if ($row[4] == 3) {
                                                            $required = $row[2] == 'YES' ? '' : 'required';
                                                            echo "<input type='checkbox' name='$row[0]' $required id='$row[0]'/>";
                                                        } else {
                                                            $required = $row[2] == 'YES' ? '' : 'required';
                                                            echo "<input type='text' name='$row[0]' $required class='form-control' id='$row[0]' placeholder='Enter $row[0]'/>";
                                                        }
                                                    } elseif ($row[3] == 'int') {
                                                        if ($row[10] == 'FOREIGN KEY') {

                                                            $a = $row[8];
                                                            //echo $b = '$' . $a . 'List';
                                                            $sql = "SELECT $row[9], Name FROM $row[8]";
                                                            //$sql = "SELECT DESIGNATION_ID, DESIGNATION_NAME FROM designation";
                                                            $data = rs2array($sql);

                                                            comboBox($row[0], $data, '', TRUE, 'form-control');
                                                        } else {
                                                            $required = $row[2] == 'YES' ? '' : 'required';
                                                            echo "<input type='text' name='$row[0]' $required class='form-control' id='$row[0]'/>";
                                                        }
                                                    } elseif ($row[3] == 'set') {
                                                        // if column type is set
                                                        //echo "<pre>";
                                                        $arr = str_replace('set', 'array', $row[5]);
                                                        $loop = eval("return $arr;");
                                                        foreach ($loop as $key => $value) {
                                                            echo "$value <input type='checkbox' name='$value' $required class='form-control' id='$value'/>";
                                                        }

                                                        //echo "</pre>";
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


                            <div class="col-lg-6">

                                <?php
                                $Result = fromDraw($db_name, $table);
                                if ($Result) {
                                    while ($row = $Result->fetch_row()) {

                                        //ORDINAL_POSITION even
                                        if ($row[1] % 2 == 1 && $row[1] <= $totalField && $row[1] > 1) {
                                            ?>

                                            <div class="box-body">
                                                <div class="form-group">
                                                    <label for="<?php echo $row[0]; ?>"><?php echo $row[0]; ?></label>
                                                    <?php
                                                    if ($row[3] == 'varchar') {
                                                        $required = $row[2] == 'YES' ? '' : 'required';
                                                        echo "<input type='text' name='$row[0]' $required class='form-control' id='$row[0]'/>";
                                                    } elseif ($row[3] == 'int') {
                                                        if ($row[10] == 'FOREIGN KEY') {
                                                            $a = $row[8];
                                                            //echo $b = '$' . $a . 'List';
                                                            $sql = "SELECT $row[9], Name FROM $row[8]";
                                                            $data = rs2array($sql);

                                                            comboBox($row[0], $data, '', TRUE, 'form-control');
                                                        } else {
                                                            $required = $row[2] == 'YES' ? '' : 'required';
                                                            echo "<input type='text' name='$row[0]' $required class='form-control' id='$row[0]'/>";
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
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>

                </div><!-- /.box -->
            </div>
        <?php } ?>



    </section><!-- /.content -->
</aside><!-- /.right-side -->



<?php include '../body/footer.php'; ?>