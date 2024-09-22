import React, { useEffect, useState } from 'react';
import axios from 'axios';
import { useParams, Link } from 'react-router-dom';

const PostList = () => {
    const { websiteId } = useParams();  // Get websiteId from URL parameters
    const [posts, setPosts] = useState([]);
    const [loading, setLoading] = useState(true);
    const [view, setView] = useState('list'); // State to toggle between grid and list

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
            <h2 className="pt-5 mb-3">Posts for Website {websiteId}</h2>

            {/* Create row with flex utilities */}
            <div className="d-flex justify-content-between mb-3">
                {/* Left-aligned buttons */}
                <div>
                    <Link to={`/websites/${websiteId}/posts/create`} className="btn btn-primary me-2">Create New Post</Link>
                    <Link to={`/`} className="btn btn-secondary">Back to Posts</Link>
                </div>

                {/* Right-aligned buttons with icons */}
                <div>
                    <button className="btn btn-outline-secondary me-2" onClick={() => setView('list')}>
                        <i className="fas fa-list me-1"></i> List View
                    </button>
                    <button className="btn btn-outline-secondary" onClick={() => setView('grid')}>
                        <i className="fas fa-th me-1"></i> Grid View
                    </button>
                </div>
            </div>

            {posts.length > 0 ? (
                <div className={view === 'grid' ? 'row' : 'list-group'}>
                    {posts.map((post) => (
                        <div key={post.id} className={view === 'grid' ? 'col-md-4 mb-4' : 'list-group-item'}>
                            <div className={view === 'grid' ? 'card h-100' : ''}>
                                <div className="card-body">
                                    <h5 className="card-title">{post.title}</h5>
                                    <p className="card-text text-truncate">{post.description}</p>
                                    <Link to={`/websites/${websiteId}/posts/${post.id}`} className="btn btn-primary">
                                        View Post
                                    </Link>
                                </div>
                            </div>
                        </div>
                    ))}
                </div>
            ) : (
                <p>No posts available for this website.</p>
            )}
        </div>
    );
};

export default PostList;
