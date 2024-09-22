import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import axios from 'axios';

const WebsiteForm = () => {
    const [name, setName] = useState('');
    const [url, setUrl] = useState('');
    const [message, setMessage] = useState('');
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
            setMessage('Website successfully created!');
            setErrors({});
            setName('');
            setUrl('');
            navigate('/'); // Redirect to Dashboard on success
        } catch (error) {
            if (error.response && error.response.data.errors) {
                setErrors(error.response.data.errors);
                setMessage(''); // Clear any success message
            }
        }
    };

    return (
        <div className="container mt-5">
            <div className="row justify-content-center">
                <div className="col-md-8">
                    <div className="card p-4 shadow-sm border-0">
                        <h2 className="mb-4 text-center text-primary">Create New Website</h2>

                        {/* Success or Error Message */}
                        {message && (
                            <div className="alert alert-success text-center">
                                {message}
                            </div>
                        )}
                        {Object.keys(errors).length > 0 && (
                            <div className="alert alert-danger text-center">
                                There were some errors with your submission.
                            </div>
                        )}

                        {/* Form for Creating Website */}
                        <form onSubmit={handleSubmit}>
                            {/* Website Name Input */}
                            <div className="form-group mb-3">
                                <label htmlFor="name">Name</label>
                                <input
                                    type="text"
                                    id="name"
                                    className="form-control"
                                    value={name}
                                    onChange={handleNameChange}
                                    placeholder="Enter website name"
                                    required
                                />
                                {errors.name && <div className="text-danger mt-1">{errors.name[0]}</div>}
                            </div>

                            {/* URL Input (Auto-generated) */}
                            <div className="form-group mb-3">
                                <label htmlFor="url">URL (Auto-generated)</label>
                                <input
                                    type="url"
                                    id="url"
                                    className="form-control"
                                    value={url}
                                    readOnly
                                />
                                {errors.url && <div className="text-danger mt-1">{errors.url[0]}</div>}
                            </div>

                            {/* Submit Button */}
                            <div className="text-center">
                                <button type="submit" className="btn btn-success mt-3 w-50">
                                    Create Website
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default WebsiteForm;
