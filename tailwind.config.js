/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                primary: "#001524",
                secondary: "#FDE5D4",
                accent: "#445D48",
            },
        },
    },
    plugins: [],
};
