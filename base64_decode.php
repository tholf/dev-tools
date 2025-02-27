<?php
/* *
 *** Base64 decode text content
 ***
*/
$title = 'Base64 Decode';

function base64_decode_content(string $string): string {
    return base64_decode($string);
}

function base64_encode_content(string $string): string {
    return base64_encode($string);
}

$sample = 'Some string.';
$input_placeholder = print_r(base64_encode_content($sample),true);
$output_placeholder = print_r(base64_decode_content($input_placeholder),true);

if (isset($_POST['content'])) {
    $result = !empty($_POST['content']) ? print_r(base64_decode_content($_POST['content']),true) : $output_placeholder;
} else {
    $result = '';
}

?><html xmlns="http://www.w3.org/1999/xhtml" lang="us">
<head>
    <title><?php echo $title; ?></title>
    <?php include "includes/head.php"; ?>
</head>
<body>
<div class="container">
    <?php include "includes/heading.php"; ?>
    <?php include "includes/dev_menu.php"; ?>

    <div class="content">
        <form action='' method='post' id="theform">
            <label>
                Bas64 Encoded
                <textarea name="content" class="input" placeholder='<?php echo $input_placeholder; ?>'></textarea>
            </label>
            <button type="submit" name="submit" id="submit">go</button>
            <?php if (isset($_POST['content'])) { ?>
                <button type="button" name="reset" id="reset" onclick="window.history.back();">reset</button>
            <?php } ?>
        </form>
        <label>
            Content
            <textarea
                id="result"
                class="result"
                placeholder='<?php echo $output_placeholder ?>'
            ><?php echo $result; ?></textarea>
        </label>
        <p>&nbsp;</p>
    </div>
</div>
<script>
    let resultTextarea = document.getElementById('result');
    resultTextarea.style.height = (resultTextarea.scrollHeight + 10) + "px";
</script>
</body>
</html>
