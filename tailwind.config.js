/** @type {import('tailwindcss').Config} */

const usedColors = [
    "blue",
    "green",
    "red",
    "yellow",
    "purple",
    "indigo",
    "pink",
    "orange",
    "amber",
    "teal",
    "cyan",
    "lime",
    "emerald",
];

export default {
    content: ["./resources/**/*.blade.php", "./resources/**/*.js"],
    safelist: [
        ...usedColors.flatMap((color) => [
            `bg-${color}-500`,
            `bg-${color}-700`,
            "bg-green-50",
        ]),
    ],
    theme: {
        extend: {
            fontFamily: {
                inter: ["Inter", "sans-serif"],
            },
            animation: {
                wiggle: "wiggle 1s ease-in-out infinite",
                showUp: "showUp 0.5s ease-in-out",
                fadeIn: "fadeIn 0.5s ease-in-out",
            },
            keyframes: {
                wiggle: {
                    "0%, 100%": { transform: "rotate(-3deg)" },
                    "50%": { transform: "rotate(3deg)" },
                },
                showUp: {
                    "0%": { transform: "translateY(100%)", opacity: 0 },
                    "100%": { transform: "translateY(0)", opacity: 1 },
                },
                fadeIn: {
                    "0%": { opacity: 0 },
                    "100%": { opacity: 1 },
                },
            },
            colors: {
                primary: "#0b3e75",
            },
        },
    },
    plugins: [
        require("tailwind-scrollbar"),
        require("@tailwindcss/typography"),
    ],
};
