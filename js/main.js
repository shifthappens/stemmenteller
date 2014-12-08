(function($){
    $('.sortr').sortr({ ignore: 'th.sortr-nonsortable' });
    $('#movie-name-for-showings').on('change', getShowings).trigger('change');
    $('.btn-delete').on('click', confirmDeletion);
    $('.toggleactions').on('click', toggleActionsColumn);
})(jQuery);

function getShowings(event, c)
{
    if($(event.target).val() == "NULL" || $(event.target).val() == "")
        return;

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

function confirmDeletion(event)
{
    if(!confirm('Weet je het zeker? Dit kan niet ongedaan worden gemaakt!'))
        return false;
}

function toggleActionsColumn(event)
{
    $('th.actions-th, td.actions').toggle();
    $('th.star-th, td.movie-can-win').toggle();
    $('th.totalvotes-th, td.movie-totalvotes').toggle();
    $('#ahide, #ashow').toggle();
}