/** @type {import('tailwindcss').Config} */
export default {
    content: ["./resources/**/*.blade.php", "./resources/**/*.js"],
    theme: {
        extend: {
            colors: {
                primary: "#0b3e75",
            },
        },
    },
    plugins: [
        require("tailwind-scrollbar"),
    ],
};
