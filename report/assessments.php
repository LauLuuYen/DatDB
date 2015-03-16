<script>
    function getData(callback) {
        showLoading();
        $.ajax({
            type: "GET",
            url:"http://lauluuyen.azurewebsites.net/php/get_assessmentreports.php" ,
            crossDomain: true,
            dataType: "json",
            async: true,
            timeout: 10000,

            success: function (data) {
                hideLoading();
                callback(data["assessments"]);
            },

            error: function(xhr, status, error) {
                getData(callback);
            }
        });
    }

</script>

<div class="assessments">
    <div class="heading">Group Assessment Tasks</div>

    <div class="linebreak"></div>
    <div>Here is the list of reports your group has to give an assessment to.</div><br>

    <div class="heading2">Colour codings:</div>
    <div>Grey - The group hasn't submitted and finalised their report yet</div>
    <div>Red - Your group has yet to make an assessment</div>
    <div>Green - Your group has completed the assessment</div>

    <div class="container">
        <ul id="container">
            <li ng-repeat="assessment in assessments">
                <button class="item" ng-class="assessment._status" ng-click="next(assessment.reportID)"
                    ng-disabled="assessment.isdisabled">
                    <div class="name">Group: <span>{{assessment.groupname}}</span></div>
                    <div class="linebreak"></div>
                    <div class="assignment">Assignment: {{assessment.title}}</div>
                    <div class="status">Status: {{assessment._status}}</div>
                    <div class="score">Score: {{assessment.score}}/5</div>
                    <div class="more">More ></div>
                </button>

            </li>
        </ul>
    </div>
</div>