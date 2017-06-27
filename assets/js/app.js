$(document).ready(function(){
    $(".delete_button").click(function(){
        var delete_id=$(this).attr('data-id');
        if (confirm("You are going to delete one record !") == true) {
            $.get("delete.php",{
                delete_key: delete_id
            });

        }
    });
});