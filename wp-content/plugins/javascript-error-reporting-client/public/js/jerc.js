window.onerror = function (msg, url, lineNo, columnNo, error) {
    data = {
        nonce: jerc.nonce,
        message: msg,
        script: url,
        lineNo: lineNo,
        columnNo: columnNo,
        pageUrl: window.location.pathname
    }

    var xhr = new XMLHttpRequest();
    xhr.open("POST", jerc.url + "?action=" + jerc.action);
    xhr.setRequestHeader('Content-type', 'application/json;');
    xhr.send(encodeURI(JSON.stringify(data)));
    return false;
}