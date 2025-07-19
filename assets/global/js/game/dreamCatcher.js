let result = '';
let invest;
let choose;
let investField;
let minLimit;
let maxLimit;
let currency;
let investUrl;
let endUrl;
var wheelSpinning = false;
let response;

$(window).on("load", function () {
  var theWheel = new Winwheel({
    numSegments: 54,
    outerRadius: 210,
    lineWidth: 2,
    segments: [
      {
        text: "1",
        fillStyle: "#FFD700",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#00FFD1",
      },
      {
        text: "2",
        fillStyle: "#00B4FF",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#00FFD1",
      },
      {
        text: "10",
        fillStyle: "#00FF00",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#00FFD1",
      },
      {
        text: "1",
        fillStyle: "#FFD700",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#00FFD1",
      },
      {
        text: "2",
        fillStyle: "#00B4FF",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#00FFD1",
      },
      {
        text: "1",
        fillStyle: "#FFD700",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#00FFD1",
      },
      {
        text: "5",
        fillStyle: "#FF00FF",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#00FFD1",
      },
      {
        text: "1",
        fillStyle: "#FFD700",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#00FFD1",
      },
      {
        text: "2",
        fillStyle: "#00B4FF",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#00FFD1",
      },
      {
        text: "5",
        fillStyle: "#FF00FF",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#00FFD1",
      },
      {
        text: "1",
        fillStyle: "#FFD700",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#00FFD1",
      },
      {
        text: "2",
        fillStyle: "#00B4FF",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#00FFD1",
      },
      {
        text: "5",
        fillStyle: "#FF00FF",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#00FFD1",
      },
      {
        text: "1",
        fillStyle: "#FFD700",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#00FFD1",
      },
      {
        text: "2",
        fillStyle: "#00B4FF",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#00FFD1",
      },
      {
        text: "1",
        fillStyle: "#FFD700",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#00FFD1",
      },
      {
        text: "10",
        fillStyle: "#00FF00",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#00FFD1",
      },
      {
        text: "1",
        fillStyle: "#FFD700",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#00FFD1",
      },
      {
        text: "2",
        fillStyle: "#00B4FF",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#00FFD1",
      },
      {
        text: "1",
        fillStyle: "#FFD700",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#00FFD1",
      },
      {
        text: "2",
        fillStyle: "#00B4FF",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#00FFD1",
      },
      {
        text: "1",
        fillStyle: "#FFD700",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#00FFD1",
      },
      {
        text: "20",
        fillStyle: "#FF6600",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#00FFD1",
      },
      {
        text: "1",
        fillStyle: "#FFD700",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#00FFD1",
      },
      {
        text: "2",
        fillStyle: "#00B4FF",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#00FFD1",
      },
      {
        text: "5",
        fillStyle: "#FF00FF",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#00FFD1",
      },
      {
        text: "1",
        fillStyle: "#FFD700",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#00FFD1",
      },
      {
        text: "2x",
        fillStyle: "#2E2E2A",
        textFillStyle: "#C0C0C0",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#00FFEB",
      },
      {
        text: "1",
        fillStyle: "#FFD700",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#00FFD1",
      },
      {
        text: "10",
        fillStyle: "#00FF00",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#00FFD1",
      },
      {
        text: "2",
        fillStyle: "#00B4FF",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#00FFD1",
      },
      {
        text: "1",
        fillStyle: "#FFD700",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#00FFD1",
      },
      {
        text: "5",
        fillStyle: "#FF00FF",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#00FFD1",
      },
      {
        text: "2",
        fillStyle: "#00B4FF",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#00FFD1",
      },
      {
        text: "1",
        fillStyle: "#FFD700",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#00FFD1",
      },
      {
        text: "2",
        fillStyle: "#00B4FF",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#00FFD1",
      },
      {
        text: "1",
        fillStyle: "#FFD700",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#00FFD1",
      },
      {
        text: "2",
        fillStyle: "#00B4FF",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#00FFD1",
      },
      {
        text: "1",
        fillStyle: "#FFD700",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#00FFD1",
      },
      {
        text: "5",
        fillStyle: "#FF00FF",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#00FFD1",
      },
      {
        text: "40",
        fillStyle: "#FF3300",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#00FFD1",
      },
      {
        text: "1",
        fillStyle: "#FFD700",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#00FFD1",
      },
      {
        text: "10",
        fillStyle: "#00FF00",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#00FFD1",
      },
      {
        text: "1",
        fillStyle: "#FFD700",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#00FFD1",
      },
      {
        text: "2",
        fillStyle: "#00B4FF",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#00FFD1",
      },
      {
        text: "1",
        fillStyle: "#FFD700",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#00FFD1",
      },
      {
        text: "5",
        fillStyle: "#FF00FF",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#00FFD1",
      },
      {
        text: "2",
        fillStyle: "#00B4FF",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#00FFD1",
      },
      {
        text: "1",
        fillStyle: "#FFD700",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#00FFD1",
      },
      {
        text: "20",
        fillStyle: "#FF6600",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#00FFD1",
      },
      {
        text: "1",
        fillStyle: "#FFD700",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#00FFD1",
      },
      {
        text: "2",
        fillStyle: "#00B4FF",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#00FFD1",
      },
      {
        text: "1",
        fillStyle: "#FFD700",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#00FFD1",
      },
      {
        text: "7x",
        fillStyle: "#2E2E2A",
        textFillStyle: "#BFA100",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#00FFEB",
      },
    ]
  });
  runningAnimation();
  theWheel.animation.duration = 1000;
  theWheel.startAnimation();
});

