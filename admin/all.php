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
    <div class="heading">View All</div>
    <div class="linebreak"></div>

    <div class="heading2">All Groups</div>
    <table class="randomtable">
        <tr class="head">
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
    <table class="randomtable">
        <tr class="head">
            <td>ID</td>
            <td>Title</td>
            <td>Task</td>
            <td>Deadline</td>
            <td>Created</td>
        </tr>
        <tr class="r0" ng-repeat="assignment in assignments">
            <td>{{assignment.assignmentID}}</td>
            <td>{{assignment.title}}</td>
            <td>{{assignment.task}}</td>
            <td>{{assignment.deadline}}</td>
            <td>{{assignment.created}}</td>
        </tr>
    </table>


    <br>
    <div class="heading2">All Reports</div>
    <table class="randomtable">
        <tr class="head">
            <td>ID</td>
            <td>GroupID</td>
            <td>AssignmentID</td>
            <td>Status</td>
            <td>Content</td>
            <td>UserID</td>
            <td>Timestamp</td>
        </tr>
        <tr class="r0" ng-repeat="report in reports">
            <td>{{report.id}}</td>
            <td>{{report.groupid}}</td>
            <td>{{report.assignmentid}}</td>
            <td>{{report.status}}</td>
            <td>{{report.content}}</td>
            <td>{{report.userid}}</td>
            <td>{{report.timestamp}}</td>
        </tr>
    </table>

    <br>
    <div class="heading2">All Assessments</div>
    <table class="randomtable">
        <tr class="head">
            <td>GroupID</td>
            <td>ReportID</td>
            <td>Status</td>
            <td>Feedback</td>
            <td>Score</td>
            <td>UserID</td>
            <td>Timestamp</td>
        </tr>
        <tr class="r0" ng-repeat="assessment in assessments">
            <td>{{assessment.groupid}}</td>
            <td>{{assessment.reportid}}</td>
            <td>{{assessment.status}}</td>
            <td>{{assessment.feedback}}</td>
            <td>{{assessment.score}}/5</td>
            <td>{{assessment.userid}}</td>
            <td>{{assessment.timestamp}}</td>
        </tr>
    </table>
</div>

