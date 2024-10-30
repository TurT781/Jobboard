import React, { useState } from 'react';
import { FaSearch } from "react-icons/fa";
import axios from 'axios';
import "../CSS/SearchBar.css"

export const SearchBar = ({ setResults }) => {
    //function to know what the user is searching for : 
    const [input, setInput] = useState("");

    // compare what the user wrote to our date
    // value = what the user wrote
    const fetchData = (value) => {
        axios.get('http://localhost:8000/api/applications_listings')
            .then((response) => {
                const results = response.data.filter((applications_listings) => {
                    return applications_listings.toLowerCase().includes(value.toLowerCase());
                });
                setResults(results);
            })
            .catch((error) => {
                console.error('Error fetching applications_listings:', error);
            });
    };

    const handleChange = (value) => {
        setInput(value);
        fetchData(value);
    };
    return (
        <div className='inputWrapper'>
            <input
                placeholder="Type To Search... "
                value={input}
                onChange={(e) => handleChange(e.target.value)}>
            </input>
            <FaSearch id="searchIcon" />
        </div>
    );
};
