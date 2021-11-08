<!DOCTYPE html>
<html>

<head>
    <title><?= ucfirst($title) ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/fof_error.css'); ?>">
    <link rel="icon" href="<?php echo base_url('assets/images/logo_dark.png') ?>">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/ca92620e44.js" crossorigin="anonymous"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="mr-3 ml-3 bg-light con">
        <div class="content">
            <i class="far fa-file-alt"></i>
            <div class="fof_text">
                <h1>404</h1>
            </div>
            <h3>The page you requested for is unavailable!!</h3>
            <a href="<?php echo base_url(); ?>" class="btn text-light mt-4" style="background:#294a63;border-radius:0">HOMEPAGE</a>
        </div>
    </div>
</body>

</html>