<script>
    function getData(callback) {
        showLoading();
        $.ajax({
            type: "GET",
            url:"http://lauluuyen.azurewebsites.net/php/get_threads.php" ,
            crossDomain: true,
            dataType: "json",
            async: true,
            timeout: 25000,

            success: function (data) {
                hideLoading();
                callback(data["forum"]);
            },

            error: function(xhr, status, error) {
                getData(callback);
            }
        });
    }
</script>
<div class="forum">

    <div class="heading">Group Forum</div>

    <div class="linebreak"></div>

    <div class="container">
        <span>
            Search box:<br>
            <input type="text" id="query" ng-model="query"/>

        </span>
        <span class="newthread" ng-click="newThread();">
            + New Thread
        </span>
    </div>

    <ul id="container">
        <li ng-repeat="thread in threads | filter:query | orderBy: orderList">
            <div class="item" ng-click="viewThread(thread.threadID);">
                <div class="_left">
                    <div class="title">{{thread.title}}</div>
                    <div class="date">Last Post: {{thread.fullname}} at {{thread.timestamp}}</div>
                </div>
                <div class="_right">
                    <div class="n">{{thread.count}}</div>
                    <div class="post">Post(s)</div>
                </div>
            </div>
        </li>
    </ul>


</div>
