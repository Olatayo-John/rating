<h4 class="text-dark">Websites</h4>
<hr class="web">
<div class="d-flex btn_wrapper_div" style="justify-content:space-between">
    <div style="color:#294a63;font-weight:bold;margin:auto 0">
        <div>Available webspace of <span class="webspaceleft"><?php echo $this->session->userdata("mr_webspace_left") ?></span>
        </div>

        <div>Available webspace of <span class="webspaceleft"><?php echo $this->session->userdata("mr_webspace_left") ?></span></div>

    </div>
    <div>

        <button type="button" class="text-light btn addwebmodal_btn" style="background:#294a63">
            <i class="fas fa-plus-circle mr-2"></i>New Website
        </button>
    </div>
</div>
<hr>

<div class="eachwebwrapper" id="eachwebwrapper">
    <?php if ($websites->num_rows() === 0) : ?>
        <h6 class="text-center pt-4 pb-3 noweb text-danger">No website(s) created</h6>
    <?php endif; ?>

    <?php if ($websites->num_rows() > 0) : ?>
        <?php foreach ($websites->result_array() as $web) : ?>
            <div class="col-md-12 p-0 d-flex eachwebinfo">
                <div class="form-group" style="margin:0">
                    <?php if ($web['active'] == "1") : ?>
                        <span class="web_stati text-success" id="<?php echo $web['id'] ?>"><i class="fas fa-circle" title="Webste is active"></i></span>
                    <?php endif; ?>
                    <?php if ($web['active'] == "0") : ?>
                        <span class="web_stati text-danger" id="<?php echo $web['id'] ?>"><i class="fas fa-circle" title="Webste is not active"></i></span>
                    <?php endif; ?>
                </div>
                <div class="form-group col pr-0">
                    <label class="webnamelabel" id="webnamelabel"><?php echo $web['web_name'] ?></label>
                    <div class="d-flex">
                        <input type="url" name="weblinkinput" class="form-control weblinkinput" id="weblinkinput" value="<?php echo $web['web_link'] ?>" readonly required style="cursor:not-allowed">
                        <div class="d-flex col-md-2">

                            <a type="button" class="btn btn-info viewweb_btn statusweb_btn acbtn" id="<?php echo $web['id'] ?>" title="View">
                                <i class="fa-solid fa-pen-to-square"></i> View
                            </a>

                            <?php if ($web['active'] == "1") : ?>
                                <a type="button" class="btn btn-danger statusweb_btn dacbtn" attrid="<?php echo $web['id'] ?>" id="<?php echo $web['id'] ?>" status="0" title="Activate">
                                    <i class="fa-solid fa-toggle-on"></i> De-activate
                                </a>
                            <?php endif; ?>
                            <?php if ($web['active'] == "0") : ?>
                                <a type="button" class="btn btn-success statusweb_btn acbtn" attrid="<?php echo $web['id'] ?>" id="<?php echo $web['id'] ?>" status="1" title="Activate">
                                    <i class="fa-solid fa-toggle-on"></i> Activate
                                </a>
                            <?php endif; ?>
                            <a type=" button" class="btn btn-danger delete_button" title="Delete">
                                <i class="fa-solid fa-trash"></i> Delete
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<!-- view modal -->
<div class="modal edit_web_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <form method='post'>
                    <input type="hidden" class="csrf_token" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                    <input type="hidden" class="web_id form-control" name="web_id" value="">
                    <!-- <span>Website is active</span> -->
                    <hr style="margin:5px 0 20px 0">
                    <div class="form-group">
                        <label class="font-weight-bolder">Web Name</label>
                        <input type="text" name="web_name_edit" class="web_name_edit form-control" placeholder="Name of the webiste" required disabled readonly>
                    </div>
                    <div class="form-group">
                        <label class="mb-0 font-weight-bolder">Web Link</label>
                        <input type="url" name="web_link_edit" class="web_link_edit form-control" placeholder="Website link" required disabled readonly>
                    </div>
                    <hr>
                    <div class="modal_btn_actions text-right">
                        <button type="button" class="btn btn-secondary close_editweb_modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- add new website modal -->
