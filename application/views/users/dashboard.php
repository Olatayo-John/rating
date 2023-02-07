<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/dashboard.css'); ?>">
<input type="hidden" name="<?php echo $this->security->get_csrf_token_name() ?>" value="<?php echo $this->security->get_csrf_hash() ?>" class="csrf_hash">

<div class="wrapper_div">

    <div class="bg-light-custom p-3 ">
        <div class="row pl-3 pr-3 mb-3">
            <div class='col-md-6 bg-light-custom'>
                <canvas id="chart1"></canvas>
            </div>

            <div class='col-md-6 bg-light-custom'>
                <canvas id="chart2"></canvas>
            </div>
        </div>
        <div class="bg-light-custom">
            <div class='col-md-12 chart-container' style="position: relative; height:40vh; width:80vw">
                <canvas id="chart3"></canvas>
            </div>
        </div>

        <p></p>
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
                    datetime_Year:datetime_Year,
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
                                    label: '2022 - '+datetime_Year,
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
    });
</script>