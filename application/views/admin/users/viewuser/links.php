<div class="row col-md-12 mb-3 p-0">
    <div class="col-lg-4 col-xs-12 col-md-12 total-column">
        <div class="panel_s">
            <div class="panel-body">
                <h3 class="_total lst"></h3>
                <span>Total Links</span>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-xs-12 col-md-12 total-column">
        <div class="panel_s">
            <div class="panel-body">
                <h3 class="_total emailt"></h3>
                <span>Emails</span>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-xs-12 col-md-12 total-column">
        <div class="panel_s">
            <div class="panel-body">
                <h3 class="_total smst"></h3>
                <span>SMS</span>
            </div>
        </div>
    </div>
</div>

<table id="lstable" data-search="true" data-toolbar="#toolbar" data-show-export="true" data-show-columns="true" data-buttons-prefix="btn-md btn" data-buttons-align="left" data-pagination="true">
    <thead class="text-light" style="background:#294a63">
        <tr>
            <th data-field="subj" data-sortable="true">Subject</th>
            <th data-field="body" data-sortable="true">Body</th>
            <th data-field="sent_to_sms" data-sortable="true">Mobile</th>
            <th data-field="sent_to_email" data-sortable="true">Email(s)</th>
            <th data-field="sent_at" data-sortable="true" class="text-danger">Date</th>
        </tr>
    </thead>
</table>

<script>
    $(document).ready(function() {});
</script>