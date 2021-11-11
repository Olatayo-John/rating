<div class="row col-md-12 m-0 mb-3 p-0">
    <div class="col-lg-2 col-md-2 col-xs-12 total-column">
        <div class="panel_s">
            <div class="panel-body">
                <h3 class="_total"><?php echo $rr->num_rows() ?></h3>
                <span class="text-success">Ratings</span>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-md-2 col-xs-12 total-column">
        <div class="panel_s">
            <div class="panel-body">
                <h3 class="_total"><?php echo $ud->total_one ?></h3>
                <span>One Stars</span>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-md-2 col-xs-12 total-column">
        <div class="panel_s">
            <div class="panel-body">
                <h3 class="_total"><?php echo $ud->total_two ?></h3>
                <span>Two Stars</span>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-md-2 col-xs-12 total-column">
        <div class="panel_s">
            <div class="panel-body">
                <h3 class="_total"><?php echo $ud->total_three ?></h3>
                <span>Three Stars</span>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-md-2 col-xs-12 total-column">
        <div class="panel_s">
            <div class="panel-body">
                <h3 class="_total"><?php echo $ud->total_four ?></h3>
                <span>Four Stars</span>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-md-2 col-xs-12 total-column">
        <div class="panel_s">
            <div class="panel-body">
                <h3 class="_total"><?php echo $ud->total_five ?></h3>
                <span>Five Stars</span>
            </div>
        </div>
    </div>
</div>

<table id="rrtable" data-toggle="table" data-search="true" data-show-export="true" data-show-columns="true" data-buttons-prefix="btn-md btn" data-buttons-align="left" data-pagination="true">
    <thead class="text-light" style="background:#294a63">
        <tr>
            <th data-field="webname" data-sortable="true">Website Name</th>
            <th data-field="ratedby" data-sortable="true">Rated By</th>
            <th data-field="star" data-sortable="true">Star Given</th>
            <th data-field="date" data-sortable="true">Date</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($rr->result() as $rr) : ?>
            <tr>
                <td><?php echo $rr->web_name; ?></td>
                <td><?php echo $rr->name; ?></td>
                <td><?php echo $rr->star . " Star"; ?></td>
                <td style="color:#a71d2a;"><?php echo $rr->rated_at; ?></td>
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
    $(document).ready(function() {});
</script>