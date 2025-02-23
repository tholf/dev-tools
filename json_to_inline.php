<html xmlns="http://www.w3.org/1999/xhtml" lang="us">
<head>
    <title>Pretty JSON to Inline</title>
    <?php include "includes/head.php"; ?>
</head>
<body>
    <div class="container">
        <h2><a href="index.php">Tools</a> :: Pretty JSON to Inline</h2>
        <?php include "includes/dev_menu.php"; ?>

        <div class="content">
            <?php
            $placeholder = print_r(json_encode(json_decode('{"something":"else"}'), JSON_PRETTY_PRINT),true);
            ?>
            <form action='' method='post'>
                <label>
                    Pretty JSON
                    <textarea name="enc" class="input" placeholder='<?php echo $placeholder ?>'></textarea>
                </label>
                <button type="submit" name="submit" id="submit">go</button>
            </form>
            <?php
            $sample = $placeholder;
            $placeholder = print_r(json_encode(json_decode($sample), JSON_UNESCAPED_SLASHES),true);
            if (isset($_POST['enc'])) {
                $result = !empty($_POST['enc']) ? print_r(json_encode(json_decode($_POST['enc'])),true) : $placeholder;
            } else {
                $result = '';
            }
            ?>
            <label>
                Result
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
