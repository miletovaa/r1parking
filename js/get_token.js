/*
*
* THIS FILE GETS GOOGLE FIREBASE TOKEN OF USER'S DEVICE TO SIMPLIFY FURTHER USE OF THE SERVICE.
*
*/
  import { initializeApp } from "https://www.gstatic.com/firebasejs/9.6.10/firebase-app.js";
  import { getAnalytics } from "https://www.gstatic.com/firebasejs/9.6.10/firebase-analytics.js";
  import { getMessaging, getToken } from "https://www.gstatic.com/firebasejs/9.6.10/firebase-messaging.js";  
  const firebaseConfig = {
    apiKey: "",
    authDomain: "",
    projectId: "",
    storageBucket: "",
    messagingSenderId: "",
    appId: "",
    measurementId: ""
  };

  const app = initializeApp(firebaseConfig);
  const analytics = getAnalytics(app);
  const messaging = getMessaging(app);

  getToken(messaging, { vapidKey: 'VAPID_KEY' }).then((currentToken) => {
    if (window.location.href.includes('??token')) window.location.href = window.location.origin+window.location.pathname + '?token=' + currentToken;
    else if (!window.location.href.includes('token')) window.location.href = window.location.href + '?token=' + currentToken;
    console.log(currentToken);
  });