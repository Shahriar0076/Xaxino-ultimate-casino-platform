$(".info-btn").click(function () {
    if ($(".info").hasClass("hide")) {
        $(".info").removeClass("hide");
        $(".info").addClass("show");
    } else {
        $(".info").removeClass("show");
        $(".info").addClass("hide");
    }
});

function sloting(pos1) {
    var slot = [
        {
            transform: "rotateX(324deg)",
        },
        {
            transform: "rotateX(-900deg)",
        },
        {
            transform: "rotateX(-1260deg)",
        },
        {
            transform: "rotateX(-1584deg)",
        },
        {
            transform: `rotateX(${pos1}deg)`,
        },
    ];

    var slotRef = document.getElementById("slot1");
    slotRef.animate(slot, {
        duration: 10000,
        fill: "forwards",
        easing: "linear",
        iterationCount: 1,
    });
}

function sloting2(pos2) {
    var slot = [
        {
            transform: "rotateX(324deg)",
        },
        {
            transform: "rotateX(-900deg)",
        },
        {
            transform: "rotateX(-1260deg)",
        },
        {
            transform: "rotateX(-1584deg)",
        },
        {
            transform: `rotateX(${pos2}deg)`,
        },
    ];

    var slotRef = document.getElementById("slot2");
    slotRef.animate(slot, {
        duration: 12000,
        fill: "forwards",
        easing: "linear",
        iterationCount: 1,
    });
}

function sloting3(pos3) {
    var slot = [
        {
            transform: "rotateX(324deg)",
        },
        {
            transform: "rotateX(-900deg)",
        },
        {
            transform: "rotateX(-1260deg)",
        },
        {
            transform: "rotateX(-1584deg)",
        },
        {
            transform: `rotateX(${pos3}deg)`,
        },
    ];

    var slotRef = document.getElementById("slot3");
    slotRef.animate(slot, {
        duration: 13000,
        fill: "forwards",
        easing: "linear",
        iterationCount: 1,
    });
}

function successOrError() {
    $(".dices").find("img").removeClass("op");
    $("#game").find("input").not("input[name=type],input[name=_token]").val("");
    $("button[type=submit]").html("Play Now");
    $("button[type=submit]").removeAttr("disabled");
}

function posSlot1(slot1) {
    if (slot1 == 1) {
        return -72;
    }
    if (slot1 == 2) {
        return -108;
    }
    if (slot1 == 3) {
        return -144;
    }
    if (slot1 == 4) {
        return -180;
    }
    if (slot1 == 5) {
        return -216;
    }
    if (slot1 == 6) {
        return -252;
    }
    if (slot1 == 7) {
        return -288;
    }
    if (slot1 == 8) {
        return -324;
    }
    if (slot1 == 9) {
        return -360;
    }
    if (slot1 == 0) {
        return -396;
    }
}

function posSlot2(slot2) {
    if (slot2 == 1) {
        return -1152;
    }
    if (slot2 == 2) {
        return -1188;
    }
    if (slot2 == 3) {
        return -1224;
    }
    if (slot2 == 4) {
        return -1260;
    }
    if (slot2 == 5) {
        return -1296;
    }
    if (slot2 == 6) {
        return -1332;
    }
    if (slot2 == 7) {
        return -1368;
    }
    if (slot2 == 8) {
        return -324;
    }
    if (slot2 == 9) {
        return -360;
    }
    if (slot2 == 0) {
        return -396;
    }
}

function posSlot3(slot3) {
    if (slot3 == 1) {
        return -1152;
    }
    if (slot3 == 2) {
        return -1188;
    }
    if (slot3 == 3) {
        return -1224;
    }
    if (slot3 == 4) {
        return -1260;
    }
    if (slot3 == 5) {
        return -1296;
    }
    if (slot3 == 6) {
        return -1332;
    }
    if (slot3 == 7) {
        return -1368;
    }
    if (slot3 == 8) {
        return -324;
    }
    if (slot3 == 9) {
        return -360;
    }
    if (slot3 == 0) {
        return -396;
    }
}

function startGame(data) {
    var pos1 = posSlot1(data.result[0]);
    var pos2 = posSlot2(data.result[1]);
    var pos3 = posSlot3(data.result[2]);
    sloting(pos1);
    sloting2(pos2);
    sloting3(pos3);
    $("button[type=submit]").html('<i class="la la-gear fa-spin"></i> Playing...');
    timerA = setInterval(function () {
        successOrError();
        endGame(data);
    }, 13000);
}

function success(data) {
    setPopup(data);
    $(".bal").html(data.bal);
}

$('input[name=invest]').keypress(function (e) {
    var character = String.fromCharCode(e.keyCode)
    var newValue = this.value + character;
    if (isNaN(newValue) || hasDecimalPlace(newValue, 3)) {
        e.preventDefault();
        return false;
    }
});

function beforeProcess() {
    $('button[type=submit]').html('<i class="la la-gear fa-spin"></i> Processing...');
    $('button[type=submit]').attr('disabled', '');
    $('.alert').remove();
}

$('#game').on('submit', function (e) {
    e.preventDefault();
    playGame($(this).serialize(), "number-slot.mp3");
});
