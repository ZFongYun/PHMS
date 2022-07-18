## 專案暨人資考核系統
此系統的管理、績效考核功能，提供使用者管理團隊事務與提升自主學習能力。

![phms](https://user-images.githubusercontent.com/53658361/179455981-c800ddc0-214c-470d-a127-e5cf34623d11.jpg)

### 安裝
1. 在terminal輸入`git clone https://github.com/ZFongYun/PHMS.git`下載專案資料夾
2. 開啟網頁虛擬器(XAMPP...etc)，為專案配置虛擬目錄，以及新增資料庫
3. 開啟專案，複製`.env .example`成新增`.env`，接著設定資料庫與google drive相關環境變數
4. 在terminal輸入`php artisan key:generate`，以建立`.env`的`APP_KEY`
5. 在terminal輸入`php artisan migrate`，遷移資料表至資料庫
6. 在terminal輸入`php artisan db:seed --class=AdminSeeder`，將6組管理員帳號新增至資料表中
7. 開啟瀏覽器，輸入`http://localhost/PHMS_admin/login`即可進入管理員的登入畫面；若輸入`http://localhost/PHMS_member/login`即可進入一般用戶的登入畫面

### 系統架構
![PHMS](https://user-images.githubusercontent.com/53658361/176618575-1107bca6-75a4-438a-b3e3-b720e5e3e840.png)

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
