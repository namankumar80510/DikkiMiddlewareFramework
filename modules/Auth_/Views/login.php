<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login to your account</title>
    <link rel="stylesheet" href="/css/style.css">
    <script src="https://unpkg.com/@hotwired/turbo@7.3.0/dist/turbo.es2017-umd.js"></script>
</head>

<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6 col-lg-4">
                <div class="card">
                    <div class="card-body p-4">
                        <h4 class="card-title text-center mb-4">Login</h4>
                        <div id="error-message" class="alert alert-danger d-none"></div>
                        <form id="login-form" data-turbo="true">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username or Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text" class="form-control" id="username" name="username" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Sign In</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('turbo:load', () => {
            const form = document.getElementById('login-form');
            const errorMessage = document.getElementById('error-message');

            form.addEventListener('submit', async (e) => {
                e.preventDefault();

                const formData = new FormData(form);

                try {
                    // You will need to create this endpoint in API module. Or, remove all
                    // ... this javascript and directly set form to /auth/login
                    // .... and edit the Handler accordingly.
                    const response = await fetch('/api/auth/login', {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'Turbo-Frame': '_top'
                        },
                        body: formData
                    });

                    const data = await response.json();

                    if (response.ok) {
                        // Redirect on success
                        window.location.href = '/repositories';
                    } else {
                        // Show error message
                        errorMessage.textContent = data.message;
                        errorMessage.classList.remove('d-none');
                    }
                } catch (error) {
                    errorMessage.textContent = 'An error occurred. Please try again.';
                    errorMessage.classList.remove('d-none');
                }
            });
        });
    </script>
</body>

</html>