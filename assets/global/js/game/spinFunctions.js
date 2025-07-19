function startGame(data) {
  startSpin(data);
  $('#flip').html('<i class="la la-gear fa-spin"></i> Playing...');
  timerA = setInterval(function () {
    successOrError();
    endGame(data);
  }, 10000);
}

function startSpin(data) {
  playingAnimation();
  setpoint(data);
  theWheel.startAnimation();
  wheelSpinning = true;
}

function winnerPoint(data) {
  theWheel.stopAnimation();
  getWinnerPoint(data);
  theWheel.draw();
  wheelSpinning = false;
}

function successOrError() {
  $(".gmimg").removeClass("active");
  $("#game").find("input").not("input[name=type],input[name=_token]").val("");
  $("#flip").html("Play Now");
  $("#flip").removeAttr("disabled");
}

function setpoint(point) {
  if (point.result == "BLUE") {
    theWheel.animation.stopAngle = 12;
  } else {
    theWheel.animation.stopAngle = 30;
  }
}

function getWinnerPoint(data) {
  if (data.result == "BLUE") {
    theWheel.rotationAngle = 28;
  } else {
    theWheel.rotationAngle = 10;
  }
}

function runningAnimation() {
  theWheel.animation.type = "spinOngoing";
}

function playingAnimation() {
  theWheel.animation.type = "spinToStop";
  theWheel.animation.spins = 50;
  theWheel.animation.duration = 10;
}

function beforeProcess() {
  $('#flip').html('<i class="la la-gear fa-spin"></i> Processing...');
  $('#flip').attr('disabled', '');
  $(".cd-ft").children().remove();
}

function success(data) {
  setPopup(data);
  $(".bal").html(data.bal);
  $(".gmimg").removeClass("active");
  $("#game").find("input").not("input[name=type],input[name=_token]").val("");
}

function gameFinish(data, timerA) {
  clearInterval(timerA);
  winnerPoint(data);
  success(data);
}

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
  $("input[name=choose]").val("blue");
  $(this).addClass("active");
  $(".red").removeClass("active");
  playAudio(audioAssetPath, "click.mp3")
});

$(".red").click(function () {
  $("input[name=choose]").val("red");
  $(this).addClass("active");
  $(".black").removeClass("active");
  playAudio(audioAssetPath, "click.mp3")
});

$(window).on("load", function () {
  var theWheel = new Winwheel({
    numSegments: 18,
    outerRadius: 210,
    segments: [
      { fillStyle: "#09097d", text: "" },
      { fillStyle: "#ff0000", text: "" },
      { fillStyle: "#09097d", text: "" },
      { fillStyle: "#ff0000", text: "" },
      { fillStyle: "#09097d", text: "" },
      { fillStyle: "#ff0000", text: "" },
      { fillStyle: "#09097d", text: "" },
      { fillStyle: "#ff0000", text: "" },
      { fillStyle: "#09097d", text: "" },
      { fillStyle: "#ff0000", text: "" },
      { fillStyle: "#09097d", text: "" },
      { fillStyle: "#ff0000", text: "" },
      { fillStyle: "#09097d", text: "" },
      { fillStyle: "#ff0000", text: "" },
      { fillStyle: "#09097d", text: "" },
      { fillStyle: "#ff0000", text: "" },
      { fillStyle: "#09097d", text: "" },
      { fillStyle: "#ff0000", text: "" },
    ],
  });
  runningAnimation();
  theWheel.startAnimation();
});

var theWheel = new Winwheel({
  numSegments: 18,
  outerRadius: 210,
  segments: [
    { fillStyle: "#09097d", text: "" },
    { fillStyle: "#ff0000", text: "" },
    { fillStyle: "#09097d", text: "" },
    { fillStyle: "#ff0000", text: "" },
    { fillStyle: "#09097d", text: "" },
    { fillStyle: "#ff0000", text: "" },
    { fillStyle: "#09097d", text: "" },
    { fillStyle: "#ff0000", text: "" },
    { fillStyle: "#09097d", text: "" },
    { fillStyle: "#ff0000", text: "" },
    { fillStyle: "#09097d", text: "" },
    { fillStyle: "#ff0000", text: "" },
    { fillStyle: "#09097d", text: "" },
    { fillStyle: "#ff0000", text: "" },
    { fillStyle: "#09097d", text: "" },
    { fillStyle: "#ff0000", text: "" },
    { fillStyle: "#09097d", text: "" },
    { fillStyle: "#ff0000", text: "" },
  ],
});
var wheelSpinning = false;

$("input[type=number]").on("keydown", function (e) {
  if (e.keyCode == 189) {
    return false;
  }
});

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
  playGame($(this).serialize(), "spin-wheel.mp3");
});
