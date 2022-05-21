import React from 'react'
import ReactDOM from 'react-dom'
import "./frontend.scss"

const divsToUpdate = document.querySelectorAll(".paying-attention-update-me");

divsToUpdate.forEach((div) => {
    const data = JSON.parse(div.querySelector("pre").innerHTML)
    // ReactDOM.render(<Quiz question={question} />, div)
    // ReactDOM.render(<Quiz data={data} />, div)
    ReactDOM.render(<Quiz {...data} />, div) // this way is the same of the previous one, this is called d structure 
    div.classList.remove("paying-attention-update-me")

})

function Quiz(props) {
    return (
        <div className="paying-attention-frontend">
            {/* {props.question} */}
            {/* {props.data.question} */}
            <p>{props.question}</p>
            <ul>
                {props.answers.map((answer) => {
                    return <li>{answer}</li>
                })}
            </ul>
        </div>

    )
}