<?php

?>
<!DOCTYPE html>
<html lang="pt-br">
<!-- [Head] start -->

<head>
    <title>
        <?php 
echo $title ?? '';
?> <?php 
echo $sistem ?? '';
?>
    </title>
    <!-- [Meta] -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="<?php 
echo $description ?? '';
?>">
    <meta name="keywords" content="<?php 
echo $keywords ?? '';
?>">
    <meta name="author" content="<?php 
echo $dev ?? '';
?>">
    <!--  -->
    <!-- [Favicon] icon -->
    <link rel="icon" href="<?php 
echo asset("img/logoM.png");
?>" type="image/x-icon"> <!-- [Google Font] Family -->
    <link href="<?php 
echo asset("img/apple-touch-icon.png");
?>" rel="apple-touch-icon">

    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.css" rel="stylesheet">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap"
        id="main-font-link">

    <!-- [Bootstrap] https://get.bootstrap.com -->
    <link href="<?php 
echo asset("vendor/bootstrap/css/bootstrap.min.css");
?>" rel="stylesheet">


    <!-- [Tabler Icons] https://tablericons.com -->
    <link href="<?php 
echo asset("fonts/tabler-icons.min.css", true);
?>" rel="stylesheet">

    <!-- [Feather Icons] https://feathericons.com -->
    <link href="<?php 
echo asset("fonts/feather.css", true);
?>" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/feather-icons"></script>

    <!-- [Font Awesome Icons] https://fontawesome.com/icons -->
    <link href="<?php 
echo asset("fonts/fontawesome.css", true);
?>" rel="stylesheet">


    <!-- [Material Icons] https://fonts.google.com/icons -->
    <link href="<?php 
echo asset("fonts/fontawesome.css", true);
?>" rel="stylesheet">
    <link href="<?php 
echo asset("vendor/select2/css/select2.min.css");
?>" rel="stylesheet">

    <!-- [Template CSS Files] -->
    <link rel="stylesheet" href="<?php 
echo asset("css/style.css", true);
?>" id="main-style-link">
    <link rel="stylesheet" href="<?php 
echo asset("css/style-preset.css", true);
?>">
    <link rel="stylesheet" href="<?php 
echo asset("css/custom.css");
?>" id="main-style-link">

</head>
<!-- [Head] end -->
<!-- [Body] Start -->

<body data-pc-preset="preset-1" data-pc-direction="ltr" data-pc-theme="light">
    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <!-- [ Pre-loader ] End --><?php 
