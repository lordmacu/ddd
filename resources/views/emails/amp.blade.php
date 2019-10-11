<!--
## Introduction

This sample demonstrates how to build an AMP-powered email that contains a simple interactive survey.
-->

<!-- -->
<!doctype html>
<html ⚡4email>
<head>
  <meta charset="utf-8">
  <script async src="https://cdn.ampproject.org/v0.js"></script>
  <script async custom-element="amp-form" src="https://cdn.ampproject.org/v0/amp-form-0.1.js"></script>
  <style amp4email-boilerplate>body{visibility:hidden}</style>
  <style amp-custom>
    .container {
      max-width: 500px;
      margin: auto;
      font-family: sans-serif;
      padding: 1em;
      text-align: center;
    }

    .block {
      display: block;
      width: 100%;
    }

    .m1 {
      margin: 1em 0;
    }

    label {
      margin-bottom: 0.5em;
    }
  </style>
</head>
<body>
  <div class="container">
    <!--
      The main content of the email, an image and a short description of the event.
    -->
    <div>
      <amp-img class="m1" width="600" height="314" layout="responsive" src="https://amp.dev/static/img/sharing/default-600x314.png"></amp-img>
      <p>It’s been a busy few days at the latest AMP conference. We hope you had a good time!</p>
    </div>

    <hr>

    <!--
      To make the survey, we use an `amp-form` with radio button input fields.

      The second step of the form, free text input, is hidden initially and gets displayed after the user selects a rating, as this triggers a `change` event.

      When the form is submitted, we display a short confirmation message to the user by using `<div submit-success>`.
    -->
    <form method="post" action-xhr="/documentation/examples/api/submit-form-input-text-xhr">
      <div class="m1">
        <p>How would you rate this year's conference?</p>

        <input type="radio" id="rating1" name="rating" value="3" on="change:step2.show" required>
        <label for="rating1">Great</label>

        <input type="radio" id="rating2" name="rating" value="2" on="change:step2.show">
        <label for="rating2">Not bad</label>

        <input type="radio" id="rating3" name="rating" value="1" on="change:step2.show">
        <label for="rating3">Meh</label>
      </div>
      <div class="m1" id="step2" hidden>
        <label class="block" for="info">Would you like to tell us more?</label>
        <textarea class="block" id="info" name="name" rows="5"></textarea>
      </div>
      <input type="submit" value="Send feedback">
      <input type="reset" value="Clear">

      <div class="m1" submit-success>
        Thank you for submitting feedback.
      </div>
    </form>
  </div>
</body>
</html>