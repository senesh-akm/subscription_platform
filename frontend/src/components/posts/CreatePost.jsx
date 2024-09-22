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
      const response = await axios.post(`http://127.0.0.1:8000/api/websites/${websiteId}/posts`, {
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
    <div className="container mt-5">
      <div className="row justify-content-center">
        <div className="col-md-8">
          <div className="card p-4 shadow border-0">
            <h2 className="mb-4 text-center text-primary">Create a New Post</h2>

            {/* Message Notification */}
            {message && (
              <div className={`alert ${message.includes('error') ? 'alert-danger' : 'alert-info'} text-center`}>
                {message}
              </div>
            )}

            {/* Post Form */}
            <form onSubmit={handleSubmit}>
              <div className="form-group mb-3">
                <label htmlFor="title" className="form-label">Title</label>
                <input
                  type="text"
                  className="form-control"
                  id="title"
                  value={title}
                  onChange={(e) => setTitle(e.target.value)}
                  placeholder="Enter post title"
                  required
                />
              </div>

              <div className="form-group mb-3">
                <label htmlFor="description" className="form-label">Description</label>
                <textarea
                  className="form-control"
                  id="description"
                  rows="5"
                  value={description}
                  onChange={(e) => setDescription(e.target.value)}
                  placeholder="Write the description for your post"
                  required
                />
              </div>

              <div className="text-center">
                <button type="submit" className="btn btn-success mt-3 w-50">
                  Create Post
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  );
};

export default CreatePost;
