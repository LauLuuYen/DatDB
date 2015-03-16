<div class="makeassessment">
    <div class="heading">Your Group Assessment</div>

    <div class="linebreak"></div>
    <div>Here you can read your peer's group report.  You can either give your group's assessment with a rating and a feedback or view your assessment:</div><br>

    <div class="heading2">Group: {{assessment.groupname}}</div>
    <div class="heading2">Status: {{assessment._status}}</div>
    
    <div id="report" class="fullreport"></div><br>
    
    <!--View/Edit mode-->
    <div id="viewmode" class="conceal">
        <div class="input_wrapper">
            <div class="heading2">Your group's rating:</div>
            <span>
                <span ng-repeat="star in stars" class="viewstar" ng-class="star.state"></span>
            </span>
            <div class="clean"></div>
        </div><br>
        
        <div class="input_wrapper">
            <div class="heading2">Your group's feedback:</div>
            <div class="feedback"></div>
        </div>
    </div>

    <div id="editmode" class="conceal">
        <form ng-submit="submit()">
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
    
</div>
