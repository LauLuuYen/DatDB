<script>

    function getData(callback) {
        showLoading();
        $.ajax({
            type: "GET",
            url:"http://lauluuyen.azurewebsites.net/php/get_allreportassessments.php" ,
            crossDomain: true,
            dataType: "json",
            async: true,
            timeout: 15000,

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

<div class="viewall">
    <div class="heading">Overview</div>
    <div class="linebreak"></div>
    
    <div>Here, all assignments, groups, reports and assessments are summarized in tables for an easy overview.</div>
    <br>
    
    <div class="heading2">All Groups</div>
    <table class="awesomeTable">
        <tr class="awesomeHead">
            <td>ID</td>
            <td>Group Name</td>
        </tr>
        <tr class="r0" ng-repeat="group in groups">
            <td>{{group.groupID}}</td>
            <td>{{group.groupname}}</td>
        </tr>
    </table>

    <br>
    <div class="heading2">All Assignments</div>
    <table class="awesomeTable">
        <tr class="awesomeHead">
            <td class="row-fivePercent">ID</td>
            <td class="row-thirtyPercent">Title</td>
            <td class="row-fortyPercent">Task</td>
            <td class="row-tenPercent">Deadline</td>
            <td class="row-fifteenPercent">Created</td>
        </tr>
        <tr class="r0" ng-repeat="assignment in assignments">
            <td>{{assignment.assignmentID}}</td>
            <td>{{assignment.title}}</td>
            <td ng-bind-html="assignment.task"></td>
            <td>{{assignment.deadline}}</td>
            <td>{{assignment.created}}</td>
        </tr>
    </table>


    <br>
    <div class="heading2">All Reports</div>
    <table class="awesomeTable">
        <tr class="awesomeHead">
            <td class="row-fivePercent">ID</td>
            <td class="row-tenPercent">GroupID</td>
            <td class="row-tenPercent">AssignmentID</td>
            <td class="row-tenPercent">Status</td> 
            <td class="row-fortyfivePercent">Content</td>
            <td class="row-fivePercent">UserID</td>
            <td class="row-fifteenPercent">Timestamp</td>
        </tr>
        <tr class="r0" ng-repeat="report in reports">
            <td>{{report.id}}</td>
            <td>{{report.groupid}}</td>
            <td>{{report.assignmentid}}</td>
            <td>{{report.status}}</td>
            <td ng-bind-html="report.content"></td>
            <td>{{report.userid}}</td>
            <td>{{report.timestamp}}</td>
        </tr>
    </table>

    <br>
    <div class="heading2">All Assessments</div>
    <table class="awesomeTable">
        <tr class="awesomeHead">
            <td class="row-fivePercent">GroupID</td>
            <td class="row-fivePercent">ReportID</td>
            <td class="row-tenPercent">Status</td>
            <td class="row-fortyfivePercent">Feedback</td>
            <td class="row-fivePercent">Score</td>
            <td class="row-fivePercent">UserID</td>
            <td class="row-fifteenPercent">Timestamp</td>
        </tr>
        <tr class="r0" ng-repeat="assessment in assessments">
            <td>{{assessment.groupid}}</td>
            <td>{{assessment.reportid}}</td>
            <td>{{assessment.status}}</td>
            <td ng-bind-html="assessment.feedback"></td>
            <td>{{assessment.score}}/5</td>
            <td>{{assessment.userid}}</td>
            <td>{{assessment.timestamp}}</td>
        </tr>
    </table>
</div>

