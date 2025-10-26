
## 環境

-   PHP v8.4.7
-   Laravel v11
-   Laravel Sail
-   Laravel Breeze
-   Docker

## インストール方法

### 前提条件

以下のソフトウェアがインストールされている必要があります。

-   Git
-   Docker
-   PHP 8.2以上
-   Composer
-   Node.js

### 手順

1.  **Gitクローン**（お好きなフォルダで）
    ```bash
    git clone [リポジトリのURL]
    cd quiz-app
    ```

2.  **Composerインストール**
    ```bash
    composer install
    ```

3.  **.envファイルの生成**
    `.env.example` ファイルをコピーして `.env` ファイルを生成します。
    ```bash
    cp .env.example .env
    ```

4.  **APP_KEYの生成**
    `.env` ファイル内の `APP_KEY` を設定します。
    ```bash
    php artisan key:generate
    ```

5.  **Dockerコンテナの起動**
    （初回起動時は時間がかかる場合があります）
    ```bash
    ./vendor/bin/sail up -d
    ```

6.  **npmインストール**
    ```bash
    ./vendor/bin/sail npm ci
    ```

7.  **Viteの起動**
    （ターミナルで別タブを開いて実行するのがおすすめです）
    ```bash
    ./vendor/bin/sail npm run dev
    ```

8.  **マイグレーションの実行**
    ```bash
    ./vendor/bin/sail artisan migrate
    ```

9.  **シーディングの実行**
    （管理者データを作成します）
    ```bash
    ./vendor/bin/sail artisan db:seed
    ```

## アクセス情報

-   **管理画面:** `http://localhost/login`
    -   メールアドレス： `test@example.com`
    -   パスワード： `password123`

-   **プレイヤー画面:** `http://localhost`
