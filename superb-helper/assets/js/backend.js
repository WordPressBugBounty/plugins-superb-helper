function spbhlpr_LoadSpinner(title, msg) {
  var msgLength = msg.length;
  var titleLength = title.length;
  var charsPerLine = 12;
  var msgEmSize = charsPerLine / msgLength;
  var titleEmSize = charsPerLine / titleLength;
  var textBaseSize = 20;
  var msgFontSize;
  msgFontSize = msgEmSize < 0.52 ? msgEmSize * textBaseSize : 11;
  console.log(msgEmSize);
  console.log(msgFontSize);
  var titleFontSize;
  titleFontSize = titleEmSize < 1 ? titleEmSize * textBaseSize : textBaseSize;

  // Create container
  var container = document.createElement("div");
  container.id = "spbhlpr-load-spinner";

  // Create SVG using createElementNS
  var svg = document.createElementNS("http://www.w3.org/2000/svg", "svg");
  svg.setAttribute("width", "100%");
  svg.setAttribute("height", "100%");
  svg.setAttribute("viewBox", "0 0 100 100");
  svg.setAttribute("preserveAspectRatio", "xMidYMid");

  // Add circle
  var circle = document.createElementNS("http://www.w3.org/2000/svg", "circle");
  circle.setAttribute("cx", "50");
  circle.setAttribute("cy", "50");
  circle.setAttribute("fill", "none");
  circle.setAttribute("stroke", "#FFF");
  circle.setAttribute("stroke-width", "10");
  circle.setAttribute("r", "35");
  circle.setAttribute(
    "stroke-dasharray",
    "164.93361431346415 56.97787143782138"
  );
  circle.setAttribute("transform", "rotate(203.718 50 50)");

  // Add animation
  var animate = document.createElementNS(
    "http://www.w3.org/2000/svg",
    "animateTransform"
  );
  animate.setAttribute("attributeName", "transform");
  animate.setAttribute("type", "rotate");
  animate.setAttribute("calcMode", "linear");
  animate.setAttribute("values", "0 50 50;360 50 50");
  animate.setAttribute("keyTimes", "0;1");
  animate.setAttribute("dur", "1s");
  animate.setAttribute("begin", "0s");
  animate.setAttribute("repeatCount", "indefinite");

  // Add title text
  var titleText = document.createElementNS(
    "http://www.w3.org/2000/svg",
    "text"
  );
  titleText.setAttribute("x", "0%");
  titleText.setAttribute("y", "45%");
  titleText.setAttribute("textLength", "100%");
  titleText.setAttribute("style", "font-size:" + titleFontSize + "px");
  titleText.textContent = title;

  // Add message text
  var msgText = document.createElementNS("http://www.w3.org/2000/svg", "text");
  msgText.setAttribute("x", "0%");
  msgText.setAttribute("y", "60%");
  msgText.setAttribute("textLength", "100%");
  msgText.setAttribute("style", "font-size:" + msgFontSize + "px");
  msgText.textContent = msg;

  // Assemble the elements
  circle.appendChild(animate);
  svg.appendChild(circle);
  svg.appendChild(titleText);
  svg.appendChild(msgText);
  container.appendChild(svg);

  document.getElementById("wpwrap").appendChild(container);
}
