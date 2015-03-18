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

    function formatList(list) {
        var data = [];
        for (i =0; i<list.length ; i++) {
            data.push(list[i].groupname);
        }
        return data;
    }

    function getData(callback) {
        showLoading();
        $.ajax({
            type: "GET",
            url:"http://lauluuyen.azurewebsites.net/php/get_allgroups.php" ,
            crossDomain: true,
            dataType: "json",
            async: true,
            timeout: 25000,

            success: function (data) {
                hideLoading();
                var d = formatList(data["grouplist"]);
                callback(d);
            },

            error: function(xhr, status, error) {
                getData(callback);
            }
        });
    }

</script>

<div class="createassignment">
    <div class="heading">Create Assignment</div>

    <div class="linebreak"></div>

    <div>Here, an adminstrator can create an assignment for all the available groups. The adminstrator needs to give an assignment a title, a content and a deadline. Which groups that assessess each other is randomly determined, but the adminstrator can re-randomize the list if they wish to do so.</div>
    <br>
    <form ng-submit="submit()">

        <div class="input_wrapper">
            Assignment Title
            <input type="text" class="input_text" ng-model="assignment.title"
                maxlength="80" placeholder="Title (80 characters maximum)"
                ng-change="onChange('e1')"></input>
            <div id="e1" class="error invisible">Error: Please type in the title</div>
        </div>

        <div class="input_wrapper">
            Assignment Content<br>
            <textarea cols="95" rows="5" class="input_text content" ng-model="assignment.content"
                 maxlength="800" placeholder="Task (800 characters maximum)"
                ng-change="onChange('e2')"></textarea>
            <div id="e2" class="error invisible">Error: Please type in the task</div>
        </div>

        <div class="input_wrapper">
            Assignment Deadline<br>
            <input type="text" class="input_text date" id="datepicker" ng-model="assignment.date"
                placeholder="Select date" ng-change="onChange('e3')"></input>
            <div id="e3" class="error invisible">Error: Please select a date</div><br>
        </div>

        <div class="input_wrapper">
            <div class="heading2">Group Assessment Assigner</div>
            <div>Here is the table showing the groups that are to be assessing the reports made by another group for this assignment.  Press the Randomise button until you are happy with the listing.</div>
            <br>
            <div id="randombtn" ng-click="randomise();">Randomise</div>

            <div id="randomsection"></div>

        </div>

        <div class="input_wrapper">
            <button class="submitbtn" type="submit">Create Assignment</button>
        </div>

    </form>


</div>
