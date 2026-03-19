// --- React SPA (Single Page Application) ---
// 하나의 HTML 페이지 위에서 React가 UI를 동적으로 렌더링한다.
// 페이지 전환 없이 컴포넌트 단위로 화면을 업데이트하는 것이 SPA의 핵심이다.

import { useState, useEffect } from 'react';

function App() {
  // useState: React의 상태 관리 Hook — 상태가 변경되면 컴포넌트가 자동 리렌더링
  const [users, setUsers] = useState([]);    // 사용자 목록
  const [name, setName] = useState('');      // 입력 폼: 이름
  const [email, setEmail] = useState('');    // 입력 폼: 이메일

  // REST API 호출하여 사용자 목록 갱신
  const loadUsers = () => {
    fetch('/api/users')
      .then((res) => res.json())
      .then((data) => setUsers(data));
  };

  // useEffect: 컴포넌트 마운트(최초 렌더링) 시 한 번 실행
  // 두 번째 인자 []는 의존성 배열 — 빈 배열이면 마운트 시에만 실행
  useEffect(() => { loadUsers(); }, []);

  // POST 요청으로 새 사용자 추가 후 목록 갱신
  const addUser = () => {
    fetch('/api/users', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ name, email }),    // ES6 단축 속성: { name: name } → { name }
    }).then(() => {
      setName('');
      setEmail('');
      loadUsers();
    });
  };

  // DELETE 요청으로 사용자 삭제
  const deleteUser = (id) => {
    fetch('/api/users/' + id, { method: 'DELETE' }).then(() => loadUsers());
  };

  return (
    <div>
      <h1>사용자 관리 (React SPA)</h1>
      <div>
        <input value={name} onChange={(e) => setName(e.target.value)} placeholder="이름" />
        <input value={email} onChange={(e) => setEmail(e.target.value)} placeholder="이메일" />
        <button onClick={addUser}>추가</button>
      </div>
      <table border="1" style={{ marginTop: '10px', borderCollapse: 'collapse' }}>
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

export default App;
