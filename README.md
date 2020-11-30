# CDA Bet Readme

A sport betting site

# Constraints

- Use of Git et Git Flow for versioning
- Language: English
- No CSS, JS in run 1

## Sprint 1 - Modeling and design

Specifications : https://github.com/OFP-CDA-Mulhouse-2020/specs
From 03/11/2020 to 12/11/2020

### Tasks

- Review existing sites
- Produce a class diagram
- Produce a wireframe mockup
- Optionally an HTML mockup

### Tools

Adobe XD
Plant UML

## Sprint 2 - Preparing the project

Details: https://github.com/OFP-CDA-Mulhouse-2020/specs/blob/master/projet-init.md
From 16/11/2020 to 25/11/200

- Prepare a Symfony project
- Install and configure the tools (quality)
- Install and configure the Docker containers
- Configure environments (dev, test)
- Configure the databases
- Perform unit testing on a dummy entity
- Setup GitHub actions for unit testing

Setup: The project uses uncommited and locally overrided default values for the environment variables, especially for the database configuration. Create local environment files (.env.local, .env.test.local) with your database specific configurations

## Sprint 3 - Security Module

Details: https://github.com/OFP-CDA-Mulhouse-2020/specs/blob/master/Security.md
From 26/11/2020 to 10/12/2020 (tentatively)

- Create and test the User entity (unit test)
- Create and test the registration form using the form and validator components (functional test)
- Create and test the connection form using the security components (functional test)
- Setup the authentication
- Use TDD for all tests (unit and functional)

Keep using git flow features for the features, start using Pull Requests to merge code change
