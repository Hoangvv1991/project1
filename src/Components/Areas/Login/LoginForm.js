import React, { useState } from 'react';
import RegisterForm from './Register/RegisterForm';
import './LoginForm.css'; 

function LoginForm() {
  const [username, setUsername] = useState('');
  const [password, setPassword] = useState('');

  const [isFlipped, setIsFlipped] = useState(false);

  const handleSubmit = (event) => {
    event.preventDefault();
    console.log('Username:', username);
    console.log('Password:', password);
  };

  const handleForgottenPassword = () => {
    window.location.href = '/forgot-password';
  };

  const handleCreateUser = () => {
    setIsFlipped(!isFlipped);
  };

  const handleFlip = () => {
    setIsFlipped(!isFlipped);
  };

  return (
    <div className={`login-container ${isFlipped ? 'is-flipped' : ''}`}>
      <div className='card-inner'>
        <div className="card-login">
          <form onSubmit={handleSubmit} className="login-form">
            <h2 className="login-title">Welcome Back</h2>
            <div className="input-group">
              <label htmlFor="username">Username:</label>
              <input
                type="text"
                id="username"
                value={username}
                onChange={(e) => setUsername(e.target.value)}
                className="login-input"
              />
            </div>
            <div className="input-group">
              <label htmlFor="password">Password:</label>
              <input
                type="password"
                id="password"
                value={password}
                onChange={(e) => setPassword(e.target.value)}
                className="login-input"
              />
            </div>
            <button type="submit" className="login-button">Login</button>
            <p className="trans-p" onClick={handleForgottenPassword}>Forgotten Password?</p>
            <p className="trans-p" onClick={handleCreateUser}>Create new user</p>
          </form>
        </div>
        <RegisterForm handleFlip={handleFlip} />
      </div>
   </div>
  );
}

export default LoginForm;
