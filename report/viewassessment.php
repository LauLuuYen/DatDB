<div class="viewassessment">
    <div class="heading">Your Report Assessment</div>
    <div class="linebreak"></div>
    <div>Here is the assessment of your report made by the group.</div><br>

    <div class="heading2">Your report was marked by: {{group.name}}</div>
    <div style="width:300px; height:35px; background-color:lightgray; font-size:18px;">&nbsp;Their Aggregrated Mark: {{group.score}}/5</div><br>


    <div class="heading2">Date assessed by {{group.name}}: {{assessment.timestamp}}</div>
    
    <div class="input_wrapper">
        <div class="heading2">Mark given by {{group.name}}:</div>
        <span>
            <span ng-repeat="star in stars" class="viewstar" ng-class="star.state"></span>
        </span>
        <div class="clean"></div>
    </div>
    
    <div class="input_wrapper">
        <div class="heading2">Feedback by {{group.name}}:</div>
        <div class="feedback"></div>
    </div>

</div>
