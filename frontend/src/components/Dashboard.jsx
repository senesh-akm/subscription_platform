import React, { useEffect, useState } from 'react';
import axios from 'axios';
import { Link, useNavigate } from 'react-router-dom';

const Dashboard = () => {
    const [websites, setWebsites] = useState([]);
    const [email, setEmail] = useState('');
    const [message, setMessage] = useState('');  // For feedback after subscribing
    const navigate = useNavigate();  // For navigation to PostList

    // Fetch websites from the API
    useEffect(() => {
        const fetchWebsites = async () => {
            try {
                const response = await axios.get('http://127.0.0.1:8000/api/websites');
                setWebsites(response.data);
            } catch (error) {
                console.error('Error fetching websites:', error);
            }
        };

        fetchWebsites();
    }, []);

    const handleSubscribe = async (websiteId) => {
        try {
            // Make the POST request to subscribe with websiteId and email
            await axios.post('http://127.0.0.1:8000/api/subscriptions', {
                website_id: websiteId,
                email: email,
            });

            // Provide feedback to the user
            setMessage(`Subscribed successfully to website ${websiteId}`);
            setEmail(''); // Clear the email field after subscribing
        } catch (error) {
            console.error('Error subscribing:', error);
            setMessage('An error occurred while subscribing.');
        }
    };

    const handleWebsiteClick = (websiteId) => {
        // Navigate to the PostList component with the websiteId
        navigate(`/websites/${websiteId}/posts`);
    };

    return (
        <div className="container">
            <h2 className="pt-5">Dashboard</h2>
            <Link to="/create-website" className="btn btn-primary mb-3">Create New Website</Link>
            {message && <div className="alert alert-info">{message}</div>}
            <div className="row">
                {websites.map((website) => (
                    <div className="mb-4" key={website.id}>
                        <div className="card">
                            <div className="card-body d-flex justify-content-between">
                                <div>
                                    <h5
                                        className="card-title text-primary text-black"
                                        style={{ cursor: 'pointer' }}
                                        onClick={() => handleWebsiteClick(website.id)}
                                    >
                                        {website.name}
                                    </h5>
                                    <p
                                        className="card-text text-primary"
                                        style={{ cursor: 'pointer' }}
                                        onClick={() => handleWebsiteClick(website.id)}
                                    >
                                        {website.url}
                                    </p>
                                </div>
                                <div>
                                    <div className="d-flex">
                                        <input
                                            type="email"
                                            className="form-control me-2"
                                            placeholder="Enter your email"
                                            value={email}
                                            onChange={(e) => setEmail(e.target.value)}
                                        />
                                        <button
                                            className="btn btn-primary"
                                            onClick={() => handleSubscribe(website.id)}
                                        >
                                            Subscribe
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                ))}
            </div>
        </div>
    );
};

export default Dashboard;
