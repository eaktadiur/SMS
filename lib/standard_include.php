<?php

function saveTable($array) {
    $field = '';
    $fieldValue = '';
    $i = 0;
    foreach ($array as $key => $value) {
        if ($i == 0) {
            $table = $key;
            $primaryKey = $value;
        } elseif ($i == 1) {
            $searchId = $key;
            $userId = $value;
        } else {
            $field.=$key . ', ';
            $val = getParam("$value");
            $fieldValue.="'$val', ";
        }
        $i++;
    }

    $field.='CreatedBy, CreatedDate';
    $fieldValue.="'$userId', NOW()";
    $sql = "INSERT INTO `$table` ($field) VALUES($fieldValue)";
    try {
        query($sql);
    } catch (PDOException $e) {
        echo "Error " . $e->errorInfo();
    }
}

function updateTable($array) {
    $field = '';
    $update = '';
    $fieldValue = '';
    $i = 0;
    foreach ($array as $key => $value) {
        if ($i == 0) {
            $table = $key;
            $primaryKey = $value;
        } elseif ($i == 1) {
            $searchId = $key;
            $userId = $value;
        } else {
            $field = $key;
            $val = $_POST[$value];
            $fieldValue = "'$val', ";
            $update.="$field" . '=' . "$fieldValue";
        }
        $i++;
    }

    $field.='ModifiedBy, ModifiedDate';
    $sql = "UPDATE `$table` SET $update ModifiedBy='$userId', ModifiedDate=NOW() WHERE $primaryKey='$searchId'";
    query($sql);
}

function deleteTable($array) {
    $field = '';
    $update = '';
    $fieldValue = '';
    $i = 0;
    foreach ($array as $key => $value) {
        if ($i == 0) {
            $table = $key;
            $primaryKey = $value;
        } elseif ($i == 1) {
            $searchId = $key;
            $userId = $value;
        }
        $i++;
    }

    $fieldValue.="'rajib', NOW()";
    echo $sql = "DELETE FROM $table WHERE $primaryKey='$searchId'";
    //query($sql);
}

function find($sql, $dummy = false) {

    $result = query($sql);
    $row = $result->fetch_object();

    if (!$row) {
        if ($dummy)
            return new Dummy();
        else
            return null;
    }


    return $row;
}

function findValue($sql, $default = null) {
    $rs = query($sql);
    $row = $rs->fetch_array();
    if ($row == null)
        return $default;
    if ($row[0] == null)
        return $default;

    return $row[0];
}

function rs2array($sql) {
    $sql_result = query($sql);
    $result = array();
    while ($row = $sql_result->fetch_row()) {
        $result[] = $row;
    }
    return $result;
}

function query($sql) {

    global $mysqli;

    $q = $mysqli->query($sql) or die($sql);

    return $q;
}

function authenticate($userName) {

    if (strstr($_SERVER['SCRIPT_NAME'], 'login.php'))
        return;
    if (array_key_exists('logout', $_GET)) {
        logout();
        echo "<script>location.replace('../common/index.php');</script>";
        showLoginDialog();
        return;
    }
    if ($userName)
        return;

    $userSupplied = isset($_SERVER['PHP_AUTH_USER']) || !isEmpty($userName);
    if (!$userSupplied) {
        //echo "dddddddddddddddddddddd";
        showLoginDialog();
        return;
    }

    if (!login())
        die();
}

function showLoginDialog($mess = null) {
    $_SESSION['ORG_SCRIPT_NAME'] = $_SERVER['SCRIPT_NAME'];
    include ('../common/index.php');
    include ('../body/footer.php');
    die();
    //header("Location: ../common/index.php");
    //return false;
}

function destroySession($name) {
    if (isset($_SESSION[$name])) {
        $_SESSION[$name] = NULL;
        unset($_SESSION[$name]);
    }
}

