# PiGly -Weight Records-

## 概要

・fortifyを使用した登録、認証<br>
・初期体重登録<br>
・情報の作成・更新・削除<br>
・期間での検索機能

## 使用技術

Laravel Framework 8.83.29<br>
php:8.1-fpm<br>
nginx:1.21.1<br>
mysql:8.0.32<br>
phpMyAdmin

## 環境構築

- Docker のビルドからマイグレーション、シーディングまでを記述

### Docker 　ビルド

下記コマンドを 1 行ずつ実行してください<br>

1.git クローン

```
git clone git@github.com:Yu-Sasaki451/pigly.git
```

2.Docker ビルド

```
cd pigly
```

```
docker compose up -d --build
```

### Laravel 　環境構築

下記コマンドを 1 行ずつ実行してください<br>

1.PHP コンテナへ入る

```
docker compose exec php bash
```

2.composer インストール

```
composer install
```

3.　.env コピー　※環境変数は適宜変更してください

```
cp .env.example .env
```

4.アプリケーションキー作成

```
php artisan key:generate
```

5.　マイグレーション実行

```
php artisan migrate
```

6.　シーディング実行

```
php artisan db:seed
```

## URL

開発環境：http://localhost<br>
phpMyAdmin：http://localhost:8080/

## ER 図

![ER Diagram](src/public/er.svg)

```

```
