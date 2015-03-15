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
    <div>Please make your assessments:</div>


    <div class="container">
        <ul id="container">
            <li ng-repeat="assessment in assessments">
                <button class="item" ng-click="next(assessment.reportID)"
                    ng-disabled="assessment.isdisabled">
                    <div class="name">Group: <span>{{assessment.groupname}}</span></div>
                    <div class="linebreak"></div>
                    <div class="assignment">Assignment: {{assessment.title}}</div>
                    <div class="feedback">{{assessment.feedback}}</div>
                    <div class="status">Status: {{assessments._status}}</div>
                    <div class="score">Score: {{assessment.score}}/5</div>
                    <div class="more">More ></div>
                </button>

            </li>
        </ul>
    </div>
</div>