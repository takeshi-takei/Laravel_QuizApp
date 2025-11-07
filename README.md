# Laravel Quiz App

## 🚀 アプリケーション概要

ユーザーがクイズに回答し、管理者がカテゴリやクイズを登録・管理できるWebアプリケーションです。

## 🌐 サイトURL

| 画面 | URL | 認証情報（管理画面のみ）|
| :--- | :--- | :--- |
| **プレイ画面** (クイズ回答) | [http://quiz.takecom.blog/](http://quiz.takecom.blog/) | - |
| **管理画面** (ログイン必須) | [http://quiz.takecom.blog/admin/top](http://quiz.takecom.blog/admin/top) | **Email**: test@example.com / **Password**: password |

---

## 💻 技術スタック 

| カテゴリ | 技術 |
| :--- | :--- |
| バックエンド | **PHP 8.x**, **Laravel 10** |
| データベース | **MySQL 8.0** |
| フロントエンド | **Vite**, **Tailwind CSS** (CSSフレームワーク) |
| インフラ/環境 | **AWS EC2 (Ubuntu)**, **Docker / Docker Compose (Laravel Sail)**, **NGINX** |

# 🧠 大変だったこと

このデプロイで最も困難だった点は、NGINXとDocker、および外部DNSシステム間のプロトコルと設定の互換性に関する2つの問題でした。

### 1.  $\text{502 Bad Gateway}$ のループとプロトコル不一致

アプリケーションコンテナは起動しているにもかかわらず、長期間 $\text{502 Bad Gateway}$ エラーが解消しなかった。

* **原因の特定**: $\text{NGINX}$ の設定は **$\text{FastCGI}$** プロトコルを要求していたが、$\text{Laravel Sail}$ 環境が **$\text{HTTP}$ 組み込み $\text{Web}$ サーバー**を起動していたため、プロトコルが不一致を起こしていた。
* **回避策**: $\text{FastCGI}$ 連携を断念し、$\text{NGINX}$ の設定を $\text{FastCGI}$ から **$\text{HTTP}$ リバースプロキシ**（`proxy_pass http://127.0.0.1:8000`）に切り替えることで、プロトコル問題を回避し、サイト表示に成功しました。FastCGIを安定して起動させるためのSail環境の正確なcommand設定は、現在も不明なまま。

### 2.  $\text{DNS}$ ネームサーバーがなぜか変更できない

ドメインの管理権限をXserverからAWS Route 53に移譲する際に、なぜかネームサーバーが変更できませんでした。サポートに連絡したところ、
Route 53が発行した4つのネームサーバーアドレスのうちなぜか2つしかホスト登録ができておらず、４つのネームサーバーを何回入力しても設定不可となってしまっていた。
* **回避策**: Xserverサポートと連携し、**ホスト登録が完了していた $2$ つのアドレスのみ**を使って移譲を完了させた。なぜ4つすべてのアドレスが受け付けられないのかという原因は不明なまま。
