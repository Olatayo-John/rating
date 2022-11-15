<!-- <h4 class="text-dark">Personal Information</h4>
<hr class="p_i"> -->
<form action="<?php echo base_url('admin-update-profile'); ?>" method="post" id="userprofile_adminForm">
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
        <label>Email</label> <span>*</span>
        <input type="email" name="email" class="form-control email" placeholder="example@domain-name.com" required>
    </div>

    <div class="form-group">
        <label>Mobile</label> <span>*</span>
        <input type="number" name="mobile" class="form-control mobile" placeholder="0123456789" required>
        <div class="text-danger font-weight-bolder mobileerr" style="display: none;">Invalid mobile length</div>
    </div>

    <div class="form-group">
        <label>Username</label>
        <input type="text" name="uname" class="form-control uname" readonly disabled required disabled style="cursor: not-allowed;">
    </div>

    <div class="row">
        <div class="form-group col-md-6">
            <label>Gender</label>
            <select name="gender" id="gender" class="form-control gender">
                <option value=""></option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>
        </div>
        <div class="form-group col-md-6">
            <label>Date Of Birth</label>
            <input type="date" name="dob" class="form-control dob">
        </div>
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
        <button class="btn text-light save_pinfo_btn" type="submit" style="background-color:#294a63">Update</button>
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
        // $('.save_pinfo_btn').click(function(e) {
        $('form#userprofile_adminForm').submit(function(e) {
            e.preventDefault();

            var fname = $('.fname').val();
            var lname = $('.lname').val();
            var email = $('.email').val();
            var mobile = $('.mobile').val();
            var gender = $('.gender').val();
            var dob = $('.dob').val();
            var user_id = $('#currentUserId').attr("user_id");
            var form_key = $('#currentUserId').attr("form_key");

            if (email == "" || email == null) {
                return false;
            }

            if (mobile == "" || mobile == null || mobile.length < 10 || mobile.length > 10) {
                $('.mobileerr').show();
                return false;
            } else {
                $('.mobileerr').hide();
            }

            $.ajax({
                url: "<?php echo base_url('admin-update-profile'); ?>",
                method: "post",
                data: {
                    user_id: user_id,
                    form_key: form_key,
                    fname: fname,
                    lname: lname,
                    email: email,
                    mobile: mobile,
                    gender: gender,
                    dob: dob,
                    [csrfName]: csrfHash
                },
                dataType: "json",
                error: function(res) {
                    var con = confirm('Some error occured. Refresh?');
                    if (con === true) {
                        window.location.reload();
                    } else if (con === false) {
                        return false;
                    }
                },
                success: function(res) {
                    if (res.status === false) {
                        $(".ajax_succ_div,.ajax_err_div").hide();
                        $(".ajax_res_err").text(res.msg);
                        $(".ajax_err_div").fadeIn();

                    } else if (res.status === true) {
                        $(".ajax_err_div,ajax_succ_div").hide();
                        $(".ajax_res_succ").text(res.msg);
                        $(".ajax_succ_div").fadeIn();

                        $("#currentUserId").attr({
                            'user_email': email
                        });
                    }

                    $('.csrf-token').val(res.token);
                }
            })
        });

    });
</script>