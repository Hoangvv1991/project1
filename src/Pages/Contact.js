import React from 'react';

const Contact = () => {
  return (
    <div className="container mt-5">
      <h2 className="mb-4 text-center">Contact Us</h2>
      <form>
        <div className="form-group">
          <label for="name">Name</label>
          <input type="text" className="form-control" id="name" placeholder="Your name"/>
        </div>
        <div className="form-group">
          <label for="email">Email address</label>
          <input type="email" className="form-control" id="email" placeholder="name@example.com"/>
        </div>
        <div className="form-group">
          <label for="message">Message</label>
          <textarea className="form-control" id="message" rows="4" placeholder="Your message"></textarea>
        </div>
        <button type="submit" className="btn btn-primary mt-3">Send</button>
      </form>
    </div>
  );
};

export default Contact;
