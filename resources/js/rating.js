$(document).ready(function () {
    $('.rating__input').click(function () {
        $.ajax({
            type: 'POST',
            url: '/rating',
            data: {
                point: $(this).val(),
                movie_id: $('#movie_id').val(),
                _token: $('meta[name="csrf-token"]').attr('content')
            },
        });
    });
});