function login() {
    $username = null;
    if (array_key_exists('PHP_AUTH_USER', $_SERVER))
        $username = $_SERVER['PHP_AUTH_USER'];
    if (isEmpty($username))
        $username = getParam('username');
    $pwd = null;
    if (array_key_exists('PHP_AUTH_PW', $_SERVER))
        $pwd = $_SERVER['PHP_AUTH_PW'];
    if (isEmpty($pwd))
        $pwd = getParam('password');

    $password = md5($pwd);
    //$Company = 102;
    $Company = getParam('company');

    $escaped_password = $password;
    $sql = "SELECT e.RoleId, e.DesignationId, e.NextApprovalId,
            e.EmployeeId, d.`Name` AS 'dName', c.CompanyID, c.`Code`,
             c.`Name` AS cName, c.LogoPath
            FROM user_table AS ut
            INNER JOIN employee AS e ON e.EmployeeId=ut.EmployeeId
            LEFT JOIN designation d ON d.DesignationId=e.DesignationId
            LEFT JOIN company c ON c.CompanyID=e.CompanyId
            WHERE UserName='$username' AND `Password`='$escaped_password' AND c.`Code`='$Company'";
    $user = find($sql);

    if (!$user) {
        echo "<script>location.replace('../common/index.php');</script>";
    } else {
        set('userType', $user->RoleId);
        set('designationId', $user->DesignationId);
        set('userName', $username);
        set('employeeId', $user->EmployeeId);
        set('companyId', $user->CompanyID);
        set('companyName', "$user->cName");
        set('roleId', "$user->RoleId");
        set('nextApprovalId', $user->NextApprovalId);
        set('cCode', $user->Code);
        set('logoPath', $user->LogoPath);
    }

    $remoteHost = $_SERVER['REMOTE_ADDR'];


    query("insert into user_session (username, logintime, remote_host) values ('$username', NOW(), '$remoteHost')");

    echo "<script>location.replace('../index/index.php');</script>";
}

function CheckUserPermission($userName) {

    $link = str_replace('/primebank', '..', $_SERVER['REQUEST_URI']);

    $MenuMainId = findValue("SELECT SYS_MENU_ID FROM sys_menu WHERE LINKS LIKE '%$link%'");

    $sql = "SELECT MENU_SUB_ID
        FROM user_level ul 
        INNER JOIN master_user mu ON mu.USER_LEVEL_ID=ul.USER_LEVEL_ID
        WHERE USER_NAME='$userName'";
    $MENU_SUB_ID = findValue($sql);

    $permitied_menu = array_flip(explode(",", $MENU_SUB_ID));
    if (!array_key_exists($MenuMainId, $permitied_menu)) {
        //echo "<h2 align='center'>Unauthorized, you need this permission</h2>";
        //die();
    }
}

function hours2minutes($hours) {
    $hours = strtok($hours, ":.");
    $minutes = strtok(":.");
    return $hours * 60 + $minutes;
}

function minutes2hours($minutes) {
    $hours = floor($minutes / 60);
    $minutes = $minutes - $hours * 60;
    return sprintf("%02d:%02d", $hours, $minutes);
}

function isEmpty($str) {
    return (strlen(trim($str)) == 0) || ($str == "null");
}

function escape($string) {
    $string = htmlspecialchars($string);
    if (get_magic_quotes_runtime())
        $string = stripslashes($string);
    return $string;
}

#-#escape()

function getParam($name, $default = null) {
    global $mysqli;
    if (array_key_exists($name, $_REQUEST)) {
        $param = $_REQUEST[$name];

        if (is_string($param)) {
            $param = $mysqli->real_escape_string("$param");
        } else {
            $param = $_REQUEST[$name];
        }
        //$param = $_REQUEST[$name];
        if ($default != null && isEmpty($param)) {
            return $default;
        }
        return $param;
    } else
        return $default;
}

function formatCase($str) {
    $first = substr($str, 0, 1);
    $first = strtoupper($first);
    $tail = substr($str, 1);
    return $first . $tail;
}

function onChange($onChange) {
    return "ajaxLoader('$onChange.php?val='+this.value+'', '$onChange', '<img src=../public/images/loading.gif />');";
}

function file_upload_edit($search_id, $module, $multiple = NULL) {
    ?>
    <br>
    <?php
    if ($multiple != "") {
        echo "<button type='button' onclick='addFileMore();' class = 'btn btn-primary'><i class='icon-white icon-plus-sign'></i> Add</button> <br/>";
    }
    ?>
    <table class="table table-striped table-bordered table-condensed" id="attachment_tab">
        <thead>
        <th width="30">SL.</th>
        <th align="left">Attachment Tittle</th>
        <th align="left">File</th>
        <th width="50">Action</th>
    </thead>
    <tbody>
        <?php
        $j = 1;
        $ResultAttachment = attachResult($search_id, $module);
        while ($rowAttachment = $ResultAttachment->fetch_object()) {
            ?>
            <tr>
                <td><?php echo $j; ?>.</td>
                <td><?php echo $rowAttachment->ATTACH_TITTLE; ?></td>
                <td align="center"><a href='../PR/<?php echo $rowAttachment->ATTACH_FILE_PATH; ?>' target='_blank'>View </a></td>
                <td><div class='remove float-right' id="<?php echo $rowAttachment->FILE_ATTACH_LIST_ID; ?>" ><img src='../public/images/delete.png'/></div></td>
            </tr>

            <?php
            $j++;
        }
        ?>
    </tbody>
    </table>
    <?php
}

