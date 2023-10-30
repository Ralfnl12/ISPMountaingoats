document.getElementById("login-form").addEventListener("submit", function (event) {
    event.preventDefault();

    const username = document.getElementById("username").value;
    const password = document.getElementById("password").value;

    // Define your user-password pairs and their associated redirect URLs
    const users = {
        "user1": { password: "password1", redirectUrl: "https://bit.ly/473dn8x" },
        "user2": { password: "password2", redirectUrl: "https://example.com/user2" },
        "thegoat": { password: "mountain", redirectUrl: "https://www.youtube.com/watch?v=YjyUIwKPAxA" },
    };

    if (users[username] && users[username].password === password) {
        window.location.href = users[username].redirectUrl;
    } else {
        alert("Login failed. Please check your credentials.");
    }
});
