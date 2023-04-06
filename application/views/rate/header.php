<!DOCTYPE html>
<html>

<head>
    <title>
        <?php echo (isset($title) && !empty($title)) ? ucwords($title) . ($this->st->site_name ? ' - ' . $this->st->site_name : '') : '' ?>
    </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="title" content="<?php echo $this->st->site_title ?>">
    <meta name="description" content="<?php echo $this->st->site_desc ?>">
    <meta name="keywords" content="<?php echo $this->st->site_keywords ?>">

    <meta name="google-site-verification" content="4Zl2nRJpgHrj0_NZozlpZEiv3i-WKHdQ861N1QJZ-x4" />

    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/header.css'); ?>">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/ca92620e44.js" crossorigin="anonymous"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.5.0/gsap.min.js"></script>

    <link href="https://unpkg.com/bootstrap-table@1.18.3/dist/bootstrap-table.min.css" rel="stylesheet">
    <script src="https://unpkg.com/bootstrap-table@1.18.3/dist/bootstrap-table.min.js"></script>

    <script src="https://unpkg.com/bootstrap-table@1.18.3/dist/extensions/mobile/bootstrap-table-mobile.min.js"></script>

    <link href="https://unpkg.com/ionicons@4.5.5/dist/css/ionicons.min.css" rel="stylesheet">

    <script src="https://unpkg.com/tableexport.jquery.plugin/tableExport.min.js"></script>
    <script src="https://unpkg.com/bootstrap-table@1.18.3/dist/extensions/export/bootstrap-table-export.min.js"></script>

    <script src="https://unpkg.com/bootstrap-table@1.18.3/dist/extensions/print/bootstrap-table-print.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

    <link rel="icon" href="<?php echo base_url('assets/images/') . $this->st->site_fav_icon ?>">
    <script type="text/javascript">
        document.onreadystatechange = function() {
            if (document.readyState !== "complete") {
                $(".spinnerdiv").show();
            } else {
                $(".spinnerdiv").fadeOut();
            }
        };
    </script>
</head>

<body>
    <div class="spinnerdiv">
        <div class="spinner-border" style="color:cornflowerblue"></div>
    </div>

    <!-- errors -->
    <div class="container">

        <!-- ajax-failed -->
        <div class="alertWrapper ajax_alert_div ajax_err_div" style="padding:8px;display:none;z-index: 9999;">
            <strong class="ajax_res_err text-dark"></strong>
        </div>

        <!-- ajax-success -->
        <div class="alertWrapper ajax_alert_div ajax_succ_div" style="padding:8px;display:none;z-index: 9999;">
            <strong class="ajax_res_succ text-dark"></strong>
        </div>

        <!-- session-flashMsg-function -->
        <?php if ($this->session->userdata('FlashMsg')) : ?>
            <div class="alertWrapper alert<?php echo $this->session->userdata('FlashMsg')['status'] ?>">
                <strong><?php echo $this->session->userdata('FlashMsg')['msg'] ?></strong>
            </div>
        <?php endif; ?>

        <?php if (validation_errors()) : ?>
            <div class="alerterror alertWrapper">
                <strong><?php echo validation_errors(); ?></strong>
            </div>
        <?php endif; ?>
    </div>
    <!--  -->

    <div id="content" style="margin:20px 0 0 0">
