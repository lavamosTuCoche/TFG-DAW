document.addEventListener('DOMContentLoaded', () => {

    const passwordToggle = document.getElementById('password-toggle');
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const form = document.getElementById('loginForm');
    const contenedorErrores = document.getElementsByClassName('container-errores')[0];

    passwordToggle.addEventListener("click", () => {
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            passwordToggle.src = "../img/visible.png";
            passwordToggle.alt = "Imagen ojo abierto, indicando campo visible";
        } else {
            passwordInput.type = "password";
            passwordToggle.src = "../img/oculto.png";
            passwordToggle.alt = "Imagen ojo tachado, indicando campo oculto";
        }
    });

    form.addEventListener("submit", ($event) => {

        let errores = [], camposVacios;
        let validadorEmail = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        let validadorPassword = /^(?=.*[A-Z])(?=.*\W)[A-Za-z\d\W]{10,}$/;
        const email = emailInput.value;
        const password = passwordInput.value;

        $event.preventDefault();
        contenedorErrores.innerHTML = "";

        if ( !email || !password ) {
            errores.push( new Error('Rellena los campos del formulario de registro'));
            camposVacios = true;
        }
    
        if ( !email.match(validadorEmail) && !camposVacios) {
            errores.push(new Error('El email introducido no tiene una sintaxis correcta'))
        }
    
        if ( !password.match(validadorPassword) && !camposVacios ) {
            errores.push( new Error('La contraseña introducida no cumple con los requisitos de seguridad mínimos'))
        }
    
        if ( errores.length === 0 ) {
            console.info('FORMUALRIO LOGIN VALIDO => PASO A PHP');
            form.submit();
        }else{
            
            for (const error of errores) {
                    let errorElement = document.createElement("p");
                    errorElement.classList.add('error-element');
                    errorElement.textContent = error.message;
                    errorElement.addEventListener("click", ($event) => {
                    $event.target.remove();
                })
                contenedorErrores.append(errorElement);
            }
    
        }
    
    });

});