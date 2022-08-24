// Initialize Firebase
const app = initializeApp(firebaseConfig);

// Reference messages collection
let messageRef = firebase.database().ref("messages");

// Listen for form submit

document.getElementById("contactForm").addEventListener("submit", submitForm);

function submitForm(e) {
  e.preventDefault();

  // Get values
  let firstName = getInputVal("firstName");
  let lastName = getInputVal("lastName");
  let email = getInputVal("email");
  let phone = getInputVal("phone");
  let subject = getInputVal("subject");
  let message = getInputVal("message");

  // Save message
  saveMessage(firstName, lastName, email, phone, subject, message);
}

// Function to get form values
function getInputVal(id) {
  return document.getElementById(id).value;
}

// Save message to firebase

function saveMessage(firstName, lastName, email, phone, subject, message) {
  let newMessageRef = messages.ref.push();
  newMessageRef.set({
    firstName: firstName,
    lastName: lastName,
    email: email,
    phone: phone,
    subject: subject,
    message: message,
  });
}
