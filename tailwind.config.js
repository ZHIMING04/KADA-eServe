module.exports = {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],

    theme: {
        extend: {
            colors: {
                'primary': '#3B82F6',  // Light blue color
                'primary-hover': '#2563EB',  // Darker blue for hover
                'blue': {
                    400: '#60A5FA',
                    600: '#2563EB',
                },
                green: {
                    100: '#dcfce7',
                    700: '#15803d',
                },
                orange: {
                    300: '#fdba74',  // changed from 100 to 300 for darker shade
                    700: '#c2410c',
                },
                yellow: {
                    100: '#fef9c3',
                    700: '#a16207',
                },
                red: {
                    100: '#fee2e2',
                    700: '#b91c1c',
                },
                gray: {
                    100: '#f3f4f6',
                    700: '#374151',
                },
            },
            opacity: {
                '65': '0.65',
            },
            backgroundImage: {
                'paddy': "url('/images/paddy.jpg')",
            },
        },
    },

    plugins: [
        require('@tailwindcss/forms'),
    ],
}
