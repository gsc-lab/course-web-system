import { defineConfig } from 'vite';
import react from '@vitejs/plugin-react';

export default defineConfig({
  plugins: [react()],      // React JSX 변환 및 HMR 지원
  server: {
    proxy: {
      // 개발 서버에서 /api 요청을 Nginx(web:80)로 프록시
      // → Vite 직접 접속(localhost:3000) 시에도 API 호출 가능
      '/api': 'http://web:80'
    }
  }
});
