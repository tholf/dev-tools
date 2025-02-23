<html xmlns="http://www.w3.org/1999/xhtml" lang="us">
<head>
    <title>SSL / TLS</title>
    <?php include "includes/head.php"; ?>
</head>
<body>
    <div class="container">
        <h2><a href="index.php">Tools</a> :: SSL / TLS</h2>
        <?php include "includes/host_menu.php"; ?>

        <div class="content">
            <?php
            $ch = curl_init('https://www.howsmyssl.com/a/check');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $data = curl_exec($ch);
            curl_close($ch);

            $json = json_decode($data);
            ?>
            <p>
                Checking: https://www.howsmyssl.com/a/check
            </p>
            <p>
                Rating: <?php echo $json->rating; ?><br>
                TLS Version Received: <?php echo $json->tls_version; ?>
            </p>
            <h4>
                Cipher Suites
            </h4>
            <p>
                <?php
                foreach ($json->given_cipher_suites as $suite) {
                    echo str_replace('_',' ', $suite) . '<br>';
                }
                ?>
            </p>
            <p>&nbsp;</p>
        </div>
    </div>
</body>
</html>


