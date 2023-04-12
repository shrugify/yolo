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
