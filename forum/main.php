<script>
    function getData(callback) {
        showLoading();
        $.ajax({
            type: "GET",
            url:"http://lauluuyen.azurewebsites.net/php/get_threads.php" ,
            crossDomain: true,
            dataType: "json",
            async: true,
            timeout: 10000,

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

    <div class="newthread" ng-click="newThread();">
        + New Thread
    </div>

    
    <div class="container">
        <div dynamic="itemlist"></div>

    </div>

<div id="notebooks">

    <input type="text" id="query" ng-model="query"/>
    <select ng-model="orderList">
        <option value="name">By name</option>
        <option value="-age">Newest</option>
        <option value="age">Oldest</option>
    </select>
        <!--
        <li ng-repeat="notebook in notebooks | filter:query | orderBy: orderList">
          name: {{notebook.name}}<br/>
        </li>
        -->

    <ul id="container">
        <li ng-repeat="thread in threads">
            <div class="item" ng-click="viewThread(thread.threadID);">
                <div class="_left">
                    <div class="title">{{thread.title}}</div>
                    <div class="date">Last post: {{thread.fullname}} at {{thread.timestamp}}</div>
                </div>
                <div class="_right">
                    <div class="n">{{thread.count}}</div>
                    <div class="post">Post(s)</div>
                </div>
            </div>
        </li>
    </ul>

</div>


</div>