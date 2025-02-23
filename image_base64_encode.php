<?php
chdir('../../');

// set default time zone if not set at php.ini
if (version_compare(phpversion(), '5.1.0', '>=')) {
    date_default_timezone_set('America/New_York'); // put here default timezone
}

if (!empty($_GET['action'])) {

    $destination = 'tmp/';

    $allowedExts = array("gif", "jpeg", "jpg", "png");
    $temp = explode(".", $_FILES["file"]["name"]);
    $extension = end($temp);

    $output = '';

    if ((($_FILES["file"]["type"] == "image/gif")
            || ($_FILES["file"]["type"] == "image/jpeg")
            || ($_FILES["file"]["type"] == "image/jpg")
            || ($_FILES["file"]["type"] == "image/pjpeg")
            || ($_FILES["file"]["type"] == "image/x-png")
            || ($_FILES["file"]["type"] == "image/png"))
        && ($_FILES["file"]["size"] < 150000)
        && in_array($extension, $allowedExts)) {

        if ($_FILES["file"]["error"] > 0) {
            $output .= "Return Code: " . $_FILES["file"]["error"] . "<br>";
        } else {
            $output .= "Upload: " . $_FILES["file"]["name"] . "<br>";
            $output .= "Type: " . $_FILES["file"]["type"] . "<br>";
            $output .= "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
            $output .= "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";
            if (file_exists($destination . $_FILES["file"]["name"])) {
                $output .= $_FILES["file"]["name"] . " already exists, deleting... <br>";
                @unlink($destination . $_FILES["file"]["name"]);
            }
            move_uploaded_file($_FILES["file"]["tmp_name"], $destination . $_FILES["file"]["name"]);
            $output .= "Stored in: " . $destination . $_FILES["file"]["name"] . '<br>';
        }

        $output .= "converting " . $destination . $_FILES["file"]["name"] . "... <br>";
        $file = base64_encode(file_get_contents($destination . $_FILES["file"]["name"]));
        $output .= "deleting " . $destination . $_FILES["file"]["name"] . "... <br>";
        @unlink($destination . $_FILES["file"]["name"]);

        $output .= '<br><label>Encoded Image</label><textarea cols="150" rows="15">'.$file.'</textarea><br><br>';
        $output .= '<label>CSS</label><textarea cols="150" rows="15">'.'background: #FFF url(data:image/gif;base64,'.$file.') no-repeat top left;'.'</textarea><br><br>';

    } else {
        $output .= "Invalid file";
    }

} ?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="us">
<head>
    <title>Image Base64 Encode</title>
    <?php include "includes/head.php"; ?>
</head>
<body>
    <div class="container">
        <h2><a href="index.php">Tools</a> :: Image Base64 Encode</h2>
        <?php include "includes/dev_menu.php"; ?>

        <div class="content" style="display: flex">

            <form name="image" action="image_base64_encode.php?action=convert" method="post" enctype="multipart/form-data">
                <label>
                    Select Image
                </label>
                <div class="file-upload">
                    <label class="file">
                        <input type="file" name="file" id="file" accept="image/png, image/jpeg" />
                    </label>
                </div>
                <button id="tdb1" type="submit">Go</button>
            </form>
            <?php if(!empty($output)) { ?>
                <?=$output?>
                <form name="image2" action="image_base64_encode.php" method="get"><button id="tdb1" type="submit">Cancel</button></form><p>&nbsp;</p>
            <?php } ?>

        </div>
    </div>
</body>
</html>
