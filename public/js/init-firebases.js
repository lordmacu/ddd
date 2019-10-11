importScripts('https://www.gstatic.com/firebasejs/4.1.3/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/4.1.3/firebase-messaging.js');

 var firebaseConfig = {
    apiKey: "AIzaSyDXQBOlulXnmB7jtiN-RYDOPmIygxlbLLM",
    authDomain: "webdueno.firebaseapp.com",
    databaseURL: "https://webdueno.firebaseio.com",
    projectId: "webdueno",
    storageBucket: "",
    messagingSenderId: "166042654068",
    appId: "1:166042654068:web:3f9b5c5643c6ec27"
  };
  
// Initialize the Firebase app in the service worker by passing in the
// messagingSenderId.
firebase.initializeApp(firebaseConfig);

// Retrieve an instance of Firebase Messaging so that it can handle background
// messages.
const messaging = firebase.messaging();

self.addEventListener('notificationclick', function(event) {
  event.notification.close();
  event.waitUntil(self.clients.openWindow(event.notification.data.url));
});

messaging.setBackgroundMessageHandler(function(payload) {
  console.log('[firebase-messaging-sw.js] Received background message ', payload);
  
  var data=payload["data"];
  // Customize notification here
  const notificationTitle = data["title"];
  const notificationOptions = {
    body:data["body"],
    data: { url:data["url"] }, //the url which we gonna use later
    icon: 'favicon.png',
    //renotify:true,
    vibrate:true,
    badge: 'badge.png',
    image:'download.jpg',
    requireInteraction:true
  };
  
  
  

  return self.registration.showNotification(notificationTitle,
      notificationOptions);
});