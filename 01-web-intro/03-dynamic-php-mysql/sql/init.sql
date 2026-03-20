-- 이 파일은 MySQL 컨테이너 최초 기동 시 자동 실행된다.
-- docker-entrypoint-initdb.d 디렉토리에 마운트된 .sql 파일은 알파벳 순으로 실행된다.

-- SQL 파일 실행 시 클라이언트 문자셋을 utf8mb4로 설정 (한글 깨짐 방지)
SET NAMES utf8mb4;

-- 사용자 테이블 생성 (utf8mb4: 한글·이모지 등 다국어 지원 문자셋)
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,          -- 자동 증가 기본키
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP  -- 레코드 생성 시각 자동 기록
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 초기 샘플 데이터 삽입
INSERT INTO users (name, email) VALUES
('홍길동', 'hong@example.com'),
('김철수', 'kim@example.com'),
('이영희', 'lee@example.com');
