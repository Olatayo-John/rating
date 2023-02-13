<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/dashboard.css'); ?>">
<input type="hidden" name="<?php echo $this->security->get_csrf_token_name() ?>" value="<?php echo $this->security->get_csrf_hash() ?>" class="csrf_hash">

<div class="wrapper_div_">

    <div class="bg-light-custom_ p-3">

        <div class="d-flex mb-3" style="flex-wrap: wrap;">
            <div class='col-md-6 p-0'>
                <canvas class='bg-light-custom m-0 p-3' id="chart1"></canvas>
            </div>

            <div class='col-md-6 p-0'>
                <canvas class='bg-light-custom m-0 p-3' id="chart2"></canvas>
            </div>
        </div>

        <div class="col-md-12 p-0 m-0 mb-3">
            <!-- <div class='col chart-container' style="position: relative; height:40vh; width:80vw"> -->
            <div class=''>
                <canvas class="bg-light-custom m-0 p-3" id="chart3"></canvas>
            </div>
        </div>

        <div class="bg-light-custom p-3">
            <form method="post" id="genFrameForm">
                <input type="hidden" class="csrf" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                <input type="hidden" name="form_key" id="form_key" value='<?php echo $this->session->userdata('mr_form_key') ?>'>
                <input type="hidden" name="id" id="id" value='<?php echo $this->session->userdata('mr_id') ?>'>

                <div class="form-group_">
                    <select name="platforms[]" id="" class="selectpicker form-control" multiple data-live-search="true" title="Select Platform" data-width="100%">
                        <?php if ($platforms->num_rows() > 0) : ?>
                            <?php foreach ($platforms->result_array() as $p) : ?>
                                <?php if ($p['active'] === '1') : ?>
                                    <option value="<?php echo $p['id'] ?>"><?php echo $p['web_name'] ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <option value="">No platform created</option>
                        <?php endif; ?>
                    </select>
                </div>

                <div class="form-group text-right mt-2">
                    <button type="submit" class="btn btn-block text-light genFrameBtn" style="background-color:#294a63">Generate</button>
                </div>
            </form>
            <hr>

            <div id="frameCode" <?php echo ($this->session->userdata('mr_frame_id')) ? '' : 'style="display:none"' ?>>
                <label>Paste code anywhere</label>
                <div class="input-group">
                    <input type="text" name="linkshare" class="form-control linkshare" id='linkshare' value='<iframe width="100%" height="100" src="<?php echo base_url('pf/') . $this->session->userdata('mr_frame_id') ?>" frameborder="0" allowfullscreen></iframe>'' readonly style="cursor: not-allowed;">

                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-copy ml-2 copy_i" style="cursor:pointer" onclick="copylink_fun(' #linkshare')"></i></span>
                </div>
            </div>
            <div class="linkcopyalert" style="display:none;color:#294a63">Copied to your clipboard</div>
        </div>

        <div class="modal fade FrameModal" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-dialog-top modal-xl">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="modalcloseDiv">
                            <h6></h6>
                            <i class="fas fa-times closeFrameModal text-danger"></i>
                        </div>

                        <form method="post" id="createFrameForm">
                            <input type="hidden" class="csrf" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                            <input type="hidden" name="frame_platformFormkey" class="form-control" value='<?php echo $this->session->userdata('mr_form_key') ?>'>
                            <input type="hidden" name="frame_platformUserid" class="form-control" value='<?php echo $this->session->userdata('mr_id') ?>'>

                            <div id='formInput'></div>

                            <div class="text-right mt-3">
                                <button type="submit" class="btn createFrameBtn text-light" style="background-color:#294a63;">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>


</div>



