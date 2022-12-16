<div class="wrapperDiv">
    <div class="p-3 bg-light-custom">
        <div class="modal vplanmodal fade" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="modalcloseDiv">
                            <h6></h6>
                            <i class="fas fa-times closevplanbtn text-danger"></i>
                        </div>

                        <form action="<?php echo base_url(''); ?>" method="post" id="planForm">
                            <input type="hidden" class="csrf_token" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                            <div class="form-group">
                                <label>Plan Name</label> <span>*</span>
                                <input type="text" name="name" class="form-control name" value="" required>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Amount</label> <span>*</span>
                                    <input type="text" name="amount" class="form-control amount" value="" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>per</label>
                                    <input type="text" name="per" class="form-control per" placeholder="per month" value="">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>SMS Quota</label> <span>*</span>
                                    <input type="number" name="sms_quota" class="form-control sms_quota" value="" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Email Quota</label> <span>*</span>
                                    <input type="number" name="email_quota" class="form-control email_quota" value="" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Whatsapp Quota</label> <span>*</span>
                                    <input type="number" name="whatsapp_quota" class="form-control whatsapp_quota" value="" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Web Quota</label> <span>*</span>
                                    <input type="number" name="web_quota" class="form-control web_quota" value="" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Order</label>
                                <input type="number" name="orderBy" class="form-control orderBy">
                            </div>

                            <div class="form-group">
                                <label>Active</label>
                                <select name="active" class="form-control active" required>
                                    <option value="">Select</option>
                                    <option value="0">0</option>
                                    <option value="1">1</option>
                                </select>
                            </div>

                            <hr>
                            <div class="form-group text-right">
                                <button class="btn text-light save_plan_btn" type="submit" planid="" style="background-color:#294a63">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal aplanmodal fade" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="modalcloseDiv">
                            <h6></h6>
                            <i class="fas fa-times closeaplanbtn text-danger"></i>
                        </div>

                        <form action="<?php echo base_url(''); ?>" method="post" id="addplanForm">
                            <input type="hidden" class="csrf_token" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                            <div class="form-group">
                                <label>Plan Name</label> <span>*</span>
                                <input type="text" name="add_name" class="form-control add_name" value="" required>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Amount</label> <span>*</span>
                                    <input type="text" name="add_amount" class="form-control add_amount" value="" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>per</label>
                                    <input type="text" name="add_per" class="form-control add_per" placeholder="per month" value="">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>SMS Quota</label> <span>*</span>
                                    <input type="number" name="add_sms_quota" class="form-control add_sms_quota" value="" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Email Quota</label> <span>*</span>
                                    <input type="number" name="add_email_quota" class="form-control add_email_quota" value="" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Whatsapp Quota</label> <span>*</span>
                                    <input type="number" name="add_whatsapp_quota" class="form-control add_whatsapp_quota" value="" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Web Quota</label> <span>*</span>
                                    <input type="number" name="add_web_quota" class="form-control add_web_quota" value="" required>
                                </div>
                            </div>


                            <div class="form-group">
                                <label>Order</label>
                                <input type="number" name="add_orderBy" class="form-control add_orderBy">
                            </div>
                            <div class="form-group">
                                <label>Active</label>
                                <select name="add_active" class="form-control add_active" required>
                                    <option value="">Select</option>
                                    <option value="0">0</option>
                                    <option value="1">1</option>
                                </select>
                            </div>

                            <hr>
                            <div class="form-group text-right">
                                <button class="btn text-light add_plan_btn" type="submit" style="background-color:#294a63">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex pb-4" style="justify-content:space-between;">
            <div style="font-weight: bold;text-transform: uppercase;color:#294a63">
            </div>
            <div>
                <a href="" title="New Plan" class="btn text-light aplanbtn" style="background:#294a63;">
                    <i class="fas fa-plus pr-2"></i>New Plan
                </a>
            </div>
        </div>

        <!-- table -->
        <table id="planstable" data-toggle="table" data-search="true" data-show-export="true" data-buttons-prefix="btn-md btn" data-buttons-align="right" data-pagination="true">
            <thead class="text-light" style="background:#294a63">
                <tr>
                    <th data-field="name" data-sortable="true">Name</th>
                    <th data-field="action" scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($plans->result_array() as $p) : ?>
                    <tr>
                        <td><?php echo $p['name'] ?></td>
                        <td class="w-25">
                            <a href="">
                                <i class="fa fa-reorder editPlanI" title="Show" id="<?php echo $p['id'] ?>"></i>
                            </a>
                            <?php if ($p['active'] == '1') : ?>
                                <span class="text-success"> Active</span>
                            <?php endif; ?>
                            <?php if ($p['active'] == '0') : ?>
                                <span class="text-danger"> Not Active</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>




