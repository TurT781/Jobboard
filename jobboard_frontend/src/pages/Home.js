import React from "react";
import { Link } from "react-router-dom";
import "../CSS/pageHome.css"

const Home = () => {
    return (
        <section className="home">
            <div className="contentBox">
                <div className="contentHomeTitle">

                    <div className="titleContainer">
                        <span style={{ color: "#D3D3D3" }}>Tech</span>
                        <span style={{ color: "#f8cb2e" }}>Apply</span>
                    </div>

                </div>

                <div className="contentHomeText">
                    <p>
                        Welcome to our website! <br />
                        The ultimate platform for connecting tech professionals
                        and companies. <br />
                        Discover your next opportunity in the world of innovation
                        and growth.
                    </p>
                </div>

                <div className="searchingBarBox">

                    <div className="searchingBarTitle">
                        <h1>What Are You:</h1>

                        <div className="searchingBar">

                            <Link to='/recruiters'>
                                <button>Recruiter</button>
                            </Link>

                            <Link to="/offers">
                                <button>Applicant</button>
                            </Link>

                        </div>

                    </div>

                </div>
            </div>
        </section>
    );
};

export default Home;
