import { initializeApp } from "firebase/app";
import { getDatabase, ref, set, push } from "firebase/database";

import { gsap } from "gsap";
import { ScrollToPlugin } from "gsap/ScrollToPlugin";

gsap.registerPlugin(ScrollToPlugin);

const firebaseConfig = {
  apiKey: "AIzaSyA14xcELq2lr3IvR1Oa_WsJK8PfPoueFKc",
  authDomain: "iamtomfarrellsite.firebaseapp.com",
  databaseURL: "https://iamtomfarrellsite-default-rtdb.firebaseio.com",
  projectId: "iamtomfarrellsite",
  storageBucket: "iamtomfarrellsite.appspot.com",
  messagingSenderId: "816924721496",
  appId: "1:816924721496:web:8f8f1f6670d64ba959e52d",
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);

document.getElementById("contactForm").addEventListener("submit", submitForm);

function submitForm(e) {
  e.preventDefault();

  // Get values
  var firstName = getInputVal("firstName");
  var lastName = getInputVal("lastName");
  var email = getInputVal("email");
  var phone = getInputVal("phone");
  var phone2 = getInputVal("phone2");
  var phone3 = getInputVal("phone3");
  var subject = getInputVal("subject");
  var message = getInputVal("message");

  // Save message
  saveMessage(
    firstName,
    lastName,
    email,
    phone,
    phone2,
    phone3,
    subject,
    message
  );

  // Scroll alert into view
  gsap.to(window, {
    scrollTo: "#contact",
    duration: 0.65,
    ease: "power3.out",
  });

  // Show alert
  document.querySelector(".form-alert").style.display = "block";

  setTimeout(function () {
    document.querySelector(".form-alert").style.display = "none";
  }, 4000);

  // clear form
  document.getElementById("contactForm").reset();
}

// Function to get form values
function getInputVal(id) {
  return document.getElementById(id).value;
}

// Save message to firebase
function saveMessage(
  firstName,
  lastName,
  email,
  phone,
  phone2,
  phone3,
  subject,
  message
) {
  const db = getDatabase();
  const postListRef = ref(db);
  const newPostRef = push(postListRef);
  set(newPostRef, {
    firstName: firstName,
    lastName: lastName,
    email: email,
    phone: phone,
    phone2: phone2,
    phone3: phone3,
    subject: subject,
    message: message,
  });
}
