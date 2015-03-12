<div class="submitreport">
    <div class="heading">Submit/ View Report</div>

    <div class="linebreak"></div>

    <div>In this section, you can view your assignment tasks and submit your report!</div>

    <div class="input_wrapper">
        <div class="heading2">Please pick your assignment:</div>
        <select class="input_text" ng-model="report" ng-options="item.name for item in assignments"></select>
        
    </div>

    <div class="input_wrapper">
        <div class="heading2">Task:</div>
        <div>Your task is to do this and that...</div>
    </div>

    <div class="input_wrapper">
        <div class="heading2">Group Report:</div>
        <div>Status: Incomplete<div>
        <div>Uploaded by: Yo mama</div>

        <div class="fullreport"></div>

        <div> <!--Only in draft, show-->
            <div>Press submit to finalise the report</div>
            <button ng-click="submit()">Submit</button>
        </div><br>

    </div>

    <div class="input_wrapper">
        <div class="heading2">Upload/ Update your Group Report:</div>

        <div class="upload">
            <form enctype="multipart/form-data" ng-submit="send()">
                <input id="uploadfile" name="myFile" type="file" accept=".xml"></input>
                <div class="error">Error: {{feedback}}</div>
                <button id="btn_uploadfile" type="submit" disabled>Upload</button>
                <div class="clean"></div>
            </form>
        </div>
    </div>



</div>