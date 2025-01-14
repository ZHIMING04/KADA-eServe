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
            },
            opacity: {
                '65': '0.65',
            }
        },
    },

    plugins: [
        require('@tailwindcss/forms'),
    ],
}
