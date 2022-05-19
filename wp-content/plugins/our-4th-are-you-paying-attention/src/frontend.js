import React from 'react'
import ReactDOM from 'react-dom'
import "./frontend.scss"

const divsToUpdate = document.querySelectorAll(".paying-attention-update-me");

divsToUpdate.forEach((div) => {
    ReactDOM.render(<Quiz />, div)

})

function Quiz() {
    return (
        <div className="paying-attention-frontend">
            Hello from React
        </div>

    )
}