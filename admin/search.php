<script>


    function getData(callback) {
        showLoading();
        $.ajax({
            type: "GET",
            url:"http://lauluuyen.azurewebsites.net/php/get_allusers.php" ,
            crossDomain: true,
            dataType: "json",
            async: true,
            timeout: 25000,

            success: function (data) {
                hideLoading();
                callback(data["users"]);

            },

            error: function(xhr, status, error) {
                getData(callback);
            }
        });
    }

</script>

<div class="searchusers">
    <div class="heading">Search Student</div>
    <div class="linebreak"></div>
    </br>
    <div>This page shows all student accounts. Students can be searched by their UserID, Name, Lastname, Email and GroupID.</div>
    </br>

    <div class="input_wrapper">
        <span>
            <div class="heading2">Search box:</div>
            <input type="text" id="query" class="input_text" style="width:300px" ng-model="query" ></input>

        </span>
    </div>


    <table class="randomtable">
        <tr class="head">
            <td>UserID</td>
            <td>Name</td>
            <td>Lastname</td>
            <td>Email</td>
            <td>GroupID</td>
        </tr>

        <tr class="r0" ng-repeat="user in users | filter:query">
            <td>{{user.userID}}</td>
            <td>{{user.name}}</td>
            <td>{{user.lastname}}</td>
            <td>{{user.email}}</td>
            <td>{{user.groupID}}</td>
        </tr>

    </table>
    <br>
    <form class="cpw" ng-submit="submit()">
        <div class="input_wrapper">
            <div class="heading2">Delete User by ID</div>
            <input type="number" class="input_text" placeholder="userID" ng-change="onChange('e1')" ng-model="user.id"></input>
            <div id="e1" class="error invisible">Error: Please type in a valid number</div>
        </div>
        <button id="submit" type="submit">Delete</button>
    </form>
</div>

