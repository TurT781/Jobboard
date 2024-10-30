import React, { useEffect, useState } from "react";
import { useParams } from "react-router-dom";
import axios from "axios";
import "../CSS/Apply.css";

const Apply = () => {
    const { id } = useParams(); // Get the ID of the adv
    const [jobDetails, setJobDetails] = useState(null);
    const [error, setError] = useState(null);

    useEffect(() => {
        console.log("Applying for job ID:", id); // Vérification de l'ID

        const fetchJobDetails = async () => {
            try {
                const response = await axios.get(`http://localhost:8000/advertisements/${id}`);
                setJobDetails(response.data);
            } catch (error) {
                console.error("Error fetching job details:", error);
                setError("An error has occurred on our server. Please leave this page and try again to apply.");
            }
        };

        fetchJobDetails();
    }, [id]);

    const handleSubmit = async (event) => {
        event.preventDefault();

        const formData = new FormData(event.target);
        const applicationData = {
            firstName: formData.get('firstName'),
            lastName: formData.get('lastName'),
            phone: formData.get('tel'),
            email: formData.get('mail'),
            jobId: id,
        };

        try {
            await axios.post('http://localhost:8000/api/applications', applicationData);
            alert('Application submitted successfully!');
        } catch (error) {
            console.error('Error submitting application:', error);
            alert('Error submitting application. Please try again later.');
        }
    };

    if (error) {
        return (
            <div className="errorData">
                <h4>{error}</h4>
            </div>
        );
    }

    if (!jobDetails) {
        return (
            <div className="errorData">
                <h4>No job details found.</h4>
            </div>
        );
    }

    return (
        <section className='Apply'>
            <div className='ApplyContainer'>
                <h1 className='ApplyTitle'>{jobDetails.title}</h1>
                <p className='ApplyDescription'>{jobDetails.content}</p>

                <div className='ApplyForm'>
                    <form onSubmit={handleSubmit} className='Form'>
                        <div className='formGroup'>
                            <label htmlFor="firstName" className='FormLabel'>First Name:</label>
                            <input type="text" id="firstName" name='firstName' className='FormInput' required />
                        </div>
                        <div className='formGroup'>
                            <label htmlFor="lastName" className='FormLabel'>Last Name:</label>
                            <input type="text" id="lastName" name='lastName' className='FormInput' required />
                        </div>
                        <div className='formGroup'>
                            <label htmlFor="tel" className='FormLabel'>Phone:</label>
                            <input type="tel" id="tel" name='tel' className='FormInput' required />
                        </div>
                        <div className='formGroup'>
                            <label htmlFor="mail" className='FormLabel'>Email:</label>
                            <input type="email" id="mail" name='mail' className='FormInput' required />
                        </div>
                        <button type="submit" className='FormButton'>Submit Application</button>
                    </form>
                </div>
            </div>
        </section>


    );
};

export default Apply;
