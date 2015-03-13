<script>
    $(function() {
        $( "#datepicker" ).datepicker({
            changeMonth: true,
            changeYear: true
        });
    });

</script>

<div class="createassignment">
    <div class="heading">Create Assignment</div>

    <div class="linebreak"></div>

    <div>Here you can create an assignment for all the available groups.</div>
    
  <form ng-submit="submit()">
    
        <div class="input_wrapper">
            Title
            <input type="text" class="input_text" ng-model="assignment.title">
        </div>
        
        <div class="input_wrapper">
            Content <br>
            <textarea cols="95" rows="5" class="input_text content" ng-model="assignment.content"></textarea>
        </div>
	
	<p>Date: <input type="text" id="datepicker" ng-model="assignment.date"></p>


    </form>


    <button ng-click="randomise();">Randomise</button>

    <div id="randomsection">

        <table class="randomtable">
            <tr class="head">
                <td>Group</td>
                <td>Assessment 1</td>
                <td>Assessment 2</td>
                <td>Assessment 3</td>
            </tr>
            <tr class="r0">
                <td>Jill</td>
                <td>Smith</td>		
                <td>50</td>
                <td>50</td>
            </tr>
            <tr class="r1">
                <td>Eve</td>
                <td>1</td>
                <td>Jackson</td>		
                <td>94</td>
            </tr>
            <tr class="r0">
                <td>John</td>
                <td>1</td>
                <td>Doe</td>		
                <td>80</td>
            </tr>
        </table>
    </div>


</div>
