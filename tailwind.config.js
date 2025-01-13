/** @type {import('tailwindcss').Config} */

export default {
    content: ["./resources/**/*.blade.php", "./resources/**/*.js"],
    safelist: [
        "border-blue-500",
        "border-green-500",
        "border-red-500",
        "border-yellow-500",
        "border-purple-500",
        "border-orange-500",
        "border-pink-500",
        "border-cyan-500",
        "border-teal-500",
        "border-indigo-500",
        "border-lime-500",
        "border-emerald-500",
        "border-amber-500",
        "border-l-4",
        "bg-blue-500",
        "bg-blue-700",
        "bg-green-700",
        "bg-green-500",
        "bg-red-500",
        "bg-yellow-500",
        "bg-purple-500",
        "bg-orange-500",
        "bg-pink-500",
        "bg-cyan-500",
        "bg-teal-500",
        "bg-indigo-500",
        "bg-lime-500",
        "bg-emerald-500",
        "bg-amber-500",
        "bg-green-50",
        "bg-orange-50",
        "text-orange-400",
        "border-orange-200",
        "text-green-600",
        "border-green-200",
        "bg-blue-100",
        "bg-red-700",
    ],
    theme: {
        extend: {
            fontFamily: {
                inter: ["Inter", "sans-serif"],
                ginto: ["ABC Ginto Nord Unlicensed Trial", "sans-serif"],
            },
            animation: {
                wiggle: "wiggle 1s ease-in-out infinite",
                showUp: "showUp 0.5s ease-in-out",
                fadeIn: "fadeIn 0.5s ease-in-out",
                marquee: "marquee 20s linear infinite",
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
                marquee: {
                    "0%": { transform: "translateX(0%)" },
                    "100%": { transform: "translateX(-100%)" },
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
