import React from "react"
import ReactDOM from "react-dom"
import IframeResizer from "iframe-resizer-react"
import {url} from "./config"

const divsToUpdate = document.querySelectorAll(".provecho-recipe-embed-insertion-point")

console.log(divsToUpdate)

document.addEventListener('DOMContentLoaded', () => {
  const divsToUpdate = document.querySelectorAll(".provecho-recipe-embed-insertion-point")

  divsToUpdate.forEach(div => {
    const data = JSON.parse(div.querySelector("pre").innerText)
    ReactDOM.render(<OurComponent {...data} />, div)
    div.classList.remove("provecho-recipe-embed-insertion-point")
  })
})

function OurComponent(props) {
  const recipeID = (props.recipeID || "").trim();

  return (
    <div className="">
      {recipeID != "" &&
        <>
          {/* <iframe id="provechoIframe" src={`https://www.provecho.bio/embed/recipe/${props.recipeID.trim()}?bg=white`} width="100%" height="400px" frameBorder="0" seamless allowFullScreen allowTransparency>
            <a href="https://www.provecho.bio/embed/recipe/RhUUbsw936tIvrmcVPlN?bg=white">Link</a>
          </iframe> */}
          <IframeResizer
            frameBorder={0}
            src={`${url}/embed/recipe/${recipeID}?bg=white`}
            style={{ width: '1px', minWidth: '100%' }}
          />
        </>
      }
    </div>
  )
}
