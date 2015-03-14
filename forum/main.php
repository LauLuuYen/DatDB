<script>
    function getData(callback) {
        showLoading();
        $.ajax({
            type: "GET",
            url:"http://lauluuyen.azurewebsites.net/php/get_forum.php" ,
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

</div>