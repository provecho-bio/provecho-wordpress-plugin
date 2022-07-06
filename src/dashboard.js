import React from "react"
import ReactDOM from "react-dom"
import {url} from "./config"

document.addEventListener("DOMContentLoaded", () => {
    const wpBodyContent = document.getElementById("wpbody-content");
    wpBodyContent.style.paddingBottom = "0px";
    const wpContent = document.getElementById("wpcontent");
    wpContent.style.paddingLeft = "0px";
    const wpThankYou = document.getElementById("wpfooter");
    wpThankYou.innerHTML = ""
    const adminAppElem = document.querySelector("#provecho-admin-app")
    console.log(adminAppElem)

    ReactDOM.render(<DashboardEmbed />, adminAppElem)
})

function DashboardEmbed(props) {
    return (
        <div className="">
            <iframe
                scrolling={true}
                frameBorder={0}
                src={`${url}/dashboard`}
                style={{ width: '1px', minWidth: '100%', minHeight: "calc(100vh - 36px)" }}
            />
        </div>
    )
}
