<?php
/* *
 *** Converts image into base64 encoded text
 *** If you need to debug file upload issue, you can add "?debug"
 *** to the URL and hit enter. Then submit your image again.
 ***
*/

const TMP_LOCATION = '../../tmp/';

// set default time zone if not set at php.ini
if (version_compare(phpversion(), '5.1.0', '>=') && empty(date_default_timezone_get())) {
    date_default_timezone_set('America/New_York'); // put here default timezone
}

function validate_upload(array $file): array {
    $allowedExtensions = array("gif", "jpeg", "jpg", "png", "svg");
    $allowedMimeTypes = array("image/gif", "image/jpeg", "image/jpg", "image/pjpeg", "image/x-png", "image/png", "image/svg+xml");
    $temp = explode(".", $file["name"]);
    $extension = end($temp);

    if ($file["error"] > 0) {
        return [
            'status' => false,
            'message' => 'There was an file upload error. Code: ' . $file["error"]
        ];
    }

    if (!in_array($file["type"], $allowedMimeTypes) || !in_array($extension, $allowedExtensions)) {
        return [
            'status' => false,
            'message' => 'File type is not allowed.'
        ];
    }

    if ($file["size"] > 150000) {
        return [
            'status' => false,
            'message' => 'File is too large.'
        ];
    }

    return [
        'status' => true
    ];
}

function convert_file(array $file): array {
    $log = [];
    $validate_upload = validate_upload($file);

    if (!$validate_upload['status']) {
        @unlink(TMP_LOCATION . $file["tmp_name"]);

        return $validate_upload;
    }

    $log[] = "Temp Filename: " . $file["tmp_name"];
    $log[] = "File Type: " . $file["type"];
    $log[] = "File Size: " . ($file["size"] / 1024) . " kB";
    $log[] = "Filename: " . $file["name"];

    if (file_exists(TMP_LOCATION . $file["name"])) {
        $log[] = $file["name"] . " already exists, deleting...";
        @unlink(TMP_LOCATION . $file["name"]);
    }

    $log[] = "Storing in: " . TMP_LOCATION . $file["name"] . '...';
    @move_uploaded_file($file["tmp_name"], TMP_LOCATION . $file["name"]);

    $log[] = "Converting: " . TMP_LOCATION . $file["name"] . "...";
    $base64_encode_file = base64_encode(@file_get_contents(TMP_LOCATION . $file["name"]));

    $log[] = "Deleting: " . TMP_LOCATION . $file["name"] . "...";
    @unlink(TMP_LOCATION . $file["name"]);

    return [
        'status' => true,
        'message' => implode('<br>', $log),
        'base64_encoded' => $base64_encode_file,
        'mime_type' => $file["type"],
    ];
}

$converted_file = false;
if (!empty($_FILES['file'])) {
    $converted_file = convert_file($_FILES['file']);
}

?><html xmlns="http://www.w3.org/1999/xhtml" lang="us">
<head>
    <title>Base64 Encode Image</title>
    <?php include "includes/head.php"; ?>
</head>
<body>
    <div class="container">
        <h2><a href="index.php">Tools</a> :: Base64 Encode Image</h2>
        <?php include "includes/dev_menu.php"; ?>

        <div class="content">
            <form action='<?php echo isset($_GET['debug']) ? '?debug' : ''; ?>' method='post' enctype='multipart/form-data'>
                <label for="file">
                    Select Image
                </label>
                <div class="file-upload">
                    <input type="file" name="file" id="file" accept="image/png, image/jpeg, image/svg+xml" />
                </div>
                <button type="submit" name="submit" id="submit">go</button>
            </form>
            <?php if (!empty($converted_file) && $converted_file['status']) { ?>
                <?php echo (isset($_GET['debug']) && !empty($converted_file['message'])) ? '<p style="color: white;">' . $converted_file['message'] . '</p>' : ''; ?>
                <p>
                    <label>
                        Encoded Image
                        <textarea class="result" cols="150" rows="15"><?php echo $converted_file['base64_encoded']; ?></textarea>
                    </label>
                </p>
                <p>
                    <label>
                        CSS
                        <textarea class="result" cols="150" rows="15">background: #FFF url(data:<?php echo $converted_file['mime_type']; ?>;base64,<?php echo $converted_file['base64_encoded']; ?>) no-repeat top left;</textarea>
                    </label>
                </p>
                <form action='' method="post">
                    <button type="submit" id="cancel">Cancel</button>
                </form>
                <p>&nbsp;</p>
            <?php } else { ?>
                <?php echo $converted_file['message']; ?>
            <?php } ?>
        </div>
    </div>
    <script>
        let resultTextareas = document.querySelectorAll('.result');
        resultTextareas.forEach(resultTextarea => resultTextarea.style.height = (resultTextarea.scrollHeight + 10) + "px");
    </script>
</body>
</html>
