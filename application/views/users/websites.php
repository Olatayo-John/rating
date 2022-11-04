<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/websites.css'); ?>">

<div class="bg-light-custom" style="margin-top: 74px;">
    <div class="modal add_web_modal">
        <div class="modal-dialog modal-dialog-top">
            <div class="modal-content">
                <div class="modal-body">
                    <form method="post" action="<?php echo base_url("user/add_website") ?>" class="add_web_modal_form">
                        <input type="hidden" class="csrf_token" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                        <div class="form-group">
                            <label>Website Name</label>
                            <input type="text" name="web_name" class="web_name form-control" placeholder="Name of the webisite" required>
                        </div>
                        <div class="form-group">
                            <label class="mb-0">Website Link</label>
                            <div class="text-danger font-weight-bolder mt-0 web_link_err"></div>
                            <input type="url" name="web_link" class="web_link form-control" placeholder="e.g https://domainname.com" required>
                        </div>
                        <div class="modal_btn_actions d-flex justify-content-between">
                            <button type="button" class="btn btn-secondary closewebmodal_btn">Close</button>
                            <button type="submit" class="btn add_web_modal_btn text-light" style="background-color:#294a63;">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <form action="<?php echo base_url('account'); ?>" method="post" class="addweb_form">
        <input type="hidden" class="csrf_token" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
        <div class="text-right">
            <button type="button" class="text-light btn addwebmodal_btn" style="background:#294a63">
                <i class="fas fa-plus-circle mr-2"></i>
                Add a website to your account
            </button>
        </div>

        <div class="text-danger text-left instruction_div">
            <?php if ($this->session->userdata("mr_iscmpy") === "1" && !empty($this->session->userdata("mr_cmpyid"))) : ?>
                <div>Webspace is used by all users under <span style="color:black"><?php echo $this->session->userdata("mr_cmpy") ?></span> COMPANY</div>
                <div>For more quota, contact your company Admin.</div>
            <?php else : ?>
                <div>For more quota, contact us at <a href="mailto:hr@nktech.in">nktech.in</a> for your desired package.</div>
            <?php endif; ?>
        </div>
        <hr>

        <div class="text-center countwebs_div font-weight-bolder">
            Created <span class="countwebs"><?php echo $webs->num_rows() ?></span> out of <span class="webspaceleft"></span>
        </div>

        <div class="web_info_div" id="web_info_div">
            <?php foreach ($webs->result_array() as $web) : ?>
                <div class="d-flex flex-direction-row col-md-12 eachwebinfo">
                    <div class="form-group" style="margin:0">
                        <span class="web_num"><i class="fas fa-circle"></i></span>
                    </div>
                    <div class="form-group col">
                        <label class="webnamelabel" id="webnamelabel"><?php echo $web['web_name'] ?></label>
                        <input type="url" name="weblinkinput" class="form-control weblinkinput" id="weblinkinput" value="<?php echo $web['web_link'] ?>" readonly required style="cursor:not-allowed">
                    </div>
                    <div class="form-group" style="margin:35px 0 0 0">

                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="btngrp text-right mt-5">
            <button class="btn text-light" type="submit" style="background:#294a63">Continue</button>
        </div>
    </form>
</div>



