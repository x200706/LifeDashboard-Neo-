## 已知issue
- 記帳管理頁面上方的快速新增，如果欄位不符合驗證，出現提示後提交按鈕會卡在loading字樣無法再次送出
    - 2024查閱官方GitHub issue網友[貢獻](https://github.com/z-song/laravel-admin/pull/5385)有修到獨立表單頁的部分，但似乎沒有修到`editable()`，有空先研究js怎麼修，不能修再去官方提issue

## 運作環境
這是Laravel 8，你需要在主機或容器準備：
- PHP 8.2
- Composer

另外還需要一個PostgreSQL資料庫

## 環境安裝
到專案目錄下
```shell
composer install
```
直到長出Vendor

## 資料庫資料表安裝
（準備中）
開發完成穩定版本才會提供

***
## 主要功能介紹
### 記帳
記帳系統的使用順序：
1. 建立資產帳戶 以及 建立記帳類別
2. 開始記帳

⚠️注意，本記帳系統是**既往不咎**—因為程式寫法是記了就會開始根據收支類型對帳戶餘額進行增減，所以建議您先調查完所有資產帳戶的金額並在新增帳戶時一併填入，日後再開始進行記帳

>Beancount這個複式記帳軟體就設計得很精良—會去檢查帳必須要等於或晚於帳戶創建日期。<br>
>然而考慮本作的定位是一個「多功能的小型系統」，可以滿足最小限度對該功能的要求，暫時不打算讓單一功能變得非常非常精密（程式會變很龐大，使用規則也會變得複雜，有點違背初衷）

## 投資
- 載入自己要觀測的股票清單（註：爬蟲或fetch排成需自行撰寫） 並提供上標籤的功能（5天／10天）<-業務邏輯感謝 [@faiz135753](https://github.com/faiz135753) 提供
  - 還需要微調讓它更彈性（未完成）
 
### 健康管理
- 減肥功能
  - 卡路里紀錄 跟記帳一樣可以上標籤（不過是多選）
  - 身體素質（體重、體脂肪紀錄）（Tips：可自行撰寫系統排程載入其他有API的健康管理APP/裝置資料）
  - 一些基本的分析圖表

### 生活資訊
- 餐廳決定器<-載入自己收集的餐廳，並自動產生多重篩選器
### 生活
