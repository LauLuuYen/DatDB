<script>
    function getData(callback) {
        showLoading();
        $.ajax({
            type: "GET",
            url:"http://lauluuyen.azurewebsites.net/php/get_studentstats.php" ,
            crossDomain: true,
            dataType: "json",
            async: true,
            timeout: 10000,

            success: function (data) {
                hideLoading();
                callback(data);
            },

            error: function(xhr, status, error) {
                getData(callback);
            }
        });
    }
</script>

<div class="main">

    
    <div class="heading">Hi, {{profile.name}} {{profile.lastname}}</div>
    <div class="linebreak"></div>
    <div class="heading2">Group: <em>{{profile.groupname}}</em></div><br>
    <div>...you can do this for your group and that...</div>

    <br>
    <div class="heading2">The Info:</div>
    <div>Submitted & Finalised Reports: {{stat.reports}}</div>
    <div>Assessments Completed: {{stat.assessments_s}}</div>
    <div>Received Assessments: {{stat.assessments_r}}</div>
    <div>Group's average aggregated mark {{stat.mark}}/5</div>

</div>
