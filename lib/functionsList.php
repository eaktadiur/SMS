<?php

function fromDraw($db_name, $table) {
    $sqlSchema = "SELECT c.COLUMN_NAME, c.ORDINAL_POSITION, IS_NULLABLE, DATA_TYPE,
    CHARACTER_MAXIMUM_LENGTH, COLUMN_TYPE, COLUMN_KEY, COLUMN_COMMENT,
    kcu.REFERENCED_TABLE_NAME, kcu.REFERENCED_COLUMN_NAME, tc.CONSTRAINT_TYPE


    FROM information_schema.`COLUMNS` c
    LEFT JOIN information_schema.KEY_COLUMN_USAGE kcu ON kcu.TABLE_SCHEMA=c.TABLE_SCHEMA AND kcu.TABLE_NAME=c.TABLE_NAME AND kcu.COLUMN_NAME=c.COLUMN_NAME
    LEFT JOIN information_schema.TABLE_CONSTRAINTS tc ON tc.CONSTRAINT_NAME=kcu.CONSTRAINT_NAME AND tc.CONSTRAINT_SCHEMA=c.TABLE_SCHEMA AND tc.CONSTRAINT_NAME=kcu.CONSTRAINT_NAME AND tc.TABLE_NAME=c.TABLE_NAME

    WHERE c.TABLE_SCHEMA='$db_name' AND c.TABLE_NAME='$table'";

    $result = query($sqlSchema);
    return $result;
}

$showDataList = array(array('20', '20'), array('50', '50'), array('100', '100'), array('200', '200'));
$weeklist = array(array('1', 'Sat'), array('2', 'Sun'), array('3', 'Mon'), array('4', 'Tue'), array('5', 'Wed'), array('6', 'Thu'), array('7', 'Fri'), array('8', 'Daily'), array('9', 'Monthly'));
?>

