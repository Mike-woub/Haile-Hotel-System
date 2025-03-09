/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./build/*.{html,php}",
     './build/php/**/*.{html,php}', 
  ],
  theme: {
    extend: {
      
        'gridTemplateColumns':{ 
          'griddy': '3fr 1fr',
          'haile': '1.25fr 1fr',
          'service': '1fr 1fr 1fr',
          'dest': '10px 1fr',
          'dashboard': '4fr 1fr',
          'gdashboard': '1.25fr 2fr',
          'rooms': '2fr 1fr',
          'reservation': '1fr 1fr',
         }, 
        'gridTemplateRows':{ 
          'griddy': '3fr 1fr',
          'haile': '1.25fr 1fr',
          'service': '1fr 1fr 1fr',
          'dest': '10px 1fr',
          'dashboard': '4fr 1fr',
         }, 
    },
  },
  plugins: [],
}