<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        fillChart();

        function fillChart() {
            var id = "<?php echo $this->session->userdata('mr_id'); ?>";
            var csrfName = $('.csrf_hash').attr('name');
            var csrfHash = $('.csrf_hash').val();
            var currentdate = new Date();
            var datetime_Year = currentdate.getFullYear();

            $.ajax({
                url: "<?php echo base_url('fill-chart'); ?>",
                method: "post",
                data: {
                    id: id,
                    datetime_Year: datetime_Year,
                    [csrfName]: csrfHash
                },
                dataType: "json",
                beforeSend: function() {
                    clearAlert();
                },
                success: function(res) {
                    $('.csrf_hash').val(res.token);

                    if (res.status === true) {

                        const c1 = document.getElementById('chart1');
                        const c2 = document.getElementById('chart2');
                        const c3 = document.getElementById('chart3');

                        new Chart(c1, {
                            type: 'pie',
                            data: {
                                labels: res.chartData.cp.map(row => row.web_name),
                                datasets: [{
                                    label: 'Reviews',
                                    labels: res.chartData.cp.map(row => row.web_name),
                                    data: res.chartData.cp.map(row => row.total_ratings),
                                }]
                            },
                            options: {
                                animation: true,
                                aspectRatio: 2,
                                plugins: {
                                    legend: {
                                        display: true
                                    },
                                    tooltip: {
                                        enabled: true
                                    },
                                    colors: {
                                        enabled: true
                                    }
                                }
                            }
                        });

                        new Chart(c2, {
                            type: 'line',
                            data: {
                                labels: res.chartData.cm.map(row => row.month),
                                datasets: [{
                                    label: '2022 - ' + datetime_Year,
                                    data: res.chartData.cm.map(row => row.rating),
                                    backgroundColor: '#294a63',
                                }]
                            },
                            options: {
                                animation: true,
                                aspectRatio: 2,
                                plugins: {
                                    legend: {
                                        display: true
                                    },
                                    tooltip: {
                                        enabled: true
                                    },
                                    colors: {
                                        enabled: false
                                    }
                                },
                                scales: {
                                    y: {
                                        ticks: {
                                            stepSize: 1
                                        },
                                        beginAtZero: true,
                                        min: 0,
                                    }
                                }
                            }
                        });

                        var datastsArr = [];
                        for (let a = 0; a < res.chartData.cr.length; a++) {
                            var obj = {};
                            obj['label'] = res.chartData.cr[a].web_name;
                            obj['data'] = res.chartData.cr[a].starArr;
                            datastsArr.push(obj);
                        }

                        new Chart(c3, {
                            type: 'bar',
                            data: {
                                labels: ['1 Star', '2 Star', '3 Star', '4 Star', '5 Star'],
                                datasets: datastsArr,
                            },
                            options: {
                                maintainAspectRatio: false,
                                animation: true,
                                aspectRatio: 2,
                                plugins: {
                                    legend: {
                                        display: true
                                    },
                                    tooltip: {
                                        enabled: true
                                    },
                                    colors: {
                                        enabled: true
                                    }
                                },
                                scales: {
                                    y: {
                                        ticks: {
                                            stepSize: 1
                                        },
                                        beginAtZero: true,
                                        // max:100
                                    }
                                }
                            }
                        });

                    } else if (res.status == false) {
                        $(".ajax_succ_div,.ajax_err_div").fadeOut();
                        $('.ajax_res_err').html(res.msg);
                        $('.ajax_err_div').fadeIn();
                    } else if (res.status == "error") {
                        window.location.assign(res.redirect);
                    }
                },
                error: function(res) {
                    // window.location.assign(res.redirect);
                }
            });
        }

        //create new frame
        $('form#genFrameForm').submit(function(e) {
            e.preventDefault();

            let myForm = document.getElementById('genFrameForm');
            form_data = new FormData(myForm);

            $.ajax({
                url: "generate-frame",
                type: "POST",
                data: form_data,
                processData: false,
                contentType: false,
                cache: false,
                dataType: 'json',
                beforeSend: function() {
                    clearAlert();

                    $('#formInput').children().remove();

                    $('.genFrameBtn').html("Generating...").attr('disabled', 'disabled').css('cursor', 'not-allowed');
                },
                success: function(res) {
                    if (res.status === true) {
                        $(".ajax_res_succ").append(res.msg);
                        $(".ajax_succ_div").fadeIn();

                        //show modal foreach selected platform to update rie image or icon
                        // if (res.info.length > 1) {
                        //     var len = 'mb-3';
                        // }
                        // res.info.forEach(info => {
                        //     $('#formInput').append('<div class="bg-light-custom p-3 ' + len + '"><input type="hidden" name="frame_platformId[]" class="frame_platformId form-control" value="' + info.id + '"><div class="form-group"><label class="mb-0">Platform</label><input type="text" name="frame_platformName[]" class="frame_platformName form-control" value="' + info.web_name + '" required readonly></div><div class="row"><div class="form-group col-md-6 m-0"><label class="mb-0">Icon</label><input type="text" class="frame_icon form-control" name="frame_icon[]" value="fa-solid fa-globe" required></div></div></div>');
                        // })
                        // $('.FrameModal').modal('show');


                        let frameCode = '<iframe width="100%" height="100" src="' + res.frameLink + '" frameborder="0" allowfullscreen></iframe>';
                        $('#frameCode input').val(frameCode);
                        $('#frameCode').fadeIn('');
                    } else if (res.status === false) {
                        $(".ajax_res_err").append(res.msg);
                        $(".ajax_err_div").fadeIn();
                    } else {
                        window.location.reload();
                    }

                    $('.csrf').val(res.token);
                    $('.genFrameBtn').html("Generate").removeAttr('disabled').css('cursor', 'pointer');
                }
            });
        });

        $(document).on('click', '.closeFrameModal', function(e) {
            e.preventDefault();

            $('.FrameModal').modal("hide");
        });

        //disabled
        //save frame-details
        $('form#createFrameForm').submit(function(e) {
            e.preventDefault();

            let myForm = document.getElementById('createFrameForm');
            form_data = new FormData(myForm);

            $.ajax({
                url: "create-frame",
                type: "POST",
                data: form_data,
                processData: false,
                contentType: false,
                cache: false,
                dataType: 'json',
                beforeSend: function() {
                    clearAlert();

                    $('.createFrameBtn').html("Saving...").attr('disabled', 'disabled').css('cursor', 'not-allowed');
                },
                success: function(res) {
                    if (res.status === true) {
                        $(".ajax_res_succ").append(res.msg);
                        $(".ajax_succ_div").fadeIn();

                        $('.FrameModal').modal('hide');
                        $('#frameCode').fadeIn('');

                        let frameCode = '<iframe width="100%" height="100" src="' + res.frameLink + '" frameborder="0" allowfullscreen></iframe>';
                        $('#frameCode input').val(frameCode);
                    } else if (res.status === false) {
                        $(".ajax_res_err").append(res.msg);
                        $(".ajax_err_div").fadeIn();
                    } else {
                        window.location.reload();
                    }

                    $('.csrf').val(res.token);
                    $('.createFrameBtn').html("Save").removeAttr('disabled').css('cursor', 'pointer');
                }
            });
        });
    });
</script>