import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import viteReact from "@vitejs/plugin-react";

export default defineConfig({
  plugins: [
    viteReact(),
    laravel({
      input: ["resources/css/app.css", "resources/js/app.tsx"],
      refresh: true,
    }),
  ],
  resolve: {
    alias: {
      "@": "/resources/js",
    },
  },
});
