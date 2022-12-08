<div class="bg-light-custom p-3">

    <!-- doc modal -->
    <div class="modal helpmodal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <label for="Bought" class="font-weight-bolder">SMS Quota</label>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quia ratione dolorum velit blanditiis, ad aspernatur, accusantium explicabo maxime adipisci soluta ea perferendis maiores laborum consectetur ex. Ab minus ex eaque non tempora dicta odit dignissimos fugit harum eos magnam dolor vel, nostrum, quis quibusdam autem.</p>

                    <label for="Balance" class="font-weight-bolder">Email Quota</label>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quia ratione dolorum velit blanditiis, ad aspernatur, accusantium explicabo maxime adipisci soluta ea perferendis maiores laborum consectetur ex.</p>

                    <label for="Used" class="font-weight-bolder">WhatsApp Quota</label>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quia ratione dolorum velit blanditiis, ad aspernatur, accusantium explicabo maxime adipisci soluta ea perferendis maiores laborum consectetur ex.</p>

                    <label for="Webspace" class="font-weight-bolder">Web Quota</label>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quia ratione dolorum velit blanditiis, ad aspernatur, accusantium explicabo maxime adipisci soluta ea perferendis maiores laborum consectetur ex. Ab minus ex eaque non tempora dicta odit dignissimos fugit harum eos magnam dolor vel, nostrum, quis quibusdam autem.</p>

                    <?php if ($this->session->userdata("mr_admin") === "1") : ?>
                        <label for="Userspace" class="font-weight-bolder">Userspace</label>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quia ratione dolorum velit blanditiis, ad aspernatur, accusantium explicabo maxime adipisci soluta ea perferendis maiores laborum consectetur ex.</p>
                    <?php endif; ?>
                </div>
                <div class="modal-footer text-right">
                    <button type="button" class="btn btn-secondary close_helpmodal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="text-right doc">
        <!-- Documentation <i class="fas fa-hands-helping"></i> -->
    </div>


    <div class="row col-md-12 m-0 p-0 pb-5">
        <div class="col-lg-4 col-xs-12 col-md-12 total-column">
            <div class="panel_s">
                <div class="panel-body">
                    <h3 class="_total"><?php echo $quota->sms_quota ?></h3>
                    <span class="text-primary">SMS Quota</span>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-xs-12 col-md-12 total-column">
            <div class="panel_s">
                <div class="panel-body">
                    <h3 class="_total"><?php echo $quota->email_quota ?></h3>
                    <span class="text-primary">Email Quota</span>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-xs-12 col-md-12 total-column">
            <div class="panel_s">
                <div class="panel-body">
                    <h3 class="_total"><?php echo $quota->whatsapp_quota ?></h3>
                    <span class="text-primary">WhatsApp Quota</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row col-md-12 m-0 p-0 pb-5">
        <div class="col-lg-4 col-xs-4 col-md-4 total-column">
            <div class="panel_s">
                <div class="panel-body">
                    <h3 class="_total">
                        <?php echo $quota->web_quota ?>
                    </h3>
                    <span class="text-primary">Web Quota</span>
                </div>
            </div>
        </div>
    </div>

    <?php if ($this->session->userdata("mr_iscmpy") === "1") : ?>
        <div class="text-right user_cmpy">
            <p>Quota is shared by all users under <span class="company"><?php echo $user_info->cmpy; ?></span></p>
        </div>
    <?php endif; ?>
</div>

<div class="bg-light-custom p-3 mt-3">
    <p><strong>Amount: Rs </strong><?php echo $quota->amount ?></p>
    <p><strong>Due Amount: Rs </strong><?php echo $quota->balance ?></p>

    <!-- hide from compnay user -->
    <?php if ($this->session->userdata("mr_cmpyid") === null) : ?>
        <div class="pendDiv text-right">

            <!-- check again if pending balance is there -->
            <?php if ($quota->balance !== '0' && $quota->balance !== null) : ?>

                <!-- generated order from razorpay -->
                <?php if ($error === false) : ?>

                    <form action="<?php echo base_url('payment-response') ?>" method="POST">

                        <input type="hidden" class="csrf_token" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                        <script src="https://checkout.razorpay.com/v1/checkout.js" data-key="<?php echo $key_id; ?>" data-amount="<?php echo $order->amount ?>" data-currency="INR" data-order_id="<?php echo $order->id ?>" data-buttontext="Pay Now" data-name="NKTECH" data-description="Review Plan Payment" data-image="<?php echo base_url('assets/images/').$this->st->site_fav_icon ?>" data-prefill.name="<?php echo $user_info->uname ?>" data-prefill.email="<?php echo $user_info->email ?>" data-prefill.contact="+91<?php echo $user_info->mobile ?>" data-theme.color="#294a63">
                        </script>

                        <input type="hidden" custom="Hidden Element" name="hidden">
                    </form>
                <?php endif; ?>

                <!-- failed to generate order from razorpay -->
                <?php if ($error === true) : ?>
                    <h6><?php echo $error_msg ?></h6>
                <?php endif; ?>

            <?php endif; ?>

        </div>
    <?php endif; ?>
</div>



<style>
    div.pendDiv {
        /* font-weight: 500; */
    }

    div.pendDiv h4 {
        font-weight: 500;
    }
    p strong{
		color: #294a63;
	}
</style>
<script>
    $(document).ready(function() {
        $(document).on('click', '.doc', function(e) {
            e.preventDefault();
            $('.helpmodal').modal("show");
        });

        $(document).on('click', 'button.close_helpmodal', function(e) {
            e.preventDefault();
            $('.helpmodal').modal("hide");
        });

        $(".razorpay-payment-button").css({
            'color': '#fff',
            'background': '#dc3545',
            'border-radius': '0'
        }).addClass('btn');

    });
</script>