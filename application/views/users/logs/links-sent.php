<div class="row col-md-12 m-0 mb-3 p-0">
    <div class="col-lg-4 col-xs-12 col-md-12 total-column">
        <div class="panel_s">
            <div class="panel-body">
                <h3 class="_total"><?php echo $ud->total_email+$ud->total_sms ?></h3>
                <span class="">Total Links</span>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-xs-12 col-md-12 total-column">
        <div class="panel_s">
            <div class="panel-body">
                <h3 class="_total"><?php echo $ud->total_email?></h3>
                <span>Emails</span>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-xs-12 col-md-12 total-column">
        <div class="panel_s">
            <div class="panel-body">
                <h3 class="_total"><?php echo $ud->total_sms ?></h3>
                <span>SMS</span>
            </div>
        </div>
    </div>
</div>


<table id="lstable" data-toggle="table" data-search="true" data-show-export="true" data-buttons-prefix="btn-md btn" data-buttons-align="left" data-pagination="true">
    <thead class="text-light" style="background:#294a63">
        <tr>
            <th data-field="type" data-sortable="true">Type</th>
            <th data-field="sentto" data-sortable="true">Sent to</th>
            <th data-field="subj" data-sortable="true">Subject</th>
            <th data-field="msg" data-sortable="true">Message</th>
            <th data-field="date" data-sortable="true">Date</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($ls->result_array() as $web) : ?>
            <tr>
                <td><?php echo (empty($web['sent_to_sms']) || $web['sent_to_sms'] == null) ? "EMAIL" : "SMS"; ?></td>
                <td style="word-break:break-all;"><?php echo (empty($web['sent_to_sms']) || $web['sent_to_sms'] == null) ? $web['sent_to_email'] : $web['sent_to_sms']; ?></td>
                <td><?php echo $web['subj']; ?></td>
                <td style="word-break:break-all;"><?php echo $web['body']; ?></td>
                <td style="color:#a71d2a;"><?php echo $web['sent_at']; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>


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

    });
</script>