$(".info-btn").click(function () {
    if ($(".info").hasClass("hide")) {
        $(".info").removeClass("hide");
        $(".info").addClass("show");
    } else {
        $(".info").removeClass("show");
        $(".info").addClass("hide");
    }
});

$(".black").click(function () {
    $("input[name=choose]").val("black");
    $(this).addClass("op");
    $(".red").removeClass("op");
    playAudio(audioAssetPath, "click.mp3");
});

$(".red").click(function () {
    $("input[name=choose]").val("red");
    $(this).addClass("op");
    $(".black").removeClass("op");
    playAudio(audioAssetPath, "click.mp3");
});

function beforeProcess() {
    if ($(".flying").hasClass("d-none")) {
        $("#cards").removeClass("op");
        $(".res").addClass("d-none");
    }
    $("#playBtn").html('<i class="la la-gear fa-spin"></i> Processing...');
    $("#playBtn").attr("disabled", true);
}

function animationCard(data) {
    $('.flying').addClass('d-none');
    $('#cards').removeClass('d-none');
    deck.sort()
    deck.sort()
    deck.sort()
    deck.sort()
    deck.sort()
    deck.sort()
    deck.fan()
    var img = `${imagePath}/${card(data.result)}.png`;
    setTimeout(function () {
        $('.resImg').find('img').attr('src', img)
        $('#cards').addClass('op');
        $('.res').removeClass('d-none');
    }, 10110);
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
    animationCard(data);
    $('#playBtn').html('<i class="la la-gear fa-spin"></i> Playing...');
    timerA = setInterval(function () {
        successOrError();
        endGame(data);
    }, 10110);
    $('#playBtn').html('<i class="la la-gear fa-spin"></i> Playing...');
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

function card(res) {
    if (res == "RED") {
        var blackCard = ["01", "2", "03", "05", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27"];
        var card = blackCard[Math.floor(Math.random() * blackCard.length)];
    } else {
        var redCard = ["28", "29", "30", "31", "32", "33", "34", "35", "36", "37", "38", "39", "40", "41", "42", "43", "44", "45", "46", "47", "48", "49", "50", "51", "52", "53"];
        var card = redCard[Math.floor(Math.random() * redCard.length)];
    }
    return card;
}

$('input[name=invest]').keypress(function (e) {
    var character = String.fromCharCode(e.keyCode)
    var newValue = this.value + character;
    if (isNaN(newValue) || hasDecimalPlace(newValue, 3)) {
        e.preventDefault();
        return false;
    }
});

$('#game').on('submit', function (e) {
    e.preventDefault();
    playGame($(this).serialize(), "card.mp3");
});
