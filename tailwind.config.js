/** @type {import('tailwindcss').Config} */
module.exports = {
    content: ["./resources/**/*.blade.php", "./node_modules/flowbite/**/*.js"],
    theme: {
        extend: {
            colors: {
                "primary": "#2F2E2E",
                "primary-dark": "#0F0F0F",
                "primary-light": "#7A7973",
                "primary-superlight":"#BABABA",
                "secondary": "#F0E4D5",
                "secondary-dark": "#F0E4D5",
                "secondary-light": "#F0E4D5",
                "dark": "#464646",
                "dark-medium": "#555555",
                "dark-light": "#F5F5F5",
            },
        },
        borderColor: {
            "custom-border-color": "#FF5733",
            "focus-border-color": "#E10098", // Define el color de borde enfocado personalizado aquí
        },   
        ringColor: {
            "custom-ring-color": "#E10098", // Define el color de anillo personalizado aquí
        },

    },
    plugins: [require("flowbite/plugin")],
    variants: {
        extend: {
            borderColor: ['focus'], // Habilita las clases de borde enfocado
        },
    },

};
