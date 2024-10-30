import React, { useState } from 'react';
import "../CSS/SignUp.css"
import axios from 'axios';

const SignUp = () => {
  const [firstName, setFirstName] = useState("");
  const [lastName, setLastName] = useState("");
  const [phoneNumber, setPhoneNumber] = useState("");
  const [email, setEmail] = useState("");
  // this one is to check if password === confirmPassword
  const [password, setPassword] = useState({
    password: "",
    confirmPassword: "",
  });

  //Send error if there's an error by this state (like in login page)
  const [error, setError] = useState("");
  const [success, setSuccess] = useState("");

  const checkPassword = (e) => {
    setPassword({ ...password, [e.target.name]: e.target.value });
  };

  const submit = async (e) => {
    e.preventDefault();
    if (password.password !== password.confirmPassword) {
      setError("Your Passwords Are Not The Same ! ")
      return;
    }

    //this is an object, thats what we are sending to our DB
    const userData = {
      first_name: firstName,
      last_name: lastName,
      phone_number: phoneNumber,
      email: email,
      password: password.password,
    };
    console.log(userData); // Ajoutez cette ligne pour déboguer

    try {
      const response = await axios.post('http://localhost:8000/api/registration', { 
        userData: userData });
      setSuccess(response.data.message);
      setError("");
      setFirstName("");
      setLastName("");
      setPhoneNumber("");
      setEmail("");
      setPassword({ password: "", confirmPassword: "" });
    } catch (error) {
      if (error.response) {
        setError(error.response.data.message); // Afficher le message d'erreur de l'API
      } else {
        setError("An unexpected error occurred.");
      }
    }
  };

  return (
    <section className='signUpPage'>
      <div className='container'>
        <h1>Sign Up</h1>
        <form onSubmit={submit}>

          <label>
            <input
              type="text"
              placeholder='First Name'
              className='inputField'
              value={firstName}
              onChange={(e) => setFirstName(e.target.value)}
              required
            />

            <input
              type="text"
              placeholder='Last Name'
              className='inputField'
              value={lastName}
              onChange={(e) => setLastName(e.target.value)}
              required
            />

            <input
              type="number"
              placeholder='Phone Number'
              className='inputField'
              value={phoneNumber}
              onChange={(e) => setPhoneNumber(e.target.value)}
              required
            />

            <input
              type="email"
              placeholder='Email'
              className='inputField'
              value={email}
              onChange={(e) => setEmail(e.target.value)}
              required
            />

            <input
              type="password"
              placeholder='Password'
              className='inputField'
              value={password.password}
              name='password'
              onChange={checkPassword}
              required
            />

            <input
              type="password"
              placeholder='Confirm Password'
              className='inputField'
              value={password.confirmPassword}
              name='confirmPassword'
              onChange={checkPassword}
              required
            />

            {/* display if its an error or a success on the screen */}
            {error && <p className="errorMessage">{error}</p>}
            {success && <p className="successMessage">{success}</p>}
            <button type="submit" className="submitButton">Submit</button>


          </label>
        </form>
      </div>
    </section>
  );
};
export default SignUp;