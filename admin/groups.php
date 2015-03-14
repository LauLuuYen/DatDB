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

<div class="viewgroups">
    View groups

</div>

