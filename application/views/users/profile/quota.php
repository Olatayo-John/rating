<div class="text-right mb-5 doc">
    Documentation <i class="fas fa-hands-helping"></i>
</div>

<?php if ($this->session->userdata("mr_admin") === "1") : ?>
    <p style="color:#a71d2a" class="pl-3 pb-4">
        Except <strong style="color:#294a63">Userspace,</strong> all other services applies to you & all users under <a href="<?php echo base_url('users') ?>" style="color:#294a63;font-weight:bold;"><?php echo $this->session->userdata("mr_cmpy"); ?></a>
    </p>
<?php endif; ?>
<div class="row col-md-12 m-0 p-0 pb-5">
    <div class="col-lg-4 col-xs-12 col-md-12 total-column">
        <div class="panel_s">
            <div class="panel-body">
                <h3 class="_total"><?php echo $quota->bought ?></h3>
                <span class="text-success">Quota Bought</span>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-xs-12 col-md-12 total-column">
        <div class="panel_s">
            <div class="panel-body">
                <h3 class="_total"><?php echo $quota->bal ?></h3>
                <span>Balance</span>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-xs-12 col-md-12 total-column">
        <div class="panel_s">
            <div class="panel-body">
                <h3 class="_total"><?php echo $quota->used ?></h3>
                <span style="color:#a71d2a">Used</span>
            </div>
        </div>
    </div>
</div>


<div class="row col-md-12 m-0 p-0 pb-5">
    <div class="col-lg-4 col-xs-4 col-md-4 total-column">
        <div class="panel_s">
            <div class="panel-body">
                <h3 class="_total">
                    <?php echo $quota->webspace ?>
                </h3>
                <span>Webspace</span>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-xs-4 col-md-4 total-column">
        <div class="panel_s">
            <div class="panel-body">
                <h3 class="_total" style="<?php echo ($quota->webspace_left == "0") ? "opacity: .5;" : "" ?>">
                    <?php echo $quota->webspace_left ?>
                </h3>
                <span>Left</span>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-xs-4 col-md-4 total-column">
        <div class="panel_s">
            <div class="panel-body">
                <h3 class="_total">
                    <?php echo ($quota->webspace - $quota->webspace_left) ?>
                </h3>
                <span style="color:#a71d2a">Used</span>
            </div>
        </div>
    </div>
</div>

<?php if ($this->session->userdata("mr_admin") === "1") : ?>
    <div class="row col-md-12 m-0 p-0 pb-5">
        <div class="col-lg-4 col-xs-4 col-md-4 total-column">
            <div class="panel_s">
                <div class="panel-body">
                    <h3 class="_total">
                        <?php echo $quota->userspace ?>
                    </h3>
                    <span>Userspace</span>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-xs-4 col-md-4 total-column">
            <div class="panel_s">
                <div class="panel-body">
                    <h3 class="_total" style="<?php echo ($quota->userspace_left == "0") ? "opacity: .5;" : "" ?>">
                        <?php echo $quota->userspace_left ?>
                    </h3>
                    <span>Left</span>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-xs-4 col-md-4 total-column">
            <div class="panel_s">
                <div class="panel-body">
                    <h3 class="_total">
                        <?php echo ($quota->userspace - $quota->userspace_left) ?>
                    </h3>
                    <span style="color:#a71d2a">Used</span>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

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
                <label for="Bought" class="font-weight-bolder">Bought</label>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quia ratione dolorum velit blanditiis, ad aspernatur, accusantium explicabo maxime adipisci soluta ea perferendis maiores laborum consectetur ex. Ab minus ex eaque non tempora dicta odit dignissimos fugit harum eos magnam dolor vel, nostrum, quis quibusdam autem.</p>

                <label for="Balance" class="font-weight-bolder">Balance</label>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quia ratione dolorum velit blanditiis, ad aspernatur, accusantium explicabo maxime adipisci soluta ea perferendis maiores laborum consectetur ex.</p>

                <label for="Used" class="font-weight-bolder">Used</label>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quia ratione dolorum velit blanditiis, ad aspernatur, accusantium explicabo maxime adipisci soluta ea perferendis maiores laborum consectetur ex.</p>

                <label for="Webspace" class="font-weight-bolder">Webspace</label>
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