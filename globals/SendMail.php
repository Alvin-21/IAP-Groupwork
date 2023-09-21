<?php
class SendMail{
    public function SendeMail($details=array(), $conf){
        if(!empty($details["email_receiver"]) & !empty($details["name_receiver"]) & !empty($details["email_subject_line"]) & !empty($details["email_message"])){
            $headers = array(
                'Authorization: Bearer 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',
                'Content-Type: application/json'
            );

            $data = array(
                "personalizations" => array(
                    array(
                        "to" => array(
                            array(
                                "email" => $details["email_receiver"],
                                "name" => $details["name_receiver"]
                            )
                        )
                    )
                ),
                "from" => array(
                    "email" => $conf["u_smtp_authentication"],
                    "name" => $conf["site_name"]
                ),
                "subject" => $details["email_subject_line"],
                "content" => array(
                    array(
                        "type" => "text/html",
                        "value" => nl2br($details["email_message"])
                    )
                )
            );
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://api.sendgrid.com/v3/mail/send");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $response = curl_exec($ch);
            curl_close($ch);
        }else{
            print_r($details);
            die("Error: Missing elements");
        }
    }
}