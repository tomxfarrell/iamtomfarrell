import { initializeApp } from "firebase/app";
import { getDatabase, ref, set, push } from "firebase/database";

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
  var subject = getInputVal("subject");
  var message = getInputVal("message");

  // Save message
  saveMessage(firstName, lastName, email, phone, subject, message);

  // show alert

  // clear form
  document.getElementById("contactForm").reset();
}

// Function to get form values
function getInputVal(id) {
  return document.getElementById(id).value;
}

// Save message to firebase
function saveMessage(firstName, lastName, email, phone, subject, message) {
  const db = getDatabase();
  const postListRef = ref(db);
  const newPostRef = push(postListRef);
  set(newPostRef, {
    firstName: firstName,
    lastName: lastName,
    email: email,
    phone: phone,
    subject: subject,
    message: message,
  });
}
