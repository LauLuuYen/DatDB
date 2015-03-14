<script>
    $(function() {
        $( "#datepicker" ).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "dd/mm/yy"
        });
    });

    function isDateAfter(datestr) {
        var parts = datestr.split("/");
        var year = parts[2];
        var month = parseInt(parts[1])-1;
        var day = parts[0];        
        var date = new Date(year, month, day);
        var now = new Date();
        return date > now;
    }



</script>

<div class="createassignment">
    <div class="heading">Create Assignment</div>

    <div class="linebreak"></div>

    <div>Here you can create an assignment for all the available groups.</div>
    
    <form ng-submit="submit()">

        <div class="input_wrapper">
            Title
            <input type="text" class="input_text" ng-model="assignment.title"
                maxlength="80" placeholder="Title (80 characters maximum)"
                ng-change="onChange('e1')"></input>
            <div id="e1" class="error invisible">Error: Please type in the title</div>
        </div>

        <div class="input_wrapper">
            Content<br>
            <textarea cols="95" rows="5" class="input_text content" ng-model="assignment.content"
                 maxlength="800" placeholder="Task (800 characters maximum)"
                ng-change="onChange('e2')"></textarea>
            <div id="e2" class="error invisible">Error: Please type in the task</div>
        </div>

        <div class="input_wrapper">
            Date Submission<br>
            <input type="text" class="input_text date" id="datepicker" ng-model="assignment.date"
                placeholder="Select date" ng-change="onChange('e3')"></input>
            <div id="e3" class="error invisible">Error: Please select a date</div><br>
        </div>

        <div class="input_wrapper">
            <div class="heading2">Group Assessment Assigner</div>
            <div>Here is the table showing the groups that are to be assessing the reports made by another group for this assignment.  Press the Randomise button until you are happy with the listing.</div>
            <div id="randombtn" ng-click="randomise();">Randomise</div>

            <div id="randomsection"></div>

        </div>

        <div class="input_wrapper">
            <button id="submitbtn" type="submit">Create Assignment</button>
        </div>

    </form>


</div>
