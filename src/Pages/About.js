import React from 'react';

const About = () => {
  return (
    <div className="container mt-5">
      <h2 className="mb-4 text-center">About Us</h2>
      <div className="row">
        <div className="col-md-6">
          <p>
            Paris France Beauty has been the leading provider of luxurious beauty products and treatments. Our mission is to provide premium services that help our customers look and feel their best.
          </p>
        </div>
        <div className="col-md-6">
          <img src="https://via.placeholder.com/500x300" alt="About us" className="img-fluid rounded shadow-sm"/>
        </div>
      </div>
    </div>
  );
};

export default About;
