const square = document.getElementById("square");
const ctx = square.getContext("2d");

ctx.moveTo(0, 0);
ctx.lineTo(50, 50);

ctx.moveTo(0, 50);
ctx.lineTo(50, 0);

ctx.strokeStyle = "#c21278";
ctx.lineWidth = 2;

ctx.stroke();

ctx.lineWidth = 5;
ctx.strokeRect(0, 0, 50, 50);
