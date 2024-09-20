import React, { useEffect, useState } from 'react';
import axios from 'axios';
import { useParams, Link } from 'react-router-dom';

const PostList = () => {
    const { websiteId } = useParams();  // Get websiteId from URL parameters
    const [posts, setPosts] = useState([]);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        const fetchPosts = async () => {
            try {
                const response = await axios.get(`http://127.0.0.1:8000/api/websites/${websiteId}/posts`);
                setPosts(response.data);
            } catch (error) {
                console.error('Error fetching posts:', error);
            } finally {
                setLoading(false);
            }
        };

        fetchPosts();
    }, [websiteId]);

    if (loading) {
        return <div>Loading posts...</div>;
    }

    return (
        <div className="container">
            <h2 className="pt-5">Posts for Website {websiteId}</h2>
            <Link to={`/websites/${websiteId}/posts/create`} className="btn btn-primary mb-3">Create New Post</Link>
            {posts.length > 0 ? (
                <ul className="list-group">
                    {posts.map((post) => (
                        <li key={post.id} className="list-group-item">
                            <h5>{post.title}</h5>
                            <p>{post.description}</p>
                        </li>
                    ))}
                </ul>
            ) : (
                <p>No posts available for this website.</p>
            )}
        </div>
    );
};

export default PostList;
