# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project

S/W 인터페이스 설계 및 구현 교과목의 수업 예제 및 실습 코드 저장소.
각 예제는 Docker Compose로 독립 실행 가능하게 구성되어 있다.

## Run Examples

각 예제 폴더에서:

```bash
docker compose up        # 실행 (localhost:8080)
docker compose down      # 종료
docker compose up --build  # Dockerfile 변경 시 재빌드
```

## Architecture

- `01-web-intro/` — Web 시스템 개론 (6단계 진행형)
  - 01~02: Nginx만 또는 Nginx + PHP-FPM
  - 03~05: Nginx + PHP-FPM + MySQL (Dockerfile로 pdo_mysql 확장 설치)
  - 06: Nginx + Node(Vite/React) + PHP-FPM + MySQL
- `02-nginx/` — Nginx 설정 실습
- `03-html/`, `04-css/` — 정적 파일 예제 (Docker 불필요, 브라우저에서 직접 열기)

## Conventions

- 모든 Docker 예제는 포트 8080 사용
- PHP + MySQL 예제는 공통 Dockerfile (php:8.3-fpm + pdo_mysql)
- DB 초기 데이터는 sql/init.sql로 자동 로드 (docker-entrypoint-initdb.d)
- MySQL 접속 정보: host=db, user=root, password=root, database=example