<script>
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();

        get_userQuota();

        //hide or show necessary data
        function get_userQuota() {
            var csrfName = $('.csrf_token').attr('name');
            var csrfHash = $('.csrf_token').val();

            $.ajax({
                url: "<?php echo base_url('get-user-quota'); ?>",
                method: "post",
                data: {
                    [csrfName]: csrfHash
                },
                dataType: "json",
                success: function(data) {
                    $('.csrf_token').val(data.token);

                    if (data.status === true) {
                        if (parseInt(data.userQuota.web_quota) <= 0) {
                            $(".addwebmodal_btn").hide();
                            $(".add_web_modal").modal('hide');
                        } else if (parseInt(data.userQuota.web_quota) > 0) {
                            $(".addwebmodal_btn").show();
                        }

                        //show number of quota left
                        $(".webspaceleft").text(data.userQuota.web_quota);

                    } else if (data.status == "error" || data.status == false) {
                        window.location.assign(data.redirect);
                    }
                },
                error: function(data) {
                    window.location.assign(data.redirect);
                }
            })
        }

        //
        const getUserQuota = async () => {
            var csrfName = $('.csrf_token').attr('name');
            var csrfHash = $('.csrf_token').val();

            const response = await $.ajax({
                url: "<?php echo base_url('get-user-quota'); ?>",
                method: "post",
                data: {
                    [csrfName]: csrfHash
                },
                dataType: "json"
            })

            return response;
        }
        $(document).on('click', 'button.addwebmodal_btnn', function(e) {
            e.preventDefault();

            var csrfName = $('.csrf_token').attr('name');
            var csrfHash = $('.csrf_token').val();
            var userQuotaInfo = getUserQuota;

        });
        //

        //get anc check user quota
        //open modal if there is quota for website 
        $(document).on('click', 'button.addwebmodal_btn', function(e) {
            e.preventDefault();

            var csrfName = $('.csrf_token').attr('name');
            var csrfHash = $('.csrf_token').val();

            $.ajax({
                url: "<?php echo base_url('get-user-quota'); ?>",
                method: "post",
                data: {
                    [csrfName]: csrfHash
                },
                dataType: "json",
                success: function(data) {
                    $('.csrf_token').val(data.token);

                    if (data.status === true) {
                        if (parseInt(data.userQuota.web_quota) <= 0) {
                            $(".add_web_modal").modal('hide');

                            $(".ajax_succ_div,.ajax_err_div").fadeOut();
                            $('.ajax_res_err').html("Web Quota limit reached");
                            $('.ajax_err_div').fadeIn();
                        } else if (parseInt(data.userQuota.web_quota) > 0) {
                            $(".add_web_modal_btn").show();
                            $('.web_name,.web_link').removeAttr("readonly");
                            $('.add_web_modal').modal("show");

                            $(".ajax_succ_div,.ajax_err_div").fadeOut();
                        }
                    } else if (data.status == "error" || data.status == false) {
                        window.location.assign(data.redirect);
                    }
                },
                error: function(data) {
                    window.location.assign(data.redirect);
                }
            })
        });

        //close the modal to add new websites
        $(document).on('click', 'button.closewebmodal_btn', function(e) {
            e.preventDefault();
            $('.add_web_modal').modal("hide");
        });

        //create a website
        $(document).on('click', 'button.add_web_modal_btn', function(e) {
            e.preventDefault();

            var csrfName = $('.csrf_token').attr('name');
            var csrfHash = $('.csrf_token').val();
            var web_name = $('.web_name').val();
            var web_link = $('.web_link').val();
            var countweb = $('.countwebs').text();

            if (web_name == "" || web_name == null) {
                $('.web_name').css('border', '2px solid red');
                return false;
            } else {
                $('.web_name').css('border', '1px solid #ced4da');
            }
            if (web_link == "" || web_link == null) {
                $(".web_link").css('border', '2px solid red');
                return false;
            }

            var patt = new RegExp('^(https?:\\/\\/)?' + // protocol
                '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.?)+[a-z]{2,}|' + // domain name
                '((\\d{1,3}\\.){3}\\d{1,3}))' + // ip (v4) address
                '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*' + //port
                '(\\?[;&amp;a-z\\d%_.~+=-]*)?' + // query string
                '(\\#[-a-z\\d_]*)?$', 'i');
            var res = patt.test(web_link);
            if (res == true) {
                $(".web_link_err").fadeOut();
                $('.web_link').css('border', '1px solid #ced4da');
            } else if (res == false) {
                $(".web_link").css('border', '2px solid red');
                $(".web_link_err").html("Invalid WEB URL").fadeIn();
                return false;
            }

            $.ajax({
                method: "post",
                url: "<?php echo base_url("add-website") ?>",
                data: {
                    web_name: web_name,
                    web_link: web_link,
                    [csrfName]: csrfHash
                },
                dataType: "json",
                success: function(data) {
                    $('.csrf_token').val(data.token);

                    if (data.status === true) {
                        $(".ajax_succ_div,.ajax_err_div").fadeOut();
                        $('.ajax_res_succ').html(data.msg);
                        $('.ajax_succ_div').fadeIn();

                        $(".web_info_div").append('<div class="d-flex flex-direction-row col-md-12 web_wrapper eachwebinfo" id="' + data.webID + '" webname="' + web_name + '" weblink="' + web_link + '"><div class="form-group" style="margin:0"><span class="web_num"><i class="fas fa-circle"></i></span></div><div class="form-group col"><label class="webname_label" id="webname_label">' + web_name + '</label><input type="url" name="weblink_input" class="form-control weblink_input" id="weblink_input" value="' + web_link + '" readonly required style="cursor:not-allowed"></div><div class="form-group" style="margin:35px 0 0 0"><i class="fas fa-times remove_web_i text-danger" web_id="' + data.webID + '" web_name="' + web_name + '" web_link="' + web_link + '"></i></div></div>');

                        $('.add_web_modal').modal("hide");
                        $('.web_name').val("");
                        $('.web_link').val("");

                        var new_countweb = parseInt(countweb) + 1;
                        $(".countwebs").html(new_countweb);

                    } else if (data.status == "error" || data.status == false) {
                        $(".ajax_succ_div,.ajax_err_div").fadeOut();
                        $('.ajax_res_err').html(data.msg);
                        $('.ajax_err_div').fadeIn();
                    }
                }
            });

        });

        //remove a website added
        $(document).on('click', 'i.remove_web_i', function() {
            var csrfName = $('.csrf_token').attr('name');
            var csrfHash = $('.csrf_token').val();
            var web_name = $(this).attr("web_name");
            var web_link = $(this).attr("web_link");
            var web_id = $(this).attr("web_id");
            var countweb = $('.countwebs').text();

            $.ajax({
                method: "post",
                url: "<?php echo base_url("remove-website") ?>",
                data: {
                    web_name: web_name,
                    web_link: web_link,
                    web_id: web_id,
                    [csrfName]: csrfHash
                },
                dataType: "json",
                success: function(data) {
                    $('.csrf_token').val(data.token);

                    if (data.status === true) {
                        $(".ajax_succ_div,.ajax_err_div").fadeOut();
                        $('.ajax_res_succ').html(data.msg);
                        $('.ajax_succ_div').fadeIn();

                        //remove from html page
                        $("div#" + web_id).remove();

                        var new_countweb = parseInt(countweb) - 1;
                        $(".countwebs").html(new_countweb);

                    } else if (data.status == "error" || data.status == false) {
                        $(".ajax_succ_div,.ajax_err_div").fadeOut();
                        $('.ajax_res_err').html(data.msg);
                        $('.ajax_err_div').fadeIn();
                    }
                }
            });
        });


    });
</script>