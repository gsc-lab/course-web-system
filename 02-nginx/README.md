# 02 - Nginx 웹서버 설정 실습

Nginx 설정 파일을 직접 수정하며 웹서버 동작 원리를 학습한다.

## 구성도

```
브라우저 ──▶ Nginx ──▶ 정적 파일 반환
             (:80)
```

## 실행

```bash
docker compose up
# http://localhost:8080 접속
```

## 학습 포인트

| 설정 항목 | 설명 |
|-----------|------|
| `listen` | 수신 포트 지정 |
| `server_name` | 가상 호스트 도메인 매칭 |
| `root` / `index` | 문서 루트 및 기본 파일 |
| `try_files` | 요청 URI 매칭 순서 (파일 → 디렉토리 → 오류) |
| `access_log` / `error_log` | 로그 파일 경로 |
| `expires` / `Cache-Control` | 브라우저 캐시 제어 |
| `location` 블록 | URL 패턴별 처리 규칙 (prefix, regex) |

## 파일 구조

```
02-nginx/
├── docker-compose.yml   # Nginx 단독 컨테이너
├── conf/
│   └── default.conf     # Nginx 설정 파일 (편집 대상)
└── html/
    └── index.html       # 테스트용 정적 페이지
```
