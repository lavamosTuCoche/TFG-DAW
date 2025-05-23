document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("registerForm");
    const contenedorErrores = document.querySelector(".container-errores");
    const contenedorInfo = document.getElementById("contenedor-info");
    const passwordToggle = document.getElementById("password-toggle");
    const logoContainer = document.getElementById("logoContainer");
    const logoPreview = document.querySelector(".logo-negocio");
    const inputFile = document.getElementById("logo");

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

    logoContainer.addEventListener('click', (e) => {
        inputFile.click();
    });

    inputFile.addEventListener("change", () => {
        const file = inputFile.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                logoPreview.src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    });

    logoPreview.addEventListener("click", () => {
        logoPreview.src = '../../img/logo-default.png';
    })

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