<?php if ($this->session->userdata("mr_webspace_left") > 0) : ?>
    <div class="modal add_web_modal">
        <div class="modal-dialog modal-dialog-top">
            <div class="modal-content">
                <div class="modal-header text-danger justify-content-center font-weight-bolder">
                    You can't change or remove any of this information after
                </div>
                <div class="modal-body">
                    <form method="post" action="<?php echo base_url("user/user_new_website") ?>" class="add_web_modal_form">
                        <input type="hidden" class="csrf_token" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                        <div class="form-group">
                            <label class="mb-0 font-weight-bolder">Website Name</label>
                            <input type="text" name="web_name_new" class="web_name_new form-control" placeholder="Name of the webisite" required>
                            <div class="text-danger font-weight-bolder mt-0 web_name_err"></div>
                        </div>
                        <div class="form-group">
                            <label class="mb-0 font-weight-bolder">Website Link</label>
                            <input type="url" name="web_link_new" class="web_link_new form-control" placeholder="e.g https://domainname.com" required>
                            <div class="text-danger font-weight-bolder mt-0 web_link_err"></div>
                        </div>
                        <hr>
                        <div class="modal_btn_actions d-flex justify-content-between">
                            <button type="button" class="btn btn-secondary closewebmodal_btn">Close</button>
                            <button type="submit" class="btn add_web_modal_btn text-light" style="background-color:#294a63;">
                                <i class="fas fa-save mr-2"></i>Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endif ?>