var theWheel = new Winwheel({
  numSegments: 54,
  outerRadius: 210,
  segments: [
    {
      text: "1",
      fillStyle: "#FFD700",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#00FFD1",
    },
    {
      text: "2",
      fillStyle: "#00B4FF",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#00FFD1",
    },
    {
      text: "10",
      fillStyle: "#00FF00",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#00FFD1",
    },
    {
      text: "1",
      fillStyle: "#FFD700",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#00FFD1",
    },
    {
      text: "2",
      fillStyle: "#00B4FF",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#00FFD1",
    },
    {
      text: "1",
      fillStyle: "#FFD700",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#00FFD1",
    },
    {
      text: "5",
      fillStyle: "#FF00FF",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#00FFD1",
    },
    {
      text: "1",
      fillStyle: "#FFD700",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#00FFD1",
    },
    {
      text: "2",
      fillStyle: "#00B4FF",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#00FFD1",
    },
    {
      text: "5",
      fillStyle: "#FF00FF",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#00FFD1",
    },
    {
      text: "1",
      fillStyle: "#FFD700",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#00FFD1",
    },
    {
      text: "2",
      fillStyle: "#00B4FF",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#00FFD1",
    },
    {
      text: "5",
      fillStyle: "#FF00FF",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#00FFD1",
    },
    {
      text: "1",
      fillStyle: "#FFD700",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#00FFD1",
    },
    {
      text: "2",
      fillStyle: "#00B4FF",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#00FFD1",
    },
    {
      text: "1",
      fillStyle: "#FFD700",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#00FFD1",
    },
    {
      text: "10",
      fillStyle: "#00FF00",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#00FFD1",
    },
    {
      text: "1",
      fillStyle: "#FFD700",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#00FFD1",
    },
    {
      text: "2",
      fillStyle: "#00B4FF",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#00FFD1",
    },
    {
      text: "1",
      fillStyle: "#FFD700",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#00FFD1",
    },
    {
      text: "2",
      fillStyle: "#00B4FF",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#00FFD1",
    },
    {
      text: "1",
      fillStyle: "#FFD700",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#00FFD1",
    },
    {
      text: "20",
      fillStyle: "#FF6600",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#00FFD1",
    },
    {
      text: "1",
      fillStyle: "#FFD700",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#00FFD1",
    },
    {
      text: "2",
      fillStyle: "#00B4FF",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#00FFD1",
    },
    {
      text: "5",
      fillStyle: "#FF00FF",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#00FFD1",
    },
    {
      text: "1",
      fillStyle: "#FFD700",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#00FFD1",
    },
    {
      text: "2x",
      fillStyle: "#2E2E2A",
      textFillStyle: "#C0C0C0",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#00FFEB",
    },
    {
      text: "1",
      fillStyle: "#FFD700",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#00FFD1",
    },
    {
      text: "10",
      fillStyle: "#00FF00",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#00FFD1",
    },
    {
      text: "2",
      fillStyle: "#00B4FF",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#00FFD1",
    },
    {
      text: "1",
      fillStyle: "#FFD700",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#00FFD1",
    },
    {
      text: "5",
      fillStyle: "#FF00FF",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#00FFD1",
    },
    {
      text: "2",
      fillStyle: "#00B4FF",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#00FFD1",
    },
    {
      text: "1",
      fillStyle: "#FFD700",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#00FFD1",
    },
    {
      text: "2",
      fillStyle: "#00B4FF",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#00FFD1",
    },
    {
      text: "1",
      fillStyle: "#FFD700",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#00FFD1",
    },
    {
      text: "2",
      fillStyle: "#00B4FF",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#00FFD1",
    },
    {
      text: "1",
      fillStyle: "#FFD700",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#00FFD1",
    },
    {
      text: "5",
      fillStyle: "#FF00FF",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#00FFD1",
    },
    {
      text: "40",
      fillStyle: "#FF3300",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#00FFD1",
    },
    {
      text: "1",
      fillStyle: "#FFD700",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#00FFD1",
    },
    {
      text: "10",
      fillStyle: "#00FF00",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#00FFD1",
    },
    {
      text: "1",
      fillStyle: "#FFD700",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#00FFD1",
    },
    {
      text: "2",
      fillStyle: "#00B4FF",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#00FFD1",
    },
    {
      text: "1",
      fillStyle: "#FFD700",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#00FFD1",
    },
    {
      text: "5",
      fillStyle: "#FF00FF",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#00FFD1",
    },
    {
      text: "2",
      fillStyle: "#00B4FF",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#00FFD1",
    },
    {
      text: "1",
      fillStyle: "#FFD700",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#00FFD1",
    },
    {
      text: "20",
      fillStyle: "#FF6600",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#00FFD1",
    },
    {
      text: "1",
      fillStyle: "#FFD700",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#00FFD1",
    },
    {
      text: "2",
      fillStyle: "#00B4FF",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#00FFD1",
    },
    {
      text: "1",
      fillStyle: "#FFD700",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#00FFD1",
    },
    {
      text: "7x",
      fillStyle: "#2E2E2A",
      textFillStyle: "#BFA100",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#00FFEB",
    },
  ]
});


