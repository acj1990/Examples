// MainForm.js
import { useState, useEffect, useRef } from 'react'
import { ReactDOM, findDOMNode } from 'react-dom'
import UserNameEmail from './UserNameEmail'
import DobGender from './DobGender'
import Address from './Address'

const MainForm = () => {
    const [activeTab, setActiveTab] = useState(0);
    
    const [data, setData] = useState({
        username: "",
        email: "",
        dob: "",
        gender: "male",
        street: "",
        stepValid: false
    })

    const handleChange = (event) => {
        const { name, value } = event.target;
        validator();
        setData({
            ...data,
            [name]: value,
        });
    };

    const setStep = () => {
        //Need to apply class only to those steps equal or lower than the current selected
        let activeStep = activeTab + 1;

        if (activeStep === 3) {
            //ReactDOM.findDOMNode(this).getElementsByClassName('step3segment').addClass('bg-red-700');
        } else if (activeStep === 2) {
            //ReactDOM.findDOMNode(this).getElementsByClassName('step2segment').addClass('bg-red-700');
            //ReactDOM.findDOMNode(this).getElementsByClassName('step3segment').removeClass('bg-red-700');
        } else if (activeStep === 1) {
            //ReactDOM.findDOMNode(this).getElementsByClassName('step2segment').removeClass('bg-red-700');
        }
    }

    const validator = () => {
        if (activeTab === 0) {
            if (data.username.trim() !== "" && data.email.trim() !== "") {
                setData(data.stepValid = true); // Step 1 is valid
            } else {
                setData(data.stepValid = false); // Step 1 is valid
            }
        }
        
        if (activeTab === 1) {
            if (data.dob.trim() !== "" && data.gender.trim() !== "") {
                setData(data.stepValid = true); // Step 2 is valid
            } else {
                setData(data.stepValid = false); // Step 2 is valid
            }
        }
        
        if (activeTab === 2) {
            if (data.street.trim() !== "") {
                setData(data.stepValid = true); // Step 3 is valid
            } else {
                setData(data.stepValid = false); // Step 3 is valid
            }
        }
    };

    const formElements = [
        <UserNameEmail data={data} handleChange={handleChange} />,
        <DobGender data={data} handleChange={handleChange} />,
        <Address data={data} handleChange={handleChange} />
    ];

    return (
        <div className="col-span-4 m-3 max-w-100 content-start bg-white dark:bg-gray-300 overflow-hidden shadow-xl rounded-md">
            <div className='p-5 flex flex-col justify-center bg-slate-800'>
                <div className="grid grid-cols-3">
                    <div className="m-5 bg-red-700 h-2.5 rounded-full step1segment"></div>
                    <div className="m-5 bg-gray-400 rounded-full h-2.5 step2segment"></div>
                    <div className="m-5 bg-gray-400 rounded-full h-2.5 step3segment"></div>
                </div>
                <div className="grid grid-cols-3">
                    <div className="text-center text-red-700 font-bold step1segment">Step 1</div>
                    <div className="text-center text-gray-200 font-bold step2segment">Step 2</div>
                    <div className="text-center text-gray-200 font-bold step3segment">Step 3</div>
                </div>
                <div>
                    {
                        formElements[activeTab]
                    }
                </div>
                <div className='grid grid-cols-2'>
                    <button
                        disabled={activeTab === 0 ? "disabled" : ""}
                        onClick={() => {setActiveTab(prev => prev - 1); setStep()}}
                        className={`mr-60 ml-5 px-4 py-2 rounded-xl bg-red-700 text-white ${activeTab === 0 ? "opacity-50 bg-slate-600" : "opacity-100"}`}>
                            Back
                    </button>
                    <button
                        disabled={(activeTab == (formElements.length - 1) || !data.stepValid) ? true : false}
                        onClick={() => {setActiveTab(prev => prev + 1); setStep()}}
                        className={`ml-60 mr-5 px-4 py-2 rounded-xl bg-red-700 right-0 text-white ${activeTab === formElements.length - 1 ? "opacity-50 bg-slate-600" : "opacity-100"} ${!data.stepValid ? "opacity-50 bg-slate-600" : ""}`}>
                            Next
                    </button>
                    {
                        activeTab === formElements.length - 1 ? <button className='px-4 py-2 rounded-xl bg-blue-600 text-white' onClick={() => console.log(data)}>Submit</button> : null
                    }
                </div>
            </div>
        </div>
    )
}

export default MainForm