<style>
    .wrapperDiv {
        padding: 14px;
    }

    .editPlanI {
        color: #294a63;
    }

    td span {
        font-weight: 500;
    }
</style>

<script>
    var csrfName = $('.csrf_token').attr('name');
    var csrfHash = $('.csrf_token').val();

    $(document).ready(function() {
        //close view plan modal
        $(document).on('click', '.closevplanbtn', function(e) {
            e.preventDefault();

            $(".vplanmodal").modal("hide");
        });

        //view and get plan details
        $(document).on('click', 'i.editPlanI', function(e) {
            e.preventDefault();

            var planid = $(this).attr("id");

            if (planid == '' || planid == undefined) {
                window.location.reload();
            } else {
                $.ajax({
                    url: "<?php echo base_url("get-plan"); ?>",
                    method: "post",
                    dataType: "json",
                    data: {
                        [csrfName]: csrfHash,
                        planid: planid
                    },
                    beforeSend: function(res) {
                        clearAlert();
                    },
                    success: function(res) {
                        if (res.status === 'error') {
                            window.location.assign(res.redirect);
                        } else if (res.status === false) {
                            $(".ajax_res_err").append(res.msg);
                            $(".ajax_err_div").fadeIn();
                        } else if (res.status === true) {
                            $('.name').val(res.details.name);
                            $('.amount').val(res.details.amount);
                            $('.per').val(res.details.per);
                            $('.sms_quota').val(res.details.sms_quota);
                            $('.email_quota').val(res.details.email_quota);
                            $('.whatsapp_quota').val(res.details.whatsapp_quota);
                            $('.web_quota').val(res.details.web_quota);
                            $('.orderBy').val(res.details.orderBy);
                            $('.active').val(res.details.active);
                            $('.save_plan_btn').attr('planid', res.details.id);


                            $(".vplanmodal").modal("show");
                        }

                        $('.csrf-token').val(res.token);
                    },
                    error: function(res) {
                        var con = confirm('Some error occured. Refresh?');
                        if (con === true) {
                            window.location.reload();
                        } else if (con === false) {
                            return false;
                        }
                    },
                });
            }
        });

        //update plan
        $('form#planForm').submit(function(e) {
            e.preventDefault();

            var planid = $('.save_plan_btn').attr("planid");
            var name = $('.name').val();
            var amount = $('.amount').val();
            var per = $('.per').val();
            var sms_quota = $('.sms_quota').val();
            var email_quota = $('.email_quota').val();
            var whatsapp_quota = $('.whatsapp_quota').val();
            var web_quota = $('.web_quota').val();
            var orderBy = $('.orderBy').val();
            var active = $('.active').val();

            if (email_quota == "" || email_quota == null || sms_quota == "" || sms_quota == null || whatsapp_quota == "" || whatsapp_quota == null || web_quota == "" || web_quota == null) {
                return false;
            } else {
                $.ajax({
                    url: "<?php echo base_url("update-plan"); ?>",
                    method: "post",
                    dataType: "json",
                    data: {
                        [csrfName]: csrfHash,
                        planid: planid,
                        name: name,
                        amount: amount,
                        per: per,
                        sms_quota: sms_quota,
                        email_quota: email_quota,
                        whatsapp_quota: whatsapp_quota,
                        web_quota: web_quota,
                        orderBy: orderBy,
                        active: active
                    },
                    beforeSend: function(res) {
                        clearAlert();

                        $('.save_plan_btn').addClass('bg-danger').html('Saving...').attr('disabled', 'disabled').css('cursor', 'not-allowed');
                    },
                    success: function(res) {
                        if (res.status === 'error') {
                            window.location.assign(res.redirect);
                        } else if (res.status === false) {
                            $(".ajax_res_err").append(res.msg);
                            $(".ajax_err_div").fadeIn();
                        } else if (res.status === true) {
                            $(".ajax_res_succ").append(res.msg);
                            $(".ajax_succ_div").fadeIn();

                            // $(".vplanmodal").modal("hide");
                            window.location.reload();
                        }

                        $('.save_plan_btn').removeClass('bg-danger').html('Save').removeAttr('disabled').css('cursor', 'pointer');
                        $('.csrf-token').val(res.token);
                    },
                    error: function(res) {
                        var con = confirm('Some error occured. Refresh?');
                        if (con === true) {
                            window.location.reload();
                        } else if (con === false) {
                            return false;
                        }
                    },
                });
            }
        });

        //open add plan modal
        $(document).on('click', '.aplanbtn', function(e) {
            e.preventDefault();

            $(".aplanmodal").modal("show");
        });

        //close add plan modal
        $(document).on('click', '.closeaplanbtn', function(e) {
            e.preventDefault();

            $(".aplanmodal").modal("hide");
        });

        //add new plan
        $('form#addplanForm').submit(function(e) {
            e.preventDefault();

            var name = $('.add_name').val();
            var amount = $('.add_amount').val();
            var per = $('.add_per').val();
            var sms_quota = $('.add_sms_quota').val();
            var email_quota = $('.add_email_quota').val();
            var whatsapp_quota = $('.add_whatsapp_quota').val();
            var web_quota = $('.add_web_quota').val();
            var orderBy = $('.add_orderBy').val();
            var active = $('.add_active').val();

            if (email_quota == "" || email_quota == null || sms_quota == "" || sms_quota == null || whatsapp_quota == "" || whatsapp_quota == null || web_quota == "" || web_quota == null) {
                return false;
            } else {
                $.ajax({
                    url: "<?php echo base_url("add-plan"); ?>",
                    method: "post",
                    dataType: "json",
                    data: {
                        [csrfName]: csrfHash,
                        name: name,
                        amount: amount,
                        per: per,
                        sms_quota: sms_quota,
                        email_quota: email_quota,
                        whatsapp_quota: whatsapp_quota,
                        web_quota: web_quota,
                        orderBy: orderBy,
                        active: active
                    },
                    beforeSend: function(res) {
                        clearAlert();

                        $('.add_plan_btn').addClass('bg-danger').html('Saving...').attr('disabled', 'disabled').css('cursor', 'not-allowed');
                    },
                    success: function(res) {
                        if (res.status === 'error') {
                            window.location.assign(res.redirect);
                        } else if (res.status === false) {
                            $(".ajax_res_err").append(res.msg);
                            $(".ajax_err_div").fadeIn();
                        } else if (res.status === true) {
                            $(".ajax_res_succ").append(res.msg);
                            $(".ajax_succ_div").fadeIn();

                            $(".aplanmodal").modal("hide");
                            window.location.reload();
                        }

                        $('.add_plan_btn').removeClass('bg-danger').html('Save').removeAttr('disabled').css('cursor', 'pointer');
                        $('.csrf-token').val(res.token);
                    },
                    error: function(res) {
                        var con = confirm('Some error occured. Refresh?');
                        if (con === true) {
                            window.location.reload();
                        } else if (con === false) {
                            return false;
                        }
                    },
                });
            }
        });
    });
</script>