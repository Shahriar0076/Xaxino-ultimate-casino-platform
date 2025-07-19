$(window).on("load", function () {
  $(".flipcoin").removeClass("animate");

  setTimeout(function () {
    $(".flipcoin").addClass("animate");
  }, 1);
});

$(".info-btn").click(function () {
  if ($(".info").hasClass("hide")) {
    $(".info").removeClass("hide");
    $(".info").addClass("show");
  } else {
    $(".info").removeClass("show");
    $(".info").addClass("hide");
  }
});

$("input[type=number]").on("keydown", function (e) {
  if (e.keyCode == 189) {
    return false;
  }
});

$(".head").click(function () {
  $("input[name=choose]").val("head");
  $(this).addClass("active");
  $(".tail").removeClass("active");
  playAudio(audioAssetPath, "click.mp3");
});

$(".tail").click(function () {
  $("input[name=choose]").val("tail");
  $(this).addClass("active");
  $(".head").removeClass("active");
  playAudio(audioAssetPath, "click.mp3");
});

function successOrError() {
  $(".gmimg").removeClass("active");
  $(".game-select-box ").removeClass("active");
  $("#game").find("input").not("input[name=type],input[name=_token]").val("");
  $('#flip').html("Play Now");
  $("#flip").removeAttr("disabled");
}

function flipping() {
  $(".flipcoin").removeClass("animateClick");
  setTimeout(function () {
    $(".flipcoin").addClass("animateClick");
  }, 5);
}

function startGame(data) {
  flipping();
  $('#flip').html('<i class="la la-gear fa-spin"></i> Playing...');
  timerA = setInterval(function () {
    successOrError();
    endGame(data);
  }, 15000);
}

function gameResult(data) {
  if (data.result == "head") {
    $(".headCoin").removeClass("d-none");
    $(".headCoin").find(".front").removeClass("d-none");
    $(".headCoin").find(".back").addClass("d-none");
    $(".tailCoin").addClass("d-none");
    $(".flpng").addClass("d-none");
  } else {
    $(".tailCoin").removeClass("d-none");
    $(".tailCoin").find(".back").addClass("d-none");
    $(".tailCoin").find(".front").removeClass("d-none");
    $(".headCoin").addClass("d-none");
    $(".flpng").addClass("d-none");
  }
}

function success(data) {
  setPopup(data);
  $(".bal").html(data.bal);
  gameResult(data);
}

function beforeProcess() {
  $('.flipcoin').removeClass('animateClick');
  $('.flpng').removeClass('d-none');
  $('#coin .headCoin').addClass('d-none');
  $('#coin .tailCoin').addClass('d-none');
  $('#flip').html('<i class="la la-gear fa-spin"></i> Processing...');
  $('#flip').attr('disabled', true);
}

$('#game').on('submit', function (e) {
  e.preventDefault();
  playGame($(this).serialize(), 'coin.mp3');
});
