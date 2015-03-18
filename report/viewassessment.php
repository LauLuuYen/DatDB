<div class="viewassessment">
    <div class="heading">Your Report Assessment</div>
    <div class="linebreak"></div>
    <div>Here is the assessment of your report made by the group.</div><br>

    <div class="heading2">Your report was marked by: {{group.name}}</div>
    <div style="width:300px; height:35px; background-color:lightgray; font-size:18px;">&nbsp;Their Aggregrated Mark: {{group.score}}/5</div><br>


    <div class="heading2">{{group.name}} assessed your report on: {{assessment.timestamp}}</div>
    
    <div class="input_wrapper">
        <div class="heading2">{{group.name}} gave your reprot the mark:</div>
        <span>
            <span ng-repeat="star in stars" class="viewstar" ng-class="star.state"></span>
        </span>
        <div class="clean"></div>
    </div>
    
    <div class="input_wrapper">
        <div class="heading2">{{group.name}} gave following feedback:</div>
        <div class="feedback"></div>
    </div>

</div>
