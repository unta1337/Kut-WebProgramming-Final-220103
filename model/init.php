<!-- 필요 설정 초기화 -->

<?php
    session_start();

    # DB 설정 파일 불러오기.
    $configRaw = file_get_contents('../config.json');
    $config = json_decode($configRaw, true);

    # 불러온 DB 설정을 세션에 저장.
    $_SESSION['dbUrl'] = $config['dbUrl'];
    $_SESSION['dbUser'] = $config['dbUser'];
    $_SESSION['dbPasswd'] = $config['dbPasswd'];
    $_SESSION['dbName'] = $config['dbName'];

    # config.json 형식.
    #
    # {
    #     "dbUrl": {your_db_url_here},
    #     "dbUser": {your_db_user_here},
    #     "dbPasswd": {your_db_password_here},
    #     "dbName": {your_db_name_here}
    # }
?>