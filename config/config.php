<?php

define("DB_SERVER",($_SERVER['SERVER_NAME']=="localhost")?'127.0.0.1':'ec2-184-73-209-230.compute-1.amazonaws.com');
define("DB_PORT", ($_SERVER['SERVER_NAME']=="localhost")?'5432':'5432');
define("DB_NAME", ($_SERVER['SERVER_NAME']=="localhost")?'mi_tutor':'d6mcd3o62r1tq3');
define("DB_USER", ($_SERVER['SERVER_NAME']=="localhost")?'postgres':'zjohnmqmorhrdn');
define("DB_PASSW", ($_SERVER['SERVER_NAME']=="localhost")?'123456':'8450d5015ca38d0716d97fc4f8479e14a82e6e13e595838b01a8f3e9cbf5613b');