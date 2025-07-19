function beforeProcess() {
    $('.result-card').find('img').attr('src', '');
    setTimeout(function () {
    }, 1000);
    $("#playBtn").html('<i class="la la-gear fa-spin"></i> Processing...');
    $('.showAndarCard').html('');
    $('.showBaharCard').html('');
    $("#playBtn").attr("disabled", true);
}

function success(data) {
    setPopup(data);
    $('.bal').html(data.bal);
    $('#playBtn').html('Play');
    $('#playBtn').attr('disabled', false);
    $('.single-select').removeClass('active');
    $('.single-select').removeClass('op');
    $('.single-select').find('img').removeClass('op');
    $('img').removeClass('op');
}

function successOrError() {
    $(".gmimg").removeClass("op");
    $("#game").find("input").not("input[name=type],input[name=_token]").val("");
    $("button[type=submit]").html("Play");
    $("button[type=submit]").removeAttr("disabled");
    $(".single-select").removeClass("active");
    $(".single-select").removeClass("op");
    $(".single-select").find("img").removeClass("op");
}

function startGame(data) {
    $('#playBtn').html('<i class="la la-gear fa-spin"></i> Playing...');
    $('.result-card').append(`<img src="${imagePath}/${data.randomCard}.png">`);
    $('.ab-card').removeClass('d-none');

    setTimeout(function () {
        $.each(data.andarCards, function (index, value) {
            if (value == undefined) {
                return false;
            }
            setTimeout(function () {
                $('.showAndarCard').append(`<img class="andar-image" src="${imagePath}/${value}.png">`);
            }, index * 1000);

            if (data.baharCards[index] == undefined) {
                return false;
            }
            setTimeout(function () {
                $('.showBaharCard').append(`<img class="bahar-image" src="${imagePath}/${data.baharCards[index]}.png">`);
            }, index * 1000 + 500);
        });

        setTimeout(function () {
            endGame(data);
            successOrError();
        }, data.andarCards.length * 1000 + 1000);
    }, 1000);
}

$(".andar").click(function () {
    $("input[name=choose]").val("andar");
    $(this).addClass("op");
    $(".bahar").removeClass("op");
    playAudio(audioAssetPath, "click.mp3");
});

$(".bahar").click(function () {
    $("input[name=choose]").val("bahar");
    $(this).addClass("op");
    $(".andar").removeClass("op");
    playAudio(audioAssetPath, "click.mp3");
});

$('#game').on('submit', function (e) {
    e.preventDefault();
    playGame($(this).serialize(), "card.mp3");
});
