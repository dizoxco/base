<?php

return array(
    "driver" => "smtp",
    "host" => "smtp.mailtrap.io",
    "port" => 2525,
    "from" => array(
        "address" => "noreply@larabase.dev",
        "name" => "Larabase Administration"
    ),
    "username" => "5593db13773ba5",
    "password" => "32d59f0010acc4",
    "sendmail" => "/usr/sbin/sendmail -bs",
    "pretend" => false
);
