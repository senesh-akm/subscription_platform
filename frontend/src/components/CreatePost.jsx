import React, { useState } from "react";
import axios from "axios";
import { useNavigate, useParams } from 'react-router-dom';

const CreatePost = () => {
  const { websiteId } = useParams(); // Get websiteId from URL parameters
  const [title, setTitle] = useState("");
  const [description, setDescription] = useState("");
  const [message, setMessage] = useState("");
  const navigate = useNavigate(); // Use navigate for redirection

  const handleSubmit = async (e) => {
    e.preventDefault();

    try {
      const response = await axios.post(`http://127.0.0.1:8000/api/websites/${websiteId}/posts/create`, {
        title,
        description,
      });
      setMessage(response.data.message);
      setTitle("");
      setDescription("");

      // Navigate to the PostList component after successful post creation
      navigate(`/websites/${websiteId}/posts`); // Redirects to the post list for that website
    } catch (error) {
      setMessage("An error occurred while creating the post.");
    }
  };

  return (
    <div className="container mt-4">
      <h2>Create a Post</h2>
      {message && <div className="alert alert-info">{message}</div>}
      <form onSubmit={handleSubmit}>
        <div className="mb-3">
          <label htmlFor="title" className="form-label">Title</label>
          <input
            type="text"
            className="form-control"
            id="title"
            value={title}
            onChange={(e) => setTitle(e.target.value)}
            required
          />
        </div>
        <div className="mb-3">
          <label htmlFor="description" className="form-label">Description</label>
          <textarea
            className="form-control"
            id="description"
            rows="3"
            value={description}
            onChange={(e) => setDescription(e.target.value)}
            required
          />
        </div>
        <button type="submit" className="btn btn-primary">Create Post</button>
      </form>
    </div>
  );
};

export default CreatePost;
