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
    <div class="heading">Search User</div>
    <div class="linebreak"></div>
    <div class="container">
    <br>
    <div>This page shows all student accounts. Students can be searched by their UserID, Name, Lastname, Email and GroupID.</div>
    <br>
    
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
        </tr>

        <tr class="r0" ng-repeat="user in users | filter:query">
            <td>{{user.userID}}</td>
            <td>{{user.name}}</td>
            <td>{{user.lastname}}</td>
            <td>{{user.email}}</td>
            <td>{{user.groupID}}</td>
        </tr>

    </table>
</div>

