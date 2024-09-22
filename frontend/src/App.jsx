import React from 'react';
import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';
import TopNavbar from './components/navbar/TopNavbar';
import BottomNavbar from './components/navbar/BottomNavbar';
import Dashboard from './components/Dashboard';
import WebsiteForm from './components/WebsiteForm';
import CreatePost from './components/posts/CreatePost';
import PostList from './components/posts/PostList';
import ViewPost from './components/posts/ViewPost';

const App = () => {
    return (
        <Router>
            <TopNavbar />
            <div className="container">
                <Routes>
                    <Route path="/" element={<Dashboard />} />
                    <Route path="/create-website" element={<WebsiteForm />} />
                    <Route path="/websites/:websiteId/posts" element={<PostList />} />
                    <Route path="/websites/:websiteId/posts/create" element={<CreatePost />} />
                    <Route path="/websites/:websiteId/posts/:postId" element={<ViewPost />} />
                </Routes>
            </div>
            <BottomNavbar />
        </Router>
    );
};

export default App;
