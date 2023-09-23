<?php

class auth{
    public function bind_to_template($replacements, $template){
        return preg_replace_callback('/{{(.+?)}}/', function($matches) use ($replacements){
            return $replacements[$matches[1]];
        }, $template);
    }

    public function receive_sign_up($MYSQL, $OBJ_SendMail, $lang, $conf){
        if(isset($_POST["signup"])){

            $full_name = $_POST["fullname"];
            $email_address = addslashes($_POST["email_address"]);
            $pass_token = md5(time());
            $pass_token_expire = date('Y-m-d H:i:s', strtotime('+ 2hours'));
            $data = array('fullname' => $full_name, 'email_address' => $email_address, 'pass_token' => $pass_token, 'pass_token_expire' => $pass_token_expire);
            $table = "users";
            $insert_user = $MYSQL->insert($table, $data);
            

            if (!filter_var($email_address, FILTER_VALIDATE_EMAIL)) {
                die("Invalid email format");
            }else{
                $replacements = array('fullname'=>$full_name, 'site_name'=>$conf["site_name"], 'email_address'=>$email_address);
                $OBJ_SendMail->SendeMail([
                    'email_receiver' => $email_address,
                    'name_receiver' => $full_name,
                    'email_subject_line' => $lang["sign_up_feedback_subject"],
                    'email_message' => $this->bind_to_template($replacements, $lang["sign_up_feedback"])
                ], $conf);
                header("Location: signin.php");
                exit();
            }
        }
    }

    public function sign_up_completion($MYSQL){
        if(isset($_POST["signupcompletion"])){
            $email_address = $_POST["email_address"];
            $password = md5($_POST["password"]);
            $data = array('password' => $password);
            $table = "users";
            $where = "email_address = '$email_address'";
            $MYSQL->update($table, $data, $where);
            header("Location: signin.php");
            exit();
        }
    }

    public function sign_in($MYSQL){
        if(isset($_POST["signin"])){
            $email_address = $_POST["email_address"];
            $password = md5($_POST["password"]);
            $sql = "SELECT * FROM users WHERE email_address='$email_address' AND password='$password'";
            $count = $MYSQL->count_results($sql);
            
            if ($count == 1) {
                header("Location: about.php");
                exit();
            }   
        }
    }
}