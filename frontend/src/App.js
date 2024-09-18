import React, { useState } from 'react';
import './App.css';
import CreateWebsite from './components/CreateWebsite';
import WebsiteList from './components/WebsiteList';

const App = () => {
  const [websites, setWebsites] = useState([]);

  const handleWebsiteCreated = (newWebsite) => {
    setWebsites((prevWebsites) => [...prevWebsites, newWebsite]);
  };

  return (
    <div className="App">
      <CreateWebsite onWebsiteCreated={handleWebsiteCreated} />
      <WebsiteList websites={websites} />
    </div>
  );
};


export default App;
