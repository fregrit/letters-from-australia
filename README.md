# Letters from Australia

## Overview

**Letters from Australia** is a web application that showcases a collection of heartfelt letters written by Margareta to her mom in Sweden during the early 1970s. These letters detail the experiences and adventures of Margareta, her husband Stig, and their son Per as they settled into their new life in Australia. The letters offer a unique glimpse into everyday life and the world as it was back then. After Margareta's passing in 2017, her sons preserved and published these letters to keep her story alive.

The website serves as a tribute to Margareta's life and legacy and is designed to be simple, privacy-focused, and accessible.

## Prerequisites

Before you begin, ensure you have met the following requirements:

- **Docker**: This project uses Docker to simplify the setup process. Ensure Docker and Docker Compose are installed on your system.
- **Git**: For cloning the repository.
- **Heroku CLI** (optional for Heroku deployment): If you plan to deploy this project to Heroku, you'll need the Heroku CLI installed on your Mac. You can install it via Homebrew with the following command:

   ```bash
   brew tap heroku/brew && brew install heroku
   ```

## Installation

1. **Clone the Repository**

   ```bash
   git clone https://github.com/fregrit/letters-from-australia.git
   cd letters-from-australia
   ```

2. **Configure Environment**

   Ensure you have the necessary environment variables and configuration files in place. Modify `config/master.php` if needed.

3. **Build, Start, and Run the Application**

   Use the `make` command to build the Docker image, start or restart the application, and run any necessary PHP scripts.

   ```bash
   make
   ```

   This command checks if the Docker container is running. If it is, it will restart the container. If not, it will build and start the application, then execute any scripts in the `build-scripts` directory.

4. **Access the Application**

   Once the Docker containers are running, you can access the application by navigating to:

   ```
   http://localhost:8080
   ```

## Heroku Deployment

This project includes a `Procfile` that makes it easy to deploy to Heroku. The `Procfile` specifies the commands needed to run the application on Heroku using Apache and PHP.

### Setting Up Heroku on a Mac

1. **Install the Heroku CLI** (if not already installed):

   ```bash
   brew tap heroku/brew && brew install heroku
   ```

2. **Log in to Heroku**:

   ```bash
   heroku login
   ```

3. **Create a Heroku App**:

   ```bash
   heroku create
   ```

4. **Deploy to Heroku**:

   Simply push your code to Heroku:

   ```bash
   git push heroku main
   ```

   Heroku will automatically use the `Procfile` to set up the application.

5. **Open Your Deployed App**:

   After deployment, open your app in the browser:

   ```bash
   heroku open
   ```

With these steps, you'll have the application running on Heroku, leveraging the `Procfile` configuration for an easy and streamlined deployment process.

## Usage

- **Viewing Letters**: The application displays letters in a user-friendly format, allowing you to browse through the collection, read individual letters, and explore related content.
- **Filtering**: Use the filters provided to narrow down letters by keywords, people, or specific dates.
- **Language Switch**: The website supports both Swedish and English. Use the language switcher in the header to toggle between languages.

## Customization

- **Apache Configuration**: Modify `apache.conf` to adjust the Apache server settings.
- **PHP Configuration**: The `php.ini` file contains the PHP settings. Adjust memory limits, error display settings, etc., as needed.
- **Translations**: Translations are managed via the `translations.json` file in the `data` directory. Update or add new translations as required.

## Development

If you're planning to contribute or further develop this project, here are a few tips:

- **Source Code**: The primary source code resides in the `www`, `include`, and `templates` directories.
- **Logging**: Logs are stored in the `logs` directory. The `Makefile` includes a target to monitor logs (`make logs`).
- **Composer**: Manage PHP dependencies using Composer. The `composer.json` and `composer.lock` files are included.

## Contributing

Contributions are welcome! Please submit a pull request with a detailed description of the changes.

## License

This project is open-source and licensed under the MIT License. See the `LICENSE` file for details.

## Acknowledgements

This project is dedicated to Margareta, with deep gratitude for her life and the legacy she left behind. Thank you to everyone who has supported the creation and preservation of this piece of history.
