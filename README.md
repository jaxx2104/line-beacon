# line-beacon

LINE BOT webhook program 🤖

## Description

LINE Bot API & Beacon Module

Event webhook program

## Requirement

- linecorp/line-bot-sdk

## Installation

### Get account 
sign up
[LINE BUSINESS CENTER](https://business.line.me/ja/services/bot)

### Setup bot
set icon, default message
[LINE@MANAGER](https://admin-official.line.me/)

### Setup program

```shell
$ git clone git@github.com:jaxx2104/line-beacon.git
```

install line-bot-sdk

```shell
$ cd line-beacon
$ composer install
```

run appche and ngrok

```shell
$ service httpd start
$ ngrok http 80
```

### Resister webhook

set webhook URL and get token
[LINE Developers](https://developers.line.me/ba/)

write token
```shell
$ emacs token.txt
```
