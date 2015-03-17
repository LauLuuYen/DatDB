<script>
    function getData(callback) {
        showLoading();
        $.ajax({
            type: "GET",
            url:"http://lauluuyen.azurewebsites.net/php/get_assignmentreports.php" ,
            crossDomain: true,
            dataType: "json",
            async: true,
            timeout: 10000,

            success: function (data) {
                hideLoading();
                callback(data["assignments"]);
            },

            error: function(xhr, status, error) {
                getData(callback);
            }
        });
    }
</script>

<div class="submitreport">
    <div class="heading">Submit/ View Report</div>

    <div class="linebreak"></div>

    <div>In this section, you can view your assignment tasks and submit your report!</div>

    <div class="input_wrapper">
        <div class="heading2">Please pick your assignment:</div>
        <select class="input_text" ng-model="selection" ng-options="item.name for item in list" ng-change="selectAssignment()"></select>
        
    </div>

    <div id="submission" class="conceal">

        <div class="input_wrapper">
            <div class="heading2">Task:</div>
            <div id="task"></div>
            <div>Deadline: <span id="deadline"></span></div>
            <div>Status: <span id="status"></span><div>

        </div>

        <div id="report" class="input_wrapper conceal">
            <div class="heading2">Group Report:</div>

            <div class="fullreport"></div>
            <div>Uploaded by: <span id="name"></span></div>

            <div id="submitsection" class="finalise">
                <div>Press submit to finalise the report</div>
                <button class="finalsubmit" ng-click="submit()">Submit</button>
            </div>
            <div class="clean"></div>
        </div>

        <div id="uploadsection" class="input_wrapper">
            <br><div class="heading2">Upload your Group Report:</div>
            <div>You can upload or update your group report as much you like until the deadline or
                when you finalise the report after uploading it.
            <div class="upload">
                <form enctype="multipart/form-data" ng-submit="send()">
                    <input id="uploadfile" name="myFile" type="file" accept=".xml"></input>
                    <div class="error invisible">Error:</div>
                    <button id="btn_uploadfile" type="submit" disabled>Upload</button>
                    <div class="clean"></div>
                </form>
            </div>

            <div class="heading2">Report Guidelines:</div>
            <div>
                You can upload your report in <b>"txt"<b> format or <b>"xml"<b> format. Maximum length of your report is <b>5000 characters<b>. Maximum file size is <b>5MB<b>.
                If you submit your report in xml format, please put your report between the opening tag <b>&ltContent&gt<b> and the closing tag <b>&lt/Content&gt<b>. 
                An example is shown below for clarification. 
            </div>
            <div>
                <br>
                <img src="../img/xmlguidelinesmall.png" alt="xmlguidelinesmall.png" width="60%">
                <br>
            </div>
        </div>

    </div>


</div>
