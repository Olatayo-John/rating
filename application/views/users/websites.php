<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/websites.css'); ?>">

<div class="bg-white" style="margin-top: 74px;">
    <?php if ($this->session->userdata("mr_webspace_left") > 0) : ?>
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
    <?php endif; ?>
    <form action="<?php echo base_url('addwebsites'); ?>" method="post" class="addweb_form">
        <input type="hidden" class="csrf_token" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
        <div class="text-right">
            <?php if ($this->session->userdata("mr_webspace_left") > 0) : ?>
                <button type="button" class="text-light btn addwebmodal_btn" style="background:#294a63">
                    <i class="fas fa-plus-circle mr-2"></i>
                    Add a website to your account
                </button>
            <?php endif; ?>
        </div>
        <div class="text-danger text-left instruction_div">
            <?php if ($this->session->userdata("mr_iscmpy") === "1" && !empty($this->session->userdata("mr_cmpyid"))) : ?>
                <div>Available webspace of <span class="webspaceleft"><?php echo $this->session->userdata("mr_webspace_left") ?></span> (webspace is used by all users under "<?php echo $this->session->userdata("mr_cmpy") ?> COMPANY")</div>
                <div>For more quota, contact us at <a href="mailto:hr@nktech.in">nktech.in</a> for your desired package.</div>
            <?php else : ?>
                <div>Available webspace of <span class="webspaceleft"><?php echo $this->session->userdata("mr_webspace_left") ?></span>.</div>
                <div>For more quota, contact your company Admin.</div>
            <?php endif; ?>
            <!-- <div>You can't change or remove any of this information after.</div> -->
        </div>
        <hr>
        <div class="text-center countwebs_div font-weight-bolder">
            Created <span class="countwebs"><?php echo $webs->num_rows() ?></span> website(s).
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

        <div class="btngrp text-right mt-5" style="display:none">
            <?php
            $webs = $webs->num_rows();
            if ($webs == 0) {
                $websnum = 1;
            } elseif ($webs > 0) {
                $websnum = $webs + 1;
            }
            ?>
            <input type="hidden" class="num_inc" value="<?php echo $websnum ?>">
            <button class="btn text-light add_allwebbtn" type="submit" style="background:#294a63">Save</button>
        </div>
    </form>
</div>



