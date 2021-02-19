<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/pay_stat.css'); ?>">

<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" class="csrf_token form-control">

<div class="container-fluid mt-3 pl-4 pr-4">
    <?php if ($userData['status'] == 'TXN_FAILURE') : ?>
        <div class="row mb-5">
            <div class="pay_stat col-md-7" style="padding-left: 55px;padding-right: 55px;">
                <h4 class="text-center text-danger">Payment Failed</h4>
                <div class="form-group">
                    <label>STATUS</label>
                    <input type="text" name="STATUS" value="<?php echo $userData['status'] ?>" class="form-control" readonly>
                </div>
                <div class="row form-group">
                    <div class="col-md-6">
                        <label>MERCHANT ID</label>
                        <input type="text" name="MERCHANT ID" value="<?php echo $userData['m_id'] ?>" class="form-control" readonly>
                    </div>
                    <div class="col-md-6 second">
                        <label>TRANSACTION ID</label>
                        <input type="text" name="TRANSACTION ID" value="<?php echo $userData['txn_id'] ?>" class="form-control" readonly>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-6">
                        <label>ORDER ID</label>
                        <input type="text" name="ORDER ID" value="<?php echo $userData['order_id'] ?>" class="form-control" readonly>
                    </div>
                    <div class="col-md-6 second">
                        <label>BANK TRANSACTION ID</label>
                        <input type="text" name="BANK TRANSACTION ID" value="<?php echo $userData['bank_txn_id'] ?>" class="form-control" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label>BANK</label>
                    <input type="text" name="BANK" value="<?php echo $userData['bank_name'] ?>" class="form-control" readonly>
                </div>
                <div class="row form-group">
                    <div class="col-md-6">
                        <label>PAYMENT MODE</label>
                        <input type="text" name="PAYMENT MODE" value="<?php echo $userData['payment_mode'] ?>" class="form-control" readonly>
                    </div>
                    <div class="col-md-6 second">
                        <label>GATEWAY NAME</label>
                        <input type="text" name="GATEWAY NAME" value="<?php echo $userData['gateway_name'] ?>" class="form-control" readonly>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-6">
                        <label>AMOUNT PAID</label>
                        <input type="text" name="AMOUNT PAID" value="<?php echo $userData['paid_amt'] ?>" class="form-control" readonly>
                    </div>
                    <div class="col-md-6 second">
                        <label>CURRENCY</label>
                        <input type="text" name="CURRENCY" value="<?php echo $userData['currency'] ?>" class="form-control" readonly>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="btnlinkgrp">
                    <h4 class="text-center text-light mb-3">Links</h4>
                    <a href="<?php echo base_url('admin/pick_plan'); ?>" class="btn btn-dark">Select another Plan</a><br>
                    <a href="<?php echo base_url('user/account'); ?>" class="btn btn-dark mt-3 mr-3">My account</a>
                    <a href="<?php echo base_url('user/rating'); ?>" class="btn btn-dark mt-3">Send Link</a>
                    <a href="<?php echo base_url('user/support'); ?>" class="btn btn-dark mt-3">Support</a>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($userData['status'] == 'TXN_SUCCESS') : ?>
        <div class="row mb-5">
            <div class="pay_stat col-md-7" style="padding-left: 55px;padding-right: 55px;">
                <h4 class="text-center text-success">Payment Successfull</h4>
                <div class="form-group">
                    <label>STATUS</label>
                    <input type="text" name="STATUS" value="<?php echo $userData['status'] ?>" class="form-control" readonly>
                </div>
                <div class="row form-group">
                    <div class="col-md-6">
                        <label>MERCHANT ID</label>
                        <input type="text" name="MERCHANT ID" value="<?php echo $userData['m_id'] ?>" class="form-control" readonly>
                    </div>
                    <div class="col-md-6 second">
                        <label>TRANSACTION ID</label>
                        <input type="text" name="TRANSACTION ID" value="<?php echo $userData['txn_id'] ?>" class="form-control" readonly>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-6">
                        <label>ORDER ID</label>
                        <input type="text" name="ORDER ID" value="<?php echo $userData['order_id'] ?>" class="form-control" readonly>
                    </div>
                    <div class="col-md-6 second">
                        <label>BANK TRANSACTION ID</label>
                        <input type="text" name="BANK TRANSACTION ID" value="<?php echo $userData['bank_txn_id'] ?>" class="form-control" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label>BANK</label>
                    <input type="text" name="BANK" value="<?php echo $userData['bank_name'] ?>" class="form-control" readonly>
                </div>
                <div class="row form-group">
                    <div class="col-md-6">
                        <label>PAYMENT MODE</label>
                        <input type="text" name="PAYMENT MODE" value="<?php echo $userData['payment_mode'] ?>" class="form-control" readonly>
                    </div>
                    <div class="col-md-6 second">
                        <label>GATEWAY NAME</label>
                        <input type="text" name="GATEWAY NAME" value="<?php echo $userData['gateway_name'] ?>" class="form-control" readonly>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-6">
                        <label>AMOUNT PAID</label>
                        <input type="text" name="AMOUNT PAID" value="<?php echo $userData['paid_amt'] ?>" class="form-control" readonly>
                    </div>
                    <div class="col-md-6 second">
                        <label>CURRENCY</label>
                        <input type="text" name="CURRENCY" value="<?php echo $userData['currency'] ?>" class="form-control" readonly>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="btnlinkgrp">
                    <h4 class="text-center text-light mb-3">Links</h4>
                    <a href="<?php echo base_url('admin/pick_plan'); ?>" class="btn btn-dark">Get New Plan</a><br>
                    <a href="<?php echo base_url('user/account'); ?>" class="btn btn-dark mt-3 mr-3">My account</a>
                    <a href="<?php echo base_url('user/rating'); ?>" class="btn btn-dark mt-3">Send Link</a>
                    <a href="<?php echo base_url('user/support'); ?>" class="btn btn-dark mt-3">Support</a>
                </div>
            </div>
        </div>
    <?php endif; ?>

</div>