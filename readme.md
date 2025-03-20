# Author:   Daniel Sones
# Date:     March 20, 2025
# Subject:  INF 653 Midterm ~ (RESTFUL API)

# This repository consists of an api folder containing folders for each of our DB's tables:
    - authors, categories, and quotes

# Each of these folders contain the CRUD commands associated with each of these tables:
    - create, delete, index, read_single, read, and update

# Config folder containing Database.php
    - This file grabs the environmnet variable for establishing connections to the DB

# Models folder containing the commands interfacing with each of the applicable api commands

# Docker files to containerize this repository to upload to an online server such as Render

# quotesdb.sql is the initial setup for tables and entries to test this API

# CRUD commands that can be ran with this API:
----------------------------------------------
# Author:
- create:
    POST - URL: /api/authors/

    Body -  {
                "author": "New Author"
            }

- update:
    PUT - URL: api/authors/

    Body -  {
                "id": "1",
                "author": "Updated Author"
            }

- delete:
    DEL - URL: api/authors/

    Body -  {
                "id": "1"
            }

- read:
    GET - URL: api/authors/

- read_single:
    GET - URL: api/authors/?id=1


# Categories:
- create:
    POST - URL: /api/categories/

    Body -  {
                "category": "New category"
            }

- update:
    PUT - URL: api/categories/

    Body -  {
                "id": "1",
                "category": "Updated category"
            }

- delete:
    DEL - URL: api/categories/

    Body -  {
                "id": "1"
            }

- read:
    GET - URL: api/categories/

- read_single:
    GET - URL: api/categories/?id=1


# Quotes:
- create:
    POST - URL: /api/quotes/

    Body -  {
                "quote": "This is a new quote",
                "author_id": 1,
                "category_id": 1
            }

- update:
    PUT - URL: api/quotes/

    Body -  {
                "quote": "This is an updated quote",
                "author_id": 1,
                "category_id": 1
            }

- delete:
    DEL - URL: api/quotes/

    Body -  {
                "id": "1"
            }

- read:
    GET - URL: api/quotes/

    GET - URL: api/quotes/?author_id=1

    GET - URL: api/quotes/?category_id=1

    GET - URL: api/quotes/?author_id=1&category_id=1

- read_single:
    GET - URL: api/quotes/?id=1