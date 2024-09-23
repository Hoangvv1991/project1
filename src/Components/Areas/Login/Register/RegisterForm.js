import '../LoginForm.css';

const RegisterForm = ({ handleFlip }) => {
    return (
        <div className="card-register">
          <form  className="login-form">
            <h2 className="login-title">Welcome Back</h2>
            <button type="submit" className="login-button">Login</button>
            <button type="button" onClick={handleFlip}>Next</button>
          </form>
        </div>
    );
};

export default RegisterForm;