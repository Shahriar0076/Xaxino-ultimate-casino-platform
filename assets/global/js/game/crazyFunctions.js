let result = '';
function startGame(data) {
  startSpin(data);
  $("#playBtn").html('<i class="la la-gear fa-spin"></i> Playing...');
  timerA = setInterval(function () {
    succOrError();
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

function succOrError() {
  $(".gmimg").removeClass("active");
  $("#game").find("input").not("input[name=type],input[name=_token]").val("");
  $("#playBtn").html("Play Now");
  $("#playBtn").removeAttr("disabled");
}

function setpoint(point) {
  let filteredData = [];
  $.each(theWheel.segments, function (index, item) {
    if (item) {
      let result = point.point;
      let resultCoin = ["coin_flip", "pachinko", "cash_hunt", "crazy_times"];
      if (resultCoin.includes(point.point)) {
        result = point.point
          .replace(/_/g, " ")
          .replace(/\b\w/g, (l) => l.toUpperCase());
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

function getWinnerPoint(data) {
  let filteredData = [];
  $.each(theWheel.segments, function (index, item) {
    if (item) {
      result = data.result;
      let resultCoin = ["coin_flip", "pachinko", "cash_hunt", "crazy_times"];
      if (resultCoin.includes(data.result)) {
        result = data.result.replace(/_/g, " ").replace(/\b\w/g, (l) => l.toUpperCase());
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

function runningAnimation() {
  theWheel.animation.type = "spinOngoing";
}

function playingAnimation() {
  theWheel.animation.type = "spinToStop";
  theWheel.animation.spins = 50;
  theWheel.animation.duration = 10;
}

function beforeProcess() {
  $("#playBtn").html('<i class="la la-gear fa-spin"></i> Processing...');
  $("#playBtn").attr("disabled", "");
  $(".cd-ft").children().remove();
}

function logerrors(data) {
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
  $(".win-loss-popup__footer").find(".data-result").text(result);

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

$(window).on("load", function () {
  var theWheel = new Winwheel({
    numSegments: 54,
    outerRadius: 210,
    lineWidth: 2,
    segments: [
      {
        text: "1",
        fillStyle: "#FF8C00",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#E3BC3F",
      },
      {
        text: "2",
        fillStyle: "#4169E1",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#E3BC3F",
      },
      {
        text: "1",
        fillStyle: "#32CD32",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#E3BC3F",
      },
      {
        text: "10",
        fillStyle: "#9370DB",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#E3BC3F",
      },
      {
        text: "2",
        fillStyle: "#FF6B6B",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#E3BC3F",
      },
      {
        text: "Cash Hunt",
        fillStyle: "#50C878",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#E3BC3F",
      },
      {
        text: "1",
        fillStyle: "#4BB4DE",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#E3BC3F",
      },
      {
        text: "2",
        fillStyle: "#FFD700",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#E3BC3F",
      },
      {
        text: "1",
        fillStyle: "#FF8C00",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#E3BC3F",
      },
      {
        text: "5",
        fillStyle: "#4169E1",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#E3BC3F",
      },
      {
        text: "1",
        fillStyle: "#32CD32",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#E3BC3F",
      },
      {
        text: "Coin Flip",
        fillStyle: "#9370DB",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#E3BC3F",
      },
      {
        text: "1",
        fillStyle: "#FF6B6B",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#E3BC3F",
      },
      {
        text: "5",
        fillStyle: "#50C878",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#E3BC3F",
      },
      {
        text: "2",
        fillStyle: "#4BB4DE",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#E3BC3F",
      },
      {
        text: "10",
        fillStyle: "#FFD700",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#E3BC3F",
      },
      {
        text: "1",
        fillStyle: "#FF8C00",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#E3BC3F",
      },
      {
        text: "Pachinko",
        fillStyle: "#4169E1",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#E3BC3F",
      },
      {
        text: "1",
        fillStyle: "#32CD32",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#E3BC3F",
      },
      {
        text: "2",
        fillStyle: "#9370DB",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#E3BC3F",
      },
      {
        text: "5",
        fillStyle: "#FF6B6B",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#E3BC3F",
      },
      {
        text: "1",
        fillStyle: "#50C878",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#E3BC3F",
      },
      {
        text: "2",
        fillStyle: "#4BB4DE",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#E3BC3F",
      },
      {
        text: "Coin Flip",
        fillStyle: "#FFD700",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#E3BC3F",
      },
      {
        text: "1",
        fillStyle: "#FF8C00",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#E3BC3F",
      },
      {
        text: "10",
        fillStyle: "#4169E1",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#E3BC3F",
      },
      {
        text: "1",
        fillStyle: "#32CD32",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#E3BC3F",
      },
      {
        text: "5",
        fillStyle: "#9370DB",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#E3BC3F",
      },
      {
        text: "1",
        fillStyle: "#FF6B6B",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#E3BC3F",
      },
      {
        text: "Cash Hunt",
        fillStyle: "#50C878",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#E3BC3F",
      },
      {
        text: "1",
        fillStyle: "#4BB4DE",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#E3BC3F",
      },
      {
        text: "2",
        fillStyle: "#FFD700",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#E3BC3F",
      },
      {
        text: "5",
        fillStyle: "#FF8C00",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#E3BC3F",
      },
      {
        text: "1",
        fillStyle: "#4169E1",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#E3BC3F",
      },
      {
        text: "2",
        fillStyle: "#32CD32",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#E3BC3F",
      },
      {
        text: "Coin Flip",
        fillStyle: "#9370DB",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#E3BC3F",
      },
      {
        text: "2",
        fillStyle: "#FF6B6B",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#E3BC3F",
      },
      {
        text: "1",
        fillStyle: "#50C878",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#E3BC3F",
      },
      {
        text: "10",
        fillStyle: "#4BB4DE",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#E3BC3F",
      },
      {
        text: "2",
        fillStyle: "#FFD700",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#E3BC3F",
      },
      {
        text: "1",
        fillStyle: "#FF8C00",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#E3BC3F",
      },
      {
        text: "Crazy Times",
        fillStyle: "#4169E1",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#E3BC3F",
      },
      {
        text: "1",
        fillStyle: "#32CD32",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#E3BC3F",
      },
      {
        text: "2",
        fillStyle: "#9370DB",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#E3BC3F",
      },
      {
        text: "5",
        fillStyle: "#FF6B6B",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#E3BC3F",
      },
      {
        text: "1",
        fillStyle: "#50C878",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#E3BC3F",
      },
      {
        text: "2",
        fillStyle: "#4BB4DE",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#E3BC3F",
      },
      {
        text: "Pachinko",
        fillStyle: "#FFD700",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#E3BC3F",
      },
      {
        text: "1",
        fillStyle: "#FF8C00",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#E3BC3F",
      },
      {
        text: "5",
        fillStyle: "#4169E1",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#E3BC3F",
      },
      {
        text: "1",
        fillStyle: "#32CD32",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#E3BC3F",
      },
      {
        text: "2",
        fillStyle: "#9370DB",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#E3BC3F",
      },
      {
        text: "1",
        fillStyle: "#FF6B6B",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#E3BC3F",
      },
      {
        text: "Coin Flip",
        fillStyle: "#50C878",
        textFillStyle: "#000000",
        textFontSize: 14,
        textAlignment: "outer",
        strokeStyle: "#E3BC3F",
      },
    ],
  });
  runningAnimation();
  theWheel.animation.duration = 1000; //duration
  theWheel.startAnimation();
});

var theWheel = new Winwheel({
  numSegments: 54,
  outerRadius: 210,
  segments: [
    {
      text: "1",
      fillStyle: "#FF8C00",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#E3BC3F",
    },
    {
      text: "2",
      fillStyle: "#4169E1",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#E3BC3F",
    },
    {
      text: "1",
      fillStyle: "#32CD32",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#E3BC3F",
    },
    {
      text: "10",
      fillStyle: "#9370DB",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#E3BC3F",
    },
    {
      text: "2",
      fillStyle: "#FF6B6B",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#E3BC3F",
    },
    {
      text: "Cash Hunt",
      fillStyle: "#50C878",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#E3BC3F",
    },
    {
      text: "1",
      fillStyle: "#4BB4DE",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#E3BC3F",
    },
    {
      text: "2",
      fillStyle: "#FFD700",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#E3BC3F",
    },
    {
      text: "1",
      fillStyle: "#FF8C00",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#E3BC3F",
    },
    {
      text: "5",
      fillStyle: "#4169E1",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#E3BC3F",
    },
    {
      text: "1",
      fillStyle: "#32CD32",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#E3BC3F",
    },
    {
      text: "Coin Flip",
      fillStyle: "#9370DB",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#E3BC3F",
    },
    {
      text: "1",
      fillStyle: "#FF6B6B",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#E3BC3F",
    },
    {
      text: "5",
      fillStyle: "#50C878",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#E3BC3F",
    },
    {
      text: "2",
      fillStyle: "#4BB4DE",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#E3BC3F",
    },
    {
      text: "10",
      fillStyle: "#FFD700",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#E3BC3F",
    },
    {
      text: "1",
      fillStyle: "#FF8C00",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#E3BC3F",
    },
    {
      text: "Pachinko",
      fillStyle: "#4169E1",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#E3BC3F",
    },
    {
      text: "1",
      fillStyle: "#32CD32",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#E3BC3F",
    },
    {
      text: "2",
      fillStyle: "#9370DB",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#E3BC3F",
    },
    {
      text: "5",
      fillStyle: "#FF6B6B",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#E3BC3F",
    },
    {
      text: "1",
      fillStyle: "#50C878",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#E3BC3F",
    },
    {
      text: "2",
      fillStyle: "#4BB4DE",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#E3BC3F",
    },
    {
      text: "Coin Flip",
      fillStyle: "#FFD700",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#E3BC3F",
    },
    {
      text: "1",
      fillStyle: "#FF8C00",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#E3BC3F",
    },
    {
      text: "10",
      fillStyle: "#4169E1",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#E3BC3F",
    },
    {
      text: "1",
      fillStyle: "#32CD32",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#E3BC3F",
    },
    {
      text: "5",
      fillStyle: "#9370DB",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#E3BC3F",
    },
    {
      text: "1",
      fillStyle: "#FF6B6B",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#E3BC3F",
    },
    {
      text: "Cash Hunt",
      fillStyle: "#50C878",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#E3BC3F",
    },
    {
      text: "1",
      fillStyle: "#4BB4DE",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#E3BC3F",
    },
    {
      text: "2",
      fillStyle: "#FFD700",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#E3BC3F",
    },
    {
      text: "5",
      fillStyle: "#FF8C00",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#E3BC3F",
    },
    {
      text: "1",
      fillStyle: "#4169E1",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#E3BC3F",
    },
    {
      text: "2",
      fillStyle: "#32CD32",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#E3BC3F",
    },
    {
      text: "Coin Flip",
      fillStyle: "#9370DB",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#E3BC3F",
    },
    {
      text: "2",
      fillStyle: "#FF6B6B",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#E3BC3F",
    },
    {
      text: "1",
      fillStyle: "#50C878",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#E3BC3F",
    },
    {
      text: "10",
      fillStyle: "#4BB4DE",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#E3BC3F",
    },
    {
      text: "2",
      fillStyle: "#FFD700",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#E3BC3F",
    },
    {
      text: "1",
      fillStyle: "#FF8C00",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#E3BC3F",
    },
    {
      text: "Crazy Times",
      fillStyle: "#4169E1",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#E3BC3F",
    },
    {
      text: "1",
      fillStyle: "#32CD32",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#E3BC3F",
    },
    {
      text: "2",
      fillStyle: "#9370DB",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#E3BC3F",
    },
    {
      text: "5",
      fillStyle: "#FF6B6B",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#E3BC3F",
    },
    {
      text: "1",
      fillStyle: "#50C878",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#E3BC3F",
    },
    {
      text: "2",
      fillStyle: "#4BB4DE",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#E3BC3F",
    },
    {
      text: "Pachinko",
      fillStyle: "#FFD700",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#E3BC3F",
    },
    {
      text: "1",
      fillStyle: "#FF8C00",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#E3BC3F",
    },
    {
      text: "5",
      fillStyle: "#4169E1",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#E3BC3F",
    },
    {
      text: "1",
      fillStyle: "#32CD32",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#E3BC3F",
    },
    {
      text: "2",
      fillStyle: "#9370DB",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#E3BC3F",
    },
    {
      text: "1",
      fillStyle: "#FF6B6B",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#E3BC3F",
    },
    {
      text: "Coin Flip",
      fillStyle: "#50C878",
      textFillStyle: "#000000",
      textFontSize: 14,
      textAlignment: "outer",
      strokeStyle: "#E3BC3F",
    },
  ],
});
var wheelSpinning = false;

$("input[type=number]").on("keydown", function (e) {
  if (e.keyCode == 189) {
    return false;
  }
});

function game(url, data) {
  theWheel.rotationAngle = 0;
  isRequest = true;
  $.ajax({
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
    url: url,
    method: "POST",
    data: data,
    success: function (data) {
      if (logerrors(data) == true) {
        return false;
      }

      $(".bal").text(data.balance);
      startGame(data);
    },
  });
}

function complete(data, url) {
  $.ajax({
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
    url: url,
    method: "POST",
    data: { game_log_id: data.game_log_id },
    success: function (data) {
      if (logerrors(data) == true) {
        return false;
      }
      gameFinish(data, timerA);
      isRequest = false;
    },
  });
}
