<html xmlns="http://www.w3.org/1999/xhtml" lang="us">
<head>
    <title>PHPInfo</title>
    <?php include "includes/head.php"; ?>
</head>
<body>
    <div class="container">
        <h2><a href="index.php">Tools</a> :: PHPInfo</h2>
        <?php include "includes/host_menu.php"; ?>

        <div class="content" style="display: flex">
            <?php
            // set default time zone if not set at php.ini
            if (version_compare(phpversion(), '5.1.0', '>=')) {
              date_default_timezone_set('America/Detroit'); // put default timezone here
            }?>
            <div>
                <?php
                // phpinfo
                echo phpinfo();
                ?>
            </div>
        </div>
        <link rel="stylesheet" href="css/styles.css"><?php // override phpinfo CSS ?>
    </body>
</html>
