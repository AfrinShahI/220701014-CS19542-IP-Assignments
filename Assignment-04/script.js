$(document).ready(function () {
    let gamePaused = false;
    let score = 0;
    let themeIndex = 0;
    const themes = ['#333', '#1a1a1a', '#444'];  // Add more themes if you'd like

    // Load highest score from localStorage or set it to 0 if it doesn't exist
    let highestScore = localStorage.getItem('highestScore') || 0;
    $('#highest-score').text(`Highest Score: ${highestScore}`);

    function updateScore() {
        $('#score').text(`Score: ${score}`);
        if (score > highestScore) {
            highestScore = score;
            localStorage.setItem('highestScore', highestScore);
            $('#highest-score').text(`Highest Score: ${highestScore}`);
        }
    }

    function spawnObject() {
        const size = Math.random() * 50 + 20;
        const x = Math.random() * ($('#game-area').width() - size);
        const y = Math.random() * ($('#game-area').height() - size);
        const $circle = $('<div class="circle"></div>').css({
            width: size,
            height: size,
            top: y,
            left: x
        }).appendTo('#game-area');

        $circle.animate({
            top: Math.random() * ($('#game-area').height() - size),
            left: Math.random() * ($('#game-area').width() - size)
        }, 4000, 'swing', function () {  // Adjust speed here
            if (!gamePaused) $circle.fadeOut(500, () => $circle.remove());
        });

        $circle.click(function () {
            if (!gamePaused) {
                score++;
                updateScore();
                $circle.stop().fadeOut(300, () => $circle.remove());
            }
        });
    }

    function spawnObjects() {
        setInterval(function () {
            if (!gamePaused) spawnObject();
        }, 1000);
    }

    // Start Game
    $('#start-game').click(function () {
        if (!gamePaused) {
            score = 0;
            updateScore();
            spawnObjects();
        }
        gamePaused = false;
    });

    // Pause Game
    $('#pause-game').click(function () {
        gamePaused = !gamePaused;
        if (gamePaused) {
            $('.circle').stop(); // Stop animations
        } else {
            $('.circle').animate(); // Resume animations
        }
    });

    // Reset Game
    $('#reset-game').click(function () {
        gamePaused = true;
        score = 0;
        updateScore();
        $('#game-area').empty(); // Clear all objects
    });

    // Clear Scores
    $('#clear-scores').click(function () {
        score = 0;
        updateScore();
        localStorage.setItem('highestScore', 0); // Reset highest score in localStorage
        $('#highest-score').text(`Highest Score: 0`);
    });

    // Change Theme
    $('#change-theme').click(function () {
        themeIndex = (themeIndex + 1) % themes.length;
        $('#game-container, #game-area').css('background', themes[themeIndex]); // Apply theme to both elements
    });
});
