$(".info-btn").click(function () {
    if ($(".info").hasClass("hide")) {
        $(".info").removeClass("hide");
        $(".info").addClass("show");
    } else {
        $(".info").removeClass("show");
        $(".info").addClass("hide");
    }
});

$(".dice1").click(function () {
    $(this).addClass("op");
    $(".op").addClass("gmimg");
    $(this).removeClass("gmimg");
    $(".gmimg").removeClass("op");
    $("input[name=choose]").val(1);
    playAudio(audioAssetPath, "click.mp3");
});

$(".dice2").click(function () {
    $(this).addClass("op");
    $(".op").addClass("gmimg");
    $(this).removeClass("gmimg");
    $(".gmimg").removeClass("op");
    $("input[name=choose]").val(2);
    playAudio(audioAssetPath, "click.mp3");
});

$(".dice3").click(function () {
    $(this).addClass("op");
    $(".op").addClass("gmimg");
    $(this).removeClass("gmimg");
    $(".gmimg").removeClass("op");
    $("input[name=choose]").val(3);
    playAudio(audioAssetPath, "click.mp3");
});

$(".dice4").click(function () {
    $(this).addClass("op");
    $(".op").addClass("gmimg");
    $(this).removeClass("gmimg");
    $(".gmimg").removeClass("op");
    $("input[name=choose]").val(4);
    playAudio(audioAssetPath, "click.mp3");
});

$(".dice5").click(function () {
    $(this).addClass("op");
    $(".op").addClass("gmimg");
    $(this).removeClass("gmimg");
    $(".gmimg").removeClass("op");
    $("input[name=choose]").val(5);
    playAudio(audioAssetPath, "click.mp3");
});

$(".dice6").click(function () {
    $(this).addClass("op");
    $(".op").addClass("gmimg");
    $(this).removeClass("gmimg");
    $(".gmimg").removeClass("op");
    $("input[name=choose]").val(6);
    playAudio(audioAssetPath, "click.mp3");
});

$("input[type=number]").on("keydown", function (e) {
    if (e.keyCode == 189) {
        return false;
    }
});

function successOrError() {
    $(".dices").find("img").removeClass("op");
    $("#game").find("input").not("input[name=type],input[name=_token]").val("");
    $("button[type=submit]").html("Play Now");
    $("button[type=submit]").removeAttr("disabled");
    $(".single-select").removeClass("active op");
}

function rolling(pos) {
    $("#dice").removeClass("diceRolling");
    $("#dice").addClass("rolling");
    var x = pos.x;
    var y = pos.y;
    var diceFrame = [
        {
            transform: `translateZ(-100px) rotateX(${Math.floor(Math.random() * 360)}deg) rotateY(${Math.floor(Math.random() * 360)}deg) rotateZ(${Math.floor(Math.random() * 360)}deg)`,
        },
        {
            transform: `translateZ(-100px) rotateX(${Math.floor(Math.random() * 360)}deg) rotateY(${Math.floor(Math.random() * 360)}deg) rotateZ(${Math.floor(Math.random() * 360)}deg)`,
        },
        {
            transform: `translateZ(-100px) rotateX(${Math.floor(Math.random() * 360)}deg) rotateY(${Math.floor(Math.random() * 360)}deg) rotateZ(${Math.floor(Math.random() * 360)}deg)`,
        },
        {
            transform: `translateZ(-100px) rotateX(${Math.floor(Math.random() * 360)}deg) rotateY(${Math.floor(Math.random() * 360)}deg) rotateZ(${Math.floor(Math.random() * 360)}deg)`,
        },
        {
            transform: `translateZ(-100px) rotateX(${Math.floor(Math.random() * 360)}deg) rotateY(${Math.floor(Math.random() * 360)}deg) rotateZ(${Math.floor(Math.random() * 360)}deg)`,
        },
        {
            transform: `translateZ(-100px) rotateX(${Math.floor(Math.random() * 360)}deg) rotateY(${Math.floor(Math.random() * 360)}deg) rotateZ(${Math.floor(Math.random() * 360)}deg)`,
        },
        {
            transform: `translateZ(-100px) rotateX(${Math.floor(Math.random() * 360)}deg) rotateY(${Math.floor(Math.random() * 360)}deg) rotateZ(${Math.floor(Math.random() * 360)}deg)`,
        },
        {
            transform: `translateZ(-100px) rotateX(${Math.floor(Math.random() * 360)}deg) rotateY(${Math.floor(Math.random() * 360)}deg) rotateZ(${Math.floor(Math.random() * 360)}deg)`,
        },
        {
            transform: `translateZ(-100px) rotateX(${Math.floor(Math.random() * 360)}deg) rotateY(${Math.floor(Math.random() * 360)}deg) rotateZ(${Math.floor(Math.random() * 360)}deg)`,
        },
        {
            transform: `translateZ(-100px) rotateX(${Math.floor(Math.random() * 360)}deg) rotateY(${Math.floor(Math.random() * 360)}deg) rotateZ(${Math.floor(Math.random() * 360)}deg)`,
        },
        {
            transform: `translateZ(-100px) rotateX(${Math.floor(Math.random() * 360)}deg) rotateY(${Math.floor(Math.random() * 360)}deg) rotateZ(${Math.floor(Math.random() * 360)}deg)`,
        },
        {
            transform: `translateZ(-100px) rotateX(${Math.floor(Math.random() * 360)}deg) rotateY(${Math.floor(Math.random() * 360)}deg) rotateZ(${Math.floor(Math.random() * 360)}deg)`,
        },
        {
            transform: `translateZ(-100px) rotateX(${x}) rotateY(${y}) rotateZ(360deg)`,
        },
    ];
    var diceRef = document.getElementById("dice");
    diceRef.animate(diceFrame, {
        duration: 5000,
        fill: "forwards",
        easing: "linear",
    });
}

function position(data) {
    if (data.result == 1) {
        return { x: "360deg", y: "0deg" };
    } else if (data.result == 2) {
        return { x: "270deg", y: "0deg" };
    } else if (data.result == 3) {
        return { x: "0deg", y: "270deg" };
    } else if (data.result == 4) {
        return { x: "0deg", y: "90deg" };
    } else if (data.result == 5) {
        return { x: "90deg", y: "0deg" };
    } else if (data.result == 6) {
        return { x: "180deg", y: "0deg" };
    }
}

function startGame(data) {
    var pos = position(data);
    rolling(pos);
    $("button[type=submit]").html('<i class="la la-gear fa-spin"></i> Playing...');
    timerA = setInterval(function () {
        successOrError();
        endGame(data);
    }, 5000);
}

function success(data) {
    setPopup(data);
    $(".bal").html(data.bal);
    $(".single-select").removeClass("active op");
}

function beforeProcess() {
    $('#flip').html('<i class="la la-gear fa-spin"></i> Processing...');
    $('#flip').attr('disabled', '');
    $('.cd-ft').html('');
}

$('input[name=invest]').on('keypress', function (e) {
    var character = String.fromCharCode(e.keyCode)
    var newValue = this.value + character;
    if (isNaN(newValue) || hasDecimalPlace(newValue, 3)) {
        e.preventDefault();
        return false;
    }
});

$('#game').on('submit', function (e) {
    e.preventDefault();
    playGame($(this).serialize(), "casino-dice.mp3");
});
