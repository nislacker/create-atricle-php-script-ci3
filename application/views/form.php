<!doctype html>
<html lang="ru">
<head>
    <meta charset="Windows-1251">
    <title>Articles Generator 1.0</title>
</head>
<body>

<form method="post">
    <label for="fileName">File name: </label><br><input type="text" id="fileName" name="fileName"
                                                        placeholder="registratsiya-lekarstvennyh-sredstv-v-ukraine-registratsiya-lekarstv"
                                                        size="75" maxlength="256"
                                                        value="<?php echo isset($_POST['fileName']) ? $_POST['fileName'] : '' ?>"><br>
    <label for="title">Title: </label><br><input type="text" id="title" name="title"
                                                 placeholder="Регистрация лекарственных средств в Украине, регистрация лекарств"
                                                 size="75" maxlength="100"
                                                 value="<?php echo isset($_POST['title']) ? $_POST['title'] : '' ?>"><br>
    <label for="description">Description: </label><br><textarea name="description" id="description" cols="40" rows="10"
                                                                placeholder="В соответствии с Законом Украины «О лекарственных средствах»  обращение лекарственных средств на территории Украины возможно только после прохождения процедуры государственной регистрации."
                                                                maxlength="500"><?php echo isset($_POST['description']) ? $_POST['description'] : '' ?></textarea><br>
    <label for="h1">H1: </label><br><input type="text" id="h1" name="h1"
                                           placeholder="Государственная регистрация лекарственных средств в Украине"
                                           size="60" maxlength="100"
                                           value="<?php echo isset($_POST['h1']) ? $_POST['h1'] : '' ?>"><br>
    <label for="text">Text: </label><br><textarea name="text" id="text" cols="40"
                                                  rows="10"><?php echo isset($_POST['text']) ? $_POST['text'] : '' ?></textarea><br><br>
    <input type="submit" name="submit" value="Create files!">
    <input type="reset" name="reset" id="reset" value="Clear">
</form>

<script>

    document.getElementById('reset').onclick =
        function () {
            document.getElementById('fileName').setAttribute('value', '');
            document.getElementById('title').setAttribute('value', '');
            document.getElementById('description').setAttribute('value', '');
            document.getElementById('h1').setAttribute('value', '');
            document.getElementById('text').setAttribute('value', '');
        };

</script>


<?php

$filesTamplatesNames['ru'] = APPPATH . "/views/ru template.html";
$filesTamplatesNames['ua'] = APPPATH . "/views/ua template.html";

if (!isset($_POST['fileName']) || ($_POST['fileName'] == '')) {
    echo 'Введи "File name"';
    die;
}

if (!isset($_POST['title']) || ($_POST['title'] == '')) {
    echo 'Введи Title';
    die;
}

if (!isset($_POST['description']) || ($_POST['description'] == '')) {
    echo 'Введи Description';
    die;
}

if (!isset($_POST['h1']) || ($_POST['h1'] == '')) {
    echo 'Введи H1';
    die;
}

$fileName = $_POST['fileName'];

$filesNames['ru'] = APPPATH . "/views/ru/" . $fileName . ".html";
$filesNames['ua'] = APPPATH . "/views/ua/" . $fileName . ".html";

$filesTexts['ru'] = file_get_contents($filesTamplatesNames['ru']);
$filesTexts['ua'] = file_get_contents($filesTamplatesNames['ua']);

$title = trim($_POST['title']);
//$title = iconv('Windows-1251', 'Windows-1251', $title);
//echo $title; die;
//
$description = trim($_POST['description']);
//$description = iconv(mb_detect_encoding( $description ), 'Windows-1251', $description);

//
$h1 = trim($_POST['h1']);
//$h1 = iconv(mb_detect_encoding( $h1 ), 'Windows-1251', $h1);
//
$text = trim($_POST['text']);
//$text = iconv(mb_detect_encoding( $text ), 'Windows-1251', $text);



// START Replaces

$filesTexts['ua'] = str_replace(array('{TITLE}', '{DESCRIPTION}', '{H1}', '{TEXT}'),
    array($title, $_POST['description'], $_POST['h1']), $filesTexts['ua']);

$filesTexts['ru'] = str_replace(array('{TITLE}', '{DESCRIPTION}', '{H1}', '{TEXT}'),
    array($title, $_POST['description'], $_POST['h1']), $filesTexts['ru']);

if (isset($_POST['text']) && ($_POST['text'] != '')) {
    $filesTexts['ru'] = str_replace('{TEXT}', $_POST['text'], $filesTexts['ru']);
    $filesTexts['ua'] = str_replace('{TEXT}', $_POST['text'], $filesTexts['ua']);
}

echo $filesTexts['ru'] . '<br><br><br>';
echo $filesTexts['ua'] . '<br>';
die;

// END Replaces

file_put_contents($filesNames['ru'], $filesTexts['ru']);
file_put_contents($filesNames['ua'], $filesTexts['ua']);

echo 'File saved!';

?>

</body>
</html>
