document.getElementById("login-form").addEventListener("submit", function (event) {
    event.preventDefault();

    const username = document.getElementById("username").value;
    const password = document.getElementById("password").value;

    // Define your user-password pairs and their associated redirect URLs
    const users = {
        "wasd": { password: "wasd", redirectUrl: "isp.html" },
        "puppy": { password: "Cute", redirectUrl: "https://bit.ly/473dn8x" },
        "illegal": { password: "Yard", redirectUrl: "https://www.youtube.com/watch?v=h0SNAsocIx8&pp=ygUXaWxsZWdhbCBpbiBteSB5YXJkIHNvbmc%3D" },
        "thegoat": { password: "mountain", redirectUrl: "https://www.youtube.com/watch?v=YjyUIwKPAxA" },
    };

    if (users[username] && users[username].password === password) {
        window.location.href = users[username].redirectUrl;
    } else {
        alert("Login failed. Please check your credentials.");
    }
});
