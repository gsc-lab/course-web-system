// --- React 앱 진입점 ---
// index.html의 <div id="root">에 React 앱을 마운트한다.
import React from 'react';
import ReactDOM from 'react-dom/client';
import App from './App';

// StrictMode: 개발 모드에서 잠재적 문제를 감지해주는 래퍼 (프로덕션에는 영향 없음)
ReactDOM.createRoot(document.getElementById('root')).render(
  <React.StrictMode>
    <App />
  </React.StrictMode>
);
