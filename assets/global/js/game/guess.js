var bon;

function color() {
  var myArray = [
    "#0060651a",
    "#654f001a",
    "#6500001a",
    "#5f00651a",
    "#000c651a",
    "#0057651a",
  ];
  var randomItem = myArray[Math.floor(Math.random() * myArray.length)];
  return randomItem;
}

function beforeProcess() {
  return true;
}

function start() {
  $(".gmg").html('<i class="la la-gear fa-spin"></i> Processing...');
  $("button[type=submit]").attr("disabled", "");
}

function gameEnd(percent) {
  $("input[name=number]").val("");
  $("input[name=game_log_id]").val("");
  $("input[name=invest]").val("");
  $(".invBtn").removeClass("d-none");
  $(".my-submit-btn").removeClass("d-none");
  $(".my-submit-btn").html("Start Game");
  $(".bon").html(`${percent}%`);
  if ($(".numberGs").hasClass("numHide")) {
    $(".numberGs").removeClass("numHide");
    $(".numberGs").addClass("numShow");
  } else {
    $(".numberGs").removeClass("numShow");
    $(".numberGs").addClass("numHide");
  }
  $(".bal-card").removeClass("d-none");
  $(".min").removeClass("d-none");
  $(".inp").removeClass("d-none");
  $(".balan").addClass("d-none");
  $(".bons").removeClass("d-none");
  $(".chance-card").addClass("col-md-6");
  $(".chance-card").removeClass("col-md-8 col-sm-8");
  $(".up").addClass("d-none");
  $(".down").addClass("d-none");
  $(".amf").show();
}

function play(data) {
  $(".overlay").css("background", color());
  $(".gmg").html("Guess The Number");
  $("button[type=submit]").removeAttr("disabled");
  $(".text").find("h2").html(data.message);

  if ((data.win_status == 1 || data.win_status == 0) && data.gameSt == 1) {
    setPopup(data);
    if (data.demo_win_amount) {
      let demoAmountHtml = `<h6>Win amount ${data.demo_win_amount}</h6>`;
      $('.win-loss-popup__footer').find('.demoAmount').html(demoAmountHtml);
    }
  }
  if (data.type == 0 && data.gameSt != 1) {
    $(".up").removeClass("d-none");
    $(".down").addClass("d-none");
  }
  if (data.type == 1 && data.gameSt != 1) {
    $(".up").addClass("d-none");
    $(".down").removeClass("d-none");
  }
  $(".bal").html(data.bal);
}

function successOrError() {
  $(".gmimg").removeClass("op");
  $("#game").find("input").not("input[name=type],input[name=_token]").val("");
  $("button[type=submit]").html("Start Game");
  $("button[type=submit]").removeAttr("disabled");
  $("input[name=invest]").removeAttr("readonly");
}

function startGame(data) {
  $(".amf").hide();
  $("button[type=submit]").html("Guess The Number");
  $("button[type=submit]").removeAttr("disabled");
  $(".invBtn").addClass("d-none");
  $(".my-submit-btn").addClass("d-none");
  $("input[name=game_log_id]").val(data.game_log_id);
  $(".bal").html(data.balance);
  if ($(".numberGs").hasClass("numHide")) {
    $(".numberGs").removeClass("numHide");
    $(".numberGs").addClass("numShow");
  } else {
    $(".numberGs").removeClass("numShow");
    $(".numberGs").addClass("numHide");
  }
  $(".bal-card").addClass("d-none");
  $(".min").addClass("d-none");
  $(".inp").addClass("d-none");
  $(".balan").addClass("d-none");
  $(".bons").removeClass("d-none");
  $(".chance-card").removeClass("col-md-6");
  $(".chance-card").addClass("col-md-8 col-sm-8");
}

function start(data, bon) {
  $.ajax({
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
    url: gameEndUrl,
    method: "POST",
    data: data,
    success: function (data) {
      if (checkErrors(data) == true) {
        return false;
      }
      if (data.gameSt == 1) {
        gameEnd(bon);
      } else {
        $(".bon").html(data.data);
      }
      play(data);
    },
  });
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
  playGame($(this).serialize(), 'click.mp3');
});

$('#start').on('submit', function (e) {
  e.preventDefault();
  playAudio(audioAssetPath, 'click.mp3');
  var data = $(this).serialize();
  start(data, bon);
});
