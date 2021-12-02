# Test Project Requested by Aloware

Create a comment system single-page web application using a framework of choice (preferably Laravel 5.5+) and VueJS / React with the following requirements:

* Assume that there is only one Blog Post that can be commented on.
* Only the user’s name and comment text are required to post a comment.
* A comment can be replied to with another comment.
* Nested comments are up to 3 layers only
* The page should not refresh when posting a comment.
* Comments must be ordered by the latest.
* Make the user interface as beautiful, responsive, and easy to use as you can.
* Use MySQL database for storing your data.
* No need to edit, delete, etc of comments.

What we are looking for:

* Optimal code that is clean and maintainable.
* Business logic organization and software design patterns.
* Optimized SQL performance.
* Documentation.
* Unit tests.

Important notes:

Start an empty repository in GitHub, commit the base Laravel to the master branch and then start work. (so when we read your code, we can separate it from framework base code).
Don’t make the project complicated; there is no need for user login, live broadcasting, and notifications.
You don’t need to create a User and Post model.

## Download 

Download the code from github and switch to develop branch

```bash
git clone https://github.com/joefreire/aloware.git

git checkout -b developer

git pull
```
## Installation
Go to the path when you are downloaded the code and install
Don't forget to configure your .env file
```bash
composer install

npm install

npm prod

php artisan migrate

php artisan serve
```


## Usage

Go to the browser and access http://127.0.0.1:8000/

## Test
Using Laravel Dusk to tests


```bash
php artisan dusk
```