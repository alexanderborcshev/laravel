/* eslint-disable import/prefer-default-export */
function fallbackCopyTextToClipboard(text) {
    const textArea = document.createElement('textarea');
    textArea.value = text;
    document.body.appendChild(textArea);
    textArea.focus();
    textArea.select();

    try {
        document.execCommand('copy');
    } catch (err) {
        console.error('Fallback: Oops, unable to copy', err);
    }

    document.body.removeChild(textArea);
}

function copyTextToClipboard(text) {
    if (!navigator.clipboard) {
        fallbackCopyTextToClipboard(text);
        return;
    }
    navigator.clipboard.writeText(text).then(
        () => {
        },
        (err) => {
            console.error('Async: Could not copy text: ', err);
        },
    );
}

// function forCycle(firstArr, secondArr = false, isBreak = false, callback) {
//     const keys = Object.keys(firstArr);
//     const values = Object.values(firstArr);
//     if (secondArr) {
//         for (let i = 0; i < keys.length; i += 1) {
//             const keysSecondArr = Object.keys(secondArr);
//             const valuesSecondArr = Object.values(secondArr);
//             for (let j = 0; j < keysSecondArr.length; j += 1) {
//                 callback(keys[i], keysSecondArr[j]);
//             }
//         }
//     } else {
//         for (let i = 0; i < keys.length; i += 1) {
//             callback(values);
//         }
//     }
// }

export { copyTextToClipboard };