function file_upload_view($searchId, $module) {
    ?>
    <br>
    <table class="productGrid" id="attachment_tab">
        <thead>
        <th width="20">SL.</th>
        <th align="left">Attachment Tittle</th>
        <th width="80" align="right">Action</th>
    </thead>
    <tbody>
        <?php
        $j = 1;
        $ResultAttachment = attachResult($searchId, $module);

        while ($rowAttachment = $ResultAttachment->fetch_object()) {
            ?>
            <tr>
                <td><?php echo $j; ?>.</td>
                <td><?php echo $rowAttachment->ATTACH_TITTLE; ?></td>
                <td align="center"><a href='<?php echo $rowAttachment->ATTACH_FILE_PATH; ?>' target="_blank" class="">View </a></td>
            </tr>
            <?php
            $j++;
        }
        ?>
    </tbody>
    </table>
    <?php
}

function parseDate($datestr) {
    if (isEmpty($datestr))
        return null;
    if (strlen($datestr) == 10) {
        if (strstr($datestr, '-') === FALSE) {
            return $datestr;
        }
        if (DATE_PATTERN == 'Y-m-d') {
            $year = strtok($datestr, '-');
            $month = strtok('-');
            $day = strtok('-');
            $date = mktime(0, 0, 0, $month, $day, $year);
            return $date;
        }
    }
    return strtotime($datestr);
}

function formatDate($date) {
    if ($date == null)
        return "";
    $date = 0 + $date;
    return date(DATE_PATTERN, $date);
}

function parseTime($hhmm) {
    $hh = strtok($hhmm, ":.,");
    $mm = strtok(":.,");
    if (isEmpty($mm) && strlen($hhmm) == 4) {
        $hh = substr($hhmm, 0, 2);
        $mm = substr($hhmm, 2, 2);
    } else {
        if ($mm == '5') {
            $mm = 30;
        }
    }
    return $hh * 60 + $mm;
}

function formatTime($minutes) {
    $hh = floor($minutes / 60);
    $mm = $minutes - $hh * 60;
    if (strlen($hh) == 1)
        $hh = "0" . $hh;
    if (strlen($mm) == 1)
        $mm = "0" . $mm;
    return $hh . ":" . $mm;
}

function formatDatetime($date) {
    return formatDate($date) . ' ' . date('H:i', $date);
}

function bddate($date) {
    if (($date != "") && ($date != "0000-00-00")) {
        list($Y, $M, $D) = explode("-", $date);
        //$date_=$D."-".$M."-".$Y;
        $date = date("d-M-Y", mktime(0, 0, 0, $M, $D, $Y));
        return $date; //25-02-2011
    }
}

function mkdatetime($date, $minutes, $seconds = 0) {
    $year = date("Y", $date);
    $month = date("m", $date);
    $day = date("d", $date);
    $hour = floor($minutes / 60);
    $minute = $minutes - $hour * 60;
    return mktime($hour, $minute, $seconds, $month, $day, $year);
}

function addDay($date, $diff = 1) {
    $year = date("Y", $date);
    $month = date("m", $date);
    $day = date("d", $date);
    $hour = date("H", $date);
    $minute = date("i", $date);
    return mktime($hour, $minute, 0, $month, $day + $diff, $year);
}

function addTime($date, $type, $diff = 1) {
    $year = date("Y", $date);
    $month = date("m", $date);
    $day = date("d", $date);
    $hour = date("H", $date);
    $minute = date("i", $date);
    if ($type == TYPE_HOURS)
        $hour += $diff;
    else if ($type == TYPE_DAYS)
        $day += $diff;
    else if ($type == TYPE_WEEKS)
        $day += $diff * 7;
    else if ($type == TYPE_MONTHS)
        $month += $diff;
    else if ($type == TYPE_YEARS)
        $year += $diff;
    return mktime($hour, $minute, 0, $month, $day, $year);
}

function roundTime($date, $type) {
    $year = date("Y", $date);
    $month = date("m", $date);
    $day = date("d", $date);
    $hour = date("H", $date);
    $minute = date("i", $date);
    if ($type == TYPE_HOURS)
        $minute = 0;
    else if ($type == TYPE_DAYS) {
        $minute = 0;
        $hour = 0;
    } else if ($type == TYPE_WEEKS) {
        return strtotime("last Sunday", $date);
    } else if ($type == TYPE_MONTHS) {
        $minute = 0;
        $hour = 0;
        $day = 1;
    }
    return mktime($hour, $minute, 0, $month, $day, $year);
}

function getYear($date) {
    return date("Y", $date);
}

function getYears($date) {
    return date("d-m-Y", $date);
}

function getAge($birthday) {
    list($year, $month, $day) = explode("-", $birthday);
    $year_diff = date("Y") - $year;
    $month_diff = date("m") - $month;
    $day_diff = date("d") - $day;
    if ($month_diff < 0)
        $year_diff--;
    elseif (($month_diff == 0) && ($day_diff < 0))
        $year_diff--;
    return $year_diff;
}

