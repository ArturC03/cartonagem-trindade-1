/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./src/**/*.{html,php}"],
  theme: {
    extend: {
      keyframes: {
        fadeInOut: {
          '0%': { opacity: 0 },
          '50%': { opacity: 1 },
          '100%': { opacity: 0 },
        },
      },
      animation: {
        'fade-in-out': 'fadeInOut 0.5s ease-in-out',
      },
    },
  },
  plugins: [require("daisyui")],
}

