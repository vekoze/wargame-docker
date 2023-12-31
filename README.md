# Wargame - CTF

- Loic LEMARCHAND
- Adrien OLLIVIER
- Victor ENJALBERT

## Application overview

`Voyage++` is a platform tailored for travel enthusiasts who are passionate about exploration and adventure. With the rise of globalization and ever-increasing access to travel, many tourists today are eager to gather reliable information, fresh reviews, and personal recommendations before planning their journeys.

## Endpoint

| Endpoint | HTTP Method | Description |
| :-------- | :------- | :------------------------- |
| / | GET | Access the homepage. |
| /login | GET, POST | Access the login page. |
| /register | GET, POST | Access the registration page. |
| /random | GET | Discover a random destination. |
| /contact | GET, POST | Access the contact form. |
| /destination/`:id` | GET, POST | View a specific destination's page. |
| /user/`:id` | GET, POST | Access one's profile page. |


## Setup

Clone the application's Git repository to your local directory:

```bash
  git clone https://github.com/Vekoze/wargame-docker.git
```

## Deploy

The following steps will guide you in setting up the required environment to run the application. Ensure you have `Docker` and `Docker Compose` installed on your system before proceeding.

Navigate to the main project directory:

```bash
  cd wargame-docker
```

## Using Python script

If you prefer automating the deployment process, a Python script has been provided to simplify the installation and running of the application. Before using this method, ensure that you have `Python` installed on your system.

Run the Python script:

```bash
  python run.py
```

## Manual Deployment

If you opt for manual deployment, follow these steps:

Build the Docker image for the main application:

```bash
  cd wargame
  docker build -t wargame .
```

Afterwards, build the Docker image for the API:

```bash
  cd ../wapi
  docker build -t wapi .
```

Go back to the main directory and launch the services using Docker Compose:

```bash
  docker-compose up
```

With either method, once the deployment completes, your application should be up and running at `localhost:80`.

## How it works ?

`Voyage++` has been designed to test and hone your intrusion skills. Several vulnerabilities have been deliberately introduced into the system, representing a variety of common and rare security oversights that can be found in real-world applications.

There are at least **8 known vulnerabilities**. Your task is to identify and exploit them. Most of the vulnerabilities have an associated flag. Once successfully exploited, these flags can be retrieved. Each flag follows the format: **flag{content}**.

Remember, the primary objective is not just to collect flags but to understand the vulnerabilities' nature, how they were exploited, and how they can be mitigated. We kindly ask that you refrain from inspecting the application's source code. It would be a shame to spoil the fun 😉

Good luck and happy hacking!