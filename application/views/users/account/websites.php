<!-- <h4 class="text-dark">Websites</h4> -->
<!-- <hr class="web"> -->
<div class="d-flex btn_wrapper_div" style="justify-content:space-between">
    <div style="color:#294a63;font-weight:bold;margin:auto 0">
        <div>Available webspace of <span class="webspaceleft"></span>
        </div>
    </div>
    <div>

        <button type="button" class="text-light btn addwebmodal_btn" style="background:#294a63">
            <i class="fas fa-plus pr-2"></i>Add Platform
        </button>
    </div>
</div>
<hr>

<div class="eachwebwrapper" id="eachwebwrapper">
    <?php if ($websites->num_rows() === 0) : ?>
        <h6 class="text-center pt-4 pb-3 noweb text-danger">No Platform(s) created</h6>
    <?php endif; ?>

    <?php if ($websites->num_rows() > 0) : ?>
        <?php foreach ($websites->result_array() as $web) : ?>
            <div class="col-md-12 p-0 d-flex eachwebinfo">
                <div class="form-group" style="margin:0">
                    <?php if ($web['active'] == "1") : ?>
                        <span class="web_stati text-success" id="<?php echo $web['id'] ?>"><i class="fas fa-circle" title="Platform is active"></i></span>
                    <?php endif; ?>
                    <?php if ($web['active'] == "0") : ?>
                        <span class="web_stati text-danger" id="<?php echo $web['id'] ?>"><i class="fas fa-circle" title="Platform is not active"></i></span>
                    <?php endif; ?>
                </div>
                <div class="form-group col pr-0">
                    <label class="webnamelabel" id="webnamelabel"><?php echo $web['web_name'] ?></label>
                    <div class="d-flex">
                        <input type="url" name="weblinkinput" class="form-control weblinkinput" id="weblinkinput" value="<?php echo $web['web_link'] ?>" readonly required style="cursor:not-allowed">
                        <div class="col">
                            <i class="fa fa-reorder viewweb_btn" id="<?php echo $web['id'] ?>" style="color:#294a63"></i>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<!-- view modal -->
<div class="modal edit_web_modal fade" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modalcloseDiv">
                    <h6></h6>
                    <i class="fas fa-times close_editweb_modal text-danger"></i>
                </div>

                <form method='post' id="edit_web_modal_form">
                    <input type="hidden" class="csrf_token" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                    <input type="hidden" class="web_id form-control" name="web_id" value="">

                    <div class="form-group">
                        <label>Platform Name</label>
                        <input type="text" name="web_name_edit" class="web_name_edit form-control" placeholder="Platform Name" required disabled readonly>
                    </div>

                    <div class="form-group">
                        <label>Platform Link</label>
                        <input type="url" name="web_link_edit" class="web_link_edit form-control" placeholder="Platform Link" required disabled readonly>
                    </div>

                    <div class="form-group">
                        <label>Subject</label>
                        <input type="url" name="web_subject_edit" class="web_subject_edit form-control" placeholder="Subject">
                    </div>

                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="web_desc_edit" class="web_desc_edit form-control" cols="30" rows="5"></textarea>
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select name="web_act" id="web_act" class="form-control" required>
                            <option value="1">Active</option>
                            <option value="0">Not Active</option>
                        </select>
                    </div>

                    <hr>
                    <div class="text-right">
                        <button type="button" class="btn text-light submit_editweb_modal" style="background-color:#294a63">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- add new website modal -->
