let audioSound = 'true';
let isRequest = false;
let audioAssetPath = '';
let audio;

function playAudio(audioAssetPath, filename) {
    audio = new Audio(`${audioAssetPath}/${filename}`);
    if (audioSound == 'true') {
        audioOn();
    }
}

if (localStorage.getItem('audioStatus') !== null) {
    audioSound = localStorage.getItem('audioStatus');
    if (audioSound == 'false') {
        $('.audioBtn').html(`<i class="fas fa-volume-mute"></i>`);
    }
} else {
    localStorage.setItem('audioStatus', 'true');
}

function audioPause() {
    audio.pause();
}

function audioOn() {
    audio.play();
}

$('.audioBtn').on('click', function () {
    audioSound = (audioSound == 'true') ? 'false' : 'true';
    localStorage.setItem('audioStatus', audioSound);
    if (audioSound == 'true') {
        $(this).html(`<i class="fas fa-volume-up"></i>`);
        if (isRequest) {
            audioOn();
        }
    } else {
        $(this).html(`<i class="fas fa-volume-mute"></i>`);
        if (isRequest) {
            audioPause();
        }
    }
});
