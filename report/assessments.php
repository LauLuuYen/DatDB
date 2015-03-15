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
        <div dynamic="itemlist"></div>
    </div>

    <ul id="container">
        <li ng-repeat="assessment in assessments">
            <div class="item" ng-click="next(assessment.reportID)">
                <div class="name">Group: <span>{{assessment.groupname}}</span></div>
                <div class="linebreak"></div>
                <div class="assignment">Assignment: {{assessment.title}}</div>
                <div class="feedback">{{assessment.feedback}}</div>
                <div class="status">Status: {{assessments.status}}</div>
                <div class="score">Score: {{assessment.score}}/5</div>
                <div class="more">More ></div>
            </div>

        </li>
    </ul>

</div>