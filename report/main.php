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
    <div>Submitted & Finalised Reports: 1/2</div>
    <div>Assessments Completed: 2/5</div>
    <div>Received Assessments: 2/4</div>

</div>