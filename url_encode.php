<html xmlns="http://www.w3.org/1999/xhtml" lang="us">
<head>
    <title>URL Encode</title>
    <?php include "includes/head.php"; ?>
</head>
<body>
    <div class="container">
        <h2><a href="index.php">Tools</a> :: URL Encode</h2>
        <?php include "includes/dev_menu.php"; ?>

        <div class="content">
            <?php
            $sample = 'http://www.somewhere.com/';
            ?>
            <form action='' method='post'>
                <label>
                    Text
                    <textarea name="enc" class="input" placeholder='<?php echo $sample; ?>'></textarea>
                </label>
                <button type="submit" name="submit" id="submit">go</button>
            </form>
            <?php
            $placeholder = print_r(urlencode($sample),true);
            if (isset($_POST['enc'])) {
                $result = !empty($_POST['enc']) ? print_r(urlencode($_POST['enc']), true) : $placeholder;
            } else {
                $result = '';
            }
            ?>
            <label>
                URL Encoded
                <textarea
                        id="result"
                        class="result"
                        placeholder='<?php echo $placeholder ?>'
                    ><?php echo $result; ?></textarea>
                <script>
                    let resultTextarea = document.getElementById('result');
                    resultTextarea.style.height = (resultTextarea.scrollHeight + 10) + "px";
                </script>
            </label>
        </div>
    </div>
</body>
</html>
