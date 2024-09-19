import React, { useState } from 'react';
import './App.css';
import WebsiteForm from './components/Websites/WebsiteForm';
import WebsiteList from './components/Websites/WebsiteList';

const App = () => {
  const [websites, setWebsites] = useState([]);

  const handleWebsiteCreated = (newWebsite) => {
    setWebsites((prevWebsites) => [...prevWebsites, newWebsite]);
  };

  return (
    <div className="App">
      <WebsiteForm onWebsiteCreated={handleWebsiteCreated} />
      <WebsiteList websites={websites} />
    </div>
  );
};


export default App;
