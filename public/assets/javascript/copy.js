const commitCmd = document.querySelector("code.typing").innerHTML.trim();
const copyBtn = document.querySelector(".clipboardBtn");

copyBtn.addEventListener("click", () => {
  navigator.clipboard.writeText(commitCmd)
    .then(() => {
      console.log("✅");
    })
    .catch((error) => {
      console.error("Error copying text to clipboard:", error);
    });
});


const steps = commitCmd.length;
const duration = steps / 12;
document.querySelector("code.typing").style.animation = `
  typewrite ${duration}s steps(${steps}, end) forwards,
  caret .75s step-end infinite
`;
