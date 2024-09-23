import React from 'react';

const Home = () => {
  return (
    <div className="container mt-5">
      <div className="jumbotron text-center bg-light p-5 shadow-sm">
        <h2 className="display-4">Welcome to Paris France Beauty</h2>
        <p className="lead">
          Your go-to destination for premium beauty products and services. We offer top-quality treatments to make you feel your best.
        </p>
        <a href="/about" className="btn btn-primary btn-lg mt-3">Learn More</a>
      </div>
    </div>
  );
};

export default Home;
