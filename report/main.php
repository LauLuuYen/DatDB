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
    <div class="heading2">Your group: <em>{{profile.groupname}}</em></div><br>
    <div>As a student, you can do the following:</div>
    
    <div>
        <ul>
          <li>Submit a group report for any assignments you have been given. After submission the report can be viewed any time.</li>
          <li>Submit an assessment on other groups' reports, provided that you and the other groups have been given the same assignment.</li>
          <li>View what score other groups have given your reports.</li>
          <li>View the leaderboard and your group's rank within it. The leaderboard ranks student groups by highest average score on their reports.</li>
          <li>Change your password.</li>
          <li>Engage in forum discussion with your own group members. You can create threads and submit comments. Deletion of threads and comments is only allowed if you are the original poster.</li>
        <li>Search for threads.</li> 
        </ul>
    </div>
    

    <br>
    <div class="heading2">Your group info:</div>
    <div>Submitted & Finalised Reports: {{stat.reports}}</div>
    <div>Assessments Completed: {{stat.assessments_s}}</div>
    <div>Received Assessments: {{stat.assessments_r}}</div>
    <div>Group's average aggregated mark {{stat.mark}}/5</div>

</div>
