$(function () {

// Ajax globals
    $(document).ajaxStart(function () {
        $('#loading').show();
    });
    $(document).ajaxStop(function () {
        $('#loading').hide();
    });

// Voting ajax
    $('div.votes').on('click', 'span.vote', function (e) {
        e.preventDefault();

        var item = $(this);

        jQuery.post('ajax/vote.php', $(item).data(), function (data, status) {
            if (status === 'success') {
                if (data.hasOwnProperty('message')) {
                    if (data.type === 'recycle') {
                        $(item).parents('div.movie').removeClass('voted');
                        var votes = parseInt($(item).siblings('span.votes').html()) - 1;
                        $(item).siblings('span.votes').html(votes);
                        $(item).remove();
                        $('#votes-used').html(parseInt($('#votes-used').html()) - 1);
                    } else {
                        $('#too-many-votes div.modal-body').html("<p>" + data.message + "</p>");
                        $('#too-many-votes').modal();
                    }
                } else {
                    $(item).siblings('span.votes').html(data.upvotes - data.downvotes);
                    $(item).parents('div.movie').addClass('voted');
                    $(item).parents('div.votes').append('<span class="vote recycle" title="Recycle this vote" data-vote="recycle" data-id="' + $(item).data('id') + '"><span class="glyphicon glyphicon-refresh"></span></span>');
                    $('#votes-used').html(parseInt($('#votes-used').html()) + 1);
                }
            }
        }, 'json');
    })

// Vote counter scrolling
    $('#votes-used-wrapper').scrollToFixed({
        marginTop: 10
    });

});