<script>
    $(document).ready(function() {
        // add new website modal
        $(document).on('click', 'button.addwebmodal_btn', function(e) {
            e.preventDefault();
            var num = $('.eachwebinfo').length;
            var web_quota = "<?php echo $this->session->userdata("mr_webspace"); ?>";
            var webspaceleft = $(".webspaceleft").text();

            if (parseInt(webspaceleft) === 0) {
                $(".addwebmodal_btn").attr({
                    disabled: "disabled"
                }).css({
                    "cursor": "not-allowed"
                });
                $(".add_web_modal_btn").hide().attr({
                    disabled: "disabled"
                }).css({
                    "cursor": "not-allowed"
                });
                $('.web_name_new,.web_link_new').attr("readonly", "true");
                $('.add_web_modal').modal("hide");
            } else {
                $(".addwebmodal_btn").removeAttr("disabled").css({
                    "cursor": "pointer"
                });
                $(".add_web_modal_btn").show().removeAttr("disabled").css({
                    "cursor": "pointer"
                });
                $(".web_link_err,.web_name_err").fadeOut();
                $('.web_link_new,.web_name_new').css('border', '1px solid #ced4da').removeAttr("readonly").val("");

                $('.add_web_modal').modal("show");
            }
        });

        $(document).on('click', 'button.closewebmodal_btn', function(e) {
            e.preventDefault();
            $('.add_web_modal').modal("hide");
        });

        // check for duplicate web-name
        $(".web_name_new").keyup(function() {
            var webname = $(".web_name_new").val();
            var csrfName = $(".csrf_token").attr("name");
            var csrfHash = $(".csrf_token").val();

            $.ajax({
                url: "<?php echo base_url("duplicate-webname") ?>",
                method: "post",
                dataType: "json",
                data: {
                    [csrfName]: csrfHash,
                    webname: webname
                },
                success: function(data) {
                    $(".csrf_token").val(data.token);

                    if (data.webdata > 0) {
                        $('.web_name_err').html("Website with this name already exist").show();
                        $(".web_name_new").css('border', '1px solid red');
                        $(".add_web_modal_btn").attr({
                            type: "button",
                            disabled: "disabled",
                            readonly: "readonly"
                        }).css("cursor", "not-allowed");
                    } else {
                        $('.web_name_err').hide();
                        $(".web_name_new").css('border', '1px solid #ced4da');
                        $(".add_web_modal_btn").removeAttr("disabled readonly").attr("type", "submit").css("cursor", "pointer");
                    }
                },
                error: function(data) {
                    window.location.reload();
                }
            });
        });

        // check for duplicate web-link
        $(".web_link_new").keyup(function() {
            var weblink = $(".web_link_new").val();
            var csrfName = $(".csrf_token").attr("name");
            var csrfHash = $(".csrf_token").val();

            $.ajax({
                url: "<?php echo base_url("duplicate-weblink") ?>",
                method: "post",
                dataType: "json",
                data: {
                    [csrfName]: csrfHash,
                    weblink: weblink
                },
                success: function(data) {
                    $(".csrf_token").val(data.token);

                    if (data.webdata > 0) {
                        $('.web_link_err').html("Website with this Link already exist").show();
                        $(".web_link_new").css('border', '1px solid red');
                        $(".add_web_modal_btn").attr({
                            type: "button",
                            disabled: "disabled",
                            readonly: "readonly"
                        }).css("cursor", "not-allowed");
                    } else {
                        $('.web_link_err').hide();
                        $(".web_link_new").css('border', '1px solid #ced4da');
                        $(".add_web_modal_btn").removeAttr("disabled readonly").attr("type", "submit").css("cursor", "pointer");
                    }
                },
                error: function(data) {
                    window.location.reload();
                }
            });
        });

        // add website to database
        $(document).on('click', 'button.add_web_modal_btn', function(e) {
            e.preventDefault();

            var csrfName = $('.csrf_token').attr('name');
            var csrfHash = $('.csrf_token').val();
            var web_name_new = $('.web_name_new').val();
            var web_link_new = $('.web_link_new').val();
            var webspaceleft = $(".webspaceleft").text();

            if (web_name_new == "" || web_name_new == null || web_name_new == undefined) {
                $('.web_name_new').css('border', '2px solid red');
                return false;
            } else {
                $('.web_name_new').css('border', '1px solid #ced4da');
            }
            if (web_link_new == "" || web_link_new == null || web_link_new == undefined) {
                $(".web_link_new").css('border', '2px solid red');
                return false;
            }

            var patt = new RegExp('^(https?:\\/\\/)?' + // protocol
                '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.?)+[a-z]{2,}|' + // domain name
                '((\\d{1,3}\\.){3}\\d{1,3}))' + // ip (v4) address
                '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*' + //port
                '(\\?[;&amp;a-z\\d%_.~+=-]*)?' + // query string
                '(\\#[-a-z\\d_]*)?$', 'i');
            var res = patt.test(web_link_new);
            if (res == true) {
                $(".web_link_err").fadeOut();
                $('.web_link_new').css('border', '1px solid #ced4da');
            } else if (res == false) {
                $(".web_link_new").css('border', '2px solid red');
                $(".web_link_err").html("Invalid WEB URL").fadeIn();
                return false;
            }

            $.ajax({
                url: "<?php echo base_url("add-website") ?>",
                method: "post",
                dataType: "json",
                data: {
                    [csrfName]: csrfHash,
                    web_name_new: web_name_new,
                    web_link_new: web_link_new
                },
                success: function(data) {
                    $(".csrf_token").val(data.token);

                    if (data.status === false) {
                        $(".ajax_succ_div,.ajax_err_div").hide();
                        $(".ajax_res_err").text(data.msg);
                        $(".ajax_err_div").fadeIn().delay("6000").fadeOut();
                    } else {
                        $(".ajax_err_div,.ajax_succ_div").hide();
                        $(".ajax_res_succ").text(data.msg);
                        $(".ajax_succ_div").fadeIn().delay("6000").fadeOut();

                        $(".noweb").hide();

                        $(".eachwebwrapper").append('<div class="col-md-12 p-0 d-flex eachwebinfo"><div class="form-group" style="margin:0"><span class="web_stati text-success" id="' + data.insert_id + '"><i class="fas fa-circle" title="Webste is active"></i></span></div><div class="form-group col pr-0"><label class="webnamelabel" id="webnamelabel">' + web_name_new + '</label><div class="d-flex"><input type="url" name="weblinkinput" class="form-control weblinkinput" id="weblinkinput" value="' + web_link_new + '" readonly required style="cursor:not-allowed"><div class="d-flex col-md-2"><button type="button" class="btn text-light viewweb_btn " id="' + data.insert_id + '" style="background:#294a63">View</button><button type="button" class="btn statusweb_btn text-light dacbtn" attrid="' + data.insert_id + '" id="' + data.insert_id + '" status="0" style="background:#294a63">Deactivate</button></div></div></div></div>');

                        var num = $('.eachwebinfo').length;
                        $(".web_num_total").text(num);

                        $(".webspaceleft").text(parseInt(webspaceleft) - 1);

                        $('.add_web_modal').modal("hide");
                    }
                }
            })
        });

        // show website details
        $(document).on('click', 'button.viewweb_btn', function() {
            var csrfName = $('.csrf_token').attr('name');
            var csrfHash = $('.csrf_token').val();
            var id = $(this).attr('id');

            $.ajax({
                url: "<?php echo base_url('website-edit'); ?>",
                method: "post",
                data: {
                    [csrfName]: csrfHash,
                    id: id,
                },
                dataType: "json",
                success: function(data) {
                    if (data.status === false) {
                        $(".ajax_succ_div,.ajax_err_div").hide();
                        $(".ajax_res_err").text(data.msg);
                        $(".ajax_err_div").fadeIn().delay("6000").fadeOut();
                    } else if (data.status === true) {
                        $('.web_name_edit').val(data.web_name);
                        $('.web_link_edit').val(data.web_link);
                        $('.edit_web_modal').fadeIn();
                        $('.web_id').val(id);
                    }

                    $('.csrf_token').val(data.token);

                }
            });
        });

        $(document).on('click', 'button.close_editweb_modal', function(e) {
            e.preventDefault();
            $('.edit_web_modal').fadeOut();
        });

        // change website status
        $(document).on('click', 'button.statusweb_btn', function(e) {
            e.preventDefault();
            var csrfName = $('.csrf_token').attr('name');
            var csrfHash = $('.csrf_token').val();
            var id = $(this).attr('id');
            var status = $(this).attr('status');

            $.ajax({
                url: "<?php echo base_url('website-status'); ?>",
                method: "post",
                data: {
                    [csrfName]: csrfHash,
                    id: id,
                    status: status,
                },
                dataType: 'json',
                success: function(data) {
                    if (data.status === false) {
                        $(".ajax_succ_div,.ajax_err_div").hide();
                        $(".ajax_res_err").text(data.msg);
                        $(".ajax_err_div").fadeIn().delay("6000").fadeOut();
                    } else if (data.status === true) {
                        $(".ajax_err_div,ajax_succ_div").hide();
                        $(".ajax_res_succ").text(data.msg);
                        $(".ajax_succ_div").fadeIn().delay("6000").fadeOut();

                        if (status == 1) {
                            $("span#" + id + "").removeClass("text-danger").addClass("text-success");
                            $("span#" + id + " i").attr('title', 'Webste is active');
                            $("button[attrid='" + id + "']").attr('status', '0').html("Deactivate");
                        } else if (status == 0) {
                            $("span#" + id + "").removeClass("text-success").addClass("text-danger");
                            $("span#" + id + " i").attr('title', 'Webste is not active');
                            $("button[attrid='" + id + "']").attr('status', '1').html("Activate");
                        }
                    }

                    $('.csrf_token').val(data.token);
                }
            });
        });
    });
</script>