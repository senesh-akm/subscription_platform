import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import axios from 'axios';

const WebsiteForm = () => {
    const [name, setName] = useState('');
    const [url, setUrl] = useState('');
    const [errors, setErrors] = useState({});
    const navigate = useNavigate();

    // Function to generate slug for URL based on the website name
    const generateSlug = (name) => {
        return name.toLowerCase().replace(/\s+/g, '-'); // Converts spaces to hyphens and converts to lowercase
    };

    const handleNameChange = (e) => {
        const inputName = e.target.value;
        setName(inputName);
        setUrl(`http://${generateSlug(inputName)}.com`); // Automatically set the URL
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        try {
            await axios.post('http://127.0.0.1:8000/api/websites', { name, url });
            navigate('/'); // Redirect to Dashboard on success
        } catch (error) {
            if (error.response && error.response.data.errors) {
                setErrors(error.response.data.errors);
            }
        }
    };

    return (
        <div className="container">
            <h2 className="pt-5 mb-3">Create New Website</h2>
            <form onSubmit={handleSubmit}>
                <div className="form-group">
                    <label htmlFor="name">Name</label>
                    <input
                        type="text"
                        id="name"
                        className="form-control mb-3"
                        value={name}
                        onChange={handleNameChange}
                        required
                    />
                    {errors.name && <div className="text-danger">{errors.name[0]}</div>}
                </div>
                <div className="form-group">
                    <label htmlFor="url">URL</label>
                    <input
                        type="url"
                        id="url"
                        className="form-control mb-3"
                        value={url}
                        readOnly
                    />
                    {errors.url && <div className="text-danger">{errors.url[0]}</div>}
                </div>
                <button type="submit" className="btn btn-primary mt-3">Create Website</button>
            </form>
        </div>
    );
};

export default WebsiteForm;
