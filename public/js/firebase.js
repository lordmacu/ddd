
var firebaseConfig = {
    apiKey: "AIzaSyDXQBOlulXnmB7jtiN-RYDOPmIygxlbLLM",
    authDomain: "webdueno.firebaseapp.com",
    databaseURL: "https://webdueno.firebaseio.com",
    projectId: "webdueno",
    storageBucket: "",
    messagingSenderId: "166042654068",
    appId: "1:166042654068:web:3f9b5c5643c6ec27"
};

firebase.initializeApp(firebaseConfig);

navigator.serviceWorker
        .register('/js/init-firebases.js')
        .then((registration) => {
            firebase.messaging().useServiceWorker(registration);



            const messaging = firebase.messaging();




            messaging
                    .requestPermission()
                    .then(function () {
                        
                        if (localStorage.getItem("tokenpusshsd") == null) {
                            return messaging.getToken();
                        } else {
                            return  localStorage.getItem("tokenpusshsd");
                        }
                    })
                    .then(function (token) {
                                                setTopic(token);

                    })
                    .catch(function (err) {
                        console.log(err);
                        console.log("Unable to get permission to notify.", err);
                    });
            messaging.onMessage(function (payload) {
                console.log("Message received. ", payload);
                var data=payload;
                console.log(data["data"]["title"]);
                console.log(JSON.stringify(payload));
            });

        });





function setTopic(token) {
    $.post('setTopic?token=' + token, {}, function () {
        localStorage.setItem("tokenpusshsd", token);
    });
}

