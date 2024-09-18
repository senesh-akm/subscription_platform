import React, { useEffect, useState } from 'react';
import axios from 'axios';

const WebsiteList = () => {
  const [websites, setWebsites] = useState([]);
  const [loading, setLoading] = useState(true);

  const fetchWebsites = async () => {
    try {
      const response = await axios.get('http://127.0.0.1:8000/api/websites');
      setWebsites(response.data);
      setLoading(false);
    } catch (error) {
      console.error('Error fetching websites', error);
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchWebsites();
  }, []);

  if (loading) {
    return <div>Loading...</div>;
  }

  return (
    <div className="container mt-4">
      <h2>Website List</h2>
      <ul className="list-group">
        {websites.map((website) => (
          <li key={website.id} className="list-group-item">
            <strong>{website.name}</strong> - <a href={website.url}>{website.url}</a>
          </li>
        ))}
      </ul>
    </div>
  );
};

export default WebsiteList;