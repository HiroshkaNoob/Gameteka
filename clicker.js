document.addEventListener("DOMContentLoaded", () => {
  const clickBtn = document.getElementById("click-btn");
  const scoreDisplay = document.getElementById("score");
  const resetBtn = document.getElementById("reset-btn");
  const saveBtn = document.getElementById("save-btn");

  let score = parseInt(localStorage.getItem("clickerScore")) || 0;
  scoreDisplay.textContent = score;

  // Обработчик кликов
  clickBtn.addEventListener("click", () => {
    score++;
    scoreDisplay.textContent = score;
    localStorage.setItem("clickerScore", score);
  });

  // Сброс счета
  resetBtn.addEventListener("click", () => {
    score = 0;
    scoreDisplay.textContent = score;
    localStorage.setItem("clickerScore", score);
  });

  // Сохранение результата
  if (saveBtn) {
    saveBtn.addEventListener("click", async () => {
      try {
        const response = await fetch("/gameteka/save_score.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/x-www-form-urlencoded",
          },
          body: `game_type=clicker&score=${score}`,
        });

        if (response.ok) {
          alert("Результат сохранен!");
        } else {
          alert("Ошибка сохранения");
        }
      } catch (error) {
        console.error("Ошибка:", error);
        alert("Ошибка соединения");
      }
    });
  }
});
