<div class="row col-md-12 dataBox">
    <div class="col-lg-3 col-md-3 col-xs-12 total-column">
        <div class="panel_s">
            <div class="panel-body">
                <h3 class="_total"><?php echo $allweb->num_rows() ?></h3>
                <span>Websites</span>
            </div>
        </div>
    </div>
</div>

<table id="webtable" data-toggle="table" data-search="true" data-show-export="true" data-buttons-prefix="btn-md btn" data-buttons-align="right" data-pagination="true">
    <thead class="text-light" style="background:#294a63">
        <tr>
            <th data-field="uname" data-sortable="true">User</th>
            <th data-field="web_name" data-sortable="true">Website Name</th>
            <th data-field="web_link" data-sortable="true">Website Link</th>
            <th data-field="total_ratings" data-sortable="true">Total Ratings</th>
            <th data-field="active" data-sortable="true">Active</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($allweb->result() as $aw) : ?>
            <tr>
                <td><?php echo $aw->uname; ?></td>
                <td><?php echo $aw->web_name; ?></td>
                <td><?php echo $aw->web_link; ?></td>
                <td><?php echo $aw->total_ratings; ?></td>
                <td class="date">
                    <?php if ($aw->active == '0') : ?>
                        <i class="fa-solid fa-circle text-danger"></i>
                    <?php elseif ($aw->active == '1') : ?>
                        <i class="fa-solid fa-circle text-success"></i>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>


<script>
    $(document).ready(function() {});
</script>