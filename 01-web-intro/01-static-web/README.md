# 01 - 정적 Web

Nginx가 HTML 파일을 그대로 클라이언트에 전달하는 가장 기본적인 웹 서버 구성이다.

## 구성도

```
브라우저 ──── HTTP 요청 ────▶ Nginx ──── index.html 반환
                              (:80)
```

## 기술 스택

| 컨테이너 | 이미지 | 역할 |
|-----------|--------|------|
| web | nginx:alpine | 정적 파일 서빙 |

## 실행

```bash
docker compose up
# http://localhost:8080 접속
```

## 핵심 개념

- **정적 웹**: 서버가 미리 작성된 HTML 파일을 그대로 전달한다. 서버 측 로직이 없다.
- **볼륨 마운트**: `./src`를 컨테이너의 웹 루트에 읽기 전용(`:ro`)으로 연결한다.

## 파일 구조

```
01-static-web/
├── docker-compose.yml   # Docker Compose 설정
└── src/
    └── index.html       # 정적 HTML 파일
```
