# Devnodes

Devnodes is an open-source web application built using the Symfony framework. It is designed to help users find the best freelance to realize their project.

The application allows users to search for freelancers based on cities, categories and skills. The search results will all the freelancers that fit the search parameters.

Devnodes also provides a platform for users to share their opinions about freelancers with the community. Registered users can propose missions to freelancers, contact and comment the freelancers.

## Requirements

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Composer
- Node.js and npm

## Installation (locale)

To install the application, follow these steps:

1. Clone the repository to your local machine:

```bash
git clone https://github.com/Johan667/Devnodes.git
```

​	2. Install the dependencies using Composer:

```bash
cd Devnodes
composer install
```

3. Configuring the .env.local file:

```bash
# .env
DATABASE_URL=mysql://user:password@localhost/devnodes

# Before using the application, you must configure the .env.local file. This file contains sensitive information such as API keys and database identifiers, so it should not be shared publicly.

# Rename the .env.local.example file to .env.local.

# Open the .env.local file in your favorite text editor.

# Replace the values of the following variables with your own information:

STRIPE_API_KEY: Your Stripe API key.
# follow the link https://dashboard.stripe.com/test/apikeys

PRICE_ID_STRIPE: The Stripe price ID.

APP_SECRET: The secret key of your application.

MAILER_DSN: The DSN URL for sending emails.
# Save the .env.local file and exit your text editor.
# Once you have correctly configured the .env.local file, you can safely use the application. Remember to keep your .env.local file private and never share it with unauthorized parties

```

4. Run the database migrations:

```bash
php bin/console doctrine:migrations:migrate
```

5. Install the front-end dependencies using npm:

```bash
npm install
```

6. Start the Symfony server:

```bash
symfony server:start
```

The application should now be accessible at `http://localhost:8000`.

## Usage

To use the application, go ahead and search for freelancers and if you like one of them. Create a new account or log in with an existing one. Once you are logged in, you can propose a mission, save your favorites, and write comments.

## License

Devnodes is released under the MIT License. See the [LICENSE](https://chat.openai.com/LICENSE) file for details.

# Prerequisites for production

Before starting the deployment process, make sure that the following requirements are met:

- Git is installed on the production server
- Composer is installed on the production server
- Node.js and npm are installed on the production server
- The necessary environment variables and configurations are set up for the production environment
- The application is fully functional on a local machine

# Deployment Steps

1. Clone the GitHub repository to your production server using the git clone command. Make sure that Git is installed on your production server. The repository link is: https://github.com/Johan667/Devnodes.git
2. Install the dependencies of the Symfony application using the Composer install command.
3. If Composer is not installed on your server, follow the instructions to install it.
4. Configure your production environment by modifying the .env.local file. Update the database, API keys, and other variables to reflect your production environment.
5. Install the front-end dependencies using npm:

```
npm install
```

1. Run the database migrations:

```
php bin/console doctrine:migrations:migrate
```

1. Configure your web server to point to the public directory of your Symfony application. You can use a web server such as Apache or Nginx for this.
2. Finally, use mRemote to connect to your production server and run the necessary commands to start your Symfony application. The first step is to start the Symfony server by running the following command:

```
symfony server:start --env=prod
```

This command starts the Symfony web server in production mode.

The application should now be accessible at `http://your-domain.com`.

## License

Devnodes is released under the MIT License. See the [LICENSE](https://chat.openai.com/LICENSE) file for details.