$(".minBtn").on('click', function (e) {
  playAudio(audioAssetPath, "click.mp3");
  investField.val(minLimit);
});

$(".maxBtn").on('click', function (e) {
  playAudio(audioAssetPath, "click.mp3");
  investField.val(maxLimit);
});

$('.game-select-box').on('click', function () {
  choose = $(this).data('value');
  playAudio(audioAssetPath, "click.mp3");
});

function hasDecimalPlace(value, x) {
  var pointIndex = value.indexOf('.');
  return pointIndex >= 0 && pointIndex < value.length - x;
}

function beforeProcess() {
  if (!invest) {
    notify('error', 'Invest amount is required')
    return false;
  }
  if (!choose) {
    notify('error', 'Choose option selection is required')
    return false;
  }
  playAudio(audioAssetPath, "spin-wheel.mp3");
  $("#playBtn").html('<i class="la la-gear fa-spin"></i> Processing...');
  $("#playBtn").attr("disabled", "");
  $(".cd-ft").children().remove();
  return true;
}

function startGame(data) {
  startSpin(data);
  $("#playBtn").html('<i class="la la-gear fa-spin"></i> Playing...');
  timerA = setInterval(function () {
    succOrError();
    endGame(data);
  }, 10000);
}

function succOrError() {
  $(".gmimg").removeClass("active");
  $("#game").find("input").not("input[name=type],input[name=_token]").val("");
  $("#playBtn").html("Play Now");
  $("#playBtn").removeAttr("disabled");
}


function playingAnimation() {
  theWheel.animation.type = "spinToStop";
  theWheel.animation.spins = 50;
  theWheel.animation.duration = 10;
}

function setPoint(point) {
  let filteredData = [];
  $.each(theWheel.segments, function (index, item) {
    if (item) {
      let result = point.point;
      let resultCoin = [1, 2, 5, 10, 20, 40, "2x", "7x"];
      if (resultCoin.includes(point.point)) {
        result = point.point.toString().replace(/_/g, " ").replace(/\b\w/g, (l) => l.toUpperCase());
      }
      if (item.text == result) {
        filteredData.push({
          text: item.text,
          endAngle: item.endAngle,
        });
      }
    }
  });

  let randomIndex = Math.floor(Math.random() * filteredData.length);
  let randomData = filteredData[randomIndex];
  theWheel.animation.stopAngle = randomData.endAngle - 3;
}

function startSpin(data) {
  playingAnimation();
  setPoint(data);
  theWheel.startAnimation();
  wheelSpinning = false;
}

