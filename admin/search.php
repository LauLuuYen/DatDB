<script>

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

<div class="searchusers">

    <div class="container">
        <span>
            Search box:<br>
            <input type="text" id="query" ng-model="query"/>

        </span>
    </div>


    <table class="randomtable">
        <tr class="head">
            <td>UserID</td>
            <td>Name</td>
            <td>Lastname</td>
            <td>Email</td>
            <td>GroupID</td>
            <td>Created</td>
        </tr>
    </table>
<!--
        {id:43, name:"linlkf", lastname:"fhsf", email:"sglj2@xv.om", groupid:32, created:"sdlnsg sdo foid"},-->
    <ul id="container">
        <li ng-repeat="user in users | filter:query | orderBy: orderList">
            {{user.name}}
            
            <!--
            <div class="item" ng-click="viewThread(thread.threadID);">
                <div class="_left">
                    <div class="title">{{thread.title}}</div>
                    <div class="date">Last post: {{thread.fullname_l}} at {{thread.timestamp}}</div>
                </div>
                <div class="_right">
                    <div class="n">{{thread.count}}</div>
                    <div class="post">Post(s)</div>
                </div>
            </div>
            -->
        </li>
    </ul>

</div>

