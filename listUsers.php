<?php
    require_once "ClassAutoLoad.php";

        $OBJ_Layout->headers($conf);
        $OBJ_Layout->logo($conf);
        $OBJ_Layout->navigation();

        $query = "select * from users";
        $result = $MYSQL->select($query);
        $count = $MYSQL->count_results($query);

        $OBJ_Layout->listUsers($result, $count);
        $OBJ_Layout->footer($conf);