function getWinnerPoint(data) {
  let filteredData = [];
  $.each(theWheel.segments, function (index, item) {
    if (item) {
      point = data.point;
      let resultCoin = [1, 2, 5, 10, 20, 40, "2x", "7x"];
      if (resultCoin.includes(data.point)) {
        result = data.point.replace(/_/g, " ").replace(/\b\w/g, (l) => l.toUpperCase());
      }
      if (item.text == point) {
        filteredData.push({
          text: item.text,
          endAngle: item.endAngle,
        });
      }
    }
  });
  let randomIndex = Math.floor(Math.random() * filteredData.length);
  let randomData = filteredData[randomIndex];
  theWheel.animation.stopAngle = randomData.endAngle - 3;
}

function winnerPoint(data) {
  theWheel.stopAnimation();
  getWinnerPoint(data);
  theWheel.draw();
  wheelSpinning = false;
}

function runningAnimation() {
  theWheel.animation.type = "spinOngoing";
}

function checkErrors(data) {
  if (data.errors) {
    notify("error", data.errors);
    succOrError();
    return true;
  }
  if (data.error) {
    notify("error", data.error);
    succOrError();
    return true;
  }
}

function success(data) {
  $(".win-loss-popup").addClass("active");
  $(".result-message").find("img").addClass("d-none");
  if (data.win_status == 1) {
    playAudio(audioAssetPath, "win.wav");
    $(".win-loss-popup__body").find(".win").removeClass("d-none");
    $(".win-loss-popup__body").find(".lose").addClass("d-none");
  } else {
    playAudio(audioAssetPath, "lose.wav");
    $(".win-loss-popup__body").find(".lose").removeClass("d-none");
    $(".win-loss-popup__body").find(".win").addClass("d-none");
  }
  $(".win-loss-popup__footer").find(".data-result").text(data.result);

  $(".bal").text(data.bal);
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

$("input[type=number]").on("keydown", function (e) {
  if (e.keyCode == 189) {
    return false;
  }
});

function game(data) {
  theWheel.rotationAngle = 0;
  isRequest = true;
  $.ajax({
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
    url: investUrl,
    method: "POST",
    data: data,
    success: function (data) {
      response = data;
      if (checkErrors(data) == true) {
        return false;
      }
      if (data.reSpin) {
        startSpin(data);
        $("#playBtn").html('<i class="la la-gear fa-spin"></i> Playing...');
        timerA = setInterval(function () {
          winnerPoint(data);
          $('#playBtn').addClass('d-none');
          $('#reSpinBtn').removeClass('d-none');
          $('[name="invest"').attr('disabled', true);
          $(".bal").text(data.balance);
        }, 10000);
      } else {
        $(".bal").text(data.balance);
        startGame(data);
      }
    },
  });
}

$('#game').on('submit', function (e) {
  e.preventDefault();
  invest = investField.val();
  if (!beforeProcess()) {
    return false;
  }
  var data = {
    invest: invest,
    choose: choose
  };
  game(data);
});

$('#reSpinBtn').on('click', function (e) {
  e.preventDefault();
  $('#playBtn').removeClass('d-none');
  $('#reSpinBtn').addClass('d-none');
  if (timerA) {
    clearInterval(timerA);
  }

  $.ajax({
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
    url: endUrl,
    method: "POST",
    data: { game_log_id: response.game_log_id, re_spin: response.reSpin },
    success: function (data) {
      response = data;
      if (checkErrors(data) == true) {
        return false;
      }
      theWheel.stopAnimation(false);
      theWheel.rotationAngle = 0;
      if (data.reSpin) {
        startSpin(data);
        clearInterval(timerA);
        timerA = setInterval(function () {
          winnerPoint(data);
          $('#playBtn').addClass('d-none');
          $('#reSpinBtn').removeClass('d-none');
          $('[name="invest"]').attr('disabled', true);
        }, 10000);
      } else {
        startSpin(data);
        $("#playBtn").html('<i class="la la-gear fa-spin"></i> Playing...');
        clearInterval(timerA);
        timerA = setInterval(function () {
          succOrError();
          gameFinish(data, timerA);
          $('[name="invest"').attr('disabled', false);
        }, 10000);
        isRequest = false;
      }
    },
  });
});

function complete(data) {
  $.ajax({
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
    url: endUrl,
    method: "POST",
    data: { game_log_id: data.game_log_id, re_spin: data.reSpin },
    success: function (data) {
      if (checkErrors(data) == true) {
        return false;
      }
      gameFinish(data, timerA);
      isRequest = false;
    },
  });
}

function endGame(data) {
  if (audioSound == 'true') {
    audioPause();
  }
  complete(data)
}
