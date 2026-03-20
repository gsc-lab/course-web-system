// --- React SPA (Single Page Application) ---
// SPA의 핵심: 하나의 HTML 페이지에서 JavaScript가 화면을 동적으로 전환한다.
// 링크를 클릭해도 브라우저가 새 HTML을 서버에 요청하지 않고,
// React가 현재 페이지 내에서 컴포넌트만 교체한다 (클라이언트 사이드 라우팅).

import { useState, useEffect } from 'react';

// =============================================
// 페이지 컴포넌트들 — SPA에서 각 "페이지"는 사실 컴포넌트이다
// =============================================

// 홈 페이지 컴포넌트
function HomePage() {
  return (
    <div>
      <h2>홈</h2>
      <p>SPA(Single Page Application) 예제입니다.</p>
      <p>위 메뉴를 클릭해보세요. 페이지가 <strong>새로고침되지 않고</strong> 화면만 전환됩니다.</p>
      <div style={{ background: '#f0f0f0', padding: '15px', borderRadius: '5px', marginTop: '10px' }}>
        <p><strong>SPA vs MPA (Multi Page Application)</strong></p>
        <ul>
          <li><strong>MPA</strong>: 링크 클릭 → 서버에 새 HTML 요청 → 전체 페이지 새로고침</li>
          <li><strong>SPA</strong>: 링크 클릭 → JavaScript가 컴포넌트 교체 → 새로고침 없음</li>
        </ul>
      </div>
    </div>
  );
}

// 사용자 관리 페이지 컴포넌트
function UsersPage() {
  // useState: 상태가 변경되면 이 컴포넌트만 자동으로 리렌더링
  const [users, setUsers] = useState([]);
  const [name, setName] = useState('');
  const [email, setEmail] = useState('');

  const loadUsers = () => {
    fetch('/api/users')
      .then((res) => res.json())
      .then((data) => setUsers(data));
  };

  // useEffect: 이 컴포넌트가 화면에 나타날 때(마운트) 한 번 실행
  useEffect(() => { loadUsers(); }, []);

  const addUser = () => {
    if (!name || !email) return;
    fetch('/api/users', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ name, email }),
    }).then(() => {
      setName('');
      setEmail('');
      loadUsers();
    });
  };

  const deleteUser = (id) => {
    fetch('/api/users/' + id, { method: 'DELETE' }).then(() => loadUsers());
  };

  return (
    <div>
      <h2>사용자 관리</h2>
      <div style={{ marginBottom: '10px' }}>
        <input value={name} onChange={(e) => setName(e.target.value)} placeholder="이름" />
        <input value={email} onChange={(e) => setEmail(e.target.value)} placeholder="이메일" />
        <button onClick={addUser}>추가</button>
      </div>
      <table>
        <thead>
          <tr><th>ID</th><th>이름</th><th>이메일</th><th>등록일</th><th>작업</th></tr>
        </thead>
        <tbody>
          {users.map((u) => (
            <tr key={u.id}>
              <td>{u.id}</td>
              <td>{u.name}</td>
              <td>{u.email}</td>
              <td>{u.created_at}</td>
              <td><button onClick={() => deleteUser(u.id)}>삭제</button></td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
}

// 소개 페이지 컴포넌트
function AboutPage() {
  return (
    <div>
      <h2>아키텍처</h2>
      <pre style={{ background: '#f0f0f0', padding: '15px', borderRadius: '5px', lineHeight: '1.8' }}>
{`브라우저 (React SPA)
  │
  ├── 페이지 요청 → Nginx → Vite (React 앱 제공)
  │
  └── API 요청  → Nginx → PHP-FPM → MySQL
                   :80     :9000     :3306`}
      </pre>
      <table>
        <thead><tr><th>컨테이너</th><th>역할</th></tr></thead>
        <tbody>
          <tr><td>Nginx</td><td>리버스 프록시 (프론트/백엔드 분기)</td></tr>
          <tr><td>Node (Vite)</td><td>React 개발 서버 (HMR)</td></tr>
          <tr><td>PHP-FPM</td><td>REST API 백엔드</td></tr>
          <tr><td>MySQL</td><td>데이터 저장소</td></tr>
        </tbody>
      </table>
    </div>
  );
}

// =============================================
// 메인 App — 클라이언트 사이드 라우팅
// =============================================
function App() {
  // 현재 어떤 "페이지"를 보여줄지 상태로 관리
  // 서버에 요청하지 않고, 이 상태값만 바꿔서 화면을 전환한다
  const [page, setPage] = useState('home');

  // 페이지 최초 로드 시각 — SPA에서는 화면을 전환해도 이 값이 유지됨
  const [loadTime] = useState(new Date().toLocaleTimeString());

  // 상태값에 따라 보여줄 컴포넌트를 선택 (클라이언트 사이드 라우팅)
  const renderPage = () => {
    switch (page) {
      case 'home':  return <HomePage />;
      case 'users': return <UsersPage />;
      case 'about': return <AboutPage />;
      default:      return <HomePage />;
    }
  };

  return (
    <div style={{ fontFamily: 'sans-serif', margin: '2rem' }}>
      <h1>React SPA 예제</h1>

      {/* 네비게이션 — 클릭 시 상태만 변경, 서버 요청 없음 */}
      <nav style={{ display: 'flex', gap: '5px', marginBottom: '15px' }}>
        <button onClick={() => setPage('home')}  style={page === 'home'  ? activeStyle : btnStyle}>홈</button>
        <button onClick={() => setPage('users')} style={page === 'users' ? activeStyle : btnStyle}>사용자 관리</button>
        <button onClick={() => setPage('about')} style={page === 'about' ? activeStyle : btnStyle}>아키텍처</button>
      </nav>

      {/* SPA 증거: 페이지를 전환해도 아래 시각이 변하지 않는다 */}
      <p style={{ color: '#888', fontSize: '14px' }}>
        페이지 로드 시각: <strong>{loadTime}</strong> — 메뉴를 눌러도 이 시각은 변하지 않습니다 (새로고침 없음)
      </p>

      <hr />

      {/* 현재 page 상태에 해당하는 컴포넌트만 렌더링 */}
      {renderPage()}
    </div>
  );
}

// 네비게이션 버튼 스타일
const btnStyle = {
  padding: '8px 16px', cursor: 'pointer',
  border: '1px solid #ccc', borderRadius: '4px', background: '#fff',
};
const activeStyle = {
  ...btnStyle,
  background: '#2196F3', color: '#fff', borderColor: '#2196F3',
};

export default App;
