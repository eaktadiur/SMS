<?php

function escape($string) {
    if (strlen($string) > 0){
        return htmlentities($string, ENT_QUOTES, 'UTF-8');
    }  else {
        return '';    
    }
}

//Boosttrap validation
function comboBox($name, $data, $selectedValue, $allowNull, $class = null, $validation = null, $onChangeFunction = null) {

    $onChange = $onChangeFunction == '' ? '' : "$onChangeFunction";
    ?>
    <select name='<?php echo $name; ?>' id='<?php echo $name; ?>ID' class='<?php echo $class; ?>' <?php echo $validation; ?> onChange= "<?php echo $onChange; ?>"  

            <?php
            if (array_key_exists('readonly', $_REQUEST))
                echo "disabled=true ";
            echo ">\n";
            if ($allowNull)
                echo "<option></option>";
            for ($j = 0; $j < count($data); $j++) {
                $option = $data[$j];
                if (count($option) > 3)
                    $label = $option[1] . ' - ' . $option[2] . ' - ' . $option[3];
                else if (count($option) > 2)
                    $label = $option[1] . ' - ' . $option[2];
                else if (count($option) > 1)
                    $label = $option[1];
                else
                    $label = $option[0]; echo "<option value='$option[0]' ";
                if ($option[0] == $selectedValue)
                    echo "selected";
                echo ">$label</option>";
            }
            echo "</select>";
        }

?>