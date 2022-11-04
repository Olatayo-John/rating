<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" class="csrf_token form-control">

<div class="bg-light-custom mt-3 ml-3 mr-3 pt-3 pb-3">
    <div class="d-flex">
        <div class="col">
            <?php if ($pays->num_rows() > 0) : ?>
                <a href="<?php echo base_url('admin/payments_export_csv'); ?>" class="btn text-light csvbtn" style="background:#294a63;">
                    <i class="fas fa-file-csv mr-2"></i>CSV Download
                </a>
            <?php endif; ?>
        </div>
        <div class="col">
            <div class="d-flex flex-row" style="border-bottom: 1px solid #294a63">
                <span class="" style="border-radius: 0;display:inline-flex; "><i class="fas fa-search"></i></span>
                <input type="text" name="search_payment" id="search_payment" class="form-control search_payment" placeholder="Search by any field" style="border-radius: 0" autofocus>
            </div>
        </div>
    </div>

</div>

<div class="payment_table_div mr-3 ml-3 mt-3 mb-5 bg-light-custom" style="overflow-x:scroll;overflow-y:hidden;">
    <table class="table table-bordered table-center table-hover tablepayment" id="tablepayment">
        <tr class="font-weight-bolder text-light text-center" style="background:#294a63;white-space: nowrap;">
            <th><span class="icon">
                    No.
                </span></th>
            <th><span class="icon">
                    Merchant ID
                </span></th>
            <th><span>
                    Transaction ID
                </span class="icon"></th>
            <th><span>
                    Order ID
                </span></th>
            <th><span>
                    Payment Mode
                </span></th>
            <th><span>
                    Gateway Mode
                </span></th>
            <th><span>
                    Bank Name
                </span></th>
            <th><span>
                    Bank ID
                </span></th>
            <th><span>
                    Amount
                </span class="icon"></th>
            <th><span>
                    Status
                </span></th>
            <th class="text-danger"><span>
                    Date
                </span></th>
        </tr>
        <?php if ($pays->num_rows() <= 0) : ?>
            <tr>
                <td colspan="11" class="font-weight-bolder text-dark text-center text-uppercase">No payment(s) data found</td>
            </tr>
        <?php elseif ($pays->num_rows() > 0) : ?>
            <?php $counting = 0; ?>
            <?php foreach ($pays->result() as $pay) : ?>
                <tr class="text-center">
                    <td><?php echo $counting = $counting + 1; ?></td>
                    <td><?php echo $pay->m_id ?></td>
                    <td><?php echo $pay->txn_id ?></td>
                    <td><?php echo $pay->order_id ?></td>
                    <td><?php echo $pay->payment_mode ?></td>
                    <td><?php echo $pay->gateway_name ?></td>
                    <td><?php echo $pay->bank_name ?></td>
                    <td><?php echo $pay->bank_txn_id ?></td>
                    <td><i class="fas fa-rupee-sign"></i><?php echo $pay->paid_amt ?></td>
                    <td><?php echo $pay->status ?></td>
                    <td><?php echo $pay->paid_at ?></td>
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