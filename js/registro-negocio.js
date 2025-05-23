document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("registerForm");
    const contenedorErrores = document.querySelector(".container-errores");
    const contenedorInfo = document.getElementById("contenedor-info");
    const passwordToggle = document.getElementById("password-toggle");
    const logoInput = document.getElementById("logo");
    const logoPreview = document.querySelector(".logo-negocio");

    const validadorEmail = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    const validadorPassword = /^(?=.*[A-Z])(?=.*[^a-zA-Z0-9]).{10,}$/;

    passwordToggle.addEventListener("click", () => {
        const passwordInputs = document.getElementsByClassName('toogle');
        for (let input of passwordInputs) {
            if (input.type === "password") {
                input.type = "text";
                passwordToggle.src = "../../img/visible.png";
                passwordToggle.alt = "Imagen ojo abierto, indicando campo visible";
            } else {
                input.type = "password";
                passwordToggle.src = "../../img/oculto.png";
                passwordToggle.alt = "Imagen ojo tachado, indicando campo oculto";
            }
        }
    });

    logoInput.parentElement.addEventListener('click', (e) => {
        console.log("Click en el botón de selección de archivo");
        for (child of e.childrens) {
            console.log("Hijo: ", child);
        }
    });

    form.addEventListener("submit", (event) => {
        event.preventDefault();

        contenedorErrores.innerHTML = "";

        let errores = [];
        let camposVacios = false;

        // Validación de email
        const emailInput = form.elements["email"];
        if (!validadorEmail.test(emailInput.value)) {
            errores.push("El email no es válido.");
        }

        // Validación de password
        const passwordInput = form.elements["password"];
        const confirmPasswordInput = form.elements["confirmarPassword"];
        if (!validadorPassword.test(passwordInput.value) || passwordInput.value !== confirmPasswordInput.value) {
            errores.push("Las contraseñas no coinciden o no cumplen con los requisitos.");
        }

        // Comprobación de campos vacíos
        for (let i = 0; i < form.elements.length; i++) {
            if (!form.elements[i].value && !form.elements[i].name.includes('password') && !form.elements[i].name.includes('email')) {
                camposVacios = true;
                break;
            }
        }

        if (camposVacios) {
            errores.push("Todos los campos son obligatorios.");
        }

        if (errores.length > 0) {
            for (let error of errores) {
                const errorElement = document.createElement("div");
                errorElement.classList.add("error-element");
                errorElement.textContent = error;
                contenedorErrores.appendChild(errorElement);
            }
        } else {
            form.submit();
        }
    });
});