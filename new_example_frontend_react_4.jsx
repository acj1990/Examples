import React, { useState } from "react";
import clsx from "clsx";
  
export default function MonthPicker({}) {
    //Get last 12 months in a list
    let dateObj = new Date();
    let dateStrings = [];
    let selectedMonth = "";
    let dateFormatOptions = {
        month: 'short'
    };

    for (var i = 0; i < 12; ++i) {
        dateStrings.unshift(dateObj.toLocaleString('en-US', dateFormatOptions));
        dateObj.setMonth(dateObj.getMonth() - 1);
    }

    function changeMonth (e, subtractor) {
        //Temporary direct JS solution
        const mnths = [...document.querySelectorAll(".months")];

        mnths.forEach((mnths) => {
            mnths.classList.remove("bg-red-800");
            mnths.classList.add("cursor-pointer", "hover:bg-gray-600", "bg-gray-900");
        });

        console.log(e.currentTarget.getAttribute('id'));
        selectedMonth = subtractor;
        e.target.classList.add("bg-red-800");
        e.target.classList.remove("cursor-pointer", "hover:bg-gray-600");
    }

    function Month(box, i) {
        let out = null;
        if (box) {
            let subtractor = 11 - i;
            out = (<div id={subtractor} key={subtractor} className={clsx("months p-1 m-1 text-gray-100 hover:bg-gray-600 cursor-pointer text-center font-bold rounded-md", subtractor == selectedMonth ? "bg-red-800" : "bg-gray-900")} onClick={(e) => {changeMonth(e, subtractor);}}>{box}</div>);
        }
        return out;
    }

    function Months() {
        return <div className="flex pt-4 items-center grid grid-cols-4">{dateStrings.map((box, i) => Month(box, i))}</div>;
    }

    return (
        <Months />
    );
}