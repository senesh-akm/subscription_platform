import React, { useEffect, useState } from 'react';
import axios from 'axios';
import { useParams, Link } from 'react-router-dom';

const ViewPost = () => {
    const { websiteId, postId } = useParams();  // Get websiteId and postId from URL parameters
    const [post, setPost] = useState(null);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        const fetchPost = async () => {
            try {
                const response = await axios.get(`http://127.0.0.1:8000/api/websites/${websiteId}/posts/${postId}`);
                setPost(response.data);
            } catch (error) {
                console.error('Error fetching post:', error);
            } finally {
                setLoading(false);
            }
        };

        fetchPost();
    }, [websiteId, postId]);

    if (loading) {
        return <div>Loading post...</div>;
    }

    if (!post) {
        return <div>Post not found.</div>;
    }

    return (
        <div className="container">
            <h2 className="pt-5">{post.title}</h2>
            <p>{post.description}</p>
            <p>{post.content}</p> {/* Assuming there's more content in the post */}
            <Link to={`/websites/${websiteId}/posts`} className="btn btn-secondary">Back to Posts</Link>
        </div>
    );
};

export default ViewPost;
