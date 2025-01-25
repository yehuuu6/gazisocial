/** @type {import('tailwindcss').Config} */

const disabledCss = {
    "code::before": false,
    "code::after": false,
    "blockquote p:first-of-type::before": false,
    "blockquote p:last-of-type::after": false,
    pre: false,
    code: false,
    "pre code": false,
    "code::before": false,
    "code::after": false,
};

export default {
    content: ["./resources/**/*.blade.php", "./resources/**/*.js"],
    theme: {
        extend: {
            typography: {
                DEFAULT: { css: disabledCss },
                sm: { css: disabledCss },
                lg: { css: disabledCss },
                xl: { css: disabledCss },
                "2xl": { css: disabledCss },
            },
            fontFamily: {
                inter: ["Inter", "sans-serif"],
                ginto: ["ABC Ginto Nord Unlicensed Trial", "sans-serif"],
                satisfy: ["Satisfy", "cursive"],
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
