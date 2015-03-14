<script>
    function getData(master) {
        showLoading();
        $.ajax({
            type: "GET",
            url:"http://lauluuyen.azurewebsites.net/php/get_allavailablegroups.php" ,
            crossDomain: true,
            dataType: "json",
            async: true,
            timeout: 10000,

            success: function (data) {
                hideLoading();
                console.log(data);
            },

            error: function(xhr, status, error) {
                getData(callback);
            }
        });
    }
</script>

<div>Welcome</div>