function dayDiff($date1, $date2) {
    return round(($date1 - $date2) / 24 / 3600);
}

function isSearch() {
    return array_key_exists("search", $_GET);
}

function isSave() {
    return array_key_exists("save", $_POST);
}

function isDelete() {
    return array_key_exists("delete", $_POST);
}

function isClear() {
    return array_key_exists("clear", $_POST);
}

function localdate($date) {
    list($Y, $M, $D) = explode("-", $date);
    $date = gmdate("d-m-Y", mktime(0, 0, 0, $M, $D, $Y));
    return $date;
}

function getDateTimeParam($name, $defaultDate = null) {
    $date = getParam($name . "date");
    if (isEmpty($date))
        $date = $defaultDate;
    return $date . " " . getParam($name . "time");
}

function prepNull($str) {
    if ($str == null)
        return "null";
    return $str;
}

function formatMoney($amount) {
    $amount = round($amount, 2);
    return sprintf('%9.2f', $amount);
}

function image($name) {
    echo "<img src='../public/images/$name'/>";
}

function deleteIcon($href) {
    echo "<a href='$href' onClick=\"javascript:conf=window.confirm('Delete the selected record?'); if(conf==false) { return false; }\">";
    image("delete.png");
    echo "</a>";
}

function editIcon($href) {
    echo "<a href='$href' onClick=\"javascript:conf=window.confirm('Edit the selected record?'); if(conf==false) { return false; }\">";
    image("edit.png");
    echo "</a> | ";
}

function viewIcon($href) {
    echo "<a href='$href'>";
    image("view.png");
    echo "</a> | ";
}

function deleteColumn($href) {
    echo "<td align=center>";
    deleteIcon($href);
    echo "</td>";
}

function checkBox($name, $value, $text = '', $onChange = null, $tooltip = null) {
    if (!isEmpty($text))
        $text = tr($text);
    $checked = $value == 1 || $value ? 'checked' : '';
    echo "<input type=checkbox name='$name' value='1' $checked ";
    if (array_key_exists('readonly', $_REQUEST))
        echo "disabled=true ";
    else if ($onChange != null) {
        echo " onClick='$onChange' ";
    }
    if ($tooltip != null)
        echo " title='$tooltip' ";
    echo ">$text</input>";
    $value0 = $value ? 1 : '';
    hidden("old_$name", $value0);
}

function numberBox($name, $value, $signed = false, $precision = 10, $scale = 0, $mandatory = false) {
    $length = $scale + $precision;
    if ($precision > 0)
        $length++;
    $signed = $signed ? 'true' : 'false';
    echo "<input type=text name='$name' value='$value' size=$length class=numberbox ";
    echo "onKeyPress='return onNumberKeyPress(event, this, $signed, $precision, $scale);' ";
    echo ">";
    hidden("old_$name", $value);
    if ($scale > 0)
        addValidator("validateNumber('" . tr($name) . "', document.postform.$name, $signed, $precision, $scale)");
    if ($mandatory)
        addValidator("validateMandatory('" . tr($name) . "', document.postform.$name)");
}

function getDescription($value, $list, $default = 'Unknown') {
    foreach ($list as $row) {
        if ($row[0] == $value)
            return tr($row[1]);
    }
    return $default;
}

function get($key) {
    if (isset($_SESSION[$key]))
        return $_SESSION[$key];
}

function escape_string($str) {
    if ($str !== null) {
        $str = str_replace(array('\\', '\''), array('\\\\', '\\\''), $str);
        $str = "$str";
    } else {
        $str = "null";
    }
    return $str;
}

function logout() {
    session_destroy();
}

function runScript($filename) {
    $fh = fopen($filename, 'r');
    $script = fread($fh, filesize($filename));
    fclose($fh);
    $sql = strtok($script, ";");
    while ($sql !== false) {
        if (strlen(trim($sql)) > 0)
            sql($sql);
        $sql = strtok(";");
    }
}

function getMonthStepperDate() {
    $year = getParam("year");
    if (isEmpty($year))
        $year = date("Y");
    $month = getParam("month");
    if (isEmpty($month))
        $month = date("m");
    if (!isEmpty(getParam("prev")))
        $month--;
    if (!isEmpty(getParam("next")))
        $month++;
    $date = mktime(0, 0, 0, $month, 1, $year);
    return $date;
}

function monthStepper($date) {
    echo "<center>";
    echo "<table>";
    echo "<tr>";
    echo "<td><input type='submit' name='prev' value=' < '/></td>";
    echo "<td>" . date("Y M", $date) . "</td>";
    echo "<td><input type='submit' name='next' value=' > '/></td>";
    echo "</tr>";
    echo "</table>";
    echo "</center>";
    $year = date("Y", $date);
    $month = date("m", $date);
    hidden('year', $year);
    hidden('month', $month);
}

