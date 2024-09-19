import React, { useEffect, useState } from 'react';
import axios from 'axios';
import { Link } from 'react-router-dom';

const Dashboard = () => {
    const [websites, setWebsites] = useState([]);
    const [email, setEmail] = useState('');

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

    const handleSubscribe = (websiteId) => {
        console.log(`Subscribed to website ${websiteId} with email ${email}`);
        // Add logic to subscribe user via API or backend if needed
    };

    return (
        <div className="container">
            <h2 className="pt-5">Dashboard</h2>
            <Link to="/create-website" className="btn btn-primary mb-3">Create New Website</Link>
            <div className="row">
                {websites.map((website) => (
                    <div className="mb-4" key={website.id}>
                        <div className="card">
                            <div className="card-body d-flex justify-content-between">
                                <div>
                                    <h5 className="card-title">{website.name}</h5>
                                    <p className="card-text">{website.url}</p>
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
