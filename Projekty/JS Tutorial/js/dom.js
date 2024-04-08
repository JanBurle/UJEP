let l = console.log

let getKnihy = () => {
    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (this.readyState == XMLHttpRequest.DONE && this.status == 200)
            l(this.responseXML);
    };

    xhr.open("GET", `/getxml.php?name=${name}`);
    xhr.send();
}


document.addEventListener('DOMContentLoaded', () => {  
  let d = document

  let knihy = d.getElementById('knihy')


})

