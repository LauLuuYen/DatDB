<script>

    function getData(callback) {
        showLoading();
        $.ajax({
            type: "GET",
            url:"http://lauluuyen.azurewebsites.net/php/get_allgroupstats.php" ,
            crossDomain: true,
            dataType: "json",
            async: true,
            timeout: 10000,

            success: function (data) {
                hideLoading();
                callback(data[""]);
            },

            error: function(xhr, status, error) {
                getData(callback);
            }
        });
    }
/*
    function getData(callback) {
        showLoading();
        $.ajax({
            type: "GET",
            url:"http://lauluuyen.azurewebsites.net/php/get_allassignments.php" ,
            crossDomain: true,
            dataType: "json",
            async: true,
            timeout: 10000,

            success: function (data) {
                console.log("loading: 1/1");
                getData2(data, callback);
               
            },

            error: function(xhr, status, error) {
                getData(callback);
            }
        });
    }
*/
</script>

<div class="viewall">
    <div class="heading">View All</div>
    <div class="linebreak"></div>

    <div class="heading2">All Groups</div>
    <table class="randomtable">
        <tr class="head">
            <td>ID</td>
            <td>Group Name</td>
        </tr>
        <tr class="r0" ng-repeat="group in groups">
            <td>{{group.groupID}}</td>
            <td>{{group.groupname}}</td>
        </tr>
    </table>
         "id":3122,
         "groupid":21,
         "status":"Incomplete",
         "feedback":"",
         "userid":"",
         "timestamp":""
    <br>
    <div class="heading2">All Reports</div>
    <table class="randomtable">
        <tr class="head">
            <td>ID</td>
            <td>GroupID</td>
            <td>Status</td>
            <td>Content</td>
            <td>UserID</td>
            <td>Timestamp</td>
        </tr>
        <tr class="r0" ng-repeat="report in reports">
            <td>{{report.id}}</td>
            <td>{{report.groupid}}</td>
            <td>{{report.status}}</td>
            <td>{{report.content}}</td>
            <td>{{report.userid}}</td>
            <td>{{report.timestamp}}</td>
        </tr>
    </table>
</div>

