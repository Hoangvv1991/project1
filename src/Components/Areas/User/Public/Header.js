import React from 'react';
import Navbar from './Navbar';

const Header = () => {
  return (
    <header className="bg-light py-3 shadow-sm">
      <div className="container">
        <div className="d-flex justify-content-between align-items-center">
          <h1 className="text-primary">Paris France Beauty</h1>
          <Navbar />
        </div>
      </div>
    </header>
  );
};

export default Header;
