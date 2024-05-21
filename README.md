# PHP Router

[![Latest Version](https://img.shields.io/badge/version-1.1.3-blue.svg)](https://github.com/oladesoftware/router)
[![License](https://img.shields.io/badge/license-MIT-green.svg)](https://opensource.org/licenses/MIT)

A simple lightweight router implementation for handling HTTP routes written in PHP. This class allows you to define routes, group them, add middleware, and handle requests based on defined routes.

## Table of Contents

- [Features](#features)
- [Installation](#installation)
- [Usage](#usage)
- [License](#license)
- [Contributing](#contributing)
- [Contributors](#contributors)
- [Author](#author)

## Features

- **Singleton Pattern**: Ensures a single instance of the router.
- **Route Definition**: Add individual routes with HTTP methods, URI paths, and targets (controllers or closures).
- **Route Grouping**: Group multiple routes under a common base path.
- **Middleware Support**: Assign middleware to routes for pre-processing.
- **Named Routes**: Name your routes for easier route generation.
- **Dynamic Route Matching**: Match incoming requests to defined routes and extract parameters.
- **Route Execution**: Execute the target action of matched routes.

## Installation

- **Via Composer (Recommended)**:

```sh
composer require oladesoftware/router
```

- Manual Installation:

[Download](https://github.com/oladesoftware/router/releases/tag/latest) the router class file and include it in your project.

## Usage

For detailed usage instructions, please refer to the [Usage Documentation](./docs/usage.md).

## License

This project is licensed under the MIT License. See the [License](./LICENSE) file for details.

## Contributing

Contributions are welcome! Feel free to submit issues or pull requests.

## Support

For support, please open an issue on the GitHub repository.

## Contributors

- [Helmut](https://github.com/ahokponou)

## Author

- [Olade Software](https://oladesoftware.com)
