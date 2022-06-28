## 專案暨人資考核系統
此系統的管理、績效考核功能，提供使用者管理團隊事務與提升自主學習能力。

### 安裝
1. 在terminal輸入`https://github.com/ZFongYun/EST2022.git`，下載專案資料夾
2. 開啟專案，複製`.env .example`成新增`.env`，接著設定資料庫與google drive相關環境變數
3. 在terminal輸入`php artisan key:generate`，以建立`.env`的`APP_KEY`
4. 在terminal輸入`php artisan migrate`，遷移資料表至資料庫
5. 在terminal輸入`php artisan db:seed --class=AdminSeeder`，將6組管理員帳號新增至資料表中

### 系統架構
![圖片1](https://user-images.githubusercontent.com/53658361/176249280-0389abe9-f0e1-4de8-a5f8-9ab7f3faa6c0.png)

此系統的主要使用者分別為二種，第一種為管理者，第二種為一般用戶。管理者與一般用戶可以在電腦或行動裝置開啟瀏覽器並輸入系統網址後，即可進入專案暨人資考核系統。

### 使用技術
* HTML/CSS
* PHP(Laravel)
* JavaScript (jQuery)
* 套件：[Middleware](https://github.com/SpartnerNL/Laravel-Excel)、[flysystem-google-drive](https://github.com/nao-pon/flysystem-google-drive)

### 開發功能
* 管理人資資料
* 管理專案資料
* 關鍵字篩選
* 考核評分
