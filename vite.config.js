import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import tailwind from '@tailwindcss/vite'

export default defineConfig({
  plugins: [
    laravel({
      input: ['resources/css/app.css', 'resources/js/app.js'],
      refresh: true,
      // 👇 báo cho laravel-vite-plugin là bản build nằm trong /public/dist
      buildDirectory: 'dist',
    }),
    tailwind(),
  ],
  build: {
    // 👇 xuất file build vào /public/dist để Vercel trỏ thẳng tới
    outDir: 'public/dist',
    emptyOutDir: true,
  },
})
