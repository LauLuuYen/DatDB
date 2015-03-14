<script>
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
                console.log("loading: 1/3");
                getData2(data, callback);
               
            },

            error: function(xhr, status, error) {
                getData(callback);
            }
        });
    }

    function getData2(data1, callback) {
        $.ajax({
            type: "GET",
            url:"http://lauluuyen.azurewebsites.net/php/get_allavailablegroups.php" ,
            crossDomain: true,
            dataType: "json",
            async: true,
            timeout: 10000,

            success: function (data) {
                console.log("loading: 2/3");
                getData3(data1, data, callback);
            },

            error: function(xhr, status, error) {
                getData2(data1, callback);
            }
        });
    }

    function getData3(data1, data2, callback) {
        $.ajax({
            type: "GET",
            url:"http://lauluuyen.azurewebsites.net/php/get_allgroupstats.php" ,
            crossDomain: true,
            dataType: "json",
            async: true,
            timeout: 10000,

            success: function (data) {
                console.log("loading: 3/3");
                hideLoading();
                callback(data1, data2, data);
            },

            error: function(xhr, status, error) {
                getData3(data1, data, callback);
            }
        });
    }
</script>

<div>Welcome</div>