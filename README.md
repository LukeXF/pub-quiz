Quizzed
=============================
Quizzed is a social quiz system which allows you to log in via your favourite social media asccount and compete in a wide range of categories. This project is build primarily in PHP, HMTL, SCSS and jQuery and uses MySQL to handle recording of users and leaderboard tracking. It uses [OpenTDB](http://opentdb.com) to pull the questions in and [HybridAuth](https://hybridauth.github.io/hybridauth/) to handle the auth from social media, as well as [Mandrill](http://www.mandrill.com/) to send emails using traditional email-verificaiton.

Task
---
We would like you to create a ‘pub quiz’ application. This will be a web based application created using the approach of your choice. The points that need to be covered/considered are below:

- Minimum of 20 multiple choice questions
- Scoring based on correct or incorrect answers
- Leaderboard to show on completion

We expect to see a nicely designed, responsive end product. Whether you choose to use a framework or write the code from scratch is up to you but we will be asking for a rationale of all the decisions you will make so think carefully!

Setup
---
1. Download the [Master Branch](https://github.com/LukeXF/pub-quiz/archive/master.zip) and place on a web server (tested running on Apache).
2. Rename `lib/config-example.php` to `lib/config.php`.
3. Setup a MySQL database for this project and import the structure from [stucture.sql](https://github.com/LukeXF/pub-quiz/blob/master/structure.sql).
4. Place your database details into `$config['db']`. 
5. Adjust your `$config['homepage']` and `$config['callback']` to match your project url.
6. Next you need to setup your oAuth keys (they are used to communicate with the social media login).
   - Create a new oAuth application on [Github](https://github.com/settings/developers), [Facebook](https://developers.facebook.com/apps/), [Twitter](https://apps.twitter.com/), [Instagram](https://www.instagram.com/developer/clients/manage/), [Tumblr](https://www.tumblr.com/oauth/apps), [Reddit](https://www.reddit.com/prefs/apps/).
   - To view the full list of supported social platforms that you can manually add, see the HybridAuth [supported providers page](https://hybridauth.github.io/providers.html).
   - Your callback url should be unique for each app, so for example the Facebook callback would be the `$config['callback']` and `?authFor=facebook`. So the callback url you give to facebook could be: `http://localhost:8888/pub-quiz/callback.php?authFor=facebook`.
   - Place your id key and secret key for each social media platform into `$config['keys']`.
7. Open terminal in your project root and run `composer install` to install [hybridauth v3.0.0-beta.1](https://packagist.org/packages/hybridauth/hybridauth#v3.0.0-beta.1). See more on composer [here](https://getcomposer.org/doc/00-intro.md).
8. Enjoy!

Project Completion:
---
- [x] Login System
  - [x] oAuth integration with HybridAuth
  - [x] Session system and handling logouts
  - [ ] Standard email login
  - [ ] Mandril intergration to send emails
  - [ ] Account overview
  - [ ] History overview
  - [x] Login design
  - [x] MySQL intergration to save login data
  - [ ] Geolocation intergration
- [x] Quiz System
  - [x] Quiz creation system
  - [ ] Test Quiz API and handle response codes
  - [x] Quiz question cycling
  - [x] Answer tracking
  - [ ] Ratelimiting on answering
  - [x] 20 second timelimit cycle
  - [x] Results overview
  - [x] Quiz and Results design
- [x] Leaderboard system
  - [x] Ranking against other users
  - [ ] Pagination
  - [ ] Search functionality
  - [ ] Compare with friends (Facebook/Twitter)
  - [x] Recording overall result to database
  - [x] Leaderboard design
  - [x] API system for leaderboard AJAX requests
  - [ ] Leaderboard visual limit
