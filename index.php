<?php

include('simple_html_dom.php');

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $urls = trim($_POST['urls']);
    $urls = str_replace(array("\r\n", "\r"), "\n", $urls);
    $urls = explode("\n", $urls);

    $result = "";
    foreach($urls as $url) {
        $data = @file_get_html($url);
        if (!empty($data)) {
            $result .= '<div style="border: 1px solid #333333">';
            $result .= '<p><a href="' . $url . '" target= "_brank">' . $url . '</a></p>';
            foreach ($data->find('title') as $element) {
                $result .= '<p><span class="bold">title</span><br />' . $element->plaintext . '</p>';
            }

            foreach ($data->find('meta') as $elements) {
                if ($elements->getAttribute('name') == 'keywords') {
                    $result .= '<p><span class="bold">keywords</span><br />' . $elements->getAttribute('content') . '</p>';
                }
            }

            foreach ($data->find('meta') as $elements) {
                if ($elements->getAttribute('name') == 'description') {
                    $result .= '<p><span class="bold">description</span><br />' . $elements->getAttribute('content') . '</p>';
                }
            }

            foreach ($data->find('link') as $elements) {
                if ($elements->getAttribute('rel') == 'index') {
                    $result .= '<p><span class="bold">rel="index"</span><br />' . $elements->getAttribute('href') . '</p>';
                }
            }

            foreach ($data->find('h1') as $element) {
                $result .= '<p><span class="bold">h1</span><br />' . $element->plaintext . '</p>';
            }
            $result .= '<p class="white">---------------------------------------------------------------</p>';
            $result .= '</div>';
        }
    }
}

?>

<!DOCTYPE HTML>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>meta tag checker</title>
    <style type="text/css">
        .bold { font-weight: bold; }
        .white { color: white; }
    </style>
</head>
<body>
    <h1>meta tag checker</h1>
	<form action="" method="post">
        <textarea placeholder="ここに1行1URLを貼り付ける！" name="urls" rows="20" cols="150"><?php
            if($_SERVER['REQUEST_METHOD'] == "POST"){
                echo $_POST['urls'];
            }
        ?></textarea> 
        <input type="submit" />
    </form>
    <div id="result">
    <?php echo $result; ?>
    </div>
</body>
</html>
