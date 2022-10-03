<div class="text-right mb-5 doc">
    Documentation <i class="fas fa-hands-helping"></i>
</div>


<div class="row col-md-12 m-0 p-0 pb-5">
    <div class="col-lg-4 col-xs-12 col-md-12 total-column">
        <div class="panel_s">
            <div class="panel-body">
                <h3 class="_total"><?php echo $quota->sms_quota ?></h3>
                <span class="text-success">SMS Quota</span>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-xs-12 col-md-12 total-column">
        <div class="panel_s">
            <div class="panel-body">
                <h3 class="_total"><?php echo $quota->email_quota ?></h3>
                <span class="text-success">Email Quota</span>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-xs-12 col-md-12 total-column">
        <div class="panel_s">
            <div class="panel-body">
                <h3 class="_total"><?php echo $quota->whatsapp_quota ?></h3>
                <span class="text-success">WhatsApp Quota</span>
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
                <span class="text-success">Web Quota</span>
            </div>
        </div>
    </div>
</div>



<div class="p-3">
    <?php if ($this->session->userdata("mr_sub") === "0") : ?>
        <div class="font-weight-bold" style="margin:auto 0;color:#294a63">
            Payment Pending!!!
        </div>
        <button class="btn btn-danger">
            <a href="pay#">Pay Now</a>
        </button>
    <?php elseif ($this->session->userdata("mr_sub") === "1") : ?>
        <button class="btn btn-success" type="button">
            <i class="fas fa-check-circle pr-1"></i>Payment Done
        </button>
    <?php endif; ?>
</div>




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
    });
</script>