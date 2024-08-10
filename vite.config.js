import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue'; // Sesuaikan dengan plugin yang digunakan

export default defineConfig({
  plugins: [vue()],
  build: {
    manifest: true,
    outDir: 'public/build',
  },
});
