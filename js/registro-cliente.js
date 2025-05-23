document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("registerForm");
    const contenedorErrores = document.querySelector(".container-errores");
    const contenedorInfo = document.getElementById("contenedor-info");
    const passwordToggle = document.getElementById("password-toggle");

    const validadorEmail = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    const validadorPassword = /^(?=.*[A-Z])(?=.*[^a-zA-Z0-9]).{10,}$/;
    const validadorApellidos = /^([\p{L}-]+\s+)+[\p{L}-]+$/u;

    passwordToggle.addEventListener("click", () => {
        const passwordInputs = document.getElementsByClassName('toogle');
        for (input of passwordInputs) {
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

    if (contenedorInfo) {
        for (let child of contenedorInfo.children) {
            child.style.transition = "opacity 0.3s ease";

            child.addEventListener("click", (e) => {
                e.target.style.opacity = "0";
                setTimeout(() => e.target.remove(), 300);
            });

            setTimeout(() => {
                if (child.parentNode === contenedorInfo) {
                    child.style.opacity = "0";
                    setTimeout(() => child.remove(), 300);
                }
            }, 10000);
        }
    }

    form.addEventListener("submit", (event) => {
        event.preventDefault();
        contenedorErrores.innerHTML = "";

        let errores = [];
        let camposVacios = false;

        const nombre = document.getElementById("nombre").value.trim();
        const apellidos = document.getElementById("apellidos").value.trim();
        const email = document.getElementById("email").value.trim();
        const password = document.getElementById("password").value;
        const confirmarPassword =
            document.getElementById("confirmarPassword").value;
        const terminos = document.getElementById("terminos").checked;

        if (!nombre || !apellidos || !email || !password || !confirmarPassword) {
            errores.push(new Error("Rellena todos los campos del formulario"));
            camposVacios = true;
        }

        if (!isNaN(nombre)) {
            errores.push(new Error("El nombre no puede ser un número"));
        }

        if (!validadorApellidos.test(apellidos)) {
            errores.push(
                new Error(
                    "Introduce al menos dos apellidos válidos. Se permiten letras y guiones."
                )
            );
        }

        if (!validadorEmail.test(email) && !camposVacios) {
            errores.push(
                new Error("El email introducido no tiene una sintaxis válida")
            );
        }

        if (!validadorPassword.test(password) && !camposVacios) {
            errores.push(
                new Error(
                    "La contraseña no cumple los requisitos de seguridad (mínimo 10 caracteres, una mayúscula y un carácter especial)"
                )
            );
        }

        if (password !== confirmarPassword && !camposVacios) {
            errores.push(new Error("Las contraseñas no coinciden"));
        }

        if (!terminos && !camposVacios) {
            errores.push(new Error("Debes aceptar los términos y condiciones"));
        }

        if (errores.length === 0) {
            console.info("FORMULARIO DE REGISTRO VÁLIDO => PASO A PHP");
            form.submit();
        } else {
            for (const error of errores) {
                const errorElement = document.createElement("p");
                errorElement.classList.add("error-element");
                errorElement.textContent = error.message;
                errorElement.addEventListener("click", (e) => {
                    e.target.remove();
                });
                contenedorErrores.appendChild(errorElement);
            }
        }
    });
});