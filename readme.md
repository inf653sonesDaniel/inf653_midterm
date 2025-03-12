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
    POST - URL: /api/authors/create.php

    Body -  {
                "author": "New Author"
            }

- update:
    PUT - URL: api/authors/update.php

    Body -  {
                "id": "1",
                "author": "Updated Author"
            }

- delete:
    DEL - URL: api/authors/delete.php

    Body -  {
                "id": "1"
            }

- read:
    GET - URL: api/authors/read.php

- read_single:
    GET - URL: api/authors/read_single.php?id=1


# Categories:
- create:
    POST - URL: /api/categories/create.php

    Body -  {
                "category": "New category"
            }

- update:
    PUT - URL: api/categories/update.php

    Body -  {
                "id": "1",
                "category": "Updated category"
            }

- delete:
    DEL - URL: api/categories/delete.php

    Body -  {
                "id": "1"
            }

- read:
    GET - URL: api/categories/read.php

- read_single:
    GET - URL: api/categories/read_single.php?id=1


# Quotes:
- create:
    POST - URL: /api/quotes/create.php

    Body -  {
                "quote": "This is a new quote",
                "author_id": 1,
                "category_id": 1
            }

- update:
    PUT - URL: api/quotes/update.php

    Body -  {
                "quote": "This is an updated quote",
                "author_id": 1,
                "category_id": 1
            }

- delete:
    DEL - URL: api/quotes/delete.php

    Body -  {
                "id": "1"
            }

- read:
    GET - URL: api/quotes/read.php

    GET - URL: api/quotes/read.php?author_id=1

    GET - URL: api/quotes/read.php?category_id=1

    GET - URL: api/quotes/read.php?author_id=1&category_id=1

- read_single:
    GET - URL: api/quotes/read_single.php?id=1