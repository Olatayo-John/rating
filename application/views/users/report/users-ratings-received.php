<div class="row col-md-12 dataBox">
    <div class="col-lg-3 col-md-3 col-xs-12 total-column">
        <div class="panel_s">
            <div class="panel-body">
                <h3 class="_total"><?php echo $allrr->num_rows() ?></h3>
                <span class="">Reviews</span>
            </div>
        </div>
    </div>
</div>

<table id="rrtable" data-toggle="table" data-search="true" data-show-export="true" data-buttons-prefix="btn-md btn" data-buttons-align="right" data-pagination="true">
    <thead class="text-light" style="background:#294a63">
        <tr>
        <th data-field="uname" data-sortable="true">User</th>
            <th data-field="webname" data-sortable="true">Platform Name</th>
            <th data-field="star" data-sortable="true">Star</th>
            <th data-field="name" data-sortable="true">Rated By</th>
            <th data-field="review" data-sortable="true">Review</th>
            <th data-field="IP" data-sortable="true">IP</th>
            <th data-field="date" data-sortable="true">Date</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($allrr->result() as $arr) : ?>
            <tr>
            <td><?php echo $arr->uname; ?></td>
                <td>
                    <a href="<?php echo $arr->web_link; ?>" target="_blank"><?php echo $arr->web_name; ?></a>
                </td>
                <td>
                        <?php echo $arr->star . " Star"; ?>
                </td>
                <td><?php echo $arr->name; ?></td>
                <td><?php echo $arr->review; ?></td>
                <td><?php echo $arr->user_ip; ?></td>
                <td class="date"><?php echo $arr->rated_at; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>


<script>
    $(document).ready(function() {});
</script>