<div class="row col-md-12 dataBox">
    <div class="col-lg-3 col-md-3 col-xs-12 total-column">
        <div class="panel_s">
            <div class="panel-body">
                <h3 class="_total"><?php echo $ls->num_rows() ?></h3>
                <span class="">Links</span>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-xs-12 total-column">
        <div class="panel_s">
            <div class="panel-body">
                <h3 class="_total"><?php echo $t_mail->num_rows() ?></h3>
                <span>Emails</span>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-xs-12 total-column">
        <div class="panel_s">
            <div class="panel-body">
                <h3 class="_total"><?php echo $t_sms->num_rows() ?></h3>
                <span>SMS</span>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-xs-12 total-column">
        <div class="panel_s">
            <div class="panel-body">
                <h3 class="_total"><?php echo $t_wp->num_rows() ?></h3>
                <span>Whatsapp</span>
            </div>
        </div>
    </div>
</div>


<table id="lstable" data-toggle="table" data-search="true" data-show-export="true" data-buttons-prefix="btn-md btn" data-buttons-align="right" data-pagination="true">
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
                <td><?php echo strtoupper($web['link_for']) ?></td>
                <td>
                    <?php if (!empty($web['sent_to_sms']) && $web['sent_to_sms'] !== null) : ?>
                        <!-- <?php echo $web['sent_to_sms']; ?> -->
                        <a href="mailto:<?php echo $web['sent_to_sms']; ?>"><?php echo $web['sent_to_sms']; ?></a>
                    <?php elseif (!empty($web['sent_to_email']) && $web['sent_to_email'] !== null) : ?>
                        <!-- <?php echo $web['sent_to_email']; ?> -->
                        <a href="tel:<?php echo $web['sent_to_email']; ?>"><?php echo $web['sent_to_email']; ?></a>
                    <?php endif; ?>
                </td>
                <td><?php echo $web['subj']; ?></td>
                <td style="word-break:break-all;"><?php echo $web['body']; ?></td>
                <td class="date"><?php echo $web['sent_at']; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>



<script>
    $(document).ready(function() {

    });
</script>