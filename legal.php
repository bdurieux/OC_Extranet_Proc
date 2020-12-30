<?php 
session_start();
// connexion database
include("connexionDB.php");

$subtitle ="Mentions Légales";
?>
<!doctype html>
<html lang="en">
  <head>
    <title>GBAF - <?= $subtitle; ?></title>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="viewport-fit=cover, width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/styles.css" />
    <link rel="stylesheet" media="screen and (max-width: 600px)" href="css/styles_mobile.css" />
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
  </head>
  <body>
    <!-- HEADER   -->
    <?php include("header.php"); ?>
    <!-- MAIN -->
    <div class="content" style="padding-top: 30px">
    <h1>Mentions légales</h1>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum nec augue leo. Donec pellentesque eget lacus eget vehicula. Pellentesque tristique vel tellus sit amet convallis. Nam posuere maximus lectus at scelerisque. Nam vel molestie quam. Donec venenatis, nunc eu laoreet congue, velit felis tincidunt neque, non vehicula diam ipsum ut ipsum. Mauris sagittis, lacus id molestie hendrerit, lorem orci tempus nulla, et iaculis lorem est a magna. Quisque facilisis elementum metus, at finibus ipsum tincidunt quis. Nulla eu felis sit amet quam egestas rutrum. In bibendum risus vel elit vulputate suscipit. Cras quis nisi id lacus luctus hendrerit vitae quis magna. Cras eu eleifend tortor, id ultrices arcu. Aenean lobortis tellus libero, non feugiat tellus congue sed. </p>
        <p>Ut dolor eros, sodales sed nisl in, bibendum varius tellus. Nullam scelerisque tincidunt arcu, in porta dolor egestas vel. Curabitur a dui nec quam finibus vehicula sed sit amet sapien. Praesent nec pulvinar odio, vitae sagittis lorem. Nullam convallis aliquet bibendum. Morbi vel odio ligula. Donec ut nulla eu quam feugiat posuere id vestibulum tortor. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Proin maximus nulla sit amet egestas aliquam. Curabitur eu sapien posuere, interdum ex sit amet, pretium leo. Integer lacinia dolor nec euismod dignissim. Duis nec consequat nulla. Duis blandit odio eget efficitur gravida. Phasellus consequat ipsum vel ligula gravida, quis accumsan lacus tempor. Sed eu ex vitae nulla malesuada lobortis. Donec pulvinar pharetra turpis, ac aliquet ex sollicitudin at. </p>
        <p>Suspendisse luctus vel ipsum vitae interdum. Suspendisse potenti. Quisque id tortor magna. Cras et commodo quam, non bibendum augue. Nam finibus, lacus at luctus aliquam, massa ex malesuada sem, nec laoreet elit est et est. Morbi quis urna eu neque consequat pharetra. Donec ut tincidunt metus, quis condimentum urna. </p>
        <p>Phasellus quis nunc pretium, vulputate magna quis, dictum erat. Morbi enim nunc, commodo in eros id, lobortis feugiat sem. Phasellus ultricies pellentesque tellus, id ullamcorper magna viverra sit amet. Maecenas vulputate scelerisque leo ac suscipit. Integer sed odio tortor. Duis tempor nisl facilisis, volutpat odio sed, luctus tellus. Curabitur at dignissim arcu. Nam et velit volutpat, condimentum neque non, mattis lacus. Maecenas odio leo, pulvinar a nisl a, malesuada dignissim lectus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Aenean aliquet mi quis lectus aliquam porttitor. Praesent imperdiet ex et diam malesuada tincidunt. Proin consequat tincidunt neque, quis porttitor elit. Nullam quis leo id nisl vestibulum volutpat. Sed facilisis quam magna, id porttitor libero fermentum quis. </p>
        <p>Aliquam erat volutpat. Nunc gravida ex a nulla tristique, et placerat diam efficitur. Nulla a suscipit justo. Vestibulum varius arcu at mollis mattis. Aenean eu velit pellentesque, mollis velit nec, mattis arcu. Proin porttitor risus vitae augue faucibus, tincidunt convallis nisl mattis. Cras faucibus, sem eleifend viverra molestie, nisl nibh hendrerit lacus, in tincidunt turpis est in ipsum. Nulla vel consequat augue. Praesent non risus mollis, volutpat ipsum eget, bibendum risus. Maecenas pharetra iaculis dolor ac commodo. Mauris et justo ac neque vestibulum imperdiet in hendrerit magna. Quisque aliquet risus eget hendrerit venenatis. Quisque quis quam mauris. Sed erat ante, malesuada et ante sed, molestie interdum nisl. Suspendisse viverra massa suscipit tempus elementum. Sed viverra elit sed nisi ullamcorper, sed egestas tellus dapibus. </p> 
    </div>
    <!-- FOOTER   -->
    <?php include("footer.php"); ?>
</body>
</html>
