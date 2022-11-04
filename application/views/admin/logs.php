<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" class="csrf_token form-control">

<div class="bg-light-custom" style="margin-top: 74px;">
    <div class="text-right p-2">
        <a href="<?php echo base_url('clearlogs'); ?>" class="btn btn-danger clearlogs">
            <i class="fas fa-trash-alt mr-2"></i>Clear all Logs
        </a>
    </div>
</div>

<div class="bg-light-custom p-3 mt-3">
    <table id="logstable" data-toggle="table" data-search="true" data-show-export="true" data-show-columns="true" data-buttons-prefix="btn-md btn" data-buttons-align="left" data-pagination="true">
        <thead class="text-light" style="background:#294a63">
            <tr>
                <th data-field="activity" data-sortable="true">Activity</th>
                <th data-field="date" data-sortable="true" class="text-danger">Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($logs->result() as $log) : ?>
                <tr class="text-center">
                    <td><?php echo $log->msg ?></td>
                    <td><?php echo $log->act_time ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>


<style>
    .search-input {
        border: none;
        border-bottom: 1px solid #294a63;
    }

    .btn-md {
        background: #294a63 !important;
    }
</style>
<script>
    $(document).ready(function() {
        $(document).on('click', '.clearlogs', function(e) {
            e.preventDefault();
            var con = confirm("Are you sure you want to clear this data?");
            if (con === false) {
                return false;
            } else {
                var linkurl = $(this).attr('href');
                window.location.assign(linkurl);
            }
        });
    });
</script>