function getYearStepperDate() {
    $year = getParam("year");
    if (isEmpty($year))
        $year = date("Y");
    if (!isEmpty(getParam("prev")))
        $year--;
    if (!isEmpty(getParam("next")))
        $year++;
    $date = mktime(0, 0, 0, 1, 1, $year);

    return $date;
}

function getYearStepperDateFY() {
    $year = getParam("year");
    if (isEmpty($year))
        $year = date("Y");
    if (!isEmpty(getParam("prev")))
        $year--;
    if (!isEmpty(getParam("next")))
        $year++;
    $date = mktime(0, 0, 0, 7, 1, $year);

    return $date;
}

function yearStepper($date) {
    echo "<center>";
    echo "<table>";
    echo "<tr>";
    echo "<td><input type='submit' name='prev' value=' < '/></td>";
    echo "<td>" . date("Y", $date) . "</td>";
    echo "<td><input type='submit' name='next' value=' > '/></td>";
    echo "</tr>";
    echo "</table>";
    echo "</center>";
    $year = date("Y", $date);
    hidden('year', $year);
}

function set($key, $value) {
    $_SESSION[$key] = $value;
}

function Paging($link, $ct, $per_page) {
    //global $totalPaggingPage;
    if ($ct == 0)
        return FALSE;
    $page = (int) isset($_GET['page']) ? intval($_GET['page']) : '';

    $to = ($page * $per_page + $per_page) < $ct ? ($page * $per_page + $per_page) : $ct;
    echo "Showing Records <b>" . ($page * $per_page + 1) . " - " . $to . "</b>  of " . $ct . "    ";

    $cnt = (int) (($ct - 1) / $per_page);
    $totalPaggingPage = $cnt;

    if ($cnt == 0)
        return;
    if ($page > 0)
        echo "<a href=\"" . $link . "&page=" . ($page - 1) . "\"><img align='absmiddle' border='0' src=\"../public/images/left_arrow.png\"></a>&nbsp;&nbsp;&nbsp;";
    for ($i = $page - 5; $i < $page + 5; $i++) {
        if ($i == $page) {
            echo "&nbsp;&nbsp;<b>[</b>" . ($i + 1) . "<b>]</b>&nbsp;&nbsp;";
        } elseif ($i >= 0 && $i <= $cnt) {
            echo "&nbsp;&nbsp;<a style='color:#000000;font-weight:bold;text-decoration:none' href=\"" . $link . "&page=" . $i . "\">" . ($i + 1) . "</a>&nbsp;&nbsp;";
        }
    }//for

    if ($page < $cnt)
        echo "&nbsp;&nbsp;&nbsp;<a href=\"" . $link . "&page=" . ($page + 1) . "\"><img align='absmiddle' border='0' src=\"../public/images/right_arrow.png\"></a>";
}

function PagingBoostrap($link, $ct, $per_page) {
    global $showPerPage;
    if ($ct == 0)
        return FALSE;
    $page = (int) isset($_GET['page']) ? intval($_GET['page']) : '';

    $to = ($page * $per_page + $per_page) < $ct ? ($page * $per_page + $per_page) : $ct;


    $cnt = (int) (($ct - 1) / $per_page);
    $totalPaggingPage = $cnt;

    if ($cnt == 0)
        return;
    if ($page > 0) {
        echo "<ul class='pagination'>"
        . "<li><a href='#'>Showing Records <b>" . ($page * $per_page + 1) . " - " . $to . "</b>  of " . $ct . "    </a></li>"
        . "<li><a href=\"" . $link . "showPerPage=$showPerPage&page=" . ($page - 1) . "\"><img align='absmiddle' border='0' src=\"../public/images/left_arrow.png\"></a></li>&nbsp;&nbsp;&nbsp;";
    } else {
        echo "<ul class='pagination'>"
        . "<li><a href='#'>Showing Records <b>" . ($page * $per_page + 1) . " - " . $to . "</b>  of " . $ct . "    </a></li>"
        . "<li class='disabled'><a href='#'><img align='absmiddle' border='0' src=\"../public/images/left_arrow.png\"></a></li>";
    }
    for ($i = $page - 5; $i < $page + 5; $i++) {
        $active = $i == $page ? 'active' : '';
        if ($i >= 0 && $i <= $cnt) {
            echo "<li class='$active'><a href=\"" . $link . "showPerPage=$showPerPage&page=" . $i . "\">" . ($i + 1) . "</a></li>";
        }
    }//for

    if ($page < $cnt) {
        echo "<li><a href=\"" . $link . "&page=" . ($page + 1) . "\"><img align='absmiddle' border='0' src=\"../public/images/right_arrow.png\"></a></li></ul>";
    } else {
        echo "<li class='disabled'><a href='#'><img align='absmiddle' border='0' src=\"../public/images/right_arrow.png\"></a></li></ul>";
    }
}

