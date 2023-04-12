const board = document.getElementById("board");

const scoreElement = document.getElementById("score");
const scoreEndElement = document.getElementById("score-end");
const restartElem = document.querySelector("[data-restart]");
const restartBtn = document.querySelector("[data-restart-btn]");

const up = document.getElementById("up");
const down = document.getElementById("down");
const left = document.getElementById("left");
const right = document.getElementById("right");

//images
const bestlogo = new Image();
bestlogo.src = "images/best_logo1.png";

//board
let blockSize;
if (window.matchMedia("(max-width: 487px)").matches) {
  blockSize = 15;
  console.log("smanjeno");
} else {
  blockSize = 20;
  console.log("nije smanjeno");
}

let rows = 18;
let cols = 22;
let context;

//snake
let snakeX = blockSize * 5;
let snakeY = blockSize * 5;

let velocityX = 0;
let velocityY = 0;

let snakeBody = [];

let snakeSpeed = 200;

//food
let foodX;
let foodY;

let superFoodX = -50;
let superFoodY = -50;

//game
let gameOver = false;
let score = 0;
let foodEaten = 0;

restartBtn.addEventListener("click", () => {
  velocityX = 0;
  velocityY = 0;
  snakeX = blockSize * 5;
  snakeY = blockSize * 5;
  snakeBody = [];
  snakeSpeed = 200;

  score = 0;
  foodEaten = 0;

  placeFood();
  superFoodX = -50;
  superFoodY = -50;

  scoreElement.innerText = "" + score;
  restartElem.classList.add("hide");
  
  if (gameOver) {
    gameOver = false;
    loadFunction();
  }
});

window.addEventListener("load", loadFunction);

function loadFunction() {
  // restartElem = document.querySelector("[data-restart]");
  // console.log(restartElem);

  board.height = rows * blockSize;
  board.width = cols * blockSize;
  context = board.getContext("2d"); //used for drawing on the board

  placeFood();
  document.addEventListener("keyup", changeDirection);

  up.addEventListener("click", () => {
    changeDirectionBtn(2);
  });
  down.addEventListener("click", () => {
    changeDirectionBtn(8);
  });
  left.addEventListener("click", () => {
    changeDirectionBtn(4);
  });
  right.addEventListener("click", () => {
    changeDirectionBtn(6);
  });

  update();
  //100 milliseconds
}

function start() {}

function update() {
  if (gameOver) {
    return;
  }

  //BORDER
  context.fillStyle = "black";
  context.fillRect(0, 0, board.width, board.height);

  //FOOD
  //context.fillStyle="red";
  //context.fillRect(foodX, foodY, blockSize, blockSize);
  context.beginPath();
  context.arc(
    foodX + blockSize / 2,
    foodY + blockSize / 2,
    blockSize / 2,
    0,
    2 * Math.PI
  );
  context.fillStyle = "#69cd28";
  context.fill();

  //SUPERFOOD
  context.drawImage(
    bestlogo,
    superFoodX,
    superFoodY,
    blockSize * 2,
    blockSize * 2
  );

  //pojede food
  if (snakeX == foodX && snakeY == foodY) {
    snakeBody.push([foodX, foodY]);
    foodEaten++;
    placeFood();
    snakeSpeed *= 0.95;
    score += 10;
    scoreElement.innerText = "" + score;
    console.log(snakeSpeed);
  }
  //pojede superfood
  if (
    (snakeX == superFoodX || snakeX == superFoodX + blockSize) &&
    (snakeY == superFoodY || snakeY == superFoodY + blockSize)
  ) {
    score += 20;
    scoreElement.innerText = "" + score;
    snakeBody.push([superFoodX, superFoodY]);
    superFoodX = -50;
    superFoodY = -50;
  }

  //kretanje
  for (let i = snakeBody.length - 1; i > 0; i--) {
    snakeBody[i] = snakeBody[i - 1];
  }
  if (snakeBody.length) {
    snakeBody[0] = [snakeX, snakeY];
  }

  //ZMIJICA
  context.fillStyle = "#fff";
  snakeX += velocityX * blockSize;
  snakeY += velocityY * blockSize;
  context.fillRect(snakeX, snakeY, blockSize, blockSize);
  context.fillStyle = "#888";
  for (let i = 0; i < snakeBody.length; i++) {
    context.fillRect(snakeBody[i][0], snakeBody[i][1], blockSize, blockSize);
  }

  //prelazak na drugu stranu
  if (snakeX < 0) {
    snakeX = blockSize * (cols - 1);
  } else if (snakeX > (cols - 1) * blockSize) {
    snakeX = 0;
  } else if (snakeY < 0) {
    snakeY = blockSize * (rows - 1);
  } else if (snakeY > (rows - 1) * blockSize) {
    snakeY = 0;
  }

  //GAME OVER
  for (let i = 0; i < snakeBody.length; i++) {
    if (snakeX == snakeBody[i][0] && snakeY == snakeBody[i][1]) {
      //   gameOver = true;
      //   alert("Game Over");
      lose();
    }
  }

  setTimeout(update, snakeSpeed);
}

function lose() {
  gameOver = true;
  //   alert("Game Over");

  console.log("kraj");
  console.log(score);
  writeScore();
//   snakeSpeed = 200;

  scoreEndElement.innerText = "" + score;
  restartElem.classList.remove("hide");
}

//kretanje na tastaturi
function changeDirection(e) {
  if (e.code == "ArrowUp" && velocityY != 1) {
    velocityX = 0;
    velocityY = -1;
  } else if (e.code == "ArrowDown" && velocityY != -1) {
    velocityX = 0;
    velocityY = 1;
  } else if (e.code == "ArrowLeft" && velocityX != 1) {
    velocityX = -1;
    velocityY = 0;
  } else if (e.code == "ArrowRight" && velocityX != -1) {
    velocityX = 1;
    velocityY = 0;
  }
}

//kretanje na dugmice
function changeDirectionBtn(btn) {
  // console.log(btn);
  if (btn == 2 && velocityY != 1) {
    velocityX = 0;
    velocityY = -1;
  } else if (btn == 8 && velocityY != -1) {
    velocityX = 0;
    velocityY = 1;
  } else if (btn == 4 && velocityX != 1) {
    velocityX = -1;
    velocityY = 0;
  } else if (btn == 6 && velocityX != -1) {
    velocityX = 1;
    velocityY = 0;
  }
}

function superFoodDisappear() {
  superFoodX = -50;
  superFoodY = -50;
}

function placeFood() {
  if (foodEaten % 2 == 0 && foodEaten != 0 && superFoodX == -50) {
    superFoodX = Math.floor(Math.random() * cols - 1) * blockSize;
    superFoodY = Math.floor(Math.random() * rows - 1) * blockSize;
    setTimeout(superFoodDisappear, 5000);
  }
  //(0-1) * cols -> (0-19.9999) -> (0-19) * 25
  foodX = Math.floor(Math.random() * cols) * blockSize;
  foodY = Math.floor(Math.random() * rows) * blockSize;
}

function writeScore() {
  let request = $.post("score.php", { score: score });
  console.log(request);
  request.done(function (response) {
    console.log(response);
  });
}
