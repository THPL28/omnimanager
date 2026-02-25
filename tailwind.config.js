import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import daisyui from 'daisyui';

/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    './storage/framework/views/*.php',
    './resources/views/**/*.blade.php',
    './resources/js/**/*.js',
    './resources/**/*.vue',
    './resources/**/*.jsx',
  ],

  theme: {
    extend: {
      colors: {
        "primary": "#1313ec",
        "primary-hover": "#2e2ef1",
        "background-light": "#f6f6f8",
        "background-dark": "#050508", // Darker for Linear look
        "surface-light": "#FFFFFF",
        "surface-dark": "#121217",
        "border-light": "#E1E4EA",
        "border-dark": "rgba(255, 255, 255, 0.08)",
        "text-primary": "#1A202C",
        "text-secondary": "#64748B",
        "text-primary-dark": "#F8FAFC",
        "text-secondary-dark": "#94A3B8",
        // Keeping some legacy colors just in case
        "card-dark": "#121217", // Mapped to surface-dark
        "input-dark": "#050508", // Mapped to background-dark
        "text-muted": "#64748B", // Mapped to text-secondary
        "input-bg": "#121217", // Mapped to surface-dark
        "input-border": "rgba(255, 255, 255, 0.08)", // Mapped to border-dark
        "surface-border": "rgba(255, 255, 255, 0.08)",
      },
      fontFamily: {
        "display": ["Inter", "sans-serif"],
        "mono": ["ui-monospace", "SFMono-Regular", "Menlo", "Monaco", "Consolas", "Liberation Mono", "Courier New", "monospace"],
      },
      borderRadius: {
        "DEFAULT": "0.375rem",
        "lg": "0.5rem",
        "xl": "0.75rem",
        "2xl": "1rem",
        "full": "9999px"
      },
      backgroundImage: {
        'gradient-radial': 'radial-gradient(var(--tw-gradient-stops))',
      },
      boxShadow: {
        "soft": "0 2px 10px rgba(0, 0, 0, 0.03)",
        "glow": "0 0 20px -5px rgba(19, 19, 236, 0.3)"
      }
    },
  },

  plugins: [forms, daisyui],

  daisyui: {
    themes: [
      {
        light: {
          primary: '#1313ec',
          secondary: '#4B5563',
          accent: '#10B981',
          neutral: '#F9FAFB',
          'base-100': '#FFFFFF',
          info: '#3ABFF8',
          success: '#36D399',
          warning: '#FBBD23',
          error: '#F87272',
        },
        dark: {
          primary: '#1313ec',
          secondary: '#9CA3AF',
          accent: '#10B981',
          neutral: '#121217',   // surface-dark
          'base-100': '#050508', // background-dark
          info: '#3ABFF8',
          success: '#36D399',
          warning: '#FBBD23',
          error: '#F87272',
        },
      },
    ],
    darkTheme: 'dark',
  },

  darkMode: 'class', // para controlar dark mode via classe 'dark'
};