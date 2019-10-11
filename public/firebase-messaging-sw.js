importScripts('https://www.gstatic.com/firebasejs/3.9.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/3.9.0/firebase-messaging.js');

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

// Retrieve an instance of Firebase Messaging so that it can handle background
// messages.
const messaging = firebase.messaging();

messaging.setBackgroundMessageHandler(function(payload) {
  console.log('[firebase-messaging-sw.js] Received background message ', payload);
  // Customize notification here
  const notificationTitle = 'Background Message Title';
  const notificationOptions = {
    body: 'Background Message body.',
    icon: '/itwonders-web-logo.png'
  };

  return self.registration.showNotification(notificationTitle,
      notificationOptions);
});