import React, { useEffect, useState } from 'react';
import axios from 'axios';
import { Link, useNavigate } from 'react-router-dom';

const Dashboard = () => {
    const [websites, setWebsites] = useState([]);
    const [emails, setEmails] = useState({});
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
            // Make the POST request to subscribe with websiteId and the respective email
            await axios.post('http://127.0.0.1:8000/api/subscriptions', {
                website_id: websiteId,
                email: emails[websiteId], // Use the email specific to the website
            });

            // Provide feedback to the user
            setMessage(`Subscribed successfully to website ${websiteId}`);
            
            // Clear the email field for the website after subscribing
            setEmails((prevEmails) => ({
                ...prevEmails,
                [websiteId]: '',
            }));
        } catch (error) {
            console.error('Error subscribing:', error);
            setMessage('An error occurred while subscribing.');
        }
    };

    const handleWebsiteClick = (websiteId) => {
        // Navigate to the PostList component with the websiteId
        navigate(`/websites/${websiteId}/posts`);
    };

    const handleEmailChange = (e, websiteId) => {
        // Update the email for the respective website
        const { value } = e.target;
        setEmails((prevEmails) => ({
            ...prevEmails,
            [websiteId]: value,
        }));
    };

    // Set a timeout to clear the message after 5 seconds
    useEffect(() => {
        if (message) {
            const timer = setTimeout(() => {
                setMessage('');  // Clear the message
            }, 5000);

            // Cleanup function to clear the timeout if the component is unmounted or if the message changes
            return () => clearTimeout(timer);
        }
    }, [message]);

    return (
        <div className="container mt-5">
            <h2 className="mb-4 text-center text-info">Website Dashboard</h2>
            <div className="d-flex justify-content-between mb-4">
                <Link to="/create-website" className="btn btn-success">Create New Website</Link>
            </div>
            {message && <div className="alert alert-info w-100 text-center">{message}</div>}

            <div className="list-group">
                {websites.map((website) => (
                    <div className="list-group-item mb-3 p-4 shadow-sm border-0" key={website.id}>
                        <div className="d-flex justify-content-between align-items-center">
                            <div>
                                <h5
                                    className="text-primary mb-2"
                                    style={{ cursor: 'pointer' }}
                                    onClick={() => handleWebsiteClick(website.id)}
                                >
                                    {website.name}
                                </h5>
                                <p
                                    className="text-muted mb-0"
                                    style={{ cursor: 'pointer' }}
                                    onClick={() => handleWebsiteClick(website.id)}
                                >
                                    {website.url}
                                </p>
                            </div>
                    
                            <div className="d-flex flex-column w-auto">  {/* Wrapping input-group and count */}
                                <div className="input-group">
                                    <input
                                        type="email"
                                        className="form-control"
                                        placeholder="Enter your email"
                                        value={emails[website.id] || ''} // Use email specific to this website
                                        onChange={(e) => handleEmailChange(e, website.id)}
                                    />
                                    <button
                                        className="btn btn-outline-primary"
                                        onClick={() => handleSubscribe(website.id)}
                                    >
                                        Subscribe
                                    </button>
                                </div>
                    
                                {/* Subscription count aligned below the input-group */}
                                <p className="text-muted mt-2 text-end mb-1"> {/* Align right if needed */}
                                    {website.subscriptions_count || 0} subscribers
                                </p>
                            </div>
                        </div>
                    </div>
                ))}
            </div>
        </div>
    );
};

export default Dashboard;
