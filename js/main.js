(function($){
    $('.sortr').sortr({ ignore: 'th.sortr-nonsortable' });
    $('#movie-name-for-showings').on('change', getShowings);
})(jQuery);

function getShowings(event, c)
{
    $.post('admin/ajax_get_showings_for_movie', 
    {
        movie_id: $(event.target).val()
    }, populateShowings);
}

function populateShowings(response)
{
    var select = $('#showing-ids');
    select.prop('disabled', false);
    select.children().remove();
    select.append(response);
}