function getAllUserLevel($userName) {

    $sql = "SELECT UserLevelId,`Name`
    FROM user_level  
    WHERE UserLevelId<>1
    ORDER BY `Name`";
    $result = query($sql);
    return $result;
}

function getUserLevelByUserId($userName) {
    $sql = "SELECT ul.MainId, ul.SubId 
    FROM user_table ut
    LEFT JOIN user_level ul ON ul.UserLevelId=ut.UserLevelId
    WHERE ut.UserName='$userName'";

    $result = find($sql);
    return $result;
}

function getMenuByMenuList($mainList) {
    $sql = "SELECT MenuId, `Name`, Links, Icon
    FROM sys_menu 
    WHERE `Group` like '%main%' AND `Show` = 1 AND MenuId IN($mainList)
    ORDER BY Sort";

    $result = query($sql);
    return $result;
}

function getMenu($userName) {
    $var = getUserLevelByUserId($userName);

    $mainList = $var->MainId == '' ? '0' : $var->MainId;
    $subList = $var->MenuId;
    $main = getMenuByMenuList($mainList);
    while ($row = $main->fetch_object()) {

        echo "<li><a class='ajax-link' href='$row->Links'><i class='$row->Icon'></i><span class='hidden-tablet'> $row->Name</span></a></li>";
    }
}

function get_switcher_menu($user_name) {
    $target = "";
    $user_menu_sql = "SELECT ul.MENU_MAIN_ID, ul.MENU_SUB_ID, ul.USER_LEVEL_NAME
                FROM master_user AS u left join user_level AS ul on ul.USER_LEVEL_ID=u.USER_LEVEL_ID
                WHERE u.USER_NAME='$user_name'";

    $emp_row = find($user_menu_sql);


    $menugroup = $emp_row->MENU_MAIN_ID;
    $menuid = $emp_row->MENU_SUB_ID;

    echo "<ul class='sf-menu'>";

    $q = query("Select sys_menu_id, menu_name, links, dependency, dependency_to, target from sys_menu where _group like '%main%' and _show = 1 and sys_menu_id in($menugroup) order by _sort") or trigger_error(mysql_error(), E_USER_ERROR);
    //$q = mysql_query("Select id, name, links, dependency, dependency_to, target from sys_menu where _group like '%main%' and _show = 1 order by _sort") or trigger_error(mysql_error(), E_USER_ERROR);
    while ($d = fetch_object($q)) {

        if ($d->dependency != 1) {
            if ($d->target != "") {
                $target = "target = $d->target";
            }

            $links = "$d->links";
            echo "<li class='current'><a href='$links' $target>$d->menu_name</a>";
            $q_sub = query("Select sys_menu_id, menu_name, links, target from sys_menu where _subid = $d->sys_menu_id and _show = 1 and sys_menu_id in($menuid) order by _sort") or trigger_error(mysql_error(), E_USER_ERROR);
            //$q_sub = mysql_query("Select id, name, links, target from sys_menu where _subid = $d->id and _show = 1 order by _sort") or trigger_error(mysql_error(), E_USER_ERROR);

            if (mysql_num_rows($q_sub) != 0) {

                echo "<ul>";
                while ($d_sub = fetch_object($q_sub)) {

                    $links = "$d_sub->links";
                    echo "<li><a href='$links'>$d_sub->menu_name</a>";

//-------------sub_sub menu begain here--------------					

                    $q_sub_sub = query("Select sys_menu_id, menu_name, links, target from sys_menu where _subid = $d_sub->sys_menu_id and _show = 1 and sys_menu_id in($menuid) order by _sort") or trigger_error(mysql_error(), E_USER_ERROR);

                    if (mysql_num_rows($q_sub_sub) != 0) {
                        echo "<ul>";
                        while ($d_sub_sub = fetch_object($q_sub_sub)) {

                            $links = "$d_sub_sub->links";
                            echo "<li><a href='$links'>$d_sub_sub->menu_name</a></li>";
                        }

                        echo "</ul>";
                    } else {
                        echo "</li>";
                    }
//end-------------------------------
                }
                echo "</ul>";
            } else {
                echo "</li>";
            }
        } else {


            $links = "$d->links";
            echo "<li><a href='$links'/>$d->menu_name</a>
                    <ul>";
            $qq = query("Select menu_main_id, category_name from $d->dependency_to where _group like '%main%' order by _sort ") or trigger_error(mysql_error(), E_USER_ERROR);
            while ($dd = fetch_object($qq)) {

                $links = "$d->links";
                echo "<li>Please generate</li>";
            }
            echo "</ul>
                </li>";
        }
    }
    echo "</ul>";
}

