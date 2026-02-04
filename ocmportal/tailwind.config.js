/** @type {import('tailwindcss').Config} */
export default {
  purge: [
    "./src/components/**/*.vue" ,
    "./src/layouts/**/*.vue" 
  ],
  darkMode: false, // or 'media' or 'class'
  content: [
    "./index.html",
    "./src/**/*.{js,ts,jsx,tsx}",
  ],
  theme: {
    extend: {
      fontSize: {
        'xxxxxs' : '.3rem' ,
        'xxxxs' : '.4rem' ,
        'xxxs' : '.5rem' ,
        'xxs' : '.6rem' ,
      },
      backgroundSize: {
          '90%': '90%' ,
          '85%': '85%' ,
          '80%': '80%' ,
          '75%': '75%' ,
          '50%': '50%' ,
          '25%': '25%' ,
          '10%': '10%' ,
          '10px': '10px' ,
          '20px': '20px' ,
          '30px': '30px' ,
          '40px': '40px' ,
          '50px': '50px' ,
          '60px': '60px'
      },
    },
  },
  plugins: [
    // require('@tailwindcss/line-clamp'),
  ],
}

