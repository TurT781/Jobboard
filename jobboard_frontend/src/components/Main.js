import React from "react";
import { Route, Routes } from 'react-router-dom';
import Home from '../pages/Home';
import Offers from '../pages/Offers';
import Apply from '../pages/Apply'
import Recruiters from "../pages/Recruiters";
import Login from "../pages/Login";
import SignUp from "../pages/SignUp";
import Dashboard from "../pages/Dashboard";

const Main = () => {
    return (
        <main>
            <Routes>
                <Route path="/" element={<Home />} />
                <Route path="/offers" element={<Offers />} />
                <Route path="/apply/:id" element={<Apply />} />
                <Route path="/recruiters" element={<Recruiters />} />
                <Route path="/login" element={<Login />} />
                <Route path="/signup" element={<SignUp />} />
                <Route path="/dashboard" element={<Dashboard />} />
                {/* Route for companies (post advertisements ) */}
            </Routes>
        </main>
    );
};

export default Main;