//encrypt
function encrypt($text) {
    return trim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, SALT, $text, MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND))));
}

//decrypt
function decrypt($text) {
    return trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, SALT, base64_decode($text), MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND)));
}

function firstDayMonth() {
    return date("Y-m-d", strtotime(date('m') . '/01/' . date('Y') . ' 00:00:00'));
}

function firstDayByMonth($monthId) {
    return date("Y-m-d", strtotime($monthId . '/01/' . date('Y') . ' 00:00:00'));
}

function today() {
    return date("Y-m-d", strtotime(date('d') . '-' . date('m') . '-' . date('Y') . ' 00:00:00'));
}

function lasDayMonth() {
    return date("Y-m-d", strtotime('-1 second', strtotime('+1 month', strtotime(date('m') . '/01/' . date('Y') . ' 00:00:00'))));
}

function lasDayByMonth($monthId) {
    return date("Y-m-d", strtotime('-1 second', strtotime('+1 month', strtotime($monthId . '/01/' . date('Y') . ' 00:00:00'))));
}

function movePage($num, $url) {
    static $http = array(
        100 => "HTTP/1.1 100 Continue",
        101 => "HTTP/1.1 101 Switching Protocols",
        200 => "HTTP/1.1 200 OK",
        201 => "HTTP/1.1 201 Created",
        202 => "HTTP/1.1 202 Accepted",
        203 => "HTTP/1.1 203 Non-Authoritative Information",
        204 => "HTTP/1.1 204 No Content",
        205 => "HTTP/1.1 205 Reset Content",
        206 => "HTTP/1.1 206 Partial Content",
        300 => "HTTP/1.1 300 Multiple Choices",
        301 => "HTTP/1.1 301 Moved Permanently",
        302 => "HTTP/1.1 302 Found",
        303 => "HTTP/1.1 303 See Other",
        304 => "HTTP/1.1 304 Not Modified",
        305 => "HTTP/1.1 305 Use Proxy",
        307 => "HTTP/1.1 307 Temporary Redirect",
        400 => "HTTP/1.1 400 Bad Request",
        401 => "HTTP/1.1 401 Unauthorized",
        402 => "HTTP/1.1 402 Payment Required",
        403 => "HTTP/1.1 403 Forbidden",
        404 => "HTTP/1.1 404 Not Found",
        405 => "HTTP/1.1 405 Method Not Allowed",
        406 => "HTTP/1.1 406 Not Acceptable",
        407 => "HTTP/1.1 407 Proxy Authentication Required",
        408 => "HTTP/1.1 408 Request Time-out",
        409 => "HTTP/1.1 409 Conflict",
        410 => "HTTP/1.1 410 Gone",
        411 => "HTTP/1.1 411 Length Required",
        412 => "HTTP/1.1 412 Precondition Failed",
        413 => "HTTP/1.1 413 Request Entity Too Large",
        414 => "HTTP/1.1 414 Request-URI Too Large",
        415 => "HTTP/1.1 415 Unsupported Media Type",
        416 => "HTTP/1.1 416 Requested range not satisfiable",
        417 => "HTTP/1.1 417 Expectation Failed",
        500 => "HTTP/1.1 500 Internal Server Error",
        501 => "HTTP/1.1 501 Not Implemented",
        502 => "HTTP/1.1 502 Bad Gateway",
        503 => "HTTP/1.1 503 Service Unavailable",
        504 => "HTTP/1.1 504 Gateway Time-out"
    );
    header($http[$num]);
    header("Location: $url");
}

//File Upload
function SaveUploadFile($Request_Id, $Module_Name, $Attach_Title, $Attach_File_Path) {

    $user_name = get('user_name');

    if (isset($Attach_File_Path)) {

        foreach ($Attach_File_Path as $key => $val) {
            $MaxFile_Attach_List_Id = NextId('file_attach_list', 'FILE_ATTACH_LIST_ID');
            $insert_sql = "INSERT INTO file_attach_list(FILE_ATTACH_LIST_ID, REQUEST_ID, MODULE_NAME, ATTACH_TITTLE, ATTACH_FILE_PATH, CREATED_BY, CREATED_DATE) 
                        values('$MaxFile_Attach_List_Id', '$Request_Id', '$Module_Name', '$Attach_Title[$key]', '$Attach_File_Path[$key]', '$user_name', NOW() )";

            sql($insert_sql);
        }
    }
}

function attachResult($search_id, $module) {
    $sql = "SELECT FILE_ATTACH_LIST_ID, ATTACH_TITTLE, ATTACH_FILE_PATH
            FROM file_attach_list
            WHERE REQUEST_ID = '$search_id' AND MODULE_NAME='$module'";
    $result = query($sql);

    return $result;
}

