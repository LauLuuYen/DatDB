<div class="makeassessment">
    <div class="heading2">Group: <span id="groupname"></span></div>
    <div class="heading2">Assessment Status: <span id="status"></span></div>
    
    <div id="report" class="fullreport"></div>
    
    <!--View/Edit mode-->
    
    <div class="rating">
        <div class="heading2">Please give a rating:</div>
        <span class="starRating">
            <input id="r1" type="radio" name="rating" value="5"></input>
            <label for="r1"></label>
            <input id="r2" type="radio" name="rating" value="4"></input>
            <label for="r2"></label>
            <input id="r3" type="radio" name="rating" value="3"></input>
            <label for="r3"></label>
            <input id="r4" type="radio" name="rating" value="2"></input>
            <label for="r4"></label>
            <input id="r5" type="radio" name="rating" value="1"></input>
            <label for="r5"></label>
        </span>
    </div>

    <div class="heading2">Your feedback</div>
    <!--
    <div>
        <input type="text"></input>
    </div>
    -->
    
    <div class="input_wrapper">
        <textarea cols="95" rows="3" class="input_text content" style="width: 93%" ng-model="assessment.feedback" ng-change="onChange('feedback_e')" placeholder="Assessment feedback (500 characters maximum)" maxlength="500"></textarea>        
        <div id="feedback_e" class="error invisible">Error: Please type in a assessment feedback</div>
    </div>
    
    <button>Submit Feedback</button>

    
</div>
