# 06 - SPA (React)

React + Vite로 SPA(Single Page Application)를 구성하고, PHP REST API 백엔드와 연동한다.

## 구성도

```
브라우저
  │
  ├── 페이지 요청 → Nginx → Vite 개발 서버 (React SPA)
  │                 (:80)   proxy_pass (:3000)
  │
  └── API 요청   → Nginx → PHP-FPM → MySQL
                   (:80)   fastcgi   (:3306)
                            (:9000)
```

## 기술 스택

| 컨테이너 | 이미지 | 역할 |
|-----------|--------|------|
| web | nginx:alpine | 리버스 프록시 (프론트/백엔드 분기) |
| app | node:20-alpine | Vite 개발 서버 (React HMR) |
| php | php:8.3-fpm (커스텀) | REST API 백엔드 |
| db | mysql:8.0 | 데이터 저장소 |

## 실행

```bash
docker compose up
# http://localhost:8080 접속
```

## 핵심 개념

- **SPA (Single Page Application)**: 하나의 HTML 페이지에서 JavaScript가 화면을 동적으로 렌더링. 페이지 전환 없이 부드러운 UX 제공
- **React**: 컴포넌트 기반 UI 라이브러리. `useState`/`useEffect` Hook으로 상태와 생명주기 관리
- **Vite**: 차세대 프론트엔드 빌드 도구. HMR(Hot Module Replacement)로 코드 수정 즉시 반영
- **리버스 프록시**: Nginx가 URL 경로에 따라 프론트엔드(Vite)와 백엔드(PHP)로 트래픽 분기
- **CORS**: 프론트엔드와 백엔드가 분리되어 있으므로 Cross-Origin 헤더 필요
- **05와의 차이**: 05는 Vanilla JS + 서버 렌더링 HTML, 06은 React SPA + 프론트/백엔드 완전 분리

## 파일 구조

```
06-spa-react/
├── Dockerfile              # PHP + pdo_mysql
├── docker-compose.yml      # 4개 컨테이너 (Nginx, Node, PHP, MySQL)
├── nginx.conf              # 리버스 프록시 (경로별 분기)
├── api/
│   └── index.php           # REST API (CORS 지원)
├── frontend/
│   ├── index.html          # SPA 진입점 (<div id="root">)
│   ├── package.json        # Node.js 의존성 (React, Vite)
│   ├── vite.config.js      # Vite 설정 (프록시 포함)
│   └── src/
│       ├── main.jsx        # React 앱 마운트
│       └── App.jsx         # 메인 컴포넌트 (사용자 CRUD UI)
└── sql/
    └── init.sql            # 초기 데이터
```