function limit($string, $length, $end = '...', $encoding = null) {
    if (!$encoding)
        $encoding = 'UTF-8';
    $string = trim($string);
    $len = mb_strlen($string, $encoding);
    if ($len == $length)
        return $string;
    else {
        $return = mb_substr($string, 0, $length, $encoding);
        return (preg_match('/^(.<em>[^\s])\s+[^\s]</em>$/', $return, $matches) ? $matches[1] : $return) . $end;
    }
}

function file_upload_save($targetFolder, $req_id, $module) {
    //$targetFolder = '../documents/PR/'; // Relative to the root

    $AttachmentDetails = getParam('AttachmentDetails');

    if (!file_exists($targetFolder))
        mkdir($targetFolder);


    if (!empty($_FILES)) {

        foreach ($_FILES["attachFile"]["error"] as $key => $error) {
            $random_digit = rand(000000, 999999);

            $tempFile = $_FILES['attachFile']['tmp_name'][$key];
            $targetPath = $targetFolder; //$_SERVER['DOCUMENT_ROOT'] . $targetFolder;
            // Validate the file type
            $fileTypes = array('jpg', 'jpeg', 'gif', 'pdf', 'png', 'xls', 'xlsx', 'doc', 'docx', 'ppt'); // File extensions
            $fileParts = pathinfo($_FILES['attachFile']['name'][$key]);

            if (in_array($fileParts['extension'], $fileTypes)) {

                $file_name = basename($_FILES['attachFile']['name'][$key], '.' . $fileParts['extension']);
                $file_name = str_replace(' ', '', $file_name);
                $targetFile = $targetPath . $file_name . $random_digit . '.' . $fileParts['extension'];
                move_uploaded_file($tempFile, $targetFile);
                $path = $targetFolder . $file_name . $random_digit . '.' . $fileParts['extension'];

                $sqlInsert = "INSERT INTO file_attach_list(REQUEST_ID, MODULE_NAME, ATTACH_TITTLE, ATTACH_FILE_PATH, CREATED_BY, CREATED_DATE)
                                    VALUES('$req_id', '$module', '$AttachmentDetails[$key]', '$path', '$employeeId', NOW())";
                query($sqlInsert);
            }
        }
    }
}

function file_upload_single($targetFolder) {

    if (!file_exists($targetFolder))
        mkdir($targetFolder);


    if (!empty($_FILES)) {
        $random_digit = rand(000000, 999999);

        $tempFile = $_FILES['file_one']['tmp_name'];
        $targetPath = $targetFolder; //$_SERVER['DOCUMENT_ROOT'] . $targetFolder;
        // Validate the file type
        $fileTypes = array('jpg', 'jpeg', 'gif', 'pdf', 'png', 'xls', 'xlsx', 'doc', 'docx', 'ppt'); // File extensions
        $fileParts = pathinfo($_FILES['file_one']['name']);

        if (in_array($fileParts['extension'], $fileTypes)) {

            $file_name = basename($_FILES['file_one']['name'], '.' . $fileParts['extension']);
            $file_name = str_replace(' ', '', $file_name);
            $targetFile = $targetPath . $file_name . $random_digit . '.' . $fileParts['extension'];
            move_uploaded_file($tempFile, $targetFile);
            $path = $targetFolder . $file_name . $random_digit . '.' . $fileParts['extension'];
        }
        return $path;
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

        function comboBox_table_top($name, $data, $selectedValue, $allowNull, $class = null) {
            ?>
            <select name ='<?php echo $name; ?>' id='<?php echo $name; ?>ID' class='<?php echo $class; ?>' onChange= "window.location.href = '?limit=' + this.value + ''"  

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

        function comboBox2($name, $data, $selectedValue, $allowNull, $class = null, $onChange = null, $ajux_sql = null) {
            if ($onChange != '') {
                if ($ajux_sql != '') {
                    $ajux_sql_call = '-' . $ajux_sql;
                    $onChange = "ajaxLoader('$onChange.php?val='+this.value+'&id=$ajux_sql', '$onChange', '<img src=../public/images/loading.gif />');";
                } else {
                    $onChange = "ajaxLoader('$onChange.php?val='+this.value+'&id=$ajux_sql', '$onChange', '<img src=../public/images/loading.gif />');";
                }
            }
            ?>
            <select name='<?php echo $name; ?>' id='<?php echo $name; ?>ID' class='<?php echo $class; ?>' onChange= "<?php echo $onChange; ?>"  

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

            function comboChange($name, $data, $selectedValue, $allowNull, $class = null, $onChange = null) {
                $onChange = $onChange == '' ? '' : $onChange;
                ?>
                <select name='<?php echo $name; ?>' id='<?php echo $name; ?>ID' class='<?php echo $class; ?>' onChange= "ComboChange($(this), '<?php echo $onChange; ?>');"

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
