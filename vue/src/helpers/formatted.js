/**
 * declOfNumber(count, ['найдена', 'найдено', 'найдены']);
 * @param number
 * @param titles
 * @returns {*}
 */
export function declOfNumber(number, titles) {
    const cases = [2, 0, 1, 1, 1, 2];
    return titles[(number % 100 > 4 && number % 100 < 20) ? 2 : cases[(number % 10 < 5) ? number % 10 : 5]];
}
export function numberFormat(number, decimals, decPoint, thousandsSep) { // Format a number with grouped thousands
    let num = number;
    let decPointParse = decPoint;
    let thousandsSepParse = thousandsSep;
    let decimalsParse = decimals;
    let j; let resp;

    const minus = num < 0;
    if (minus) {
        num *= -1;
    }

    // input sanitation & defaults
    decimalsParse = Math.abs(decimalsParse);
    if (Number.isNaN(decimalsParse)) {
        decimalsParse = 2;
    }
    if (decPointParse === undefined) {
        decPointParse = ',';
    }
    if (thousandsSepParse === undefined) {
        thousandsSepParse = '.';
    }

    num = (+num || 0).toFixed(decimalsParse);
    const i = `${parseInt(num, 10)}`;
    j = i.length;
    if (j > 3) {
        j %= 3;
    } else {
        j = 0;
    }

    const km = (j ? i.substr(0, j) + thousandsSepParse : '');
    const kw = i.substr(j).replace(/(\d{3})(?=\d)/g, `$1${thousandsSepParse}`);
    const kd = (decimalsParse ? decPointParse + Math.abs(num - i).toFixed(decimalsParse).replace(/-/, 0).slice(2) : '');

    resp = km + kw + kd;

    if (minus) {
        resp = `-${resp}`;
    }

    return resp;
}
