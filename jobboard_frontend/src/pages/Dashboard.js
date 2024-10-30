import React, { useEffect, useState } from 'react';
import axios from 'axios';
import { useNavigate } from 'react-router-dom'; 
import "../CSS/Dashboard.css";

const Dashboard = () => {
  const [applications, setApplications] = useState([]);
  const [isLoggedIn, setIsLoggedIn] = useState(true);
  const [error, setError] = useState(null); 
  const navigate = useNavigate();

  useEffect(() => {
    const token = localStorage.getItem('token');
    if (!token) {
      setIsLoggedIn(false);
      navigate('/login'); 
      return;
    }

    axios.get('http://localhost:8000/api/applications', {
      headers: { Authorization: `Bearer ${token}` }
    })
      .then(response => {
        setApplications(response.data);
      })
      .catch(error => {
        setError('Error fetching job applications');
        console.error('Error fetching job applications:', error);
      });
  }, [navigate]);

  if (!isLoggedIn) {
    return <p>Please login first</p>;
  }

  if (error) {
    return <p>{error}</p>;
  }

  return (
    <section className='dashboard'>
      <div className='dashboardContainer'>
        {applications.length === 0 ? (
          <p>You haven't applied to any jobs yet.</p>
        ) : (
          <ul>
            {applications.map((application, index) => (
              <li key={index}>
                <h3>{application.jobTitle}</h3>
                <p>{application.companyName}</p>
              </li>
            ))}
          </ul>
        )}
      </div>
    </section>
  );
};

export default Dashboard;
