# YAPI - A Base API for Apps in PHP

YAPI is a versatile API designed to serve as a foundation for various web and mobile applications. It offers a range of functionalities for checking website status, managing data, handling redirects, license verification, and app updates.

![Image Preview](https://raw.githubusercontent.com/ali39af/YAPI/main/Screenshot1.png)
![Image Preview](https://raw.githubusercontent.com/ali39af/YAPI/main/Screenshot2.png)

## API Endpoints

### Check Website Status

- **Method:** GET
- **Endpoint:** `https://api.example.com/api/`
- **Response:**
  - `{"status":"202","message":"API is online!"}`
  - `{"status":"503","message":"API is offline!"}`

### Check Exist Data

- **Method:** GET
- **Endpoint:** `https://api.example.com/api/data/check/?id=1000`
- **Response:**
  - `{"status":"202","message":"Data exists!"}`
  - `{"status":"404","message":"Data not found!"}`

### Get Data

- **Method:** GET
- **Endpoint:** `https://api.example.com/api/data/get/?id=1000`
- **Response:**
  - `Text data`
  - `{"status":"404","message":"Data not found!"}`

### Check Exist Redirect

- **Method:** GET
- **Endpoint:** `https://api.example.com/api/redirect/check/?id=1000`
- **Response:**
  - `{"status":"202","message":"Redirection exists!","address":"https://aparat.com"}`
  - `{"status":"404","message":"Redirection not found!"}`

### Get Redirect File

- **Method:** GET
- **Endpoint:** `https://api.example.com/api/redirect/get/?id=1000`
- **Response:**
  - `Redirecting to the target location`
  - `{"status":"404","message":"Redirection not found!"}`

### Check Exist License

- **Method:** GET
- **Endpoint:** `https://api.example.com/api/license/check/?author_id=[user_id]&app_id=test&license=u7iu67t5`
- **Response:**
  - `{"status":"202","message":"License exists","license":"u7iu67t5","app_id":"test","owner_id":"ali39","eval":"false"}`
  - `{"status":"404","message":"License not found!"}`

### Get Eval Data

- **Method:** GET
- **Endpoint:** `https://api.example.com/api/license/eval/?author_id=[user_id]&app_id=test&license=u7iu67t5`
- **Response:**
  - `Text of eval code`
  - `{"status":"404","message":"Eval is false in this license!"}`
  - `{"status":"404","message":"License not found!"}`

### Check Exist App Update

- **Method:** GET
- **Endpoint:** `https://api.example.com/api/update/check/?id=1000`
- **Response:**
  - `{"status":"202","message":"Update exists!","version":"1.1","news":"Hey, this is a new release!","download":"false"}`
  - `{"status":"404","message":"Update not found!"}`

### Get Download App Update

- **Method:** GET
- **Endpoint:** `https://api.example.com/api/update/download/?id=1000`
- **Response:**
  - `Redirecting to the target download location`
  - `{"status":"202","message":"Download is false in this update!"}`
  - `{"status":"404","message":"Update not found!"}`