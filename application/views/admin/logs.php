<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/logs.css'); ?>">
<input type="hidden" class="csrf_token" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

<div class="log_wrapper">

    <!-- tabLinks -->
    <div class="tab_div bg-light-custom">
        <a href="#activity" class="tab_link" id="actLogs" tabFormName="actLogs">Activity Logs</a>
        <a href="#feedback" class="tab_link" id="feedbkLogs" tabFormName="feedbkLogs">Feedback Logs</a>
        <a href="#payments" class="tab_link" id="paymentLogs" tabFormName="paymentLogs">Payment Logs</a>
    </div>
    <!--  -->

    <!-- tabs-->
    <div class="info_div bg-light-custom actLogs_outer">
        <div class="actLogs p-3" id="actLogs">
            <?php if ($logs->num_rows() > 0) : ?>
                <div class="text-left">
                    <a href="<?php echo base_url('clear-activity-logs'); ?>" class="btn btn-danger clearlogs">
                        <i class="fas fa-trash-alt mr-2"></i>Clear Data
                    </a>
                </div>
            <?php endif; ?>

            <table id="logstable" data-toggle="table" data-search="true" data-show-export="true" data-buttons-prefix="btn-md btn" data-buttons-align="right" data-pagination="true">
                <thead class="text-light" style="background:#294a63">
                    <tr>
                        <th data-field="activity" data-sortable="true">Activity</th>
                        <th data-field="date" data-sortable="true">Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($logs->result() as $log) : ?>
                        <tr>
                            <td><?php echo $log->msg ?></td>
                            <td class="date"><?php echo $log->act_time ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="info_div bg-light-custom feedbkLogs_outer" style="display:none">
        <div class="feedbkLogs p-3" id="feedbkLogs">
            <?php if ($feedbacks->num_rows() > 0) : ?>
                <div class="text-left">
                    <a href="<?php echo base_url('clear-feedbacks'); ?>" class="btn btn-danger clear_feedbacks">
                        <i class="fas fa-trash-alt mr-2"></i>Clear Data
                    </a>
                </div>
            <?php endif; ?>

            <table id="feedbackstable" data-toggle="table" data-search="true" data-show-export="true" data-buttons-prefix="btn-md btn" data-buttons-align="right" data-pagination="true">
                <thead class="text-light" style="background:#294a63">
                    <tr>
                        <th data-field="name" data-sortable="true">Name</th>
                        <th data-field="mail" data-sortable="true">E-mail</th>
                        <th data-field="msg" data-sortable="true">Message</th>
                        <th data-field="date" data-sortable="true">Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($feedbacks->result_array() as $msg) : ?>
                        <tr>
                            <td><?php echo $msg['name'] ?></td>
                            <td><a href="mailto:<?php echo $msg['user_mail'] ?>"><?php echo $msg['user_mail'] ?></a></td>
                            <td><?php echo $msg['bdy'] ?></td>
                            <td class="date"><?php echo $msg['date'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="info_div bg-light-custom paymentLogs_outer" style="display:none">
        <div class="paymentLogs p-3" id="paymentLogs">

            <div class="modal vpaymodal fade" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="modalcloseDiv">
                                <h6>Paid on <span class="text-danger tran_date"></span></h6>
                                <i class="fas fa-times closevpaybtn text-danger"></i>
                            </div>

                            <form action="<?php echo base_url(''); ?>" method="post" id="payForm">
                                <input type="hidden" class="csrf_token" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>Payee Name</label>
                                        <input type="text" name="uname" class="form-control uname" value="">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Payee Email</label>
                                        <input type="email" name="email" class="form-control email" value="">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Payee Mobile</label>
                                        <input type="text" name="mobile" class="form-control mobile" value="">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>Payment ID</label>
                                        <input type="text" name="pay_id" class="form-control pay_id" value="">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Order ID</label>
                                        <input type="text" name="order_id" class="form-control order_id" value="">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Transaction ID</label>
                                        <input type="text" name="tran_id" class="form-control tran_id" value="">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>Currency</label>
                                        <input type="text" name="currency" class="form-control currency" value="">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Amount</label>
                                        <input type="text" name="amount" class="form-control amount" value="">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>Status</label>
                                        <input type="text" name="status" class="form-control status" value="">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Captured</label>
                                        <input type="text" name="captured" class="form-control captured" value="">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Entity</label>
                                        <input type="text" name="entity" class="form-control entity" value="">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Mode Of Payment</label>
                                    <input type="text" name="mop" class="form-control mop" value="">
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label>Card ID</label>
                                        <input type="text" name="card_id" class="form-control card_id" value="">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Bank</label>
                                        <input type="text" name="bank" class="form-control bank" value="">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Wallet</label>
                                        <input type="text" name="wallet" class="form-control wallet" value="">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>UPI ID</label>
                                        <input type="text" name="upi_id" class="form-control upi_id" value="">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea name="desc" cols="30" rows="5" class="form-control desc"></textarea>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <table id="transactionstable" data-toggle="table" data-search="true" data-show-export="true" data-buttons-prefix="btn-md btn" data-buttons-align="right" data-pagination="true">
                <thead class="text-light" style="background:#294a63">
                    <tr>
                        <th data-field="uname" data-sortable="true">User</th>
                        <th data-field="payment_id" data-sortable="true">Payment ID</th>
                        <th data-field="date" data-sortable="true">Date</th>
                        <th data-field="action">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($transactions as $pay) : ?>
                        <tr>
                            <td><?php echo $pay['uname'] ?></td>
                            <td class="w-25"><?php echo $pay['payment_id'] ?></td>
                            <td class="w-25"><?php echo date('d M Y, h:i:s a', $pay['date']) ?></td>
                            <td class="w-25">
                                <div>
                                    <a href="">
                                        <i class="fa fa-reorder showPaymentI" title="Show" id="<?php echo $pay['payment_id'] ?>" data-formkey="<?php echo $pay['form_key'] ?>" data-userid="<?php echo $pay['user_id'] ?>" data-date="<?php echo date('d M Y, h:i:s a', $pay['date']) ?>"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>





<script type="text/javascript" src="<?php echo base_url('assets/js/logs.js'); ?>"></script>
<script>
    var csrfName = $('.csrf_token').attr('name');
    var csrfHash = $('.csrf_token').val();

    $(document).ready(function() {
        $(document).on('click', '.clearlogs', function(e) {
            e.preventDefault();

            var con = confirm("Are you sure you want to clear this data?");
            if (con === false) {
                return false;
            } else {
                var linkurl = $(this).attr('href');
                window.location.assign(linkurl);
            }
        });

        $(document).on('click', '.clear_feedbacks', function(e) {
            e.preventDefault();

            var con = confirm("Are you sure you want to clear this data?");
            if (con === false) {
                return false;
            } else {
                var linkurl = $(this).attr('href');
                window.location.assign(linkurl);
            }
        });

        //close view payment modal
        $(document).on('click', '.closevpaybtn', function(e) {
            e.preventDefault();

            $(".vpaymodal").modal("hide");
        });

        //view and get payment details
        $(document).on('click', 'i.showPaymentI', function(e) {
            e.preventDefault();

            var payID = $(this).attr("id");
            var formkey = $(this).attr("data-formkey");
            var userid = $(this).attr("data-userid");
            var dataDate = $(this).attr("data-date");

            if (payID == '' || payID == undefined) {
                window.location.reload();
            } else {
                $.ajax({
                    url: "<?php echo base_url("get-payment-details"); ?>",
                    method: "post",
                    dataType: "json",
                    data: {
                        [csrfName]: csrfHash,
                        payID: payID,
                        formkey: formkey,
                        userid: userid
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
                            $('.amount').val(res.details.amount);
                            $('.bank').val(res.details.bank);
                            $('.captured').val(res.details.captured);
                            $('.card_id').val(res.details.card_id);
                            $('.currency').val(res.details.currency);
                            // $('span.tran_date').text(res.details.date);
                            $('span.tran_date').text(dataDate);
                            $('.desc').val(res.details.description);
                            $('.email').val(res.details.email);
                            $('.entity').val(res.details.entity);
                            $('.mobile').val(res.details.mobile);
                            $('.mop').val(res.details.mop);
                            $('.order_id').val(res.details.order_id);
                            $('.pay_id').val(res.details.payment_id);
                            // $('.rrn').val(res.details.rrn);
                            $('.status').val(res.details.status);
                            $('.tran_id').val(res.details.transaction_id);
                            $('.uname').val(res.details.uname);
                            $('.upi_id').val(res.details.vpa);
                            $('.wallet').val(res.details.wallet);


                            $(".vpaymodal").modal("show");
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
    });
</script>