<div class="row col-md-12 dataBox">
    <div class="col-lg-3 col-md-3 col-xs-12 total-column">
        <div class="panel_s">
            <div class="panel-body">
                <h3 class="_total"><?php echo $web->num_rows() ?></h3>
                <span>Websites</span>
            </div>
        </div>
    </div>
</div>

<table id="webtable" data-toggle="table" data-search="true" data-show-export="true" data-buttons-prefix="btn-md btn" data-buttons-align="right" data-pagination="true">
    <thead class="text-light" style="background:#294a63">
        <tr>
            <th data-field="web_name" data-sortable="true">Website Name</th>
            <th data-field="web_link" data-sortable="true">Website Link</th>
            <th data-field="total_ratings" data-sortable="true">Total Ratings</th>
            <th data-field="active" data-sortable="true">Active</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($web->result() as $w) : ?>
            <tr>
                <td><?php echo $w->web_name; ?></td>
                <td><?php echo $w->web_link; ?></td>
                <td><?php echo $w->total_ratings; ?></td>
                <td class="date">
                    <?php if ($w->active == '0') : ?>
                        <i class="fa-solid fa-circle text-danger"></i>
                    <?php elseif ($w->active == '1') : ?>
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