<script>
    function getData(callback) {
        showLoading();
        $.ajax({
            type: "GET",
            url:"http://lauluuyen.azurewebsites.net/php/get_assignments.php" ,
            crossDomain: true,
            dataType: "json",
            async: true,
            timeout: 10000,

            success: function (data) {
                hideLoading();
                callback(data["assignments"]);
            },

            error: function(xhr, status, error) {
                getData(callback);
            }
        });
    }
</script>
<div>

    

</div>