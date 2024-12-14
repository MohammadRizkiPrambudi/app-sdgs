document.addEventListener("DOMContentLoaded", function () {
    toggleVoice();
});

let isPlaying = false;

function toggleVoice() {
    const content = document.getElementById("material-content").textContent;
    const buttonIcon = document.getElementById("play-stop-icon");
    const buttonText = document.getElementById("play-stop-text");

    if (!isPlaying) {
        responsiveVoice.speak(content, "Indonesian Female", {
            pitch: 1,
            rate: 1,
            volume: 2,
            onend: function () {
                toggleButton(false);
            },
        });
        toggleButton(true);
    } else {
        responsiveVoice.cancel();
        toggleButton(false);
    }
}

function toggleButton(playing) {
    isPlaying = playing;
    const buttonIcon = document.getElementById("play-stop-icon");
    const buttonText = document.getElementById("play-stop-text");

    if (playing) {
        buttonIcon.classList.replace("fa-play", "fa-stop");
        buttonText.textContent = "Stop Suara";
    } else {
        buttonIcon.classList.replace("fa-stop", "fa-play");
        buttonText.textContent = "Putar Suara";
    }
}
