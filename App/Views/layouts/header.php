<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <title><?php echo TITLE;?><?=$titulo?></title>
        <link rel="shortcut icon" type="image/png" href="<?=IMAGEM?>/icone.png"/>
        
        <!-- CSS  -->
        <link href="https://fonts.googleapis.com/css?family=Krub" rel="stylesheet">
        <link href="<?=CSS?>/icones.css?family=Material+Icons" rel="stylesheet">
        <link href="<?=CSS?>/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
        <link href="<?=CSS?>/hover-min.css" type="text/css" rel="stylesheet" media="screen,projection"/>
        <link href="<?=CSS?>/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
        <script src="<?=JS?>/jquery-3.2.1.js"></script>
        <script src="<?=JS?>/jquery.mask.js"></script>
        <script src="<?=JS?>/Chart.min.js"></script>
        <?=$css?>
    </head>
<body>
    <input type="hidden" id="link" value="<?=LINK?>" />
    <input type="hidden" id="recurso" value="<?=RECURSO?>" />
