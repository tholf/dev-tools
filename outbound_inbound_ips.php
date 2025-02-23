<html xmlns="http://www.w3.org/1999/xhtml" lang="us">
<head>
    <title>Outbound / Inbound IPs</title>
    <?php include "includes/head.php"; ?>
</head>
<body>
    <div class="container">
        <h2><a href="index.php">Tools</a> :: Outbound / Inbound IPs</h2>
        <?php include "includes/host_menu.php"; ?>

        <div class="content">
            <p>
                Outbound IP: <?php echo shell_exec('dig +short myip.opendns.com @resolver1.opendns.com'); ?>
            </p>
            <p>
                Inbound IP: <?php echo $_SERVER['REMOTE_ADDR']; ?>
            </p>
        </div>
    </div>
</body>
</html>