<script>
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();

        $(document).on('click', 'button.addwebmodal_btn', function(e) {
            e.preventDefault();
            var num = $('.num_inc').val();
            var web_quota = "<?php echo $this->session->userdata("mr_webspace") ?>";
            var web_count = $(".web_wrapper").length;
            var webspaceleft = $(".webspaceleft").text();

            if (parseInt(webspaceleft) === 0) {
                $(".add_web_modal_btn").hide();
                $('.web_name,.web_link').attr("readonly", "true");
                $('.add_web_modal').modal("hide");
                $('.countwebs_div').css("font-weight", "bolder");
                $('.countwebs').css({
                    "font-weight": "bolder",
                    "color": "#dc3545"
                });

                $(".ajax_succ_div,.ajax_err_div").fadeOut();
                $('.ajax_res_err').html("Web Quota reached");
                $('.ajax_err_div').fadeIn();
            } else {
                $(".add_web_modal_btn").show();
                $('.web_name,.web_link').removeAttr("readonly");
                $('.add_web_modal').modal("show");
                $('.countwebs_div').css("font-weight", "inherit");
                $('.countwebs').css({
                    "font-weight": "inherit",
                    "color": "black"
                });

                $(".ajax_succ_div,.ajax_err_div").fadeOut();
            }
        });

        $(document).on('click', 'button.closewebmodal_btn', function(e) {
            e.preventDefault();
            $('.add_web_modal').modal("hide");
        });

        $(document).on('click', 'button.add_web_modal_btn', function(e) {
            e.preventDefault();
            var csrfName = $('.csrf_token').attr('name');
            var csrfHash = $('.csrf_token').val();
            var web_name = $('.web_name').val();
            var web_link = $('.web_link').val();
            var num = $('.num_inc').val();

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
            var web_quota = "<?php echo $this->session->userdata("mr_webspace") ?>";
            var web_count = $(".web_wrapper").length;
            var new_web_count = parseInt(web_count) + 1;
            var webspaceleft = $(".webspaceleft").text();

            if (webspaceleft > 0) {
                $(".web_info_div").append('<div class="d-flex flex-direction-row col-md-12 web_wrapper eachwebinfo" id="' + num + '" webname="' + web_name + '" weblink="' + web_link + '"><div class="form-group" style="margin:0"><span class="web_num"><i class="fas fa-circle"></i></span></div><div class="form-group col"><label class="webname_label" id="webname_label">' + web_name + '</label><input type="url" name="weblink_input" class="form-control weblink_input" id="weblink_input" value="' + web_link + '" readonly required style="cursor:not-allowed"></div><div class="form-group" style="margin:35px 0 0 0"><i class="fas fa-times remove_web_i text-danger" web_id="' + num + '" web_name="' + web_name + '" web_link="' + web_link + '"></i></div></div>');

                $('.add_web_modal').modal("hide");
                $('.web_name').val("");
                $('.web_link').val("");

                var new_num = parseInt(num) + 1;
                $('.num_inc').val(new_num);

                $(".countwebs").html(num);
                $(".countwebs_div").fadeIn();

                $(".webspaceleft").text(parseInt(webspaceleft) - 1);

                $(".btngrp").fadeIn();
            } else {
                $(".ajax_succ_div").fadeOut();
                $('.ajax_res_err').html("Web Quota reached");
                $('.ajax_err_div').fadeIn();

                $('.add_web_modal').modal("hide");
                $('.web_name').val("");
                $('.web_link').val("");
            }


        });

        $(document).on('click', 'i.remove_web_i', function() {
            var csrfName = $('.csrf_token').attr('name');
            var csrfHash = $('.csrf_token').val();
            var web_name = $(this).attr("web_name");
            var web_link = $(this).attr("web_link");
            var webspaceleft = $(".webspaceleft").text();

            var num = $('.num_inc').val();
            var web_id = $(this).attr("web_id");

            $("div#" + web_id).remove();

            var count_all = $('.eachwebinfo').length;
            var count_created = $('.web_wrapper').length;

            $(".countwebs").html(count_all);
            $(".num_inc").val(parseInt(count_all) + 1);
            $(".webspaceleft").text(parseInt(webspaceleft) + 1);

            if (parseInt(count_created) == 0) {
                $(".btngrp").fadeOut();
            } else {
                $(".btngrp").fadeIn();
            }

            // var new_num = parseInt(num) - 1;
            // $('.num_inc').val(new_num);
        });

        $(document).on('click', '.add_allwebbtn', function(e) {
            e.preventDefault();
            var csrfName = $('.csrf_token').attr('name');
            var csrfHash = $('.csrf_token').val();

            var webname_arr = [];
            var weblink_arr = [];
            $(".web_wrapper").each(function() {
                var webname = $(this).attr("webname");
                var weblink = $(this).attr("weblink");

                webname_arr.push(webname);
                weblink_arr.push(weblink);
            });

            $.ajax({
                method: "post",
                url: "<?php echo base_url("addwebsites") ?>",
                data: {
                    webname_arr: webname_arr,
                    weblink_arr: weblink_arr,
                    [csrfName]: csrfHash
                },
                dataType: "json",
                success: function(data) {
                    $('.csrf_token').val(data.token);
                    if (data.status == true) {
                        window.location.assign(data.redirect);
                    } else if (data.status == "error" || data.status == false) {
                        // $(".ajax_succ_div,.ajax_err_div").fadeOut();
                        // $('.ajax_res_err').html(data.msg);
                        // $('.ajax_err_div').fadeIn("slow").delay("6000").fadeOut("slow");
                        window.location.assign(data.redirect);
                    }
                }
            });
        });
    });
</script>