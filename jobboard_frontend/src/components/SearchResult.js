import React from 'react'
import "../CSS/SearchResult.css"

export const SearchResult = ({ result }) => {
    return (
        <div className='searchResult'>{result.title}</div>
    )
}
