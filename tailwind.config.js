module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            keyframes: {
                'scale-up': {
                    '0%, 100%': {transform: 'scale(1.0)'},
                    '50%': {transform: 'scale(1.05)'},
                },
                flip: {
                    '0%': {transform: 'rotateX(-180deg)'},
                    '100%': {transform: 'rotateX(0deg)'}
                },
                flipTwo: {
                    '0%, 50%': {transform: 'rotateX(-180deg)'},
                    '100%': {transform: 'rotateX(0deg)'}
                },
                flipThree: {
                    '0%, 66%': {transform: 'rotateX(-180deg)'},
                    '100%': {transform: 'rotateX(0deg)'}
                }
            },
            animation: {
                'scale-up': 'scale-up .3s linear 1',
                flip: 'flip 1s ease-in-out 1',
                flipTwo: 'flip 2s ease-in-out 1',
                flipThree: 'flip 3s ease-in-out 1',
            }
        },
    },
    plugins: [],
}
