<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/logs.css'); ?>">

<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" class="csrf_token form-control">

<div class="bg-light mt-3 ml-3 mr-3 p-3">
    <div class="d-flex" style="justify-content:space-between">
        <div class="">
            <a href="<?php echo base_url('admin/logs_export_csv'); ?>" class="btn text-light csvbtn" style="background:#294a63;">
                <i class="fas fa-file-csv mr-2"></i>CSV Download
            </a>
        </div>
        <div class="">
            <a href="<?php echo base_url('admin/clear_logs'); ?>" class="btn btn-danger">
                <i class="fas fa-trash-alt mr-2"></i>Clear all Logs
            </a>
        </div>
    </div>

</div>

<div class="payment_table_div mr-3 ml-3 mt-3 mb-5 bg-light" style="overflow-x:scroll;overflow-y:hidden;">
    <table class="table table-bordered table-center table-hover tablepayment" id="tablepayment">
        <tr class="font-weight-bolder text-light text-center" style="background:#294a63;white-space: nowrap;">
            <th><span class="icon">
                    No.
                </span></th>
            <th><span class="icon">
                    Description
                </span></th>
            <th class="text-danger"><span>
                    Date
                </span></th>
        </tr>
        <?php if ($logs->num_rows() <= 0) : ?>
            <tr>
                <td colspan="3" class="font-weight-bolder text-dark text-center text-uppercase">No logs(s) data found</td>
            </tr>
        <?php elseif ($logs->num_rows() > 0) : ?>
            <?php $counting = 0; ?>
            <?php foreach ($logs->result() as $log) : ?>
                <tr class="text-center">
                    <td><?php echo $counting = $counting + 1; ?></td>
                    <td><?php echo $log->msg ?></td>
                    <td><?php echo $log->act_time ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </table>
</div>

<script>
    $(document).ready(function() {
        function load_data(query) {
            var csrfName = $('.csrf_token').attr('name');
            var csrfHash = $('.csrf_token').val();
            $.ajax({
                method: "POST",
                url: "<?php echo base_url('admin/payments_search') ?>",
                data: {
                    query: query,
                    [csrfName]: csrfHash
                },
                success: function(data) {
                    $('.table').html(data);
                }
            })
        }

        $('#search_payment').keyup(function() {
            var search = $(this).val();
            if (search != '') {
                load_data(search);
            } else {
                reload_table();
            }
        });

        function reload_table() {
            var csrfName = $('.csrf-token').attr('name');
            var csrfHash = $('.csrf-token').val();
            $.ajax({
                method: "POST",
                url: "<?php echo base_url('admin/reload_table_payments') ?>",
                data: {
                    [csrfName]: csrfHash
                },
                success: function(data) {
                    $('.table').html(data);
                    $('#search_payment').val("");
                }
            })
        }
    });
</script>