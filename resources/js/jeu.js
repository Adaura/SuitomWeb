const theword = "{{$mot->mot}}";
let words = [],
    word = theword.slice(0, 1);
console.log(theword);
document.onkeypress = function (e) {
    if (word.length === theword.length) {
    } else {
        const col = words.length * theword.length + word.length;
        if (
            (e.keyCode >= 65 && e.keyCode <= 90) ||
            (e.keyCode >= 97 && e.keyCode <= 122)
        ) {
            word += e.key;
            document.getElementsByTagName("td")[col].innerHTML =
                e.key.toUpperCase();
        }
    }
};
document.onkeydown = (e) => {
    const col = words.length * theword.length + word.length;
    if (e.keyCode === 13 && word.length === theword.length) {
        words.push(word);
        if (word.toUpperCase() === theword.toUpperCase()) {
            document.getElementById("mot").value = theword;
            document.forms[0].submit();
        }
        word = theword.slice(0, 1);
        document.getElementsByTagName("td")[col].innerHTML = word;
    }
    if (e.keyCode === 8 && word.length > 1) {
        word = word.slice(0, -1);
        document.getElementsByTagName("td")[col - 1].innerHTML = "";
    }
};
