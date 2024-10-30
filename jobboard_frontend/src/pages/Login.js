import React, { useState } from 'react';
import axios from 'axios';
import { useNavigate } from 'react-router-dom';
import "../CSS/Login.css";

const Login = () => {
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [error, setError] = useState('');
  const navigate = useNavigate();

  const handleLogin = (e) => {
    e.preventDefault();
    
    const existingToken = localStorage.getItem('token');
    if (existingToken) {
        localStorage.removeItem('token'); // Supprime le token existant si présent
    }

    // axios to fetch data from our users API
    axios.post('http://localhost:8000/api/login', { email, password })
      .then((response) => {
        const token = response.data.token;

        if (token) {
          localStorage.setItem('token', token);
          navigate('/dashboard'); // in case there is valid token
        } else {
          setError('Login failed. No token, try again.'); // in case there is no token
        }
      })
      .catch((error) => {
        if (error.response && error.response.status === 401) {
          setError('Login Failed. Invalid credentials.');
        } else {
          setError('Login Failed. Do you have an Account here?'); 
        }
      });
  };

  const handleSignup = () => {
    navigate('/signup');
  };

  return (
    <div className="loginPage">
      <div className="loginCard">

        <h1 className="loginTitle">Login</h1>
        <form className="loginForm" onSubmit={handleLogin}>

          <label className="inputGroup">
            <input
              type="email"
              placeholder="Email"
              className="inputField"
              value={email}
              onChange={(e) => setEmail(e.target.value)}
              required
            />
          </label>

          <label className="inputGroup">
            <input
              type="password"
              placeholder="Password"
              className="inputField"
              value={password}
              onChange={(e) => setPassword(e.target.value)}
              required
            />
          </label>

          {error && <p className="errorMessage">{error}</p>}

          <button type="submit" className="loginButton">Sign In</button>

        </form>

        <button onClick={handleSignup} className="signupButton">
          Create an Account
        </button>

      </div>
    </div>
  );
};

export default Login;
