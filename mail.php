<?php
    require_once "ClassAutoLoad.php";

    $details["email_receiver"] = "bmundama@strathmore.edu";
    $details["name_receiver"] = "BM";
    $details["email_subject_line"] = "Test 0001";
    $details["email_message"] = "This is yet another test";

    $OBJ_SendMail->SendeMail($details, $conf);

    header("Location: ./");
    exit();