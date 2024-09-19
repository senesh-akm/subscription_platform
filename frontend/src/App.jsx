import React from 'react';
import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';
import TopNavbar from './components/navbar/TopNavbar';
import BottomNavbar from './components/navbar/BottomNavbar';
import Dashboard from './components/Dashboard';
import WebsiteForm from './components/WebsiteForm';

const App = () => {
    return (
        <Router>
            <TopNavbar />
            <div className="container">
                <Routes>
                    <Route path="/" element={<Dashboard />} />
                    <Route path="/create-website" element={<WebsiteForm />} />
                </Routes>
            </div>
            <BottomNavbar />
        </Router>
    );
};

export default App;
