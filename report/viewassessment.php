<div class="viewassessment">
    <div class="heading">Your Report Assessment</div>
    <div class="linebreak"></div>
    <div>Here is the assessment of your report made by the group.</div><br>

    <div class="heading2">By Group: {{group.name}}</div>
    <div style="width:200px; height:38px; background-color:lightgray; font-size:18px;text-align:center;">Aggregrated Mark: {{group.score}}/5</div>


    <div class="heading2">Assessed on: {{assessment.timestamp}}</div>
    
    <div class="input_wrapper">
        <div class="heading2">Your Report Mark:</div>
        <span>
            <span ng-repeat="star in stars" class="viewstar" ng-class="star.state"></span>
        </span>
        <div class="clean"></div>
    </div>
    
    <div class="input_wrapper">
        <div class="heading2">Your Report Feedback:</div>
        <div class="feedback"></div>
    </div>

</div>