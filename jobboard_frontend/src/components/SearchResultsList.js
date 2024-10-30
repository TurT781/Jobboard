import React from 'react'
import "../CSS/SearchResultsList.css"
import { SearchResult } from './SearchResult'

export const SearchResultsList = ({ results }) => {
    return (
        <div className='resultsList'>
            {results.map((result) => {
                return <SearchResult result={result} key={result.id}/>;
            })}
        </div>
    );
};
