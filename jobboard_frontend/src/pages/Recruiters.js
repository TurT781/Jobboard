import React from 'react'
import "../CSS/Recruiters.css"
import { Link } from 'react-router-dom';

const Recruiters = () => {
    return (
        <section className='recruiterContainer'>
            <div className='features'>Features Incoming Soon
                <Link to="/">
                    <button className='return'>
                        <p>Homepage here</p>
                    </button>
                </Link>
            </div>

        </section>

    );
};
export default Recruiters;