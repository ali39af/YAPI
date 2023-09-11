const errorTextElement = document.getElementById('error-text');
let currentIndex = 0;

function writeErrorText(errorText) {
    if (currentIndex < errorText.length) {
        errorTextElement.textContent += errorText[currentIndex];
        currentIndex++;
        setTimeout(() => writeErrorText(errorText), 20);
    }
}
