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

    </div>


</div>
