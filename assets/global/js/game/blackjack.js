function game(data, url) {
    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        url: url,
        method: "POST",
        data: data,
        success: function (data) {
            if (data.error) {
                notify("error", data.error);
                playButton();
                return false;
            }
            if (data.errors) {
                notify("error", data.errors);
                playButton();
                return false;
            }
            resultArea(data);
            $("#game-start-area").addClass("d-none");
            $("#game-result-area").removeClass("d-none");
        },
    });
}

function playButton() {
    $('.play-btn').html('PlayNow');
    $('.play-btn').attr('disabled', false);
}

function hitAction(url, data) {
    data['type'] = 'hit';
    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        url: url,
        data: data,
        method: "POST",
        success: function (data) {
            hitArea(data);
        },
    });
}

function stayAction(url, data) {
    data['type'] = 'stay';
    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        url: url,
        data: data,
        method: "POST",
        success: function (data) {
            stayArea(data);
        },
    });
}
