<script>
    function getData(callback) {
        showLoading();
        $.ajax({
            type: "GET",
            url:"http://lauluuyen.azurewebsites.net/php/get_adminstats.php" ,
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
    <div>You are an administrator. An adminstrator have the following authorities:</div>
    <br>
    <div>
    
        <ul>
          <li>Create new student or admin accounts.</li>
          <li>Create new assignments and organize student groups.</li>
          <li>Delete user account.</li>
          <li>View a list of all students and search for individual students.</li>
          <li>View a list of all groups.</li>
          <li>View a list of all assignments the admins' have created.</li>
          <li>View a list of all reports the students have created.</li>
          <li>View a list of all assessments that the students have to make to each other's reports.</li>
          <li>View the leaderboard, which ranks student groups by highest average score on their reports.</li>
        </ul>
    
    </div>

    <br>
    <div class="heading2">Assignments summary:</div>
    <div>Assignment(s): {{stat.assignments}}</div>
    <div>Group(s): {{stat.groups}}</div>
    <div>Student(s): {{stat.students}}</div>
    <div>Report(s): {{stat.reports}}</div>
    <div>Assessment(s): {{stat.assessments}}</div>


</div>
