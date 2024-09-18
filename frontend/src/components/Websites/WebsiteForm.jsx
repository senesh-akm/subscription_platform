import React, { useState } from 'react';
import axios from 'axios';

const CreateWebsite = ({ onWebsiteCreated }) => {
  const [name, setName] = useState('');
  const [url, setUrl] = useState('');
  const [error, setError] = useState('');

  const handleSubmit = async (e) => {
    e.preventDefault();
    setError('');

    try {
      const response = await axios.post('http://127.0.0.1:8000/api/websites', { name, url });
      onWebsiteCreated(response.data);  // Pass newly created website to parent
      setName('');
      setUrl('');
    } catch (error) {
      setError('Error creating website. Please check your input.');
    }
  };

  return (
    <div className="container mt-4">
      <h2>Create Website</h2>
      {error && <div className="alert alert-danger">{error}</div>}
      <form onSubmit={handleSubmit}>
        <div className="mb-3">
          <label htmlFor="name" className="form-label">Website Name</label>
          <input
            type="text"
            className="form-control"
            id="name"
            value={name}
            onChange={(e) => setName(e.target.value)}
            required
          />
        </div>
        <div className="mb-3">
          <label htmlFor="url" className="form-label">Website URL</label>
          <input
            type="url"
            className="form-control"
            id="url"
            value={url}
            onChange={(e) => setUrl(e.target.value)}
            required
          />
        </div>
        <button type="submit" className="btn btn-primary">Create Website</button>
      </form>
    </div>
  );
};

export default CreateWebsite;