<div class="modal fade add_web_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-top">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modalcloseDiv">
                    <h6></h6>
                    <i class="fas fa-times closewebmodal_btn text-danger"></i>
                </div>

                <form method="post" action="<?php echo base_url("user/user_new_website") ?>" class="add_web_modal_form">
                    <input type="hidden" class="csrf_token" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                    <div class="form-group">
                        <label class="mb-0">Platform Name</label>
                        <input type="text" name="web_name_new" class="web_name_new form-control" placeholder="Platform Name" required>
                        <div class="text-danger mt-0 web_name_err"></div>
                    </div>

                    <div class="form-group">
                        <label class="mb-0">Platform Link</label>
                        <input type="url" name="web_link_new" class="web_link_new form-control" placeholder="e.g https://domainname.com" required>
                        <div class="text-danger mt-0 web_link_err"></div>
                    </div>

                    <div class="form-group">
                        <label>Subject</label>
                        <input type="url" name="web_subject_new" class="web_subject_new form-control" placeholder="Subject">
                    </div>

                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="web_desc_new" class="web_desc_new form-control" cols="30" rows="5"></textarea>
                    </div>

                    <div class="text-right">
                        <button type="submit" class="btn add_web_modal_btn text-light" style="background-color:#294a63;">
                            Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>




<script>
    $(document).ready(function() {

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
                beforeSend: function() {
                    // clearAlert();
                },
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

        // add new website modal
        $(document).on('click', 'button.addwebmodal_btn', function(e) {
            e.preventDefault();

            $('.add_web_modal').modal("show");
        });

        $(document).on('click', '.closewebmodal_btn', function(e) {
            e.preventDefault();

            $('.add_web_modal').modal("hide");

            $(".add_web_modal_btn").removeAttr("disabled readonly").attr("type", "submit").css("cursor", "pointer");

            $(".web_link_err,.web_name_err").fadeOut();
            $('.web_link_new,.web_name_new').css('border', '1px solid #ced4da').removeAttr("readonly").val("");
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
                        $('.web_name_err').html("You already have a platform with this name").show();
                        $(".web_name_new").css('border-bottom', '2px solid #dc3545');
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
                        $('.web_link_err').html("You already have a platform with this Link").show();
                        $(".web_link_new").css('border-bottom', '2px solid #dc3545');
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
            var web_subject_new = $('.web_subject_new').val();
            var web_desc_new = $('.web_desc_new').val();

            if (web_name_new == "" || web_name_new == null || web_name_new == undefined) {
                $('.web_name_new').css('border-bottom', '2px solid #dc3545');
                return false;
            } else {
                $('.web_name_new').css('border', '1px solid #ced4da');
            }
            if (web_link_new == "" || web_link_new == null || web_link_new == undefined) {
                $(".web_link_new").css('border-bottom', '2px solid #dc3545');
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
                $(".web_link_new").css('border-bottom', '2px solid #dc3545');
                $(".web_link_err").html("Invalid WEB URL").fadeIn();
                return false;
            }

            $.ajax({
                url: "<?php echo base_url("create-website") ?>",
                method: "post",
                dataType: "json",
                data: {
                    [csrfName]: csrfHash,
                    web_name_new: web_name_new,
                    web_link_new: web_link_new,
                    web_subject_new: web_subject_new,
                    web_desc_new: web_desc_new
                },
                beforeSend: function() {
                    clearAlert();

                    $('.add_web_modal_btn').addClass('bg-danger').html('Saving...').attr('disabled', 'disabled').css({
                        'cursor': 'not-allowed',
                    });
                },
                success: function(data) {
                    $(".csrf_token").val(data.token);

                    if (data.status === false) {
                        $(".ajax_res_err").text(data.msg);
                        $(".ajax_err_div").fadeIn();
                    } else if (data.status === true) {
                        $(".ajax_res_succ").text(data.msg);
                        $(".ajax_succ_div").fadeIn();

                        $(".noweb").hide();

                        $(".eachwebwrapper").append('<div class="col-md-12 p-0 d-flex eachwebinfo"><div class="form-group" style="margin:0"><span class="web_stati text-success" id="' + data.insert_id + '"><i class="fas fa-circle" title="Platform is active"></i></span></div><div class="form-group col pr-0"><label class="webnamelabel" id="webnamelabel">' + web_name_new + '</label><div class="d-flex"><input type="url" name="weblinkinput" class="form-control weblinkinput" id="weblinkinput" value="' + web_link_new + '" readonly required style="cursor:not-allowed"><div class="col"><i class="fa fa-reorder viewweb_btn" id="' + data.insert_id + '" style="color:#294a63"></i></div></div></div></div>');

                        var webscreated = $('.eachwebinfo').length;
                        var webspaceleftText = $('.webspaceleft').text();

                        $(".webspaceleft").text(parseInt(webspaceleftText) - 1);

                        $('.add_web_modal').modal("hide");
                    } else if (data.status === "error") {
                        window.location.assign(data.redirect);
                    }

                    $(".add_web_modal_btn").removeClass('bg-danger').html('Save').removeAttr("disabled").css("cursor", "pointer");
                }
            })
        });

        // show website details
        $(document).on('click', 'i.viewweb_btn', function() {
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
                beforeSend: function() {
                    clearAlert();
                },
                success: function(data) {
                    if (data.status === false) {
                        $(".ajax_succ_div,.ajax_err_div").hide();
                        $(".ajax_res_err").text(data.msg);
                        $(".ajax_err_div").fadeIn();
                    } else if (data.status === true) {
                        $('.web_name_edit').val(data.act_res.web_name);
                        $('.web_link_edit').val(data.act_res.web_link);
                        $('.web_subject_edit').val(data.act_res.subject);
                        $('.web_desc_edit').val(data.act_res.description);
                        $('select#web_act option[value=' + data.act_res.active + ']').attr('selected', 'selected');
                        $('.edit_web_modal').modal('show');
                        $('.web_id').val(id);
                    } else if (data.status == "error") {
                        window.location.assign(data.redirect);
                    }

                    $('.csrf_token').val(data.token);

                }
            });
        });

        $(document).on('click', '.close_editweb_modal', function(e) {
            e.preventDefault();
            $('.edit_web_modal').modal('hide');
            $('select#web_act option').removeAttr("selected");
        });

        // change website details
        $(document).on('click', '.submit_editweb_modal', function(e) {
            e.preventDefault();
            var csrfName = $('.csrf_token').attr('name');
            var csrfHash = $('.csrf_token').val();
            var id = $(".web_id").val();
            var webstatus = $("#web_act").val();
            var subject = $('.web_subject_edit').val();
            var description = $('.web_desc_edit').val();

            $.ajax({
                url: "<?php echo base_url('update-website'); ?>",
                method: "post",
                data: {
                    [csrfName]: csrfHash,
                    id: id,
                    webstatus: webstatus,
                    subject: subject,
                    description: description
                },
                dataType: 'json',
                beforeSend: function() {
                    clearAlert();

                    $('.submit_editweb_modal').addClass('bg-danger').html('Saving...').attr('disabled', 'disabled').css({
                        'cursor': 'not-allowed',
                    });
                },
                success: function(data) {
                    if (data.status === false) {
                        $(".ajax_res_err").text(data.msg);
                        $(".ajax_err_div").fadeIn();
                    } else if (data.status === true) {
                        $(".ajax_res_succ").text(data.msg);
                        $(".ajax_succ_div").fadeIn();

                        $('.edit_web_modal').modal('hide');

                    } else if (data.status == "error") {
                        window.location.assign(data.redirect);
                    }

                    if (webstatus == 1) {
                        $("span#" + id + "").removeClass("text-danger").addClass("text-success");
                        $("span#" + id + " i").attr('title', 'Platform is active');
                        $("button[attrid='" + id + "']").attr('status', '0').html("Deactivate");
                    } else if (webstatus == 0) {
                        $("span#" + id + "").removeClass("text-success").addClass("text-danger");
                        $("span#" + id + " i").attr('title', 'Platform is not active');
                        $("button[attrid='" + id + "']").attr('status', '1').html("Activate");
                    }

                    $(".submit_editweb_modal").removeClass('bg-danger').html('Save').removeAttr("disabled").css("cursor", "pointer");

                    $('.csrf_token').val(data.token);
                }
            });
        });
    });
</script>