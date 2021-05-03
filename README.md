# Project name

> Ex. The project contains the company's website.

![LAMP](https://img.shields.io/badge/LAMP-Docker-blue)
![Software](https://img.shields.io/badge/Software-Drupal8-blue)

## Table of Contents

- [Installation](#installation)
- [Features](#features)
- [FAQ](#faq)

---

## Installation

### Clone

Clone this repo to your local machine using: `git clone git@...`

### Setup (with docker)

- Clone the `docker/.env.dist` file to `docker/.env`

- Customize the `docker/.env` file with your parameters

- Customize the stack for your host/OS (_MAC users see this [instructions](https://wodby.com/docs/1.0/stacks/drupal/local/#docker-for-mac)_)

- Run docker and access to container PHP:

```shell
cd docker
make up
make solr-init
make shell
```

### Install

- Download libraries with `composer`:

  ```shell
  composer install --prefer-dist
  ```

- Install Drupal and Project

  Scratch:

  ```shell
  robo scaffold --site=site1
  robo install:config minimal --site=site1
  
  robo scaffold --site=site2
  robo install:config minimal --site=site2 
  ```

- Test use (**Run inside a container PHP**).

  ```shell
  drush --uri=site1 en devel_generate
  drush --uri=site1 genc 50 --bundles=article --add-type-label --kill --authors=1
  drush --uri=site1 pm:uninstall devel_generate
  
  drush --uri=site2 en devel_generate
  drush --uri=site2 genc 50 --bundles=article --add-type-label --kill --authors=1
  drush --uri=site2 pm:uninstall devel_generate
  ```

or run this robo command

  ```shell
  robo test:contents
  ```