import React, { useState, useEffect } from "react";
import { Link } from "react-router-dom";
import axios from "axios";
import "../CSS/Card.css";

//props advertisements DB fields
const Card = () => {
    const [advertisements, setAdvertisements] = useState([]);
    const [expanded, setExpanded] = useState(null);

    // extend the card
    const handleExpanded = (id) => {
        setExpanded(expanded === id ? null : id);
    };

    //limit the content at 50 char 
    const truncContent = (text, limit) => {
        if (text.length <= limit) {
            return text;
        }
        return `${text.substring(0, limit)} [...]`;
    };

    useEffect(() => {
        const advertisementsData = async () => {
            try {
                const response = await axios.get('http://localhost:8000/advertisements');
                setAdvertisements(response.data);
            } catch (error) {
                console.error('Cannot find any data for Advertisements', error);
            }
        };
        advertisementsData();
    }, []);

    return (
        <section className="cardsContainer">
            {advertisements.map((adv) => (
                <div className="card" key={adv.id}>
                    <div className="cardTitle">
                        <h2>{adv.title}</h2>
                    </div>
                    <div className="cardInfoCompany">
                        <h3>{adv.company}</h3>
                    </div>
                    <div className="cardContent">
                        <p>{expanded === adv.id ? adv.content : truncContent(adv.content, 50)}</p>
                    </div>
                    {expanded === adv.id && (
                        <div className="cardDetails">
                            <ul>

                                <li>
                                    <strong>📍 Address: <br /> </strong>
                                    <span>{adv.address}</span>
                                    <hr />
                                </li>

                                <li>
                                    <strong>🔎 Required experience: </strong>
                                    <span>{adv.experienceLevel}</span>
                                    <hr />
                                </li>

                                <li>
                                    <strong>🎓 Minimum Education: </strong>
                                    <span>{adv.educationLevel}</span>
                                    <hr />
                                </li>

                                <li>
                                    <strong>⌛ Working Time: </strong>
                                    <span>{adv.workingTime}</span>
                                    <hr />
                                </li>

                                <li>
                                    <strong>💵 Minimum Wage: </strong>
                                    <span>{adv.salaryMin} €/Month</span>
                                    <hr />
                                </li>

                                <li>
                                    <strong>🗓️ Posted: </strong>
                                    <span>{adv.createdAt}</span>
                                    <hr />
                                </li>

                            </ul>

                            <div className="btnApply">
                                <Link to={`/apply/${adv.id}`}>
                                    <button>
                                        Apply
                                    </button>
                                </Link>
                            </div>

                        </div>
                    )}

                    <div className="btnContainer">

                        <button onClick={() => handleExpanded(adv.id)}>
                            {expanded === adv.id ? 'See Less' : 'See More'}
                        </button>

                    </div>
                </div>

            ))}
        </section>
    );
};

export default Card;
