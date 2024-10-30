import React, { useState } from "react";
import { SearchBar } from "./SearchBar";
import { SearchResultsList } from "./SearchResultsList";
import '../CSS/SearchSection.css';

function SearchSection () {

    //another state 
    const [results , setResults ] = useState([]);

    return (
        <div className="App">
            <div className="searchBarContainer">
                <SearchBar setResults = {setResults}/>
                <SearchResultsList results={results} />
            </div>
        </div>
    );
};

export default SearchSection;