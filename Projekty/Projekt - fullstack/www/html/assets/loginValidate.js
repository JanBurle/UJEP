function loginSubmit(e) {
    e.preventDefault()
    
    let {jmeno, heslo} = this.elements

    if ((jmeno.value = jmeno.value.trim()).length < 3) {
        alert('Jméno je krátké')
        return
    }

    if ('heslo' == (heslo.value = heslo.value.trim())) {
        alert('Heslo nesmí být "heslo"')
        return
    }

    this.submit()
}

document.loginForm.addEventListener("submit", loginSubmit)