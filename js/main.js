$(function () {

// Ajax globals
    $(document).ajaxStart(function () {
        $('#loading').show();
    });
    $(document).ajaxStop(function () {
        $('#loading').hide();
    });

// Voting ajax
    $('div.votes span.vote').click(function (e) {
        e.preventDefault();

        var item = $(this);

        jQuery.post('ajax/vote.php', $(item).data(), function (data, status) {
            if (status === 'success') {
                if (typeof data === 'object') {
                    $(item).siblings('span.votes').html(data.upvotes - data.downvotes);
                } else {
                    $('#too-many-votes').modal();
                }
            }
        }, 'json');
    });

});