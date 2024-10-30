import React from 'react';
import SearchSection from '../components/SearchSection';
import Header from '../components/Header';
import Card from "../components/Card";
import "../CSS/pageOffers.css"


const Offers = () => {
    return (
        <Header />,
        <div className='pageOffers' >
            <Card />
        </div>

    );
};

export default Offers;
