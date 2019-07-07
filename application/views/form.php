<!doctype html>
<html lang="ru">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <title>Articles Generator 1.0</title>

    <style>
        form {
            padding: 20px;
            background-color: #EEE;
        }
    </style>
</head>
<body>

<form method="post">
    <div class="form-group row">
        <label for="fileName" class="col-sm-2 col-form-label">File name: </label>
        <div class="col-sm-10">
            <input type="text" class="form-control"
                   id="fileName" name="fileName"
                   placeholder="registratsiya-lekarstvennyh-sredstv-v-ukraine-registratsiya-lekarstv"
                   size="75" maxlength="256"
                   value="<?= isset($_POST['fileName']) ? $_POST['fileName'] : '' ?>">
        </div>
    </div>
    <div class="form-group row">
        <label for="title" class="col-sm-2 col-form-label">Title: </label>
        <div class="col-sm-10">
            <input type="text" class="form-control"
                   id="title" name="title"
                   placeholder="Регистрация лекарственных средств в Украине, регистрация лекарств"
                   size="75" maxlength="100"
                   value="<?= isset($_POST['title']) ? $_POST['title'] : '' ?>">
        </div>
    </div>
    <div class="form-group row">
        <label for="description" class="col-sm-2 col-form-label">Description: </label>
        <div class="col-sm-10">
        <textarea name="description" class="form-control"
                  id="description" cols="40" rows="10"
                  placeholder="В соответствии с Законом Украины «О лекарственных средствах» обращение лекарственных средств на территории Украины возможно только после прохождения процедуры государственной регистрации."
                  maxlength="500"><?= isset($_POST['description']) ? $_POST['description'] : '' ?></textarea>
        </div>
    </div>

    <div class="form-group row">
        <label for="h1" class="col-sm-2 col-form-label">H1: </label>
        <div class="col-sm-10">
            <input type="text" class="form-control"
                   id="h1" name="h1"
                   placeholder="Государственная регистрация лекарственных средств в Украине"
                   size="60" maxlength="100"
                   value="<?= isset($_POST['h1']) ? $_POST['h1'] : '' ?>">
        </div>
    </div>

    <div class="form-group row">
        <label for="text" class="col-sm-2 col-form-label">Text: </label>
        <div class="col-sm-10">
        <textarea name="text" class="form-control"
                  id="text" cols="40"
                  rows="10"><?= isset($_POST['text']) ? $_POST['text'] : '' ?></textarea>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-2"></div>
        <div class="col-sm-3">
            <input type="submit" class="btn btn-success btn-lg btn-primary"
                   name="submit" id="submit"
                   value="Add article to DB!">
        </div>

        <div class="form-check col-sm-5">
            <div class="col-sm-7"></div>
            <div class="col-sm-5 float-right">
                <input class="form-check-input" type="checkbox" value="" id="showPlaceholders"
                       checked
                       name="showPlaceholders">
                <label class="form-check-label" for="showPlaceholders">
                    show placeholders
                </label>
            </div>
        </div>
        <div class="col-sm-2">
            <input type="reset" class="btn btn-danger btn-lg float-right"
                   name="reset" id="reset"
                   value="Clear form">
        </div>
    </div>
</form>

<script>
    document.getElementById('reset').onclick =
        function () {
            document.getElementById('fileName').setAttribute('value', '');
            document.getElementById('title').setAttribute('value', '');
            document.getElementById('description').innerText = '';
            document.getElementById('h1').setAttribute('value', '');
            document.getElementById('text').innerText = '';
        };

    document.getElementById('showPlaceholders').onchange =
        function () {
            checkboxShowPlaceholders = document.getElementById('showPlaceholders');
            if (checkboxShowPlaceholders.checked === true) {
                document.getElementById('fileName').setAttribute('placeholder', 'registratsiya-lekarstvennyh-sredstv-v-ukraine-registratsiya-lekarstv');
                document.getElementById('title').setAttribute('placeholder', 'Регистрация лекарственных средств в Украине, регистрация лекарств');
                document.getElementById('description').setAttribute('placeholder', 'В соответствии с Законом Украины «О лекарственных средствах» обращение лекарственных средств на территории Украины возможно только после прохождения процедуры государственной регистрации.');
                document.getElementById('h1').setAttribute('placeholder', 'Государственная регистрация лекарственных средств в Украине');
                document.getElementById('text').setAttribute('placeholder', '');
            }
            else {
                document.getElementById('fileName').setAttribute('placeholder', '');
                document.getElementById('title').setAttribute('placeholder', '');
                document.getElementById('description').setAttribute('placeholder', '');
                document.getElementById('h1').setAttribute('placeholder', '');
                document.getElementById('text').setAttribute('placeholder', '');
            }
        }
</script>

<?php

$filesTamplatesNames['ru'] = APPPATH . "/views/ru template.html";
$filesTamplatesNames['ua'] = APPPATH . "/views/ua template.html";

// if submit doesn't pressed yet
if (!isset($_POST['submit'])) {
    die;
}

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

$filesTexts['ru'] = mb_convert_encoding($filesTexts['ru'], 'utf-8', 'Windows-1251');
$filesTexts['ua'] = mb_convert_encoding($filesTexts['ua'], 'utf-8', 'Windows-1251');

$title = trim($_POST['title']);
$description = trim($_POST['description']);
$h1 = trim($_POST['h1']);
$text = trim($_POST['text']);

// START Replaces

$filesTexts['ua'] = str_replace(array('{TITLE}', '{DESCRIPTION}', '{H1}', '{TEXT}'),
    array($title, $_POST['description'], $_POST['h1']), $filesTexts['ua']);

$filesTexts['ru'] = str_replace(array('{TITLE}', '{DESCRIPTION}', '{H1}', '{TEXT}'),
    array($title, $_POST['description'], $_POST['h1']), $filesTexts['ru']);

if (isset($_POST['text']) && ($_POST['text'] != '')) {
    $filesTexts['ru'] = str_replace('{TEXT}', $_POST['text'], $filesTexts['ru']);
    $filesTexts['ua'] = str_replace('{TEXT}', $_POST['text'], $filesTexts['ua']);
}

// END Replaces


$filesTexts['ru'] = mb_convert_encoding($filesTexts['ru'], 'Windows-1251', 'utf-8');
$filesTexts['ua'] = mb_convert_encoding($filesTexts['ua'], 'Windows-1251', 'utf-8');


file_put_contents($filesNames['ru'], $filesTexts['ru']);
file_put_contents($filesNames['ua'], $filesTexts['ua']);

echo <<<JAVASCRIPT
<script>
 alert('Files created!');
</script>
JAVASCRIPT;


?>

</body>
</html>
