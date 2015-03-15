<div class="makeassessment">
    <div class="heading">Your Assessment</div>

    <div class="linebreak"></div>
    <div>Please read the report carefully and give your group's assessment with a rating and a feedback:</div>

    <div class="heading2">Group: {{assessment.groupname}}</div>
    <div class="heading2">Status: {{assessment._status}}</div>
    
    <div id="report" class="fullreport">{{assessment.content}}</div><br>
    
    <!--View/Edit mode-->

    <form>
        <div class="rating input_wrapper" >
            <div class="heading2">Your rating:</div>
            <span class="starRating">
                <input id="r1" type="radio" ng-model="group.rating" value="5"
                    ng-change="onChange('e1')"></input>
                <label for="r1"></label>
                <input id="r2" type="radio" ng-model="group.rating" value="4"
                    ng-change="onChange('e1')"></input>
                <label for="r2"></label>
                <input id="r3" type="radio" ng-model="group.rating" value="3"
                    ng-change="onChange('e1')"></input>
                <label for="r3"></label>
                <input id="r4" type="radio" ng-model="group.rating" value="2"
                    ng-change="onChange('e1')"></input>
                <label for="r4"></label>
                <input id="r5" type="radio" ng-model="group.rating" value="1"
                    ng-change="onChange('e1')"></input>
                <label for="r5"></label>
            </span>
        </div>
        <div id="e1" class="error invisible">Error: Please give a rating</div><br>

        <div class="heading2">Your feedback:</div>
        
        <div class="input_wrapper">
            <textarea cols="95" rows="3" class="input_text content" ng-model="group.feedback" ng-change="onChange('e2')" placeholder="Assessment feedback (500 characters maximum)" maxlength="500"></textarea>
            <div id="e2" class="error invisible">Error: Please give your feedback</div>
        </div>
        
        <button class="submitbtn" type="submit">Submit Assessment</button>
    </form>
    
</div>
