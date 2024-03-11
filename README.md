<p align="center"><a href="https://feedier.com" target="_blank"><img src="https://dashboard.feedier.com/images/global/logo.svg" width="400" alt="Feedier"></a></p>


## Thanks for applying!
One of the key stages of our recruitment process is the technical test. All developers on our team go through this stage in order to be able to join Feedier.

The purpose of this test is mainly to see your adaptability and your comfort on our technical stack.

This site uses the same technical stack as Feedier: VueJS, InertiaJS, Laravel and TailwindCSS. More commonly called **VILT Stack**.

## How to initialize the project ?
The project run under Docker, you can easily setup all the projects by running these commands:

#### 1. Copy the .env file
```shell
cp .env.example .env
```

#### 2. Install the composer dependencies
```shell
docker run --rm \
  -u "$(id -u):$(id -g)" \
  -v "$(pwd):/var/www/html" \
  -w /var/www/html \
  laravelsail/php83-composer:latest \
  composer install --ignore-platform-reqs
```

#### 3. Run the migrations
```shell
./vendor/bin/sail artisan migrate
```

#### 4. Install and build the frontend
```shell
./vendor/bin/sail npm install
./vendor/bin/sail npm run dev
```

### You're good to start!


## Goal of this testing:
**Estimated time: ~2h**

The goal of this testing is to create a really simple Feedback's page with the following features.

This test should be done using the VIL**T** Stack (including TailwindCSS specially for the design), everything you need is already installed on the project.

**Required features:**
- Submit a Feedback (including a simple text)
  - Be able to send a Feedback as a user logged or not and attach the user if he is logged.
  - If the user is logout, he need to provide a mail address.
  - Only 1 feedback per hour can be sent for a unique user.
  - Feedback can have 2 sources: "EXTERNAL" or "DASHBOARD", (this one is a "Dashboard")
- Get feedback from "EXTERNAL" source
  - Retrieve them using this link: https://feedier-production.s3.eu-west-1.amazonaws.com/special/Reviews+Import.csv
  - Your script should get all the feedbacks each day from the previous link.
- List all the feedbacks received on the platform
  - Only for the "staff" user -> can be created from the database only (you don't need to create an admin page for that).
  - Feedback should include the user email or the mail provided.
  - Ability for a staff user to delete a feedback
    - Deleted feedback should be restorable.

**Tips:**
- Don't spent too many time on the design, it's not what we want to evaluate on this project.
- What we are looking is: 
  - If you know the VILT stack ?
  - If you're able to manage simple concepts of Laravel, such as Jobs, Services, simple CRUDs
  - If you're comfortable with InertiaJS
  - If you're application respect the basis concept of the programming for medium and big companies.


## Submit your test
This repository is a template, you can easily use it and create your repository from it and then send us the link by email.

## What's next ?
Once we receive your test, we will give you an answer within 2 days maximum and you will be attended to a technical meeting with our Head of Engineering, Alexis Riot.

## Thanks a lot !
#### Thank you for your time invested at Feedier, we hope to see you with us very soon!

