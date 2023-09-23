<?php
    require_once "ClassAutoLoad.php";

        $OBJ_Layout->headers($conf);
        $OBJ_Layout->logo($conf);
        $OBJ_Layout->navigation();
        // $OBJ_Layout->banner();

        $email_address = $_GET['email_address'];
        $query = "select * from users where email_address='".$email_address."'";
        $result = $MYSQL->select_while($query);
        $fullname = $result[0]['fullname'];
        $email = $result[0]['email_address'];

        $OBJ_Forms->sign_up_completion_form($fullname, $email_address);
        $OBJ_Layout->footer($conf);