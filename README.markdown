## PackagistProxyPlugin

This is a composer plugin and works together with [Hermes](https://github.com/glaubinix/Hermes).

### Idea
I am a big fan of dependency management systems like npm and composer and I really love that the composer team introduced satis. But there is one big issue with satis. As a end user I don't want to care whether my dependencies are store on a satis server or on github. I just simply want it to work. The idea behind this project is to allow users to have the simple composer like setup and dependency handling but with the same assurances that their dependencies will be available during deployment.

### TODO
* Find a way to cache the packagist calls as well. The idea is to simply be proxy every packagist call as well and store the result in Hermes. If packagist is not available on the some data on Hermes then Hermes should simply return the stored data.
* Figure out how this tool should handle custom dependencies which are not stored on packagist like private repositories.
* Add http auth for more security
* I think we have to handle the github api key stuff. Ideal would be if we do not have to change anything for the user.

### Install
Simply add the plugin as dependency to your composer.json file.
