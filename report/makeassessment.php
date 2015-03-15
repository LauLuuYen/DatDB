<div class="makeassessment">
    <div class="heading">Your Assessment</div>

    <div class="linebreak"></div>
    <div>Please read the report carefully and give your group's assessment with a rating and a feedback:</div>

    <div class="heading2">Group: <span id="groupname"></span></div>
    <div class="heading2">Assessment Status: <span id="status"></span></div>
    
    <div id="report" class="fullreport"></div>
    
    <!--View/Edit mode-->

    <form>
        <div class="rating input_wrapper" >
            <div class="heading2">Your rating:</div>
            <span class="starRating">
                <input id="r1" type="radio" name="rating" value="5"
                    ng-change="onChange('e1')"></input>
                <label for="r1"></label>
                <input id="r2" type="radio" name="rating" value="4"
                    ng-change="onChange('e1')"></input>
                <label for="r2"></label>
                <input id="r3" type="radio" name="rating" value="3"
                    ng-change="onChange('e1')"></input>
                <label for="r3"></label>
                <input id="r4" type="radio" name="rating" value="2"
                    ng-change="onChange('e1')"></input>
                <label for="r4"></label>
                <input id="r5" type="radio" name="rating" value="1"
                    ng-change="onChange('e1')"></input>
                <label for="r5"></label>
            </span>
            <div id="e1" class="error">Error: Please give a rating</div>
        </div>

        <div class="heading2">Your feedback:</div>
        
        <div class="input_wrapper">
            <textarea cols="95" rows="3" class="input_text content" ng-model="assessment.feedback" ng-change="onChange('e2')" placeholder="Assessment feedback (500 characters maximum)" maxlength="500"></textarea>
            <div id="e2" class="error">Error: Please give your feedback</div>
        </div>
        
        <button class="submitbtn" type="submit">Submit Assessment</button>
    </form>
    
</div>
