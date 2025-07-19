let investUrl;
let gameEndUrl;
let winLossPopupFooterDisplay = true;

function hasDecimalPlace(value, x) {
    var pointIndex = value.indexOf('.');
    return pointIndex >= 0 && pointIndex < value.length - x;
}

function gameFinish(data, timerA) {
    clearInterval(timerA);
    setTimeout(function () {
        success(data);
    }, 1800);
}

function complete(data) {
    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        url: gameEndUrl,
        method: "POST",
        data: { game_log_id: data.game_log_id },
        success: function (data) {
            if (checkErrors(data) == true) {
                audioPause();
                isRequest = false;
                return false;
            }
            gameFinish(data, timerA);
            isRequest = false;
        },
    });
}

function endGame(data) {
    if (audioSound == 'true') {
        audio.pause();
    }
    complete(data);
}

function game(data) {
    isRequest = true;
    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        url: investUrl,
        method: "POST",
        data: data,
        success: function (data) {
            if (checkErrors(data) == true) {
                audioPause();
                isRequest = false;
                return false;
            }
            $(".bal").text(data.balance); 
            startGame(data);
        }
    });
}

function playGame(data, music) {
    playAudio(audioAssetPath, music);
    beforeProcess();
    game(data);
}

// permanent code
// --------------------------------
function setPopup(data) {
    $(".win-loss-popup").addClass("active");
    $(".win-loss-popup__body").find("img").addClass("d-none");
    if (data.win_status == 0) {
        $(".win-loss-popup__body").find(".lose").removeClass("d-none");
        playAudio(audioAssetPath, "lose.wav");
    } else {
        $(".win-loss-popup__body").find(".win").removeClass("d-none");
        playAudio(audioAssetPath, "win.wav");
    }
    if (data.result && winLossPopupFooterDisplay) {
        $(".win-loss-popup__footer").find(".data-result").text(data.result);
    }else{
        $(".win-loss-popup__footer").addClass("d-none");
    }
}

function checkErrors(data) {
    if (data.errors) {
        notify("error", data.errors);
        successOrError();
        return true;
    }
    if (data.error) {
        notify("error", data.error);
        successOrError();
        return true;
    }
}
