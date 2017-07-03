$(document).ready(function () {
    $(".delete_button").click(function () {
        var delete_id = $(this).data('id');
        if (confirm("You are going to delete one record !") == true) {
            // $.ajax({
            //     url: 'delete.php',
            //     type: 'get',
            //     data: {},
            //     success: function (data) {
            //         if (data != 'error') {
            //             $("#" + data).remove();
            //         } else {
            //             alert("Something went wrong");
            //         }
            //     }
            // });/**/

            var $self = $(this);
            $self.prop('disabled', true);
            $self.find('i').removeClass('glyphicon-trash').addClass('glyphicon-refresh');

            $.get('delete.php', {
                'id': delete_id
            }).then(function (response) {
                console.log(response);
                $self.parents('tr').remove();
            }).catch(function (error) {
                console.error(error);

            }).then(function () {
                $self.prop('disabled', false);
                $self.find('i').removeClass('glyphicon-refresh').addClass('glyphicon-trash');
            });
        }
    });
});