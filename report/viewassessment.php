<div class="viewassessment">
    <div class="heading">Your Report Assessment</div>

    <div class="heading2">Group's Aggregrated Mark: 3/5</div>
    <br>
    <div class="linebreak"></div>
    <div>Here is the assessment of your report made by another group.</div><br>

    <div class="heading2">Assessed on: {{assessment.timestamp}}</div>
    
    <div class="input_wrapper">
        <div class="heading2">Your report rating:</div>
        <span>
            <span ng-repeat="star in stars" class="viewstar" ng-class="star.state"></span>
        </span>
        <div class="clean"></div>
    </div>
    
    <div class="input_wrapper">
        <div class="heading2">Your report feedback:</div>
        <div class="feedback"></div>
    </div>

</div>