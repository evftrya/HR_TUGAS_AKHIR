import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: "class",
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Poppins", ...defaultTheme.fontFamily.sans],
            },
            screens: {
                hp: { max: "615px" },
            },
            colors: {
                primary: {
                    DEFAULT: "#1C2762",
                },
                secondary: {
                    50: "#EFF6FF",
                    100: "#DBEAFE",
                    500: "#3B82F6",
                    600: "#2563EB",
                    700: "#1D4ED8",
                },
            },
            boxShadow: {
                soft: "0 22px 45px rgba(15, 23, 42, 0.55)",
            },
        },
    },

    plugins: [forms],
};
