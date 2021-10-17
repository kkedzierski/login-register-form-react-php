import { useState, useEffect } from "react";
import axios from 'axios';


const useForm = (callback, validate) => {
    const [values, setValues] = useState({
        username: '',
        email: '',
        password: '',
        password2: ''
    });
    const [errors, setErrors] = useState({});
    const [isSubmitting, setIsSubmitting] = useState(false);
    
    const handleChange = e => {
        const { name, value} = e.target
        setValues({
            ...values, 
            [name]: value
        })
    }

    const handleSubmit = e => {
        e.preventDefault();
        const formData = {
            username: e.target.username.value,
            email: e.target.email.value,
            password: e.target.password.value,
            password2: e.target.password2.value
        };
        console.log(formData);
        setErrors(validate(values))
        setIsSubmitting(true);
        axios({
            method: 'post',
            baseURL: 'http://localhost/login-register-form-react-php/server/includes/signup.inc.php',
            data: formData,
            headers: { "content-type": "application/json",
            "Access-Control-Allow-Origin": "*"}
        })
        .then(function (response) {
            console.log(response)

        })
        .catch(function (response) {
            console.log(response)
        });
    }

    useEffect(() => {
        if(Object.keys(errors).length === 0 && isSubmitting){
            callback();
        }
    },[errors]);

    return {handleChange, values, handleSubmit, errors};
}

export default useForm;