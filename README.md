![Build status](https://github.com/kdabek/refactor-kata/actions/workflows/php.yml/badge.svg)
[![Maintainability](https://api.codeclimate.com/v1/badges/2f19de0364da2da05815/maintainability)](https://codeclimate.com/github/kdabek/refactor-kata/maintainability)
[![Test Coverage](https://api.codeclimate.com/v1/badges/2f19de0364da2da05815/test_coverage)](https://codeclimate.com/github/kdabek/refactor-kata/test_coverage)

## Introduction

The following task has been created to practice the practical skills of code refactoring. 
There are 19 tests in the tests directory which all run and pass correctly when the task is started. 
These tests will be the basic tool for checking the refactored code. 
Your task is to refactor the code - that is, to make changes that will improve its quality without changing the logic of operation. 
What changes you make, some patterns or best practices you use - depends on you. Any code quality improvement is better than no code improvement! 
Remember, however, that all tests must be passed correctly when you submit an assignment.

The job should run in PHP 7.3. Unit tests were written using the phpunit 8.2 framework and should be run on it. 
A task description explaining the business logic contained in the GildedRose.php class is provided below.

> This task originally comes from https://github.com/QafooLabs/gilded-rose-kata

## Requirements
- composer
- php 7.3
- phpunit 8.2

## Instalation
To install dependencies run ```composer install```. To run test use ```./vendor/bin/phpunit```.

## Description

Hi and welcome to team Gilded Rose. As you know, we are a small inn with a
prime location in a prominent city ran by a friendly innkeeper named Allison.
We also buy and sell only the finest goods. Unfortunately, our goods are
constantly degrading in quality as they approach their sell by date. We have a
system in place that updates our inventory for us. It was developed by a
no-nonsense type named Leeroy, who has moved on to new adventures. Your task is
to add the new feature to our system so that we can begin selling a new
category of items. First an introduction to our system:

- All items have a **SellIn** value which denotes the number of days we have to
sell the item
- All items have a **Quality** value which denotes how valuable the
item is 
- At the end of each day our system lowers both values for every item

Pretty simple, right? Well this is where it gets interesting:

- Once the sell by date has passed, Quality degrades twice as fast 
- The Quality of an item is never negative 
- "**Aged Brie**" actually increases in Quality the older it gets
- The Quality of an item is never more than 50
- "**Sulfuras**", being a legendary item, never has to be sold or decreases in
Quality
- "**Backstage passes**", like aged brie, increases in Quality as it's
SellIn value approaches; Quality increases by 2 when there are 10 days or less
and by 3 when there are 5 days or less but Quality drops to 0 after the concert

Just for clarification, an item can never have its Quality increase above 50, however "Sulfuras" is a legendary 
item and as such its Quality is 80 and it never alters.
