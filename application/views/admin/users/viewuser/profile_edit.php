<h4 class="text-dark">Personal Information</h4>
<hr class="p_i">
<form action="<?php echo base_url('profile-edit'); ?>" method="post">
    <input type="hidden" class="csrf_token" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
    <div class="row">
        <div class="form-group col-md-6">
            <label>First Name</label>
            <input type="text" name="fname" class="form-control fname" placeholder="First Name">
        </div>
        <div class="form-group col-md-6">
            <label>Last Name</label>
            <input type="text" name="lname" class="form-control lname" placeholder="Last Name">
        </div>
    </div>
    <div class="form-group">
        <label><span class="text-danger">* </span>Email</label>
        <input type="email" name="email" class="form-control email" placeholder="example@domain-name.com" required>
    </div>
    <div class="form-group">
        <label><span class="text-danger">* </span>Mobile</label>
        <input type="number" name="mobile" class="form-control mobile" placeholder="0123456789" required>
        <div class="text-danger font-weight-bolder mobileerr" style="display: none;">Invalid mobile length</div>
    </div>
    <div class="row">
        <div class="form-group col-md-6">
            <label>Username</label>
            <input type="text" name="uname" class="form-control uname" readonly disabled required disabled style="cursor: not-allowed;">
        </div>
        <?php if ($this->session->userdata('mr_admin') === "1") : ?>
            <div class="form-group col-md-6">
                <label>Company</label>
                <input type="text" name="cmpy" class="form-control cmpy" readonly disabled required disabled style="cursor: not-allowed;">
            </div>
        <?php endif; ?>
    </div>
    <div class="form-group">
        <div class="d-flex" style="justify-content:space-between">
            <label>User Link<i class="fas fa-copy ml-2 copy_i" style="cursor:pointer" onclick="copylink_fun('#linkshare')"></i></label>
            <div class="linkcopyalert font-weight-bolder" style="display:none;color:#294a63">Copied to your clipboard</div>
        </div>
        <input type="text" name="linkshare" class="form-control linkshare" id='linkshare' data-host="<?php echo base_url("wtr/") ?>" required disabled style="cursor: not-allowed;">
    </div>
    <hr>
    <div class="form-group text-right">
        <button class="btn text-light save_pinfo_btn" type="submit" user_id="" form_key="" style="background-color:#294a63">Update User Profile</button>
    </div>
</form>


<script>
    function copylink_fun(element) {
        var link = $("<input>");
        $("body").append(link);
        link.val($(element).val()).select();
        document.execCommand("copy");
        link.remove();
        $('.linkcopyalert').fadeIn("slow").delay("5000").fadeOut("slow");
    }

    $(document).ready(function() {
        $('.save_pinfo_btn').click(function(e) {
            e.preventDefault();
            var fname = $('.fname').val();
            var lname = $('.lname').val();
            var email = $('.email').val();
            var mobile = $('.mobile').val();
            var user_id = $(this).attr("user_id");
            var form_key = $(this).attr("form_key");

            if (email == "" || email == null) {
                $('.email').css('border', '1px solid red');
                return false;
            } else {
                $('.email').css('border', '1px solid #ced4da');
            }
            if (mobile == "" || mobile == null) {
                $('.mobile').css('border', '1px solid red');
                return false;
            }
            if (mobile.length < 10 || mobile.length > 10) {
                $('.mobile').css('border', '1px solid red');
                $('.mobileerr').show();
                return false;
            } else {
                $('.mobile').css('border', '1px solid #ced4da');
                $('.mobileerr').hide();
            }

            $.ajax({
                url: "<?php echo base_url('updateuserprofile'); ?>",
                method: "post",
                data: {
                    user_id: user_id,
                    form_key: form_key,
                    fname: fname,
                    lname: lname,
                    email: email,
                    mobile: mobile,
                    [csrfName]: csrfHash
                },
                dataType: "json",
                error: function(res) {
                    window.location.reload();
                },
                success: function(res) {
                    if (res.status === false) {
                        $(".ajax_succ_div,.ajax_err_div").hide();
                        $(".ajax_res_err").text(res.msg);
                        $(".ajax_err_div").fadeIn().delay("6000").fadeOut();

                    } else if (res.status === true) {
                        $(".ajax_err_div,ajax_succ_div").hide();
                        $(".ajax_res_succ").text(res.msg);
                        $(".ajax_succ_div").fadeIn().delay("6000").fadeOut();
                    }

                    // $(function() {
					// 	var data = res.refdata;
					// 	$('#sadmintable').bootstrapTable({
					// 		data: data
					// 	});

					// });

                    $('.csrf-token').val(res.token);
                }
            })
        });

    });
</script>