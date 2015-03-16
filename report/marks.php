<script>
    function getData(callback) {
        showLoading();
        $.ajax({
            type: "GET",
            url:"http://lauluuyen.azurewebsites.net/php/get_assessmentmarks.php" ,
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

<div class="viewmarks">
    <div class="heading">Your Group Marks</div>

    <div class="linebreak"></div>
    <div>Here you can view the assessments that other groups (anonymously) have made on your report for different assignments.</div><br>

    <div class="heading2">Colour codings:</div>
    <div>Grey - The group hasn't given you an assessment yet.</div>
    <div>Green - The group has given you an assessment.</div>


    <div class="container">
        <ul id="container">
            <li ng-repeat="assessment in groupassessments">
                <button class="item" ng-class="assessment.status" ng-click="next(assessment.assessmentID)"
                    ng-disabled="assessment.isdisabled">
                    <div class="assignment">Assignment: {{assessment.title}}</div>
                    <div class="status">Status: {{assessment.status}}</div>
                    <div class="score">Score: {{assessment.score}}/5</div>
                    <div class="more">More ></div>
                </button>

            </li>
        </ul>
    </div>

</div>