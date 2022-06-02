<?php
    session_start();

    $configRaw = file_get_contents('.config.json');
    $config = json_decode($configRaw, true);

    $_SESSION['dbUrl'] = $config['dbUrl'];
    $_SESSION['dbUser'] = $config['dbUser'];
    $_SESSION['dbPasswd'] = $config['dbPasswd'];
    $_SESSION['dbName'] = $config['dbName'];

    # .config.json form
    # {
    #     "dbUrl": {your_db_url_here},
    #     "dbUser": {your_db_user_here},
    #     "dbPasswd": {your_db_password_here},
    #     "dbName": {your_db_name_here}
    # }
?>